<?php
include $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/controller/cursoController.php';

// Obtener ID del curso de la URL.
$id_curso = isset($_GET['id']) ? $_GET['id'] : null;

if ($id_curso) {
    $data = get_curso_contenido($id_curso);
    $temas = $data['temas'];
    $curso = $data['curso'];
} else {
    header("Location: ../layout.php?status=error&msg=" . urlencode("ID del curso no proporcionado."));
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Escuela en Casa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="/G7_SC-609_Proyecto_MN/public/css/style.css" rel="stylesheet" type="text/css" />
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/views/nav_menu.php'
        ?>

    <section class="class bg-custom" id="temas">
        <div class="container mt-5">
            <h1 class="text-center text-white" id="curso">Contenido del Curso
                <?= htmlspecialchars($curso['descripcion']); ?></h1>
            <?php if (!empty($temas)): ?>
                <div class="card row text-center">
                    <?php foreach ($temas as $tema): ?>
                        <div class="card-header">
                            <h4 class="card-title text-center"><?= htmlspecialchars($tema['nombre']); ?></h4>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-white text-center">No hay temas disponibles para este curso.</p>
            <?php endif; ?>
        </div>
        <div class="container mt-3 text-center d-flex justify-content-between">
        <form id="imprimir-temas" action="/G7_SC-609_Proyecto_MN/app/controller/cursoController.php"
                            method="POST">
                            <input type="hidden" name="action" value="imprimir-temas">
                            <input type="hidden" name="id_curso" value="<?= htmlspecialchars($id_curso) ?>">
                            <button type="submit" class="btn bg-body-custom text-white">Imprimir</button>
                        </form>
            <a href="listado.php" class="btn bg-body-custom text-white">Salir</a>
        </div>
    </section>




    <footer footer th:fragment="footer" class="navbar-light bg-primary text-white mt-5 p-3">
        <div class="container">
            <p class="text-center">Derechos Reservados - Escuela en Casa 2025</p>
        </div>
    </footer>
</body>

</html>