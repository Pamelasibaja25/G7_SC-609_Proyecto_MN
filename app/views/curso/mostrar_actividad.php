<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/controller/cursoController.php';

// Obtener ID del curso de la URL.
$id_curso = isset($_GET['id']) ? $_GET['id'] : null;

if ($id_curso) {
    $data = get_curso_actividades($id_curso);
    $actividades = $data['actividades'];
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
    include $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/views/nav_menu.php'
        ?>

    <section class="class bg-custom" id="actividades">
        <div class="container mt-5">
            <h1 class="text-center text-white" id="curso">Actividades del Curso
                <?= htmlspecialchars($curso['descripcion']); ?></h1>
            <?php if (!empty($actividades)): ?>
                <div class="card row text-center">
                        <div class="card-body">
                            <div class="mb-3 table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead class="bg-body-custom text-white">
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Titulo</th>
                                            <th>Fecha Entrega</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php foreach ($actividades as $reporte): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($reporte['tipo']) ?></td>
                                                    <td><?= htmlspecialchars($reporte['titulo']) ?></td>
                                                    <td><?= htmlspecialchars($reporte['fecha_entrega']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
            <?php else: ?>
                <p class="text-white text-center">No hay actividades disponibles para este curso.</p>
            <?php endif; ?>
        </div>
        <div class="container mt-3 text-center d-flex justify-content-between">
        <form id="imprimir-actividades" action="/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/app/controller/cursoController.php"
                            method="POST">
                            <input type="hidden" name="action" value="imprimir-actividades">
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