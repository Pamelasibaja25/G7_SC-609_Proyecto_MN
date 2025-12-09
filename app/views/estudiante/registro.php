<?php
require_once __DIR__ . '/../../controller/estudianteController.php';
require_once __DIR__ . '/../../controller/escuelaController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lista de escuelas para el combo
$escuelas = get_escuelas();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Escuela en Casa - Estudiantes</title>
    <meta charset="UTF-8">
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

<!-- Alertas de estado -->
<?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
    <div class="alert alert-success text-center mb-0" role="alert">
        <?= htmlspecialchars($_GET['msg']) ?>
    </div>
<?php elseif (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
    <div class="alert alert-danger text-center mb-0" role="alert">
        <?= htmlspecialchars($_GET['msg']) ?>
    </div>
<?php endif; ?>

<section class="bg-custom">
    <div class="container mt-5">
        <h1 class="text-center text-white mb-4">Estudiantes registrados</h1>

        <!-- Aquí podrías en el futuro poner tarjetas de resumen por grado, escuela, etc. -->
        <div class="row">
            <div class="col-12">
                <p class="text-center text-white-50 mb-0">
                    Usa el botón de abajo para registrar un nuevo estudiante.
                </p>
            </div>
        </div>

        <!-- Botón para abrir modal de registro -->
        <div class="text-center mt-4">
            <button class="btn bg-body-custom text-white" data-toggle="modal" data-target="#register-estudiante">
                Registrar nuevo estudiante
            </button>
        </div>
    </div>
</section>

<!-- Modal de Registro -->
<div class="modal fade" id="register-estudiante" tabindex="-1" role="dialog" aria-labelledby="registerEstudianteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="card-header bg-body-custom text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0" id="registerEstudianteLabel">Registro de Estudiante</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <!-- IMPORTANTE: ruta relativa correcta hacia el controller -->
                <form action="../../controller/estudianteController.php" method="POST">

                    <div class="form-group mb-3">
                        <label for="nombre">Nombre completo:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="cedula">Cédula:</label>
                        <input type="text" class="form-control" id="cedula" name="cedula" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="grado">Grado:</label>
                        <select class="form-control" id="grado" name="grado" required>
                            <option value="Primero">Primero</option>
                            <option value="Segundo">Segundo</option>
                            <option value="Tercero">Tercero</option>
                            <option value="Cuarto">Cuarto</option>
                            <option value="Quinto">Quinto</option>
                            <option value="Sexto">Sexto</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="escuela">Escuela:</label>
                        <select class="form-control" id="escuela" name="escuela" required>
                            <?php if (!empty($escuelas)): ?>
                                <?php foreach ($escuelas as $e): ?>
                                    <option value="<?= htmlspecialchars($e['nombre']) ?>">
                                        <?= htmlspecialchars($e['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled selected>No hay escuelas registradas</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <input type="hidden" name="action" value="registrar-estudiante">

                    <div class="card-footer text-center">
                        <button type="submit" class="btn bg-body-custom text-white">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<footer class="navbar-light bg-primary text-white mt-5 p-3">
    <div class="container">
        <p class="text-center mb-0">Derechos Reservados - Escuela en Casa 2025</p>
    </div>
</footer>

</body>
</html>
