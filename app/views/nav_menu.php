<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$baseUrl = '/Proyecto_NoSQL/G7_SC-609_Proyecto_MN';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <!-- Marca / Inicio -->
<a class="navbar-brand text-white" href="<?= $baseUrl ?>/app/views/layout.php">Escuela en Casa</a>


        <!-- Contenido colapsable -->
        <div class="collapse navbar-collapse" id="navbarNav">

            <!-- Navegación principal (izquierda) -->
            <ul class="navbar-nav mr-auto">
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'user'): ?>

                    <!-- USER: navegación centrada en tareas -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $baseUrl ?>/app/views/curso/listado.php">
                            Mis cursos
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= $baseUrl ?>/app/views/curso/registro_matricula.php">
                            Matrícula
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                           href="#" id="reportesUserDropdown"
                           role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            Reportes
                        </a>
                        <div class="dropdown-menu" aria-labelledby="reportesUserDropdown">
                            <a class="dropdown-item"
                               href="<?= $baseUrl ?>/app/views/nota/reporte_trimestral.php">
                                Reporte trimestral
                            </a>
                        </div>
                    </li>

                <?php elseif (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>

                    <!-- ADMIN: navegación pensada como panel de gestión -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $baseUrl ?>/app/views/metricas.php">
                            Panel
                        </a>
                    </li>

                    <!-- Académico: registros y listados -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                           href="#" id="academicoDropdown"
                           role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            Académico
                        </a>
                        <div class="dropdown-menu" aria-labelledby="academicoDropdown">

                            <!-- Sección: Registro -->
                            <h6 class="dropdown-header">Registro</h6>
                            <a class="dropdown-item"
                               href="<?= $baseUrl ?>/app/views/profesor/registro.php">
                                Registrar profesor
                            </a>
                            <a class="dropdown-item"
                               href="<?= $baseUrl ?>/app/views/escuela/registro.php">
                                Registrar escuela
                            </a>
                            <a class="dropdown-item"
                               href="<?= $baseUrl ?>/app/views/grupo/registro.php">
                                Registrar grupo
                            </a>
                            <a class="dropdown-item"
                               href="<?= $baseUrl ?>/app/views/actividad/registro.php">
                                Registrar actividad
                            </a>
                            <a class="dropdown-item"
                               href="<?= $baseUrl ?>/app/views/asistencia/registro.php">
                                Registrar asistencia
                            </a>

                            <div class="dropdown-divider"></div>

                            <!-- Sección: Listados -->
                            <h6 class="dropdown-header">Listados</h6>
                            <a class="dropdown-item"
                               href="<?= $baseUrl ?>/app/views/profesor/listado.php">
                                Profesores
                            </a>
                            <a class="dropdown-item"
                               href="<?= $baseUrl ?>/app/views/estudiante/listado.php">
                                Estudiantes
                            </a>
                            <a class="dropdown-item"
                               href="<?= $baseUrl ?>/app/views/escuela/listado.php">
                                Escuelas
                            </a>
                            <a class="dropdown-item"
                               href="<?= $baseUrl ?>/app/views/grupo/listado.php">
                                Grupos
                            </a>
                            <a class="dropdown-item"
                               href="<?= $baseUrl ?>/app/views/actividad/listado.php">
                                Actividades
                            </a>
                            <a class="dropdown-item"
                               href="<?= $baseUrl ?>/app/views/asistencia/listado.php">
                                Asistencias
                            </a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white"
                        href="<?= $baseUrl ?>/app/views/calendario/dashboard.php">
                            Calendario Académico
                        </a>
                    </li>
                    <!-- Reportes admin -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                           href="#" id="reportesAdminDropdown"
                           role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                           Reportes
                        </a>
                        <div class="dropdown-menu" aria-labelledby="reportesAdminDropdown">
                            <a class="dropdown-item"
                               href="<?= $baseUrl ?>/app/views/nota/reporte_rendimiento.php">
                                Reporte de rendimiento
                            </a>
                            <a class="dropdown-item"
                               href="<?= $baseUrl ?>/app/views/asistencia/reporte_asistencia.php">
                                Reporte de Asistencia
                            </a>
                        </div>
                    </li>

                <?php endif; ?>
            </ul>

            <!-- Zona de cuenta / sesión (derecha) -->
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'user'): ?>
                    <!-- USER: menú de cuenta -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                           href="#" id="cuentaDropdown"
                           role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            Mi cuenta
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="cuentaDropdown">
                            <a class="dropdown-item"
                               href="<?= $baseUrl ?>/app/views/nota/listado.php">
                                Mi perfil
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger"
                               href="<?= $baseUrl ?>/index.php">
                                Cerrar sesión
                            </a>
                        </div>
                    </li>
                <?php else: ?>
                    <!-- ADMIN u otros: solo botón de salir (puedes luego unificar en "Mi cuenta" también) -->
                    <li class="nav-item my-auto">
                        <a class="btn btn-outline-light"
                           href="<?= $baseUrl ?>/index.php">
                            Salir
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

        </div>
    </div>
</nav>

