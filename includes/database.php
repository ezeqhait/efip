<?php

$db = mysqli_connect('127.0.0.1', 'eze', 'Lolo2020!', 'dinotask');


if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
