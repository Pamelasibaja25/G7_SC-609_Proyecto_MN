<?php
require_once __DIR__ . '/../../controller/profesorController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$profesores = get_profesores();

$status = $_GET['status'] ?? null;
$msg    = $_GET['msg'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Escuela en Casa - Lista de Profesores</title>
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

<div class="container py-4">
    <h1 class="mb-4">Listado de Profesores</h1>

    <?php if ($status && $msg): ?>
        <div class="alert alert-<?= $status === 'success' ? 'success' : 'danger' ?>" role="alert">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>

    <div class="mb-3">
        <a href="registro.php" class="btn bg-body-custom text-white">Registrar nuevo profesor</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Cédula</th>
                    <th>Especialidad</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th style="width: 180px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($profesores)): ?>
                    <tr>
                        <td colspan="7" class="text-center">No hay profesores registrados.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($profesores as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['_id']) ?></td>
                            <td><?= htmlspecialchars($p['nombre']) ?></td>
                            <td><?= htmlspecialchars($p['cedula']) ?></td>
                            <td><?= htmlspecialchars($p['especialidad']) ?></td>
                            <td><?= htmlspecialchars($p['telefono']) ?></td>
                            <td><?= htmlspecialchars($p['correo']) ?></td>
                            <td>
                                <a href="editar.php?id_profesor=<?= urlencode($p['_id']) ?>"
                                   class="btn btn-sm btn-primary mb-1">
                                    Editar
                                </a>

                                <form method="post"
                                      action="../../controller/profesorController.php"
                                      class="d-inline">
                                    <input type="hidden" name="action" value="eliminar-profesor">
                                    <input type="hidden" name="id_profesor" value="<?= htmlspecialchars($p['_id']) ?>">
                                    <button type="submit"
                                            class="btn btn-sm btn-danger mb-1"
                                            onclick="return confirm('¿Eliminar este profesor?');">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<footer class="navbar-light bg-primary text-white mt-5 p-3">
    <div class="container">
        <p class="text-center mb-0">Derechos Reservados - Escuela en Casa 2025</p>
    </div>
</footer>

</body>
</html>