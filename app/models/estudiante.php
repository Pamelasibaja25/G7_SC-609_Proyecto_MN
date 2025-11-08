<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/G1_SC-502_JN_Proyecto/config/database.php';

class estudiante
{
    public static function modificar_info($new_encargado, $escuela)
    {
        global $conn;
        session_start();

        // Buscar el estudiante en la base de datos
        $sql = "UPDATE estudiante SET encargado_legal = '$new_encargado', id_escuela = '$escuela' WHERE id_usuario=" . $_SESSION['usuario'];
        $conn->query($sql);

        $sql = "UPDATE estudiante SET encargado_legal = '$new_encargado', id_escuela = '$escuela' WHERE id_usuario=" . $_SESSION['usuario'];
        $conn->query($sql);

        $sql = "SELECT id_escuela,descripcion FROM escuela WHERE id_escuela = " . $escuela;
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $_SESSION['id_escuela'] = $escuela;
        $_SESSION['escuela'] = $row['descripcion'];
        $_SESSION['encargado_legal'] = $new_encargado;
        return false; // estudiante no encontrado o contraseña incorrecta
    }
    public static function get_estudiantes()
    {
        global $conn;
        session_start();

        // Buscar el estudiante en la base de datos
        $sql = "SELECT e.id_estudiante, e.id_usuario, u.nombre
                FROM estudiante e
                JOIN usuario u ON e.id_usuario = u.id_usuario;
                ";
        $result = $conn->query($sql);

        return $result; // estudiante no encontrado o contraseña incorrecta
    }

    public static function get_reportes($id_estudiante, $grado, $id_curso)
    {
        global $conn;
        session_start();

        // Construir la base de la consulta
        $sql = "SELECT n.id_curso, n.nota, n.fecha_inicio_trimestre, n.fecha_final_trimestre, 
                   c.grado, c.estado, c.descripcion, u.nombre
            FROM nota n
            JOIN curso c ON n.id_curso = c.id_curso
            JOIN estudiante e ON n.id_estudiante = e.id_estudiante
            JOIN usuario u ON e.id_usuario = u.id_usuario
            WHERE 1=1";

        // Añadir condiciones según los parámetros
        if ($id_estudiante != "All") {
            $sql .= " AND e.id_estudiante = '$id_estudiante'";
        }
        if ($grado != "All") {
            $sql .= " AND c.grado = '$grado'";
        }
        if ($id_curso != "All") {
            $sql .= " AND c.descripcion = '$id_curso'";
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

    public static function imprimir_reporte()
    {
        session_start();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="Reporte Rendimiento.csv"');
    
        $output = fopen('php://output', 'w');
    
        fputcsv($output, ['Fecha Inicio', 'Fecha Final','Grado', 'Curso','Estado','Estudiante','Nota']);
    
        foreach ($_SESSION['reportes-rendimiento'] as $reporte) {
            fputcsv($output, [
                $reporte["fecha_inicio_trimestre"],
                $reporte["fecha_final_trimestre"],
                $reporte["grado"],
                $reporte["descripcion"],
                $reporte["estado"],
                $reporte["nombre"],
                $reporte["nota"]
            ]);
        }
    
        fclose($output);
        exit;
    }

}
?>