<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/controllers/AsistenciaController.php';

// Validar que venga el id
if (!isset($_GET['id_asistencia'])) {
    // Si no viene ID, puedes redirigir al listado
    header("Location: /G7_SC-609_Proyecto_MN/app/views/asistencia/listado.php?status=error&msg=" . urlencode("ID de asistencia no especificado"));
    exit();
}

$idAsistencia = (int)$_GET['id_asistencia'];
$asistencia = get_asistencia($idAsistencia);

if (!$asistencia) {
    header("Location: /G7_SC-609_Proyecto_MN/app/views/asistencia/listado.php?status=error&msg=" . urlencode("Registro de asistencia no encontrado"));
    exit();
}

$status = $_GET['status'] ?? null;
$msg = $_GET['msg'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Editar Asistencia</title>
    <link rel="stylesheet" href="/G7_SC-609_Proyecto_MN/lib/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Editar Asistencia</h1>

    <?php if ($status && $msg): ?>
        <div class="alert alert-<?= $status === 'success' ? 'success' : 'danger' ?>">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>

    <form method="post" action="/G7_SC-609_Proyecto_MN/app/controllers/AsistenciaController.php">
        <input type="hidden" name="action" value="editar-asistencia">
        <input type="hidden" name="id_asistencia" value="<?= htmlspecialchars($asistencia['_id']) ?>">

        <div class="mb-3">
            <label for="id_usuario" class="form-label">ID Usuario</label>
            <input type="number"
                   class="form-control"
                   id="id_usuario"
                   name="id_usuario"
                   value="<?= htmlspecialchars($asistencia['id_usuario']) ?>"
                   required>
        </div>

        <div class="mb-3">
            <label for="id_curso" class="form-label">ID Curso</label>
            <input type="number"
                   class="form-control"
                   id="id_curso"
                   name="id_curso"
                   value="<?= htmlspecialchars($asistencia['id_curso']) ?>"
                   required>
        </div>

        <div class="mb-3">
            <label for="semana" class="form-label">Semana</label>
            <input type="text"
                   class="form-control"
                   id="semana"
                   name="semana"
                   value="<?= htmlspecialchars($asistencia['semana']) ?>"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label" for="asistio">Asistió</label>
            <select class="form-select" id="asistio" name="asistio" required>
                <option value="1" <?= $asistencia['asistio'] ? 'selected' : '' ?>>Sí</option>
                <option value="0" <?= !$asistencia['asistio'] ? 'selected' : '' ?>>No</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="/G7_SC-609_Proyecto_MN/app/views/asistencia/listado.php" class="btn btn-secondary">Volver al listado</a>
    </form>
</div>
</body>
</html>
