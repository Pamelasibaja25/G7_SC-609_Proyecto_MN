<?php
require_once __DIR__ . '/../../controller/AsistenciaController.php';

// Validacion del id
if (!isset($_GET['id_asistencia'])) {
    header("Location: listado.php?status=error&msg=" . urlencode("ID de asistencia no especificado"));
    exit();
}

$idAsistencia = (int)$_GET['id_asistencia'];
$asistencia   = get_asistencia($idAsistencia);

if (!$asistencia) {
    header("Location: listado.php?status=error&msg=" . urlencode("Registro de asistencia no encontrado"));
    exit();
}

$status = $_GET['status'] ?? null;
$msg    = $_GET['msg'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Asistencia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- CSS propio -->
    <link href="/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/public/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php include __DIR__ . '/../nav_menu.php'; ?>

<div class="container py-4">
    <h1 class="mb-4">Editar Asistencia</h1>

    <?php if ($status && $msg): ?>
        <div class="alert alert-<?= $status === 'success' ? 'success' : 'danger' ?>">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>

    <form method="post" action="../../controller/AsistenciaController.php">
        <input type="hidden" name="action" value="editar-asistencia">
        <input type="hidden" name="id_asistencia" value="<?= htmlspecialchars($asistencia['_id']) ?>">

        <div class="form-group">
            <label for="id_usuario">ID Usuario</label>
            <input type="number"
                   class="form-control"
                   id="id_usuario"
                   name="id_usuario"
                   value="<?= htmlspecialchars($asistencia['id_usuario']) ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="id_curso">ID Curso</label>
            <input type="number"
                   class="form-control"
                   id="id_curso"
                   name="id_curso"
                   value="<?= htmlspecialchars($asistencia['id_curso']) ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="semana">Semana</label>
            <input type="text"
                   class="form-control"
                   id="semana"
                   name="semana"
                   value="<?= htmlspecialchars($asistencia['semana']) ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="asistio">Estado</label>
            <select class="form-control" id="asistio" name="asistio" required>
                <option value="1" <?= $asistencia['asistio'] ? 'selected' : '' ?>>Presente</option>
                <option value="0" <?= !$asistencia['asistio'] ? 'selected' : '' ?>>Ausente</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="listado.php" class="btn btn-secondary">Volver al listado</a>
    </form>
</div>

<!-- JS Bootstrap -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>