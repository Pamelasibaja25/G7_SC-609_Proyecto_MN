<?php
require_once __DIR__ .'/../models/curso.php';

function get_cursos()
{
    try {
        $result = curso::get_cursos();
        
        if ($result->num_rows > 0) {
            echo '<div>';
            echo '<div id="contenedor-cursos" class="row text-center">';

            $index = 0;
            while ($row = $result->fetch_assoc()) {

                echo '<div class="card col-md-4">';
                echo '<div class="card-body">';
                echo '<img src="' . $row['ruta_imagen'] . '" alt="Imagen del curso" height="100" width="100" />';
                echo '<h5 class="card-title">' . $row['descripcion'] . '</h5>';
                echo '<a href="mostrar_materia.php?id=' . $row['id_curso'] . '" class="btn bg-body-custom text-white">Revisar Materia</a>';
                echo '</div>';
                echo '</div>';
            }

            echo '</div>';
            echo '</div>';
        } else {
            echo '<p class="text-center text-white">No hay cursos disponibles.</p>';
        }
    } catch (Exception $e) {
        header("Location: ../../layout.php?status=error&msg=" . urlencode($e->getMessage()));
        exit();
    }
}

function get_curso_contenido($id_curso) {
    try {
        // Obtener los temas asociados a un curso.
        $temas = curso::get_temas_por_curso($id_curso);
        $curso = curso::get_curso($id_curso);

        return ['temas' => $temas, 'curso' => $curso];
    } catch (Exception $e) {
        header("Location: ../../layout.php?status=error&msg=" . urlencode($e->getMessage()));
        exit();
    }
}

function get_cursos_disponibles() {
    try {
        // Obtener los temas asociados a un curso.
        $cursos = curso::get_cursos_disponibles();

        return ['cursos' => $cursos];
    } catch (Exception $e) {
        header("Location: ../../layout.php?status=error&msg=" . urlencode($e->getMessage()));
        exit();
    }
}

function get_notas() {
    try {
        // Obtener los temas asociados a un curso.
        $cursos = curso::get_notas();

        return ['cursos' => $cursos];
    } catch (Exception $e) {
        header("Location: ../../layout.php?status=error&msg=" . urlencode($e->getMessage()));
        exit();
    }
}

function get_total_cursos() {
    try {
        $result = curso::get_total_cursos();
        
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                echo ' <option value="' . $row['descripcion'] . '" text="' . $row['descripcion'] . '">
                        ' . $row['descripcion'] . '
                            </option>';
                
            }

        } else {
            echo '<p class="text-center text-white">No hay cursos disponibles.</p>';
        }
    } catch (Exception $e) {
        header("Location: ../../layout.php?status=error&msg=" . urlencode($e->getMessage()));
        exit();
    }
}

try {
    if (!empty($_POST)) {
        $action = $_POST['action'] ?? '';

        if ($action === 'agregar_matricula' && !empty($_POST['curso'])) {
            $cursosSeleccionados = $_POST['curso'];
            foreach ($cursosSeleccionados as $cursoId) {
                curso::guardarMatricula($cursoId); // Esta función la defines tú en el modelo
            }
            
            header("Location: /G7_SC-609_Proyecto_MN/app/views/curso/registro_matricula.php?status=success&msg=" . urlencode("Matrícula realizada con éxito"));
            exit();
        }
        else if ($action === 'filtrar-reportes' && (!empty($_POST['reporteAnual']) || !empty($_POST['reporteMensual']) || !empty($_POST['reporteTrimestral']))) {
            $cursos = curso::get_reportes($_POST['reporteAnual'],$_POST['reporteTrimestral'],$_POST['reporteMensual'] ); 
            $_SESSION['reportes'] = $cursos;
            header("Location: /G7_SC-609_Proyecto_MN/app/views/nota/reporte_trimestral.php?status=success&msg=" . urlencode("Reporte Generado con éxito"));
            exit();
        } 
        else if ($action === 'imprimir-temas') {
            curso::imprimir_temas($_POST['id_curso']); 
        }
        else if ($action === 'imprimir-reporte') {
            curso::imprimir_reporte(); 
        }
        else if ($action === 'filtrar-reportes') {
            header("Location: /G7_SC-609_Proyecto_MN/app/views/nota/reporte_trimestral.php?status=error&msg=" . urlencode("No seleccionaste ningún reporte"));
            exit();
        }
        else if ($action === 'agregar_matricula') {
            header("Location: /G7_SC-609_Proyecto_MN/app/views/curso/registro_matricula.php?status=error&msg=" . urlencode("No seleccionaste ningún curso"));
            exit();
        }
    }
} catch (Exception $e) {
    header("Location: /G7_SC-609_Proyecto_MN/app/views/layout.php?status=error&msg=" . urlencode("Error: " . $e->getMessage()));
    exit();
}

?>
