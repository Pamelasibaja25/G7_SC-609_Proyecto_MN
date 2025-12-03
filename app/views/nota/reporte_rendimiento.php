<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Escuela en Casa - Reporte de Rendimiento</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 4 (mismo que layout) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <!-- CSS propio: ojo con la ruta absoluta desde htdocs -->
    <link href="/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/public/css/style.css" rel="stylesheet" type="text/css" />

    <!-- JS (jQuery, Popper, Bootstrap JS) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>

    <?php include __DIR__ . '/../nav_menu.php'; ?>

    <section class="bg-custom py-5">
        <div class="container">
            <h1 class="text-center text-white mb-4">Reporte de Rendimiento de Estudiantes</h1>

            <div class="row">
                <!-- Filtros -->
                <div class="col-md-5 mb-4">
                    <div class="card">
                        <div class="card-header bg-body-custom text-white">
                            Filtros
                        </div>
                        <div class="card-body">

                            <form id="reporte_rendimiento-form"
                                  action="../../controller/estudianteController.php"
                                  method="POST">

                                <!-- Estudiante -->
                                <div class="mb-3">
                                    <label for="id_estudiante">Estudiante:</label>
                                    <select id="id_estudiante" name="id_estudiante" class="form-control" required>
                                        <option value="All">All</option>
                                        <?php
                                        // Cargamos el controlador de estudiantes para llenar el combo
                                        require_once __DIR__ . '/../../controller/estudianteController.php';
                                        // Asumiendo que get_estudiantes() imprime <option> directamente
                                        get_estudiantes();
                                        ?>
                                    </select>
                                </div>

                                <!-- Grado -->
                                <div class="mb-3">
                                    <label for="grado">Grado:</label>
                                    <select class="form-control" id="grado" name="grado" required>
                                        <option value="All">All</option>
                                        <option value="Primero">Primero</option>
                                        <option value="Segundo">Segundo</option>
                                        <option value="Tercero">Tercero</option>
                                        <option value="Cuarto">Cuarto</option>
                                        <option value="Quinto">Quinto</option>
                                        <option value="Sexto">Sexto</option>
                                    </select>
                                </div>

                                <!-- Curso -->
                                <div class="mb-3">
                                    <label for="id_curso">Curso:</label>
                                    <select class="form-control" id="id_curso" name="id_curso" required>
                                        <option value="All">All</option>
                                        <?php
                                        // Cargamos cursos para llenar el combo
                                        require_once __DIR__ . '/../../controller/cursoController.php';
                                        // Asumiendo que get_total_cursos() imprime <option> directamente
                                        get_total_cursos();
                                        ?>
                                    </select>
                                </div>

                                <!-- Fechas de trimestre -->
                                <div class="mb-3">
                                    <label for="fecha_inicio">Fecha inicio trimestre:</label>
                                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                                </div>

                                <div class="mb-3">
                                    <label for="fecha_final">Fecha final trimestre:</label>
                                    <input type="date" class="form-control" id="fecha_final" name="fecha_final" required>
                                </div>

                                <input type="hidden" name="action" value="filtrar-rendimiento">

                                <div class="mt-3 d-flex justify-content-between">
                                    <button type="submit" class="btn bg-body-custom text-white">
                                        Filtrar
                                    </button>
                                    <a href="reporte_rendimiento.php" class="btn btn-secondary">
                                        Limpiar
                                    </a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <!-- Resultados -->
                <div class="col-md-7 mb-4">
                    <div class="card">
                        <div class="card-header bg-body-custom text-white">
                            Resultados del reporte
                        </div>
                        <div class="card-body">

                            <?php
                            $reportes = $_SESSION['reportes-rendimiento'] ?? [];
                            ?>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-sm mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Inicio Trimestre</th>
                                            <th>Fin Trimestre</th>
                                            <th>Grado</th>
                                            <th>Curso</th>
                                            <th>Estudiante</th>
                                            <th>Nota</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($reportes)): ?>
                                            <?php foreach ($reportes as $reporte): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($reporte['fecha_inicio_trimestre'] ?? '') ?></td>
                                                    <td><?= htmlspecialchars($reporte['fecha_final_trimestre'] ?? '') ?></td>
                                                    <td><?= htmlspecialchars($reporte['grado'] ?? '') ?></td>
                                                    <td><?= htmlspecialchars($reporte['descripcion'] ?? '') ?></td>
                                                    <td><?= htmlspecialchars($reporte['nombre'] ?? '') ?></td>
                                                    <td><?= htmlspecialchars($reporte['nota'] ?? '') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    No hay datos disponibles. Aplica un filtro y vuelve a intentarlo.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <?php if (!empty($reportes)): ?>
                                <div class="mt-3 text-right">
                                    <form id="imprimir-reporte"
                                          action="../../controller/estudianteController.php"
                                          method="POST"
                                          class="d-inline">
                                        <input type="hidden" name="action" value="imprimir-reporte">
                                        <button type="submit" class="btn bg-body-custom text-white">
                                            Imprimir reporte
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</body>
</html>