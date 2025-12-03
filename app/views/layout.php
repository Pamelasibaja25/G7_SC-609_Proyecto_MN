<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Escuela en Casa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <!-- CSS -->
    <link href="/public/css/style.css" rel="stylesheet" type="text/css" />

    <!-- JS (jQuery, Popper, Bootstrap JS) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>

    <!-- Wrapper principal -->
    <div id="page-wrapper" class="d-flex flex-column min-vh-100">

        <?php
        include __DIR__ . '/nav_menu.php';
        ?>

        <!-- Contenido principal -->
        <main class="flex-fill">
            <div class="container py-4">
                <!-- Aquí va el contenido específico de cada vista -->
                <h1 class="mb-4">Escuela en Casa</h1>
                <p>Bienvenido al sistema Escuela en Casa.</p>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-primary text-white py-3 mt-auto">
            <div class="container">
                <p class="mb-0 text-center">
                    Derechos Reservados - Escuela en Casa 2025
                </p>
            </div>
        </footer>

    </div>

</body>

</html>