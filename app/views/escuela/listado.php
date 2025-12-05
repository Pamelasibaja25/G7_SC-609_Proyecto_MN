<?php
require_once __DIR__ . '/../../controller/escuelaController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$escuelas = get_escuelas();

$status = $_GET['status'] ?? null;
$msg = $_GET['msg'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Escuela en Casa - Lista de Escuelas</title>
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

    <section class="bg-custom">
        <div class="container mt-5">
            <h1 class="text-center text-white">Lista de Escuelas</h1>

            <div class="mb-3">
                <a href="registro.php" class="btn bg-body-custom text-white">Registrar nueva escuela</a>
            </div>
            <!-- Tabla de profesores con botones editar/eliminar -->
            <div class="card mt-3">
                <div class="card-body table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="bg-body-custom text-white">
                            <tr>
                                <th>Nombre</th>
                                <th>Provincia</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($escuelas as $p): ?>
                                <tr>
                                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                                    <td><?= htmlspecialchars($p['provincia']) ?></td>
                                    <td>
                                        <button class="btn bg-body-custom text-white btn-sm" data-toggle="modal"
                                            data-target="#editar-profesor" data-id="<?= $p['_id'] ?>"
                                            data-nombre="<?= $p['nombre'] ?>"
                                            data-provincia="<?= $p['provincia'] ?>">Editar</button>

                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#eliminar-profesor" data-id="<?= $p['_id'] ?>"
                                            data-nombre="<?= $p['nombre'] ?>">Eliminar</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

    <!-- MODAL EDITAR -->
    <div class="modal fade" id="editar-escuela" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card-header bg-body-custom text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Editar Escuela</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <form action="/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/controller/escuelaController.php" method="POST">
                    <div class="modal-body">

                        <input type="hidden" name="action" value="editar-escuela">
                        <input type="hidden" name="id_escuela" id="edit-id">

                        <div class="form-group mb-3">
                            <label>Nombre:</label>
                            <input type="text" class="form-control" id="edit-nombre" name="nombre" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Provincia:</label>
                            <select id="provincia" name="provincia" class="form-select" required>
                                <option value="Alajuela">Alajuela</option>
                                <option value="Heredia">Heredia</option>
                                <option value="San José">San José</option>
                                <option value="Guanacaste">Guanacaste</option>
                                <option value="Limón">Limón</option>
                                <option value="Puntarenas">Puntarenas</option>
                                <option value="Cartago">Cartago</option>
                            </select>
                        </div>

                    </div>

                    <div class="card-footer text-center">
                        <button type="submit" class="btn bg-body-custom text-white">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL ELIMINAR -->
    <div class="modal fade" id="eliminar-profesor" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card-header bg-body-custom text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Eliminar Escuela</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <form action="/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/controller/escuelaController.php" method="POST">
                    <div class="modal-body">

                        <input type="hidden" name="action" value="eliminar-escuela">
                        <input type="hidden" name="id_escuela" id="delete-id">

                        <p>¿Estás seguro que deseas eliminar a <strong id="delete-nombre"></strong>?</p>

                    </div>

                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <footer class="navbar-light bg-primary text-white mt-5 p-3">
        <div class="container">
            <p class="text-center mb-0">Derechos Reservados - Escuela en Casa 2025</p>
        </div>
    </footer>

    <script src="/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/public/js/scripts.js"></script>
</body>

</html>