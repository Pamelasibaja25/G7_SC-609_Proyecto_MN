<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Escuela en Casa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS -->
    <link href="/public/css/style.css" rel="stylesheet" type="text/css" />

    <!-- JS (jQuery, Popper, Bootstrap JS) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body class="d-flex flex-column min-vh-100 bg-light">

    <!-- Wrapper principal -->
    <div id="page-wrapper" class="d-flex flex-column flex-fill">

        <?php
        include __DIR__ . '/nav_menu.php';
        ?>

        <!-- Contenido principal -->
        <main class="flex-fill">
            <div class="container py-4">

                <!-- Encabezado / Hero -->
                <div class="row mb-4">
                    <div class="col-lg-8">
                        <h1 class="h3 mb-3">Escuela en Casa</h1>
                        <p class="text-muted mb-0">
                            Bienvenido al sistema Escuela en Casa. Desde aquí puedes gestionar cursos,
                            matrículas y seguimiento académico de los estudiantes.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-right mt-3 mt-lg-0">
                        <span class="badge badge-primary p-2">
                            Panel principal
                        </span>
                    </div>
                </div>

                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>

                <!-- Sección informativa / ayuda rápida -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card border-0 bg-white shadow-sm h-100">
                            <div class="card-body">
                                <h2 class="h6 text-uppercase text-muted mb-3">
                                    ¿Cómo empezar?
                                </h2>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="bi bi-check-circle text-success mr-1"></i>
                                        Revisa los cursos activos y verifica que cada estudiante
                                        esté matriculado correctamente.
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-check-circle text-success mr-1"></i>
                                        Registra actividades, asistencia y notas según el avance del curso.
                                    </li>
                                    <li class="mb-0">
                                        <i class="bi bi-check-circle text-success mr-1"></i>
                                        Genera reportes periódicos para compartir con estudiantes
                                        y responsables.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card border-0 bg-white shadow-sm h-100">
                            <div class="card-body">
                                <h2 class="h6 text-uppercase text-muted mb-3">
                                    Soporte y buenas prácticas
                                </h2>
                                <p class="mb-2 text-muted">
                                    Para mantener la información organizada:
                                </p>
                                <ul class="mb-0 text-muted">
                                    <li class="mb-1">
                                        Mantén actualizada la matrícula antes de iniciar cada período.
                                    </li>
                                    <li class="mb-1">
                                        Registra asistencia y actividades de forma constante,
                                        no al final del período.
                                    </li>
                                    <li class="mb-1">
                                        Revisa los reportes con regularidad para identificar
                                        estudiantes que necesitan apoyo.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-primary text-white py-3 mt-auto">
            <div class="container">
                <p class="mb-0 text-center">
                    Derechos Reservados &mdash; Escuela en Casa 2025
                </p>
            </div>
        </footer>

    </div>

</body>

</html>
