<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/controllers/AsistenciaController.php';
$status = $_GET['status'] ?? null;
$msg = $_GET['msg'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registrar Asistencia</title>
    <link rel="stylesheet" href="/G7_SC-609_Proyecto_MN/lib/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Registrar Asistencia</h1>

    <?php if ($status && $msg): ?>
        <div class="alert alert-<?= $status === 'success' ? 'success' : 'danger' ?>">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>

    <form method="post" action="/G7_SC-609_Proyecto_MN/app/controllers/AsistenciaController.php">
        <input type="hidden" name="action" value="registrar-asistencia">

        <div class="mb-3">
            <label for="id_usuario" class="form-label">ID Usuario</label>
            <input type="number" class="form-control" id="id_usuario" name="id_usuario" required>
        </div>

        <div class="mb-3">
            <label for="id_curso" class="form-label">ID Curso</label>
            <input type="number" class="form-control" id="id_curso" name="id_curso" required>
        </div>

        <div class="mb-3">
            <label for="semana" class="form-label">Semana</label>
            <input type="text" class="form-control" id="semana" name="semana" placeholder="Semana 1, Semana 2, ..." required>
        </div>

        <div class="mb-3">
            <label class="form-label">Asistió</label>
            <select class="form-select" name="asistio" required>
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="/G7_SC-609_Proyecto_MN/app/views/asistencia/listado.php" class="btn btn-secondary">Ver listado</a>
    </form>
</div>
</body>
</html>
