<?php
// app/controller/calendarioController.php

require_once __DIR__ . '/../models/calendario.php';

function get_calendario($id_curso = null)
{
    return Calendario::lista_calendario($id_curso);
}

function get_semana_actual($id_curso = null, $fecha = null)
{
    return Calendario::semana_actual($id_curso, $fecha);
}
