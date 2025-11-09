<?php
include $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/controller/metricasController.php';
$metricas = get_metricas();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Escuela en Casa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="/G7_SC-609_Proyecto_MN/public/css/style.css" rel="stylesheet" type="text/css" />
    <!-- jQuery + Popper + Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/views/nav_menu.php';
    ?>

    <section class="bg-custom" id="metricas">
        <div class="container mt-5">
            <h1 class="text-center text-white">Métricas Generales del Sistema</h1>

            <div class="row justify-content-center text-center">
                <!-- Columna 1 -->
                <div class="col-md-6 col-lg-5 mb-4">
                    <div class="card mb-4">
                        <div class="card-header bg-body-custom text-white">Usuarios, Profesores y Estudiantes</div>
                        <div class="card-body text-center">
                            <p><strong>Usuarios Totales:</strong> <?= htmlspecialchars($metricas['usuarios']); ?></p>
                            <p><strong>Estudiantes Únicos:</strong> <?= htmlspecialchars($metricas['estudiantes']); ?></p>
                            <p><strong>Profesores:</strong> <?= htmlspecialchars($metricas['profesores']); ?></p>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-body-custom text-white">Escuelas Registradas</div>
                        <div class="card-body text-center">
                            <h3><?= htmlspecialchars($metricas['escuelas']); ?></h3>
                            <p>Total de instituciones activas en el sistema.</p>
                        </div>
                    </div>
                </div>

                <!-- Columna 2 -->
                <div class="col-md-6 col-lg-5 mb-4">
                    <div class="card mb-4">
                        <div class="card-header bg-body-custom text-white">Cursos</div>
                        <div class="card-body text-center">
                            <p><strong>Cursos Totales:</strong> <?= htmlspecialchars($metricas['cursos']); ?></p>
                            <p><strong>Cursos Matriculados <?= date('Y'); ?>:</strong> <?= htmlspecialchars($metricas['matriculados_anio']); ?></p>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-body-custom text-white">Cursos por Estado</div>
                        <div class="card-body">
                            <?php if (!empty($metricas['cursos_por_estado'])): ?>
                                <table class="table table-bordered text-center">
                                    <thead class="bg-body-custom text-white">
                                        <tr>
                                            <th>Estado</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($metricas['cursos_por_estado'] as $estado => $total): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($estado); ?></td>
                                                <td><?= htmlspecialchars($total); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p class="text-center">No hay datos disponibles.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="navbar-light bg-primary text-white mt-5 p-3">
        <div class="container">
            <p class="text-center">Derechos Reservados - Escuela en Casa 2025</p>
        </div>
    </footer>
</body>
</html>
