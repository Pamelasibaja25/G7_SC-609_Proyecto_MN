<?php
require_once __DIR__ . '/app/controller/escuelaController.php';

$escuelas = get_escuelas();

$status = $_GET['status'] ?? null;
$msg = $_GET['msg'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Escuela en Casa - Autenticación</title>
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

    <style>
        body {
            min-height: 100vh;
            background: radial-gradient(circle at top, #1d3557 0, #0b1727 45%, #02040f 100%);
        }

        .auth-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
            overflow: hidden;
        }

        .auth-card-header {
            background: linear-gradient(135deg, #1d3557, #457b9d);
        }

        .brand-panel {
            color: #012647;
        }

        .brand-panel h1 {
            font-size: 2rem;
            font-weight: 700;
        }

        .brand-panel p {
            opacity: 0.85;
        }

        .link-registro {
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <?php if ($status === 'success' && $msg): ?>
        <div class="alert alert-success text-center mb-0" role="alert">
            <?= htmlspecialchars($msg); ?>
        </div>
    <?php endif; ?>

    <!-- Contenedor principal -->
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="row w-100 justify-content-center">
            <div class="col-lg-10">
                <div class="card auth-card">
                    <div class="row no-gutters">
                        <!-- Panel izquierdo: branding / mensaje -->
                        <div
                            class="col-md-5 d-none d-md-flex align-items-center justify-content-center brand-panel flex-column p-4">
                            <h1 class="mb-3">Escuela en Casa</h1>
                            <p class="mb-3">
                                Plataforma educativa para gestionar cursos, estudiantes, asistencia y rendimiento
                                académico
                                de forma sencilla.
                            </p>
                            <ul class="mb-0 small">
                                <li>Acceso para estudiantes y administradores.</li>
                                <li>Gestión de matrícula y calificaciones.</li>
                                <li>Reportes y métricas académicas.</li>
                            </ul>
                        </div>

                        <!-- Panel derecho: autenticación -->
                        <div class="col-md-7">
                            <div class="card">

                                <div class="card-header auth-card-header text-white text-center">
                                    <h2 class="mb-0">Inicio de sesión</h2>
                                </div>

                                <div class="card-body">

                                    <!-- Mensaje de error si existe -->
                                    <?php if ($status === 'error' && $msg): ?>
                                        <div class="alert alert-danger text-center">
                                            <strong>Error:</strong> <?= htmlspecialchars($msg); ?>
                                        </div>
                                    <?php endif; ?>

                                    <form id="login-form" action="./app/controller/usuarioController.php" method="POST">
                                        <div class="form-group my-3">
                                            <label for="login-username">Usuario</label>
                                            <input class="form-control" type="text" id="login-username"
                                                name="login-username" required>
                                        </div>

                                        <div class="form-group my-3">
                                            <label for="login-password">Contraseña</label>
                                            <input class="form-control" type="password" id="login-password"
                                                name="login-password" required>
                                        </div>

                                        <input type="hidden" name="action" value="inicio">

                                        <div class="mt-4 text-center d-flex justify-content-between">
                                                <button class="btn bg-body-custom text-white" type="submit">
                                                    Ingresar
                                                </button>
                                                <span class="text-muted small">
                                                    ¿No tienes cuenta?
                                                    <a href="#" id="show-register" class="link-registro text-white-50">
                                                        Regístrate aquí
                                                    </a>
                                                </span>
                                                <button class="btn btn-outline-secondary" type="reset">
                                                    Limpiar
                                                </button>
                                        </div>
                                    </form>

                                </div> <!-- card-body -->
                            </div> <!-- inner card -->
                        </div> <!-- col-md-7 -->

                    </div> <!-- row -->
                </div> <!-- auth-card -->
            </div>
        </div>
    </div>

    <!-- Modal para Registro de Usuario -->
    <div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="card-header bg-body-custom text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" id="registerModalLabel">Registro de Usuario</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="register-form" action="./app/controller/usuarioController.php" method="POST">

                        <div class="form-group">
                            <label for="new-username">Usuario</label>
                            <input type="text" class="form-control" id="new-username" name="new-username" required>
                        </div>

                        <div class="form-group">
                            <label for="new-password">Contraseña</label>
                            <input type="password" class="form-control" id="new-password" name="new-password" required>
                        </div>

                        <div class="form-group">
                            <label for="new-nombre">Nombre completo</label>
                            <input type="text" class="form-control" id="new-nombre" name="new-nombre" required>
                        </div>

                        <div class="form-group">
                            <label for="new-cedula">Cédula</label>
                            <input type="text" class="form-control" id="new-cedula" name="new-cedula" required>
                        </div>

                        <div class="form-group">
                            <label for="new-fecha">Fecha de nacimiento</label>
                            <input type="date" class="form-control" id="new-fecha" name="new-fecha" required>
                        </div>

                        <div class="form-group">
                            <label for="new-telefono">Teléfono</label>
                            <input type="text" class="form-control" id="new-telefono" name="new-telefono" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="escuela">Escuela</label>
                            <select id="escuela" name="escuela" class="form-control" required>
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

                        <div class="form-group mb-3">
                            <label for="grado">Grado</label>
                            <select id="grado" name="grado" class="form-control" required>
                                <option value="Primero">Primero</option>
                                <option value="Segundo">Segundo</option>
                                <option value="Tercero">Tercero</option>
                                <option value="Cuarto">Cuarto</option>
                                <option value="Quinto">Quinto</option>
                                <option value="Sexto">Sexto</option>
                            </select>
                        </div>

                        <input type="hidden" name="action" value="registro">

                        <div class="card-footer text-center">
                            <button class="btn bg-body-custom text-white" type="submit">Registrarse</button>
                            <button class="btn btn-outline-secondary" type="reset">Limpiar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#show-register').on('click', function (e) {
                e.preventDefault();
                $('#register-modal').modal('show');
            });
        });
    </script>

</body>

</html>