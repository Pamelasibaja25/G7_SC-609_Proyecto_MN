<?php
require_once __DIR__ . '/../../controller/grupoController.php';

$grupos = get_grupos();

$idCursoFiltro = $_GET['id_curso'] ?? '';

if ($idCursoFiltro !== '') {
    $grupos = array_filter($grupos, function ($g) use ($idCursoFiltro) {
        return (int) $g['id_curso'] === (int) $idCursoFiltro;
    });
}

$status = $_GET['status'] ?? null;
$msg = $_GET['msg'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Grupos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- CSS propio -->
    <link href="/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/public/css/style.css" rel="stylesheet" type="text/css" />
    <!-- JS (jQuery, Popper, Bootstrap JS) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- JS propio -->
    <script src="/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/public/js/scripts.js"></script>
</head>

<body>

    <?php include __DIR__ . '/../nav_menu.php'; ?>

    <section class="bg-custom">
        <div class="container mt-5">
            <h1 class="text-center text-white mb-4">Listado de Grupos</h1>

            <?php if ($status && $msg): ?>
                <div class="alert alert-<?= $status === 'success' ? 'success' : 'danger' ?>">
                    <?= htmlspecialchars($msg) ?>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <a href="registro.php" class="btn bg-body-custom text-white">Registrar nuevo grupo</a>
            </div>
            <!-- Filtro por ID Curso -->
            <form method="get" class="mb-3">
                <div class="form-row">
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
                                <th>ID Curso</th>
                                <th>Grupo</th>
                                <th>Capacidad</th>
                                <th style="width: 180px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($grupos)): ?>
                                <tr>
                                    <td colspan="5" class="text-center">No hay grupos registrados.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($grupos as $g): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($g['_id']) ?></td>
                                        <td><?= htmlspecialchars($g['id_curso']) ?></td>
                                        <td><?= htmlspecialchars($g['grupo']) ?></td>
                                        <td><?= htmlspecialchars($g['capacidad']) ?></td>
                                        <td>
                                            <a href="editar.php?id_grupo=<?= urlencode($g['_id']) ?>"
                                                class="btn btn-sm btn-primary">Editar</a>

                                            <form method="post" action="../../controller/grupoController.php" class="d-inline">
                                                <input type="hidden" name="action" value="eliminar-grupo">
                                                <input type="hidden" name="id_grupo" value="<?= htmlspecialchars($g['_id']) ?>">
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('¿Eliminar este grupo?');">
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