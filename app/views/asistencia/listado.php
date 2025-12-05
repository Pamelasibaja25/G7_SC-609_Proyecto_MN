<?php
require_once __DIR__ . '/../../controller/AsistenciaController.php';

$asistencias = get_asistencias();

$idUsuarioFiltro = $_GET['id_usuario'] ?? '';
$idCursoFiltro = $_GET['id_curso'] ?? '';

if ($idUsuarioFiltro !== '' || $idCursoFiltro !== '') {
    $asistencias = array_filter($asistencias, function ($a) use ($idUsuarioFiltro, $idCursoFiltro) {
        if ($idUsuarioFiltro !== '' && (int) $a['id_usuario'] !== (int) $idUsuarioFiltro) {
            return false;
        }
        if ($idCursoFiltro !== '' && (int) $a['id_curso'] !== (int) $idCursoFiltro) {
            return false;
        }
        return true;
    });
}

$status = $_GET['status'] ?? null;
$msg = $_GET['msg'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Asistencias</title>
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
            <h1 class="text-center text-white mb-4">Listado de Asistencias</h1>

            <?php if ($status && $msg): ?>
                <div class="alert alert-<?= $status === 'success' ? 'success' : 'danger' ?>">
                    <?= htmlspecialchars($msg) ?>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <a href="registro.php" class="btn bg-body-custom text-white">Registrar nueva asistencia</a>
            </div>
            <!-- Filtros por ID -->
            <form method="get" class="mb-3">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="id_usuario" class=" text-white">Filtrar por ID Usuario</label>
                        <input type="number" class="form-control" id="id_usuario" name="id_usuario"
                            value="<?= htmlspecialchars($idUsuarioFiltro) ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="id_curso" class=" text-white">Filtrar por ID Curso</label>
                        <input type="number" class="form-control" id="id_curso" name="id_curso"
                            value="<?= htmlspecialchars($idCursoFiltro) ?>">
                    </div>

                    <div class="form-group col-md-3 align-self-end">
                        <button type="submit" class="btn text-white bg-body-custom">Aplicar filtros</button>
                        <a href="listado.php" class="btn btn-secondary">Limpiar</a>
                    </div>
                </div>
            </form>

            <div class="card mt-3">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center mb-0">
                        <thead class="bg-body-custom text-white">

                            <tr>
                                <th>ID</th>
                                <th>ID Usuario</th>
                                <th>ID Curso</th>
                                <th>Semana</th>
                                <th>Estado</th>
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
                                        <td><?= $a['asistio'] ? 'Presente' : 'Ausente' ?></td>
                                        <td>
                                            <a href="editar.php?id_asistencia=<?= urlencode($a['_id']) ?>"
                                                class="btn btn-sm btn-primary">Editar</a>

                                            <form method="post" action="../../controller/AsistenciaController.php"
                                                class="d-inline">
                                                <input type="hidden" name="action" value="eliminar-asistencia">
                                                <input type="hidden" name="id_asistencia"
                                                    value="<?= htmlspecialchars($a['_id']) ?>">
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
    </section>

    <footer class="bg-primary text-white py-3 mt-5">
        <div class="container">
            <p class="mb-0 text-center">
                Derechos Reservados &mdash; Escuela en Casa 2025
            </p>
        </div>
    </footer>

    <!-- JS Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>