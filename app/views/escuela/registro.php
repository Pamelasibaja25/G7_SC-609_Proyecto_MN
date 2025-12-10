<?php
require_once __DIR__ . '/../../controller/escuelaController.php';
$escuelaResumen = get_escuela_resumen();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Escuela en Casa - Escuelas</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <!-- CSS propio (ruta absoluta correcta desde htdocs) -->
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
        <h1 class="text-center text-white mb-4">Escuelas registradas</h1>

        <!-- Tarjetas de resumen por provincia -->
        <div class="row">
            <?php if (!empty($escuelaResumen)): ?>
                <?php foreach ($escuelaResumen as $provincia => $cantidad): ?>
                    <div class="col-6 col-md-3 mb-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-body-custom text-white text-center">
                                <?= htmlspecialchars($provincia) ?>
                            </div>
                            <div class="card-body text-center">
                                <h3 class="mb-1"><?= htmlspecialchars($cantidad) ?></h3>
                                <small class="text-muted">Escuelas registradas</small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-white text-center mb-0">
                        No hay datos de escuelas registrados aún.
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Botón para abrir modal de registro -->
        <div class="text-center mt-4">
            <button class="btn bg-body-custom text-white" data-toggle="modal" data-target="#register-escuela">
                Registrar nueva escuela
            </button>
        </div>
    </div>
</section>

<!-- Modal de Registro -->
<div class="modal fade" id="register-escuela" tabindex="-1" role="dialog" aria-labelledby="registerEscuelaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="card-header bg-body-custom text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0" id="registerEscuelaLabel">Registro de Escuela</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="../../controller/escuelaController.php" method="POST">

                    <div class="form-group mb-3">
                        <label for="nombre">Nombre de la escuela:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="provincia">Provincia:</label>
                        <select id="provincia" name="provincia" class="form-control" required>
                            <option value="" disabled selected>Seleccione una provincia</option>
                            <option value="San José">San José</option>
                            <option value="Alajuela">Alajuela</option>
                            <option value="Cartago">Cartago</option>
                            <option value="Heredia">Heredia</option>
                            <option value="Guanacaste">Guanacaste</option>
                            <option value="Puntarenas">Puntarenas</option>
                            <option value="Limón">Limón</option>
                        </select>
                    </div>

                    <input type="hidden" name="action" value="registrar-escuela">

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