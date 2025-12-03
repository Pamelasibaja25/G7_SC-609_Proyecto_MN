<?php
// Controller de Grupo

require_once __DIR__ . '/../models/Grupo.php';

function get_grupos()
{
    return Grupo::lista_grupos();
}

function get_grupos_por_curso($id_curso)
{
    return Grupo::lista_por_curso($id_curso);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] === 'registrar-grupo') {

        try {
            Grupo::registrar(
                $_POST['id_curso'],
                $_POST['grupo'],
                $_POST['capacidad']
            );

            header("Location: ../views/grupo/registro.php?status=success&msg=" . urlencode("Grupo registrado correctamente"));
            exit();
        } catch (Exception $e) {
            header("Location: ../views/grupo/registro.php?status=error&msg=" . urlencode($e->getMessage()));
            exit();
        }
    }

    if ($_POST['action'] === 'editar-grupo') {

        try {
            Grupo::editar(
                (int)$_POST['id_grupo'],
                $_POST['id_curso'],
                $_POST['grupo'],
                $_POST['capacidad']
            );

            header("Location: ../views/grupo/listado.php?status=success&msg=" . urlencode("Grupo actualizado correctamente"));
            exit();
        } catch (Exception $e) {
            header("Location: ../views/grupo/listado.php?status=error&msg=" . urlencode($e->getMessage()));
            exit();
        }
    }

    if ($_POST['action'] === 'eliminar-grupo') {

        try {
            Grupo::eliminar((int)$_POST['id_grupo']);

            header("Location: ../views/grupo/listado.php?status=success&msg=" . urlencode("Grupo eliminado correctamente"));
            exit();
        } catch (Exception $e) {
            header("Location: ../views/grupo/listado.php?status=error&msg=" . urlencode($e->getMessage()));
            exit();
        }
    }
}
