<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../controller/calendarioController.php';

// Filtro opcional por curso
$idCursoFiltro = $_GET['id_curso'] ?? '';

// Datos para el tablero
$calendario = get_calendario($idCursoFiltro !== '' ? (int) $idCursoFiltro : null);
$semanaActual = get_semana_actual($idCursoFiltro !== '' ? (int) $idCursoFiltro : null);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Calendario Académico</title>
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
            <h1 class="text-center text-white mb-4">Calendario Académico</h1>

            <!-- Fila principal: Semana actual + filtros -->
            <div class="row">
                <!-- Semana actual -->
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-header bg-body-custom text-white">
                            Semana actual
                        </div>
                        <div class="card-body">
                            <?php if ($semanaActual): ?>
                                <h4 class="card-title mb-3">
                                    <?= htmlspecialchars($semanaActual['semana']) ?>
                                </h4>
                                <p class="mb-1">
                                    <strong>Curso (ID):</strong>
                                    <?= htmlspecialchars($semanaActual['id_curso']) ?>
                                </p>
                                <p class="mb-1">
                                    <strong>Fecha inicio:</strong>
                                    <?= htmlspecialchars($semanaActual['fecha_inicio']) ?>
                                </p>
                                <p class="mb-1">
                                    <strong>Fecha fin:</strong>
                                    <?= htmlspecialchars($semanaActual['fecha_fin']) ?>
                                </p>
                                <p class="mt-3 mb-0 text-muted">
                                    Hoy: <?= date('Y-m-d') ?>
                                </p>
                            <?php else: ?>
                                <p class="mb-0">
                                    Hoy (<strong><?= date('Y-m-d') ?></strong>) no cae dentro
                                    de ninguna semana configurada en el calendario
                                    <?= $idCursoFiltro !== '' ? 'para el curso ID ' . htmlspecialchars($idCursoFiltro) : '' ?>.
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-header bg-body-custom text-white">
                            Filtros
                        </div>
                        <div class="card-body">
                            <form method="get">
                                <div class="form-group">
                                    <label for="id_curso">Filtrar por ID de curso</label>
                                    <input type="number" class="form-control" id="id_curso" name="id_curso"
                                        placeholder="Ej: 1" value="<?= htmlspecialchars($idCursoFiltro) ?>">
                                    <small class="form-text text-muted">
                                        Si lo dejas vacío, se mostrarán todas las semanas de todos los cursos.
                                    </small>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Aplicar filtro
                                </button>
                                <a href="dashboard.php" class="btn btn-secondary">
                                    Limpiar
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla del calendario -->
            <div class="row mt-4">
                <div class="col-12">
                    <h2 class=" text-white">Semanas configuradas</h2>
                    <div class="card mt-3">
                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-hover text-center mb-0">
                                <thead class="bg-body-custom text-white">

                                    <tr>
                                        <th>ID</th>
                                        <th>ID Curso</th>
                                        <th>Semana</th>
                                        <th>Fecha inicio</th>
                                        <th>Fecha fin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($calendario)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                No hay semanas configuradas
                                                <?= $idCursoFiltro !== '' ? 'para el curso ID ' . htmlspecialchars($idCursoFiltro) : '' ?>.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($calendario as $fila): ?>
                                            <?php
                                            $esSemanaActual = $semanaActual && $semanaActual['_id'] === $fila['_id'];
                                            ?>
                                            <tr class="<?= $esSemanaActual ? 'table-success' : '' ?>">
                                                <td><?= htmlspecialchars($fila['_id']) ?></td>
                                                <td><?= htmlspecialchars($fila['id_curso']) ?></td>
                                                <td><?= htmlspecialchars($fila['semana']) ?></td>
                                                <td><?= htmlspecialchars($fila['fecha_inicio']) ?></td>
                                                <td><?= htmlspecialchars($fila['fecha_fin']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <p class="text-center text-muted mt-2">
                            La fila resaltada en verde (si la hay) corresponde a la semana actual según la fecha de hoy.
                        </p>
                    </div>
                </div>
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