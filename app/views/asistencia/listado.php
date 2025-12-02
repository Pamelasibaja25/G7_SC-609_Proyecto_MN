<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/controllers/AsistenciaController.php';

$asistencias = get_asistencias();
$status = $_GET['status'] ?? null;
$msg = $_GET['msg'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Listado de Asistencias</title>
    <link rel="stylesheet" href="/G7_SC-609_Proyecto_MN/lib/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Listado de Asistencias</h1>

    <?php if ($status && $msg): ?>
        <div class="alert alert-<?= $status === 'success' ? 'success' : 'danger' ?>">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>

    <a href="/G7_SC-609_Proyecto_MN/app/views/asistencia/registro.php" class="btn btn-success mb-3">
        Registrar nueva asistencia
    </a>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>ID Usuario</th>
            <th>ID Curso</th>
            <th>Semana</th>
            <th>Asistió</th>
            <th style="width: 180px;">Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($asistencias)): ?>
            <tr>
                <td colspan="6" class="text-center">No hay registros de asistencia.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($asistencias as $a): ?>
                <tr>
                    <td><?= htmlspecialchars($a['_id']) ?></td>
                    <td><?= htmlspecialchars($a['id_usuario']) ?></td>
                    <td><?= htmlspecialchars($a['id_curso']) ?></td>
                    <td><?= htmlspecialchars($a['semana']) ?></td>
                    <td>
                        <?= $a['asistio'] ? 'Sí' : 'No' ?>
                    </td>
                    <td>
                        <!-- Enlace a editar -->
                        <a href="/G7_SC-609_Proyecto_MN/app/views/asistencia/editar.php?id_asistencia=<?= urlencode($a['_id']) ?>"
                           class="btn btn-sm btn-primary">
                            Editar
                        </a>

                        <!-- Formulario para eliminar -->
                        <form method="post"
                              action="/G7_SC-609_Proyecto_MN/app/controllers/AsistenciaController.php"
                              class="d-inline">
                            <input type="hidden" name="action" value="eliminar-asistencia">
                            <input type="hidden" name="id_asistencia" value="<?= htmlspecialchars($a['_id']) ?>">
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Eliminar este registro de asistencia?');">
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
</body>
</html>
