<?php

define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DB', 'valvulas-pdvsa');

$connection = mysqli_connect(HOST, USER, PASS, DB);

if (mysqli_connect_errno()) {
    echo "Error de Conexión a Mysql " . mysqli_connect_error();
    exit();
} else {
    //echo 'Conectado!!!';
}
