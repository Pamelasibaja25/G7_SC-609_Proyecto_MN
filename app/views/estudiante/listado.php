<?php
include $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/controller/estudianteController.php';

$estudiantes = get_estudiantes_admin();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Escuela en Casa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="/G7_SC-609_Proyecto_MN/public/css/style.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>

<?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
    <div class="alert alert-success text-center" role="alert">
        <?= htmlspecialchars($_GET['msg']); ?>
    </div>
<?php elseif (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
    <div class="alert alert-danger text-center" role="alert">
        <?= htmlspecialchars($_GET['msg']); ?>
    </div>
<?php endif; ?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/views/nav_menu.php'; ?>

<section class="bg-custom">
    <div class="container mt-5">
        <h1 class="text-center text-white">Lista de Estudiantes</h1>

        <!-- Tabla de profesores con botones editar/eliminar -->
        <div class="card mt-3">
            <div class="card-body table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="bg-body-custom text-white">
                        <tr>
                            <th>Nombre</th>
                            <th>Cédula</th>
                            <th>Fecha Nacimiento</th>
                            <th>Grado</th>
                            <th>Escuela</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($estudiantes as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['nombre']) ?></td>
                                <td><?= htmlspecialchars($p['cedula']) ?></td>
                                <td><?= htmlspecialchars($p['fecha_nacimiento']) ?></td>
                                <td><?= htmlspecialchars($p['grado']) ?></td>
                                <td><?= htmlspecialchars($p['escuela']) ?></td>
                                <td>
                                    <button 
                                        class="btn bg-body-custom text-white btn-sm"
                                        data-toggle="modal"
                                        data-target="#editar-estudiante"
                                        data-id="<?= $p['_id'] ?>"
                                        data-nombre="<?= $p['nombre'] ?>"
                                        data-cedula="<?= $p['cedula'] ?>"
                                        data-fecha_nacimiento="<?= $p['fecha_nacimiento'] ?>"
                                        data-grado="<?= $p['grado'] ?>"
                                        data-escuela="<?= $p['escuela'] ?>"
                                    >Editar</button>

                                    <button 
                                        class="btn btn-danger btn-sm"
                                        data-toggle="modal"
                                        data-target="#eliminar-estudiante"
                                        data-id="<?= $p['_id'] ?>"
                                        data-nombre="<?= $p['nombre'] ?>"
                                    >Eliminar</button>
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
<div class="modal fade" id="editar-estudiante" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card-header bg-body-custom text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Editar Estudiante</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <form action="/G7_SC-609_Proyecto_MN/app/controller/estudianteController.php" method="POST">
                <div class="modal-body">

                    <input type="hidden" name="action" value="editar-estudiante">
                    <input type="hidden" name="id_estudiante" id="edit-id">

                    <div class="form-group mb-3">
                        <label>Nombre:</label>
                        <input type="text" class="form-control" id="edit-nombre" name="nombre" required readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label>Cédula:</label>
                        <input type="text" class="form-control" id="edit-cedula" name="cedula" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Fecha Nacimiento:</label>
                        <input type="text" class="form-control" id="edit-fecha_nacimiento" name="fecha_nacimiento" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Grado:</label>
                        <select id="grado" name="grado" class="form-select" required>
                                <option value="Primero">Primero</option>
                                <option value="Segundo">Segundo</option>
                                <option value="Tercero">Tercero</option>
                                <option value="Cuarto">Cuarto</option>
                                <option value="Quinto">Quinto</option>
                                <option value="Sexto">Sexto</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Escuela:</label>
                        <select class="form-select form-control" id="edit-escuela" name="escuela" required>
                            <?php
                                    include $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/controller/escuelaController.php';
                                    get_escuelas();
                                    ?>
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
<div class="modal fade" id="eliminar-estudiante" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card-header bg-body-custom text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Eliminar Estudiante</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <form action="/G7_SC-609_Proyecto_MN/app/controller/estudianteController.php" method="POST">
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
        <p class="text-center">Derechos Reservados - Escuela en Casa 2025</p>
    </div>
</footer>

<script src="/G7_SC-609_Proyecto_MN/public/js/scripts.js"></script>
</body>

</html>
