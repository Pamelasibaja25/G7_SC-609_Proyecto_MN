<?php
require_once __DIR__ . '/../../controller/grupoController.php';

// Validar que venga el id
if (!isset($_GET['id_grupo'])) {
    header("Location: listado.php?status=error&msg=" . urlencode("ID de grupo no especificado"));
    exit();
}

$idGrupo = (int) $_GET['id_grupo'];
$grupo = get_grupo($idGrupo);

if (!$grupo) {
    header("Location: listado.php?status=error&msg=" . urlencode("Grupo no encontrado"));
    exit();
}

$status = $_GET['status'] ?? null;
$msg = $_GET['msg'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Grupo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- CSS propio -->
    <link href="/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/public/css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>

    <?php include __DIR__ . '/../nav_menu.php'; ?>

    <section class="bg-custom">
        <div class="container mt-5">
            <h1 class="text-center text-white mb-4">Editar Grupo</h1>

            <?php if ($status && $msg): ?>
                <div class="alert alert-<?= $status === 'success' ? 'success' : 'danger' ?>">
                    <?= htmlspecialchars($msg) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="../../controller/grupoController.php">
                <input type="hidden" name="action" value="editar-grupo">
                <input type="hidden" name="id_grupo" value="<?= htmlspecialchars($grupo['_id']) ?>">

                <div class="form-group">
                    <label for="id_curso" class=" text-white">ID Curso</label>
                    <input type="number" class="form-control" id="id_curso" name="id_curso"
                        value="<?= htmlspecialchars($grupo['id_curso']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="grupo" class=" text-white">Nombre del Grupo</label>
                    <input type="text" class="form-control" id="grupo" name="grupo"
                        value="<?= htmlspecialchars($grupo['grupo']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="capacidad" class=" text-white">Capacidad</label>
                    <input type="number" class="form-control" id="capacidad" name="capacidad"
                        value="<?= htmlspecialchars($grupo['capacidad']) ?>" required>
                </div>


                <div class="text-center d-flex justify-content-between">
                    <button type="submit" class=" text-white btn bg-body-custom">Guardar</button>
                    <a href="listado.php" class="btn btn-secondary">Ver listado</a>
                </div>
            </form>
        </div>

    </section>
    <!-- JS Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <footer class="bg-primary text-white py-3 mt-5">
        <div class="container">
            <p class="mb-0 text-center">
                Derechos Reservados &mdash; Escuela en Casa 2025
            </p>
        </div>
    </footer>
</body>

</html>