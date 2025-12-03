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
include __DIR__ . '/../nav_menu.php';
?>

    <section class="bg-custom">
        <div class="container mt-5">
            <h1 class="text-center text-white">Reporte Rendimiento de Estudiantes</h1>

            <div class="row mt-4">
                <!-- Filtro -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-body-custom text-white">Filtros</div>
                        <form id="reporte_rendimiento-form" action="/G7_SC-609_Proyecto_MN/app/controller/estudianteController.php"
                        method="POST">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="Estudiante">Estudiante:</label>
                                        <select id="id_estudiante" name="id_estudiante" class="form-select" required>
                                            <option value="All">
                                                All
                                            </option>
                                            <?php
                                            include $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/controller/estudianteController.php';
                                            get_estudiantes();
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Grado">Grados:</label>
                                        <select class="form-select" id="grado" name="grado" aria-label="Default select example"
                                            required="true">
                                            <option value="All">
                                                All
                                            </option>
                                            <option value="Primero">Primero</option>
                                            <option value="Segundo">Segundo</option>
                                            <option value="Tercero">Tercero</option>
                                            <option value="Cuarto">Cuarto</option>
                                            <option value="Quinto">Quinto</option>
                                            <option value="Sexto">Sexto</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Curso">Cursos:</label>
                                        <select class="form-select" id="id_curso" name="id_curso" aria-label="Default select example"
                                            required="true">
                                            <option value="All">
                                                All
                                            </option>
                                            <?php
                                            include $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/controller/cursoController.php';
                                            get_total_cursos();
                                            ?>
                                        </select>
                                    </div>
                                    <input type="hidden" name="action" value="filtrar-rendimiento">
                                    <div class="mt-3 text-center d-flex justify-content-between">
                                        <button type="submit" class="btn bg-body-custom text-white">Filtrar</button>
                                        <a href="" class="btn bg-body-custom text-white">Limpiar</a>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
                <!-- Información Filtrada -->
                <div class="col-md-25">
                    <div class="card" id="notas">
                        <div class="card-header bg-body-custom text-white">Datos de Estudiantes</div>
                        <div class="card-body">
                            <div class="mb-3 table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead class="bg-body-custom text-white">
                                        <tr>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Finalización</th>
                                            <th>Grado</th>
                                            <th>Curso</th>
                                            <th>Estudiante</th>
                                            <th>Nota</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($_SESSION['reportes-rendimiento'])): ?>
                                            <?php foreach ($_SESSION['reportes-rendimiento'] as $reporte): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($reporte['fecha_inicio_trimestre']) ?></td>
                                                    <td><?= htmlspecialchars($reporte['fecha_final_trimestre']) ?></td>
                                                    <td><?= htmlspecialchars($reporte['grado']) ?></td>
                                                    <td><?= htmlspecialchars($reporte['descripcion']) ?></td>
                                                    <td><?= htmlspecialchars($reporte['nombre']) ?></td>
                                                    <td><?= htmlspecialchars($reporte['nota']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6">No hay datos disponibles</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3 text-center d-flex justify-content-between">
                            <form id="imprimir-reporte"
                                    action="/G7_SC-609_Proyecto_MN/app/controller/estudianteController.php" method="POST">
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