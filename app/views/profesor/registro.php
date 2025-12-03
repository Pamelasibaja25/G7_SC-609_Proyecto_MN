<?php
require_once __DIR__ . '/../../controller/profesorController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Resumen de profesores por especialidad
$profesoresResumen = get_profesores_resumen();

// Lista de especialidades/cursos para el combo
$especialidades = get_especialidades_cursos();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Escuela en Casa - Profesores</title>
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

<section class="bg-custom py-5">
    <div class="container">
        <h1 class="text-center text-white mb-4">Profesores registrados</h1>

        <!-- Tarjetas de resumen por especialidad -->
        <div class="row">
            <?php if (!empty($profesoresResumen)): ?>
                <?php foreach ($profesoresResumen as $especialidad => $cantidad): ?>
                    <div class="col-6 col-md-3 mb-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-body-custom text-white text-center">
                                <?= htmlspecialchars($especialidad) ?>
                            </div>
                            <div class="card-body text-center">
                                <h3 class="mb-1"><?= htmlspecialchars($cantidad) ?></h3>
                                <small class="text-muted">Profesores registrados</small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-white text-center mb-0">
                        No hay profesores registrados todavía.
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Botón para abrir modal de registro -->
        <div class="text-center mt-4">
            <button class="btn bg-body-custom text-white" data-toggle="modal" data-target="#register-profesor">
                Registrar nuevo profesor
            </button>
        </div>
    </div>
</section>

<!-- Modal de Registro -->
<div class="modal fade" id="register-profesor" tabindex="-1" role="dialog" aria-labelledby="registerProfesorLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="card-header bg-body-custom text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0" id="registerProfesorLabel">Registro de Profesor</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <!-- IMPORTANTE: ruta relativa correcta hacia el controller -->
                <form action="../../controller/profesorController.php" method="POST">

                    <div class="form-group mb-3">
                        <label for="nombre">Nombre completo:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="cedula">Cédula:</label>
                        <input type="text" class="form-control" id="cedula" name="cedula" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="correo">Correo electrónico:</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="especialidad">Especialidad (curso):</label>
                        <select class="form-control" id="especialidad" name="especialidad" required>
                            <?php if (!empty($especialidades)): ?>
                                <?php foreach ($especialidades as $esp): ?>
                                    <option value="<?= htmlspecialchars($esp) ?>">
                                        <?= htmlspecialchars($esp) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled selected>No hay cursos registrados</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <input type="hidden" name="action" value="registrar-profesor">

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