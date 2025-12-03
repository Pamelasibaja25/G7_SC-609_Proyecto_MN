<?php
require_once __DIR__ . '/../../controller/grupoController.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Grupo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- CSS propio -->
    <link href="/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/public/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php include __DIR__ . '/../nav_menu.php'; ?>

<div class="container py-4">
    <h1 class="mb-4">Registrar Grupo</h1>

    <?php
    $status = $_GET['status'] ?? null;
    $msg    = $_GET['msg'] ?? null;
    ?>

    <?php if ($status && $msg): ?>
        <div class="alert alert-<?= $status === 'success' ? 'success' : 'danger' ?>">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>

    <form method="post" action="../../controller/grupoController.php">
        <input type="hidden" name="action" value="registrar-grupo">

        <div class="form-group">
            <label for="id_curso">ID Curso</label>
            <input type="number" class="form-control" id="id_curso" name="id_curso" required>
        </div>

        <div class="form-group">
            <label for="grupo">Nombre del Grupo</label>
            <input type="text" class="form-control" id="grupo" name="grupo" placeholder="Ej: Grupo 1" required>
        </div>

        <div class="form-group">
            <label for="capacidad">Capacidad</label>
            <input type="number" class="form-control" id="capacidad" name="capacidad" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="listado.php" class="btn btn-secondary">Ver listado</a>
    </form>
</div>

<!-- JS Bootstrap -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
