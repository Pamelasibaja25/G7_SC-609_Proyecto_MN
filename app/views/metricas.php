<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../controller/metricasController.php';

$metricas = get_metricas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Métricas - Escuela en Casa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- CSS propio -->
    <link href="/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/public/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php include __DIR__ . '/nav_menu.php'; ?>

<div class="container py-4">
    <h1 class="mb-4">Métricas del Sistema</h1>

    <div class="row">

        <div class="col-md-4 mb-3">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <h5 class="card-title">Usuarios del sistema</h5>
                    <p class="card-text display-4">
                        <?= htmlspecialchars($metricas['usuarios']) ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-white bg-success h-100">
                <div class="card-body">
                    <h5 class="card-title">Estudiantes registrados</h5>
                    <p class="card-text display-4">
                        <?= htmlspecialchars($metricas['estudiantes']) ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-white bg-info h-100">
                <div class="card-body">
                    <h5 class="card-title">Cursos creados</h5>
                    <p class="card-text display-4">
                        <?= htmlspecialchars($metricas['cursos']) ?>
                    </p>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-3">

        <div class="col-md-4 mb-3">
            <div class="card text-white bg-secondary h-100">
                <div class="card-body">
                    <h5 class="card-title">Escuelas registradas</h5>
                    <p class="card-text display-4">
                        <?= htmlspecialchars($metricas['escuelas']) ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-white bg-warning h-100">
                <div class="card-body">
                    <h5 class="card-title">Profesores registrados</h5>
                    <p class="card-text display-4">
                        <?= htmlspecialchars($metricas['profesores']) ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-white bg-dark h-100">
                <div class="card-body">
                    <h5 class="card-title">Cursos matriculados este año</h5>
                    <p class="card-text display-4">
                        <?= htmlspecialchars($metricas['matriculados_anio']) ?>
                    </p>
                    <p class="mb-0">
                        <small>Año: <?= date('Y') ?></small>
                    </p>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-4">
        <div class="col-12">
            <h2>Cursos por estado</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered mt-2">
                    <thead class="thead-light">
                        <tr>
                            <th>Estado</th>
                            <th>Cantidad de cursos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($metricas['cursos_por_estado'])): ?>
                            <?php foreach ($metricas['cursos_por_estado'] as $estado => $total): ?>
                                <tr>
                                    <td><?= htmlspecialchars($estado) ?></td>
                                    <td><?= htmlspecialchars($total) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" class="text-center">
                                    No hay información disponible sobre estados de cursos.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- JS (jQuery, Popper, Bootstrap JS) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
