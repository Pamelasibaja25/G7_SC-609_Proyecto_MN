<!DOCTYPE html>
<html>

<head>
    <title>Escuela en Casa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="/G7_SC-609_Proyecto_MN/public/css/style.css" rel="stylesheet" type="text/css" />
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>
    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
        <div class="alert alert-success text-center" role="alert">
            <?php echo htmlspecialchars($_GET['msg']); ?>
        </div>
    <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?php echo htmlspecialchars($_GET['msg']); ?>
        </div>
    <?php endif; ?>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/views/nav_menu.php'
        ?>

    <section class="class bg-custom" id="estudiante">
        <div class="container mt-5">
            <h1 class="text-center text-white">Reportes de los Cursos Lectivos del Año</h1>

            <div class="row mt-4">
                <!-- Filtro -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-body-custom text-white">Reportes</div>
                        <form id="reportes-form" action="/G7_SC-609_Proyecto_MN/app/controller/cursoController.php"
                            method="POST">
                            <div class="card">
                                <div class="card-body">
                                    <div class="p-2 mb-1 d-flex justify-content-between">
                                        <label for="Reportes Trimestral">Reporte Trimestral</label>
                                        <input type="checkbox" id="reporteTrimestral" name="reporteTrimestral"
                                            class="form-check-input" />
                                    </div>
                                    <div class="p-2 mb-1 d-flex justify-content-between">
                                        <label for="Reportes Mensual">Reporte Mensual</label>
                                        <input type="checkbox" id="reporteMensual" name="reporteMensual"
                                            class="form-check-input" />
                                    </div>
                                    <div class="p-2 mb-1 d-flex justify-content-between">
                                        <label for="Reportes Anual">Reporte Anual</label>
                                        <input type="checkbox" id="reporteAnual" name="reporteAnual"
                                            class="form-check-input" />
                                    </div>
                                    <input type="hidden" name="action" value="filtrar-reportes">
                                    <div class="mt-3 text-center d-flex justify-content-between">
                                        <button type="submit" class="btn bg-body-custom text-white">Filtrar</button>
                                        <button id="limpiar-reportes" type="reset"
                                            class="btn bg-body-custom text-white">Limpiar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Información Personal -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-body-custom text-white" id="notas">Datos Disponibles</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <p for="cedula">Nombre: <?= htmlspecialchars($_SESSION['nombre']); ?></p>
                                <table class="table table-bordered text-center">
                                    <thead class="bg-body-custom text-white">
                                        <tr>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Finalización</th>
                                            <th>Curso</th>
                                            <th>Estado</th>
                                            <th>Nota</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($_SESSION['reportes'])): ?>
                                            <?php foreach ($_SESSION['reportes'] as $reporte): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($reporte['fecha_inicio_trimestre']) ?></td>
                                                    <td><?= htmlspecialchars($reporte['fecha_final_trimestre']) ?></td>
                                                    <td><?= htmlspecialchars($reporte['descripcion']) ?></td>
                                                    <td><?= htmlspecialchars($reporte['estado']) ?></td>
                                                    <td><?= htmlspecialchars($reporte['nota']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5">No hay datos disponibles</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3 text-center d-flex justify-content-between">
                                <form id="imprimir-reporte"
                                    action="/G7_SC-609_Proyecto_MN/app/controller/cursoController.php" method="POST">
                                    <input type="hidden" name="action" value="imprimir-reporte">
                                    <button type="submit" class="btn bg-body-custom text-white">Imprimir</button>
                                </form>
                                <a href="" class="btn bg-body-custom text-white">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer footer th:fragment="footer" class="navbar-light bg-primary text-white mt-5 p-3">
        <div class="container">
            <p class="text-center">Derechos Reservados - Escuela en Casa 2025</p>
        </div>
    </footer>
</body>

</html>