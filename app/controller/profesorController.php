<?php
// app/controller/profesorController.php

require_once __DIR__ . '/../models/Profesor.php';

function get_profesores_resumen()
{
    return Profesor::resumen_profesores();
}

function get_especialidades_cursos()
{
    return Profesor::especialidades_cursos();
}

function get_profesores()
{
    return Profesor::lista_profesores();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    // Registrar profesor
    if ($_POST['action'] === 'registrar-profesor') {

        try {
            Profesor::registrar(
                $_POST['nombre'],
                $_POST['cedula'],
                $_POST['telefono'],
                $_POST['correo'],
                $_POST['especialidad']
            );

            // Redirección RELATIVA desde /app/controller/ al view
            header("Location: ../views/profesor/registro.php?status=success&msg=" . urlencode("Profesor registrado correctamente"));
            exit();
        } catch (Exception $e) {
            header("Location: ../views/profesor/registro.php?status=error&msg=" . urlencode($e->getMessage()));
            exit();
        }
    }

    // Editar profesor
    if ($_POST['action'] === 'editar-profesor') {

        try {
            Profesor::editar(
                (int)$_POST['id_profesor'],
                $_POST['nombre'],
                $_POST['cedula'],
                $_POST['telefono'],
                $_POST['correo'],
                $_POST['especialidad']
            );

            header("Location: ../views/profesor/listado.php?status=success&msg=" . urlencode("Profesor actualizado correctamente"));
            exit();
        } catch (Exception $e) {
            header("Location: ../views/profesor/listado.php?status=error&msg=" . urlencode($e->getMessage()));
            exit();
        }
    }

    // Eliminar profesor
    if ($_POST['action'] === 'eliminar-profesor') {

        try {
            Profesor::eliminar((int)$_POST['id_profesor']);

            header("Location: ../views/profesor/listado.php?status=success&msg=" . urlencode("Profesor eliminado correctamente"));
            exit();
        } catch (Exception $e) {
            header("Location: ../views/profesor/listado.php?status=error&msg=" . urlencode($e->getMessage()));
            exit();
        }
    }
}

