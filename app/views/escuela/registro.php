<?php
include $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/controller/escuelaController.php';

// Datos necesarios:
$resumen = get_escuela_resumen();  
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
    <script src="/G7_SC-609_Proyecto_MN/public/js/scripts.js"></script>

</head>

<body>
        <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
        <div class="alert alert-success text-center" role="alert">
            <?php echo htmlspecialchars($_GET['msg']); ?>
        </div>
    <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?php echo htmlspecialchars($_GET['msg']); ?>
        </div>
    <?php endif; ?>

     <?php include $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/views/nav_menu.php'; ?>

    <section class="bg-custom">
        <div class="container mt-5">
            <h1 class="text-center text-white">Resumen de Escuelas</h1>

            <!-- Tarjetas de resumen -->
            <div class="row mt-3">
                <?php if (!empty($resumen)): ?>
                    <?php foreach ($resumen as $provincia => $cantidad): ?>
                        <div class="col-6 col-md-3 mb-2">
                            <div class="card">
                                <div class="card-header bg-body-custom text-white text-center">
                                    <?= htmlspecialchars($provincia) ?>
                                </div>
                                <div class="card-body text-center">
                                    <h3><?= htmlspecialchars($cantidad) ?></h3>
                                    <p>Escuelas registradas</p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-white text-center">No hay datos disponibles.</p>
                <?php endif; ?>
            </div>

            <!-- Botón registrar -->
            <div class="text-center mt-4">
                <button class="btn bg-body-custom text-white" data-toggle="modal" data-target="#register-escuela">
                    Registro
                </button>
            </div>
        </div>
    </section>
    

    <!-- Modal de Registro -->
     <div class="modal fade" id="register-escuela" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card-header bg-body-custom text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Registro de Escuela</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form action="/G7_SC-609_Proyecto_MN/app/controller/escuelaController.php" method="POST">

                        <div class="form-group mb-3">
                            <label>Nombre:</label>
                            <input type="text" class="form-control" name="nombre" required>
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

                        <input type="hidden" name="action" value="registrar-escuela">

                        <div class="card-footer text-center">
                            <button type="submit" class="btn bg-body-custom text-white">Registrar</button>
                            <button type="reset" class="btn bg-body-custom text-white">Limpiar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="navbar-light bg-primary text-white mt-5 p-3">
        <div class="container">
            <p class="text-center">Derechos Reservados - Escuela en Casa 2025</p>
        </div>
    </footer>

</body>

</html>