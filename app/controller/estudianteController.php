<?php
require_once __DIR__ . '/../models/estudiante.php';
function get_estudiantes()
{
    try {
        $result = estudiante::get_estudiantes();
        
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                echo ' <option value="' . $row['id_estudiante'] . '" text="' . $row['nombre'] . '">
                        ' . $row['nombre'] . '
                            </option>';
                
            }

        } else {
            echo '<p class="text-center text-white">No hay estudiantes disponibles.</p>';
        }
    } catch (Exception $e) {
        header("Location: ../../layout.php?status=error&msg=" . urlencode($e->getMessage()));
        exit();
    }
}

try {
    if (!empty($_POST)) {
        $action = $_POST['action'] ?? '';
        if (
            $action === 'modificar' && !empty($_POST['new-encargado']) && !empty($_POST['escuela']))
        {
            $resultado = estudiante::modificar_info( $_POST['new-encargado'], $_POST['escuela']);
            header("Location: /G1_SC-502_JN_Proyecto/app/views/curso/registro_matricula.php?status=success&msg=Modificación exitosa.");
            exit();
        } 
        else if (
            $action === 'modificar-nota' && !empty($_POST['new-encargado']) && !empty($_POST['escuela']))
        {
            $resultado = estudiante::modificar_info( $_POST['new-encargado'], $_POST['escuela']);
            header("Location: /G1_SC-502_JN_Proyecto/app/views/nota/listado.php?status=success&msg=Modificación exitosa.");
            exit();
        }
        else if (
            $action === 'filtrar-rendimiento' && !empty($_POST['id_estudiante']) && !empty($_POST['grado']) && !empty($_POST['id_curso']))
        {
            $cursos = estudiante::get_reportes($_POST['id_estudiante'],$_POST['grado'],$_POST['id_curso']); 
            $_SESSION['reportes-rendimiento'] = $cursos;
            header("Location: /G1_SC-502_JN_Proyecto/app/views/nota/reporte_rendimiento.php?status=success&msg=Reporte Generado con éxito.");
            exit();
        }
        else if ($action === 'imprimir-reporte') {
            estudiante::imprimir_reporte(); 
        }  
        else if (
            $action === 'filtrar-rendimiento')
        {
            header("Location: /G1_SC-502_JN_Proyecto/app/views/nota/reporte_rendimiento.php?status=error&msg=Campos incompletos.");
            exit();
        } 
        else if (
            $action === 'modificar-nota')
        {
            header("Location: /G1_SC-502_JN_Proyecto/app/views/nota/listado.php?status=error&msg=Campos incompletos.");
            exit();
        } 
        else if (
            $action === 'modificar') {
            header("Location: /G1_SC-502_JN_Proyecto/app/views/curso/registro_matricula.php?status=error&msg=Campos incompletos.");
            exit();
        }
    }
} catch (Exception $e) {
    header("Location: /G1_SC-502_JN_Proyecto/app/views/curso/registro_matricula.php?status=error&msg=" . urlencode($e->getMessage()));
    exit();
}

?>