<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <div class="container">
        <a class="navbar-brand text-white" href="/G7_SC-609_Proyecto_MN/app/views/layout.php">Escuela en Casa</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php if ($_SESSION['rol'] === 'user'): ?>
                    <li class="nav-item"><a class="nav-link text-white" href="/G7_SC-609_Proyecto_MN/app/views/curso/listado.php">Listado de Cursos</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="/G7_SC-609_Proyecto_MN/app/views/curso/registro_matricula.php">Registro de Matrícula</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" data-toggle="dropdown" href="#" role="button" aria-expanded="false">Reportes</a>
                        <ul class="dropdown-menu bg-primary">
                            <li><a class="dropdown-item text-white" href="/G7_SC-609_Proyecto_MN/app/views/nota/reporte_trimestral.php">Reporte Trimestral</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link text-white" href="/G7_SC-609_Proyecto_MN/app/views/nota/listado.php">Mi Perfil</a></li>

                <?php elseif ($_SESSION['rol'] === 'admin'): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" data-toggle="dropdown" href="#" role="button" aria-expanded="false">Reportes</a>
                        <ul class="dropdown-menu bg-primary">
                            <li><a class="dropdown-item text-white" href="/G7_SC-609_Proyecto_MN/app/views/nota/reporte_rendimiento.php">Reporte Rendimiento</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link text-white" href="/G7_SC-609_Proyecto_MN/app/views/metricas.php">Métricas</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <ul class="navbar-nav">
            <li class="nav-item my-auto">
                <a class="btn btn-outline-light" href="/G7_SC-609_Proyecto_MN/index.php">Salir</a>
            </li>
        </ul>
    </div>
</nav>
