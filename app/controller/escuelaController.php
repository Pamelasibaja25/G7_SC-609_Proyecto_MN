<?php
// app/controller/escuelaController.php

require_once __DIR__ . '/../models/Escuela.php';

function get_escuela_resumen()
{
    // Ajusta el nombre del método si tu modelo usa otro (por ejemplo, resumen_escuelas)
    return Escuela::resumen_escuelas();
}

function get_escuelas()
{
    return Escuela::lista_escuelas();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    // Registrar escuela
    if ($_POST['action'] === 'registrar-escuela') {

        try {
            Escuela::registrar(
                $_POST['nombre'],
                $_POST['direccion'],
                $_POST['telefono'],
                $_POST['correo']
            );

            header("Location: ../views/escuela/registro.php?status=success&msg=" . urlencode("Escuela registrada correctamente"));
            exit();
        } catch (Exception $e) {
            header("Location: ../views/escuela/registro.php?status=error&msg=" . urlencode($e->getMessage()));
            exit();
        }
    }

    // Editar escuela
    if ($_POST['action'] === 'editar-escuela') {

        try {
            Escuela::editar(
                (int)$_POST['id_escuela'],
                $_POST['nombre'],
                $_POST['direccion'],
                $_POST['telefono'],
                $_POST['correo']
            );

            header("Location: ../views/escuela/listado.php?status=success&msg=" . urlencode("Escuela actualizada correctamente"));
            exit();
        } catch (Exception $e) {
            header("Location: ../views/escuela/listado.php?status=error&msg=" . urlencode($e->getMessage()));
            exit();
        }
    }

    // Eliminar escuela
    if ($_POST['action'] === 'eliminar-escuela') {

        try {
            Escuela::eliminar((int)$_POST['id_escuela']);

            header("Location: ../views/escuela/listado.php?status=success&msg=" . urlencode("Escuela eliminada correctamente"));
            exit();
        } catch (Exception $e) {
            header("Location: ../views/escuela/listado.php?status=error&msg=" . urlencode($e->getMessage()));
            exit();
        }
    }
}
