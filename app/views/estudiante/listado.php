<?php
require_once __DIR__ . '/../../controller/estudianteController.php';
require_once __DIR__ . '/../../controller/escuelaController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$estudiantes = get_estudiantes_admin();
$escuelas = get_escuelas();

$status = $_GET['status'] ?? null;
$msg = $_GET['msg'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Escuela en Casa - Lista de Estudiantes</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <!-- CSS -->
    <link href="/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/public/css/style.css" rel="stylesheet" type="text/css" />

    <!-- JS (jQuery, Popper, Bootstrap JS) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- JS -->
    <script src="/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/public/js/scripts.js"></script>
</head>

<body>

    <?php include __DIR__ . '/../nav_menu.php'; ?>

    <?php if ($status && $msg): ?>
        <div class="alert alert-<?= $status === 'success' ? 'success' : 'danger' ?> text-center mb-0" role="alert">
            <?= htmlspecialchars($msg); ?>
        </div>
    <?php endif; ?>

    <section class="bg-custom">
        <div class="container mt-5">
            <h1 class="text-center text-white mb-4">Lista de Estudiantes</h1>
            <div class="card mt-3">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center mb-0">
                        <thead class="bg-body-custom text-white">
                            <tr>
                                <th>Nombre</th>
                                <th>Cédula</th>
                                <th>Fecha Nacimiento</th>
                                <th>Grado</th>
                                <th>Escuela</th>
                                <th style="width: 180px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($estudiantes)): ?>
                                <tr>
                                    <td colspan="6">No hay estudiantes registrados.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($estudiantes as $p): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($p['nombre']) ?></td>
                                        <td><?= htmlspecialchars($p['cedula']) ?></td>
                                        <td><?= htmlspecialchars($p['fecha_nacimiento']) ?></td>
                                        <td><?= htmlspecialchars($p['grado']) ?></td>
                                        <td><?= htmlspecialchars($p['escuela']) ?></td>
                                        <td>
                                            <button class="btn btn-primary text-white btn-sm mb-1" data-toggle="modal"
                                                data-target="#editar-estudiante" data-id="<?= htmlspecialchars($p['_id']) ?>"
                                                data-nombre="<?= htmlspecialchars($p['nombre']) ?>"
                                                data-cedula="<?= htmlspecialchars($p['cedula']) ?>"
                                                data-fecha_nacimiento="<?= htmlspecialchars($p['fecha_nacimiento']) ?>"
                                                data-grado="<?= htmlspecialchars($p['grado']) ?>"
                                                data-escuela="<?= htmlspecialchars($p['escuela']) ?>">Editar</button>

                                            <button class="btn btn-danger btn-sm mb-1" data-toggle="modal"
                                                data-target="#eliminar-estudiante" data-id="<?= htmlspecialchars($p['_id']) ?>"
                                                data-nombre="<?= htmlspecialchars($p['nombre']) ?>">Eliminar</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

    <!-- MODAL EDITAR -->
    <div class="modal fade" id="editar-estudiante" tabindex="-1" role="dialog" aria-labelledby="editarEstudianteLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card-header bg-body-custom text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" id="editarEstudianteLabel">Editar Estudiante</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Ruta RELATIVA correcta hacia el controller -->
                <form action="../../controller/estudianteController.php" method="POST">
                    <div class="modal-body">

                        <input type="hidden" name="action" value="editar-estudiante">
                        <input type="hidden" name="id_estudiante" id="edit-id">

                        <div class="form-group mb-3">
                            <label for="edit-nombre">Nombre:</label>
                            <input type="text" class="form-control" id="edit-nombre" name="nombre" required readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit-cedula">Cédula:</label>
                            <input type="text" class="form-control" id="edit-cedula" name="cedula" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit-fecha_nacimiento">Fecha Nacimiento:</label>
                            <input type="text" class="form-control" id="edit-fecha_nacimiento" name="fecha_nacimiento"
                                required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit-grado">Grado:</label>
                            <select id="edit-grado" name="grado" class="form-control" required>
                                <option value="Primero">Primero</option>
                                <option value="Segundo">Segundo</option>
                                <option value="Tercero">Tercero</option>
                                <option value="Cuarto">Cuarto</option>
                                <option value="Quinto">Quinto</option>
                                <option value="Sexto">Sexto</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit-escuela">Escuela:</label>
                            <select class="form-control" id="edit-escuela" name="escuela" required>
                                <?php if (!empty($escuelas)): ?>
                                    <?php foreach ($escuelas as $e): ?>
                                        <option value="<?= htmlspecialchars($e['_id']) ?>">
                                            <?= htmlspecialchars($e['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled selected>No hay escuelas registradas</option>
                                <?php endif; ?>
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
    <div class="modal fade" id="eliminar-estudiante" tabindex="-1" role="dialog"
        aria-labelledby="eliminarEstudianteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card-header bg-body-custom text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" id="eliminarEstudianteLabel">Eliminar Estudiante</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="../../controller/estudianteController.php" method="POST">
                    <div class="modal-body">

                        <input type="hidden" name="action" value="eliminar-estudiante">
                        <input type="hidden" name="id_estudiante" id="delete-id">

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

</body>

</html>