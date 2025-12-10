<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/controller/cursoController.php';
$data = get_notas();
$cursos = $data['cursos'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Escuela en Casa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="/G7_SC-609_Proyecto_MN/public/css/style.css" rel="stylesheet" type="text/css" />
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <!-- Latest JavaScript -->
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
    include $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/views/nav_menu.php'
        ?>

    <section class="class bg-custom" id="estudiante">
        <div class="container mt-5">
            <h1 class="text-center text-white">Datos del Estudiante</h1>

            <div class="row mt-4">
                <!-- Información Personal -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-body-custom text-white">Información Personal</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <p for="cedula">Cedula: <?= htmlspecialchars($_SESSION['cedula']); ?></p>
                                <p for="fecha_nacimiento">Fecha Nacimiento:
                                    <?= htmlspecialchars($_SESSION['fecha_nacimiento']); ?>
                                </p>
                                <p for="grado">Grado: <?= htmlspecialchars($_SESSION['grado']); ?></p>
                                <p for="escuela">Escuela: <?= htmlspecialchars($_SESSION['escuela']); ?></p>
                            </div>
                            <div class="mt-3 text-center">
                                <a href="" class="btn bg-body-custom text-white" id="modify-info" data-toggle="modal"
                                    data-target="#modifyModal">Modificar</a>
                                <a href="" class="btn bg-body-custom text-white">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Datos Cursos -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-body-custom text-white">Datos Cursos</div>
                        <div class="card-body">
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
                                <?php if (!empty($cursos)): ?>
                                        <tbody>
                                            <?php foreach ($cursos as $curso): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($curso['fecha_inicio_trimestre']); ?></td>
                                                    <td><?= htmlspecialchars($curso['fecha_final_trimestre']); ?></td>
                                                    <td><?= htmlspecialchars($curso['descripcion']); ?></td>
                                                    <td><?= htmlspecialchars($curso['estado']); ?></td>
                                                    <td><?= htmlspecialchars($curso['nota']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    <?php else: ?>
                                        <tbody>
                                            <tr>
                                                <td colspan="5">No hay datos disponibles</td>
                                            </tr>
                                        </tbody>
                                    <?php endif; ?>
                            </table>
                            <div class="mt-3 text-center">
                                <a href="/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/views/curso/registro_matricula.php" class="btn bg-body-custom text-white">Agregar</a>
                                <a href="" class="btn bg-body-custom text-white">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Modificar Información -->
        <div class="modal fade" id="modifyModal" tabindex="-1" role="dialog" aria-labelledby="modifyModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div
                        class="card-header bg-body-custom text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Modificar Información</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="modify-form" action="/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/controller/estudianteController.php"
                            method="POST">
                            <div class="form-group mb-3">
                                <label for="escuela">Escuela:</label>
                                <select id="escuela" name="escuela" class="form-select" required>
                                    <?php
                                    include $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/controller/escuelaController.php';
                                    get_escuelas();
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" name="action" value="modificar-nota">
                            <div class="card-footer text-center">
                                <button type="submit" class="btn bg-body-custom text-white">Guardar Cambios</button>
                            </div>

                        </form>
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