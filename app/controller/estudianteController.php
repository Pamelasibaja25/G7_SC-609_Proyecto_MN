<?php
require_once __DIR__ . '/../models/estudiante.php';
function get_estudiantes()
{
    try {
        $result = estudiante::get_estudiantes();
        
        if (count($result) > 0) {

            foreach ($result as $row)  {
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

function get_estudiantes_admin()
{
    return Estudiante::lista_estudiantes();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['action'] === 'editar-estudiante') {

        try{
        Estudiante::editar(
            (int)$_POST['id_estudiante'],
            $_POST['cedula'],
            $_POST['fecha_nacimiento'],
            $_POST['grado'],
            $_POST['escuela']
        );

        header("Location: /Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/views/estudiante/listado.php?status=success&msg=Estudiante actualizado correctamente");
        exit();
    }
    catch (Exception $e) {
        header("Location: /Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/views/estudiante/listado.php?status=error&msg=" . urlencode($e->getMessage()));
        exit();
    }
    }

    if ($_POST['action'] === 'eliminar-estudiante') {

        try{
        Estudiante::eliminar((int)$_POST['id_estudiante']);

        header("Location: /Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/views/estudiante/listado.php?status=success&msg=Estudiante eliminado correctamente");
        exit();
        }
        catch (Exception $e) {
        header("Location: /Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/views/estudiante/listado.php?status=error&msg=" . urlencode($e->getMessage()));
        exit();
    }
    }
}

try {
    if (!empty($_POST)) {
        $action = $_POST['action'] ?? '';
        if (
            $action === 'modificar' && !empty($_POST['escuela']))
        {
            $resultado = estudiante::modificar_info( $_POST['escuela']);
            header("Location: /Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/views/curso/registro_matricula.php?status=success&msg=Modificación exitosa.");
            exit();
        } 
        else if (
            $action === 'modificar-nota' && !empty($_POST['escuela']))
        {
            $resultado = estudiante::modificar_info(  $_POST['escuela']);
            header("Location: /Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/views/nota/listado.php?status=success&msg=Modificación exitosa.");
            exit();
        }
        else if (
            $action === 'filtrar-rendimiento' && !empty($_POST['id_estudiante']) && !empty($_POST['grado']) && !empty($_POST['id_curso']))
        {
            $cursos = estudiante::get_reportes($_POST['id_estudiante'],$_POST['grado'],$_POST['id_curso']); 
            $_SESSION['reportes-rendimiento'] = $cursos;
            header("Location: /Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/views/nota/reporte_rendimiento.php?status=success&msg=Reporte Generado con éxito.");
            exit();
        }
        else if ($action === 'imprimir-reporte') {
            estudiante::imprimir_reporte(); 
        }  
        else if (
            $action === 'filtrar-rendimiento')
        {
            header("Location: /Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/views/nota/reporte_rendimiento.php?status=error&msg=Campos incompletos.");
            exit();
        } 
        else if (
            $action === 'modificar-nota')
        {
            header("Location: /Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/views/nota/listado.php?status=error&msg=Campos incompletos.");
            exit();
        } 
        else if (
            $action === 'modificar') {
            header("Location: /Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/views/curso/registro_matricula.php?status=error&msg=Campos incompletos.");
            exit();
        }
    }
} catch (Exception $e) {
    header("Location: /Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/views/curso/registro_matricula.php?status=error&msg=" . urlencode($e->getMessage()));
    exit();
}

?>