<?php
// Controlador de Actividad
require_once __DIR__ . '/../../controller/ActividadController.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Actividad</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <!-- CSS del proyecto -->
    <link href="/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/public/css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>

    <!-- Menú de navegación -->
    <?php include __DIR__ . '/../nav_menu.php'; ?>

    <section class="bg-custom">
        <div class="container mt-5">
            <h1 class="text-center text-white mb-4">Registrar Actividad</h1>

            <?php
            $status = $_GET['status'] ?? null;
            $msg = $_GET['msg'] ?? null;
            ?>

            <?php if ($status && $msg): ?>
                <div class="alert alert-<?= $status === 'success' ? 'success' : 'danger' ?>">
                    <?= htmlspecialchars($msg) ?>
                </div>
            <?php endif; ?>


            <form method="post" action="../../controller/ActividadController.php">
                <input type="hidden" name="action" value="registrar-actividad">

                <div class="form-group">
                    <label for="id_curso" class="text-white">ID Curso</label>
                    <input type="number" class="form-control" id="id_curso" name="id_curso" required>
                </div>

                <div class="form-group">
                    <label for="tipo" class="text-white">Tipo de Actividad</label>
                    <input type="text" class="form-control" id="tipo" name="tipo"
                        placeholder="Tarea, Examen, Proyecto, etc." required>
                </div>

                <div class="form-group">
                    <label for="titulo" class="text-white">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>

                <div class="form-group">
                    <label for="fecha_entrega" class="text-white">Fecha de entrega</label>
                    <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" required>
                </div>

                <div class="text-center d-flex justify-content-between">
                    <button type="submit" class=" text-white btn bg-body-custom">Guardar</button>
                    <a href="listado.php" class="btn btn-secondary">Ver listado</a>
                </div>
            </form>
        </div>
    </section>

    <!-- JS (jQuery, Popper, Bootstrap JS) igual que en layout.php -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <footer class="bg-primary text-white py-3 mt-5">
        <div class="container">
            <p class="mb-0 text-center">
                Derechos Reservados &mdash; Escuela en Casa 2025
            </p>
        </div>
    </footer>
</body>

</html>