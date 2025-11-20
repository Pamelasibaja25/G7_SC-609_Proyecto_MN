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
?>
