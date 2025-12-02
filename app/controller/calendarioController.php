<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/models/Calendario.php';

function get_calendario()
{
    return Calendario::lista_calendario();
}

function get_calendario_por_curso($id_curso)
{
    return Calendario::lista_por_curso($id_curso);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] === 'registrar-calendario') {

        try {
            Calendario::registrar(
                $_POST['id_curso'],
                $_POST['semana'],
                $_POST['fecha_inicio'],
                $_POST['fecha_fin']
            );

            header("Location: /G7_SC-609_Proyecto_MN/app/views/calendario/registro.php?status=success&msg=Registro de calendario guardado correctamente");
            exit();
        } catch (Exception $e) {
            header("Location: /G7_SC-609_Proyecto_MN/app/views/calendario/registro.php?status=error&msg=" . urlencode($e->getMessage()));
            exit();
        }
    }

    if ($_POST['action'] === 'editar-calendario') {

        try {
            Calendario::editar(
                (int)$_POST['id_calendario'],
                $_POST['id_curso'],
                $_POST['semana'],
                $_POST['fecha_inicio'],
                $_POST['fecha_fin']
            );

            header("Location: /G7_SC-609_Proyecto_MN/app/views/calendario/listado.php?status=success&msg=Calendario actualizado correctamente");
            exit();
        } catch (Exception $e) {
            header("Location: /G7_SC-609_Proyecto_MN/app/views/calendario/listado.php?status=error&msg=" . urlencode($e->getMessage()));
            exit();
        }
    }

    if ($_POST['action'] === 'eliminar-calendario') {

        try {
            Calendario::eliminar((int)$_POST['id_calendario']);

            header("Location: /G7_SC-609_Proyecto_MN/app/views/calendario/listado.php?status=success&msg=Registro de calendario eliminado correctamente");
            exit();
        } catch (Exception $e) {
            header("Location: /G7_SC-609_Proyecto_MN/app/views/calendario/listado.php?status=error&msg=" . urlencode($e->getMessage()));
            exit();
        }
    }
}
