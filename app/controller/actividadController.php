<?php
// Controller de Actividad

require_once __DIR__ . '/../models/Actividad.php';

function get_actividades()
{
    return Actividad::lista_actividades();
}

function get_actividades_por_curso($id_curso)
{
    return Actividad::actividades_por_curso($id_curso);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] === 'registrar-actividad') {

        try {
            Actividad::registrar(
                $_POST['id_curso'],
                $_POST['tipo'],
                $_POST['titulo'],
                $_POST['fecha_entrega']
            );

            header("Location: ../views/actividad/registro.php?status=success&msg=" . urlencode("Actividad registrada correctamente"));
            exit();
        } catch (Exception $e) {
            header("Location: ../views/actividad/registro.php?status=error&msg=" . urlencode($e->getMessage()));
            exit();
        }
    }

    if ($_POST['action'] === 'editar-actividad') {

        try {
            Actividad::editar(
                (int)$_POST['id_actividad'],
                $_POST['id_curso'],
                $_POST['tipo'],
                $_POST['titulo'],
                $_POST['fecha_entrega']
            );

            header("Location: ../views/actividad/listado.php?status=success&msg=" . urlencode("Actividad actualizada correctamente"));
            exit();
        } catch (Exception $e) {
            header("Location: ../views/actividad/listado.php?status=error&msg=" . urlencode($e->getMessage()));
            exit();
        }
    }

    if ($_POST['action'] === 'eliminar-actividad') {

        try {
            Actividad::eliminar((int)$_POST['id_actividad']);

            header("Location: ../views/actividad/listado.php?status=success&msg=" . urlencode("Actividad eliminada correctamente"));
            exit();
        } catch (Exception $e) {
            header("Location: ../views/actividad/listado.php?status=error&msg=" . urlencode($e->getMessage()));
            exit();
        }
    }
}
