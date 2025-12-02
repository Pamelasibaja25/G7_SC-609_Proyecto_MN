<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/controllers/ActividadController.php';

$actividades = get_actividades();
$status = $_GET['status'] ?? null;
$msg = $_GET['msg'] ?? null;

// include 'ruta/a/header.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Listado de Actividades</title>
    <link rel="stylesheet" href="/G7_SC-609_Proyecto_MN/lib/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Listado de Actividades</h1>

    <?php if ($status && $msg): ?>
        <div class="alert alert-<?= $status === 'success' ? 'success' : 'danger' ?>">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>

    <a href="/G7_SC-609_Proyecto_MN/app/views/actividad/registro.php" class="btn btn-success mb-3">
        Registrar nueva actividad
    </a>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>ID Curso</th>
            <th>Tipo</th>
            <th>Título</th>
            <th>Fecha entrega</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($actividades as $a): ?>
            <tr>
                <td><?= htmlspecialchars($a['_id']) ?></td>
                <td><?= htmlspecialchars($a['id_curso']) ?></td>
                <td><?= htmlspecialchars($a['tipo']) ?></td>
                <td><?= htmlspecialchars($a['titulo']) ?></td>
                <td><?= htmlspecialchars($a['fecha_entrega']) ?></td>
                <td>
                    <!-- Formulario de editar (simplificado: podrías redirigir a una vista editar.php) -->
                    <form method="post" action="/G7_SC-609_Proyecto_MN/app/controllers/ActividadController.php" class="d-inline">
                        <input type="hidden" name="action" value="eliminar-actividad">
                        <input type="hidden" name="id_actividad" value="<?= htmlspecialchars($a['_id']) ?>">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta actividad?');">
                            Eliminar
                        </button>
                    </form>
                    <!-- Podrías agregar un botón/ enlace a editar-actividad aquí -->
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
