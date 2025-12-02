<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/controllers/ActividadController.php';

// Aquí podrías cargar lista de cursos si tienes un modelo Curso
// $cursos = get_cursos(); // Ejemplo
$status = $_GET['status'] ?? null;
$msg = $_GET['msg'] ?? null;

// include 'ruta/a/header.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registrar Actividad</title>
    <link rel="stylesheet" href="/G7_SC-609_Proyecto_MN/lib/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Registrar Actividad</h1>

    <?php if ($status && $msg): ?>
        <div class="alert alert-<?= $status === 'success' ? 'success' : 'danger' ?>">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>

    <form method="post" action="/G7_SC-609_Proyecto_MN/app/controllers/ActividadController.php">
        <input type="hidden" name="action" value="registrar-actividad">

        <div class="mb-3">
            <label for="id_curso" class="form-label">ID Curso</label>
            <input type="number" class="form-control" id="id_curso" name="id_curso" required>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Tarea, Examen, Proyecto..." required>
        </div>

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>

        <div class="mb-3">
            <label for="fecha_entrega" class="form-label">Fecha de entrega</label>
            <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="/G7_SC-609_Proyecto_MN/app/views/actividad/listado.php" class="btn btn-secondary">Ver listado</a>
    </form>
</div>
</body>
</html>
