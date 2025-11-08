<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/config/database.php';

class curso
{
    public static function get_cursos()
    {
        global $conn;

        $sql = "SELECT id_curso,descripcion,ruta_imagen  FROM curso WHERE estado = 'En Progreso' and id_usuario = " . $_SESSION['usuario'];
        $result = $conn->query($sql);

        return $result;
    }
    public static function get_curso($id_curso)
    {
        global $conn;

        $sql = "SELECT descripcion FROM curso WHERE id_curso = " . $id_curso;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    public static function get_temas_por_curso($id_curso)
    {
        global $conn;

        $sql = "SELECT nombre, informacion FROM tema WHERE id_curso = " . $id_curso;
        $result = $conn->query($sql);

        $temas = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $temas[] = $row;
            }
        }
        return $temas;
    }

    public static function imprimir_temas($id_curso)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="Temas_Curso' . $id_curso . '.csv"');
        global $conn;

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Tema', 'Informacion']);

        $sql = "SELECT nombre, informacion FROM tema WHERE id_curso = " . $id_curso;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                fputcsv($output, [$row["nombre"], $row["informacion"]]);
            }
        }
        fclose($output);
        exit;
    }

    public static function imprimir_reporte()
    {
        session_start();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="Reporte Trimestral.csv"');
    
        $output = fopen('php://output', 'w');
    
        fputcsv($output, ['Fecha Inicio', 'Fecha Final', 'Curso','Estado','Nota']);
    
        foreach ($_SESSION['reportes'] as $reporte) {
            fputcsv($output, [
                $reporte["fecha_inicio_trimestre"],
                $reporte["fecha_final_trimestre"],
                $reporte["descripcion"],
                $reporte["estado"],
                $reporte["nota"]
            ]);
        }
    
        fclose($output);
        exit;
    }
    

    public static function get_cursos_disponibles()
    {
        global $conn;
        session_start();

        $sql = "SELECT id_curso, descripcion, detalle 
    FROM curso 
    WHERE estado = 'Disponible' 
      AND grado = '" . $_SESSION['grado'] . "' 
      AND descripcion NOT IN (
          SELECT descripcion 
          FROM curso 
          WHERE id_usuario = " . $_SESSION['usuario'] . "
      )";
        $result = $conn->query($sql);
        $cursos = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cursos[] = $row;
            }
        }
        return $cursos;
    }

    public static function get_total_cursos()
    {
        global $conn;
        session_start();

        $sql = "SELECT DISTINCT descripcion
        FROM curso;";
        $result = $conn->query($sql);
        return $result;
    }

    public static function get_notas()
    {
        global $conn;
        session_start();


        $sql = "SELECT n.id_curso, n.nota, n.fecha_inicio_trimestre, n.fecha_final_trimestre, 
        c.estado, c.descripcion
        FROM nota n
        JOIN curso c ON n.id_curso = c.id_curso
        WHERE n.id_estudiante = " . $_SESSION['id_estudiante'] . " ";

        $result = $conn->query($sql);
        $cursos = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cursos[] = $row;
            }
        }
        return $cursos;
    }

    public static function guardarMatricula($cursoId)
    {
        global $conn;
        session_start();

        $sql = "SELECT id_curso, descripcion, grado, detalle, ruta_imagen FROM curso WHERE id_curso = " . $cursoId;
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $sql = "INSERT INTO curso (descripcion, grado, detalle, ruta_imagen, estado, id_usuario) VALUES
            ('" . $row['descripcion'] . "','" . $row['grado'] . "','" . $row['detalle'] . "','" . $row['ruta_imagen'] . "','En Progreso'," . $_SESSION['usuario'] . ")";
        $conn->query($sql);

        $nuevoCursoId = $conn->insert_id;

        $fechaInicio = date("Y-m-d");

        $sql = "INSERT INTO nota (id_curso, fecha_inicio_trimestre, id_estudiante) VALUES
            ($nuevoCursoId, '$fechaInicio', " . $_SESSION['id_estudiante'] . ")";
        $conn->query($sql);

        return true;
    }


    public static function get_reportes($reporte_anual, $reporte_trimestral, $reporte_mensual)
    {
        global $conn;
        session_start();

        if (!empty($reporte_anual)) {
            $sql = "SELECT n.id_curso, n.nota, n.fecha_inicio_trimestre, n.fecha_final_trimestre, 
            c.estado, c.descripcion
        FROM nota n
        JOIN curso c ON n.id_curso = c.id_curso
        WHERE 
            n.id_estudiante = " . $_SESSION['id_estudiante'] . " 
            AND (YEAR(n.fecha_inicio_trimestre) = YEAR(CURDATE())
            OR YEAR(n.fecha_final_trimestre) = YEAR(CURDATE()))";

        } else if (!empty($reporte_trimestral)) {
            $sql = "SELECT n.id_curso, n.nota, n.fecha_inicio_trimestre, n.fecha_final_trimestre, 
               c.estado, c.descripcion
        FROM nota n
        JOIN curso c ON n.id_curso = c.id_curso
        WHERE 
            n.id_estudiante = " . $_SESSION['id_estudiante'] . " 
            AND (QUARTER(n.fecha_inicio_trimestre) = QUARTER(CURDATE())
            OR QUARTER(n.fecha_inicio_trimestre) = QUARTER(CURDATE()))
            AND (YEAR(n.fecha_inicio_trimestre) = YEAR(CURDATE())
            OR YEAR(n.fecha_final_trimestre) = YEAR(CURDATE()))";

        } else if (!empty($reporte_mensual)) {
            $sql = "SELECT n.id_curso, n.nota, n.fecha_inicio_trimestre, n.fecha_final_trimestre, 
               c.estado, c.descripcion
        FROM nota n
        JOIN curso c ON n.id_curso = c.id_curso
        WHERE 
            n.id_estudiante = " . $_SESSION['id_estudiante'] . " 
            AND (MONTH(n.fecha_inicio_trimestre) = MONTH(CURDATE())
            OR MONTH(n.fecha_inicio_trimestre) = MONTH(CURDATE()))";

        }

        $result = $conn->query($sql);
        $cursos = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cursos[] = $row;
            }
        }
        return $cursos;
    }
}
?>