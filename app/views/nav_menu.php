<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// IMPORTANTE: base de la app respecto a htdocs
$baseUrl = '/Proyecto_NoSQL/G7_SC-609_Proyecto_MN';
?>

<nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <div class="container">
        <a class="navbar-brand text-white" href="<?= $baseUrl ?>/app/views/layout.php">Escuela en Casa</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php if ($_SESSION['rol'] === 'user'): ?>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= $baseUrl ?>/app/views/curso/listado.php">
                            Listado de Cursos
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= $baseUrl ?>/app/views/curso/registro_matricula.php">
                            Registro de Matrícula
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" data-toggle="dropdown" href="#" role="button">
                            Reportes
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            <li>
                                <a class="dropdown-item text-white"
                                   href="<?= $baseUrl ?>/app/views/nota/reporte_trimestral.php">
                                   Reporte Trimestral
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= $baseUrl ?>/app/views/nota/listado.php">
                            Mi Perfil
                        </a>
                    </li>

                <?php elseif ($_SESSION['rol'] === 'admin'): ?>

                    <!-- REPORTES (ADMIN) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" data-toggle="dropdown" href="#" role="button">
                            Reportes
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            <li>
                                <a class="dropdown-item text-white"
                                   href="<?= $baseUrl ?>/app/views/nota/reporte_rendimiento.php">
                                   Reporte Rendimiento
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- REGISTRO (ADMIN) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" data-toggle="dropdown" href="#" role="button">
                            Registro
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            <li>
                                <a class="dropdown-item text-white"
                                   href="<?= $baseUrl ?>/app/views/profesor/registro.php">
                                   Registro de Profesores
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-white"
                                   href="<?= $baseUrl ?>/app/views/escuela/registro.php">
                                   Registro de Escuelas
                                </a>
                            </li>

                            <!--  Registro Actividad -->
                            <li>
                                <a class="dropdown-item text-white"
                                   href="<?= $baseUrl ?>/app/views/actividad/registro.php">
                                   Registro Actividad
                                </a>
                            </li>

                            <!--  Registro Asistencia -->
                            <li>
                                <a class="dropdown-item text-white"
                                   href="<?= $baseUrl ?>/app/views/asistencia/registro.php">
                                   Registro Asistencia
                                </a>
                            </li>

                            <!--  Registro Calendario -->
                            <li>
                                <a class="dropdown-item text-white"
                                   href="<?= $baseUrl ?>/app/views/calendario/registro.php">
                                   Registro Calendario
                                </a>
                            </li>

                            <!--  Registro Grupo -->
                            <li>
                                <a class="dropdown-item text-white"
                                   href="<?= $baseUrl ?>/app/views/grupo/registro.php">
                                   Registro Grupo
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- MANTENIMIENTO (ADMIN) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" data-toggle="dropdown" href="#" role="button">
                            Mantenimiento
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            <li>
                                <a class="dropdown-item text-white"
                                    href="<?= $baseUrl ?>/app/views/grupo/listado.php">Lista de Grupos</a></li>
                                <a class="dropdown-item text-white"
                                   href="<?= $baseUrl ?>/app/views/profesor/listado.php">
                                   Lista de Profesores
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-white"
                                   href="<?= $baseUrl ?>/app/views/estudiante/listado.php">
                                   Lista de Estudiantes
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-white"
                                   href="<?= $baseUrl ?>/app/views/escuela/listado.php">
                                   Lista de Escuelas
                                </a>
                            </li>

                            <!--  Listado Actividad -->
                            <li>
                                <a class="dropdown-item text-white"
                                   href="<?= $baseUrl ?>/app/views/actividad/listado.php">
                                   Lista de Actividades
                                </a>
                            </li>

                            <!--  Listado Asistencia -->
                            <li>
                                <a class="dropdown-item text-white"
                                   href="<?= $baseUrl ?>/app/views/asistencia/listado.php">
                                   Lista de Asistencias
                                </a>
                            </li>

                            <!--  Listado Calendario -->
                            <li>
                                <a class="dropdown-item text-white"
                                   href="<?= $baseUrl ?>/app/views/calendario/listado.php">
                                   Lista de Calendarios
                                </a>
                            </li>

                            <!--  Listado Grupo -->
                            <li>
                                <a class="dropdown-item text-white"
                                   href="<?= $baseUrl ?>/app/views/grupo/listado.php">
                                   Lista de Grupos
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= $baseUrl ?>/app/views/metricas.php">
                            Métricas
                        </a>
                    </li>

                <?php endif; ?>
            </ul>
        </div>

        <ul class="navbar-nav">
            <li class="nav-item my-auto">
                <a class="btn btn-outline-light" href="<?= $baseUrl ?>/index.php">Salir</a>
            </li>
        </ul>
    </div>
</nav>
