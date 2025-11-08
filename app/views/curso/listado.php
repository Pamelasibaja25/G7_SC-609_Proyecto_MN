<!DOCTYPE html>
<html>

<head>
    <title>Escuela en Casa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="/G1_SC-502_JN_Proyecto/public/css/style.css" rel="stylesheet" type="text/css" />
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/G1_SC-502_JN_Proyecto/app/views/nav_menu.php'
    ?>
    <section class="bg-custom" id="cursos">
        <div class="container mt-5">
            <h1 class="text-center text-white">Bienvenido</h1>
            <h3 class="text-center mb-4 text-white">Cursos En Progreso</h3>
            <?php
            // Incluir el archivo de conexión
            include $_SERVER['DOCUMENT_ROOT'] . '/G1_SC-502_JN_Proyecto/app/controller/cursoController.php';
            get_cursos();
            ?>
        </div>

        </div>
    </section>




    <footer footer th:fragment="footer" class="navbar-light bg-primary text-white mt-5 p-3">
        <div class="container">
            <p class="text-center">Derechos Reservados - Escuela en Casa 2025</p>
        </div>
    </footer>
</body>

</html>