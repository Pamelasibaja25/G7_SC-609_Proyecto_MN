<?php
require_once __DIR__ . '/../models/escuela.php';

function get_escuelas()
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
function get_escuela_resumen()
{
    return Escuela::resumen();
}
function get_escuelas_admin()
{
    return Escuela::lista_escuelas();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['action'] === 'registrar-escuela') {

        try{
        Escuela::registrar(
            $_POST['nombre'],
            $_POST['provincia']
        );

        header("Location: /G7_SC-609_Proyecto_MN/app/views/escuela/registro.php?status=success&msg=Escuela registrada correctamente");
        exit();
    }
    catch (Exception $e) {
        header("Location: /G7_SC-609_Proyecto_MN/app/views/escuela/registro.php?status=error&msg=" . urlencode($e->getMessage()));
        exit();
    }
    }

    if ($_POST['action'] === 'editar-escuela') {

        try{
        escuela::editar(
            (int)$_POST['id_escuela'],
            $_POST['nombre'],
            $_POST['provincia']
        );

        header("Location: /G7_SC-609_Proyecto_MN/app/views/escuela/listado.php?status=success&msg=Escuela actualizada correctamente");
        exit();
    }
    catch (Exception $e) {
        header("Location: /G7_SC-609_Proyecto_MN/app/views/escuela/listado.php?status=error&msg=" . urlencode($e->getMessage()));
        exit();
    }
    }

    if ($_POST['action'] === 'eliminar-escuela') {

        try{
        escuela::eliminar((int)$_POST['id_escuela']);

        header("Location: /G7_SC-609_Proyecto_MN/app/views/escuela/listado.php?status=success&msg=Escuela eliminada correctamente");
        exit();
        }
        catch (Exception $e) {
        header("Location: /G7_SC-609_Proyecto_MN/app/views/escuela/listado.php?status=error&msg=" . urlencode($e->getMessage()));
        exit();
    }
    }
}
?>
