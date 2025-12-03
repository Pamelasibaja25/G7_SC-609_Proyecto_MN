<?php
// Controlador de Actividad
require_once __DIR__ . '/../../controller/ActividadController.php';

$actividades = get_actividades();
$status      = $_GET['status'] ?? null;
$msg         = $_GET['msg'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Actividades</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <!-- CSS proyecto -->
    <link href="/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/public/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>

    <!-- Menú de navegación -->
    <?php include __DIR__ . '/../nav_menu.php'; ?>

    <div class="container py-4">
        <h1 class="mb-4">Listado de Actividades</h1>

        <?php if ($status && $msg): ?>
            <div class="alert alert-<?= $status === 'success' ? 'success' : 'danger' ?>">
                <?= htmlspecialchars($msg) ?>
            </div>
        <?php endif; ?>

        <a href="registro.php" class="btn btn-success mb-3">
            Registrar nueva actividad
        </a>

        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>ID Curso</th>
                <th>Tipo</th>
                <th>Título</th>
                <th>Fecha de Entrega</th>
                <th style="width: 150px;">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($actividades)): ?>
                <tr>
                    <td colspan="6" class="text-center">No hay actividades registradas.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($actividades as $a): ?>
                    <tr>
                        <td><?= htmlspecialchars($a['_id']) ?></td>
                        <td><?= htmlspecialchars($a['id_curso']) ?></td>
                        <td><?= htmlspecialchars($a['tipo']) ?></td>
                        <td><?= htmlspecialchars($a['titulo']) ?></td>
                        <td><?= htmlspecialchars($a['fecha_entrega']) ?></td>
                        <td>

                            <form method="post"
                                  action="../../controller/ActividadController.php"
                                  class="d-inline">
                                <input type="hidden" name="action" value="eliminar-actividad">
                                <input type="hidden" name="id_actividad" value="<?= htmlspecialchars($a['_id']) ?>">
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('¿Eliminar esta actividad?');">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- JS (jQuery, Popper, Bootstrap JS) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
