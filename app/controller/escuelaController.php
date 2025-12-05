<?php
// app/controller/escuelaController.php

require_once __DIR__ . '/../models/Escuela.php';

function get_escuela_resumen()
{
    // Ajusta el nombre del método si tu modelo usa otro (por ejemplo, resumen_escuelas)
    return Escuela::resumen();
}
function get_escuelas_option()
{
    try {
        $escuelas = Escuela::get_escuelas();

        if (!empty($escuelas)) {
            foreach ($escuelas as $row) {
                $id = isset($row['_id']) ? (string)$row['_id'] : (isset($row['id_escuela']) ? $row['id_escuela'] : '');
                $descripcion = $row['nombre'] ?? $row['descripcion'] ?? '';

                echo '<option value="' . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . '" text="' . htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8') . '">'
                     . htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8') .
                     '</option>';
            }
        } else {
            echo '<p class="text-center text-white">No hay escuelas disponibles.</p>';
        }
    } catch (Exception $e) {
        header("Location: ../../layout.php?status=error&msg=" . urlencode($e->getMessage()));
        exit();
    }
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
            $_POST['provincia']
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
