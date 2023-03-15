<?php

include_once('./php/connection.php');

$fromDate = '';
$toDate = '';
$rows = array();

$query = "SELECT * FROM logs ORDER BY `date` DESC";

if (isset($_GET['fecha-desde']) && isset($_GET['fecha-hasta'])) {
    $fromDate = $_GET['fecha-desde'];
    $toDate = $_GET['fecha-hasta'];

    $query = "SELECT * FROM logs WHERE `date` BETWEEN '$fromDate' AND '$toDate' ORDER BY `date` DESC";
}

$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medición de válvulas de pozos PDVSA</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="./">Medición de válvulas de pozos PDVSA</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="./">Inicio</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./listar-registros.php">Listar registros</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./grafico-registros.php">Gráfico de registros</a>
                    </li>
                </ul>
            </div>

            <form action="./listar-registros.php" method="get" class="form-inline">
                <input id="" name="fecha-desde" type="datetime-local" class="form-control m-1" required>
                <input id="" name="fecha-hasta" type="datetime-local" class="form-control m-1" required>
                <button id="" type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </nav>
    </header>

    <table class="table">
        <thead>
            <?php if (isset($_GET['fecha-desde']) && isset($_GET['fecha-hasta'])) : ?>
                <b>Desde: <?= $fromDate ?> - Hasta: <?= $toDate ?></b>
            <?php endif; ?>
            <tr>
                <th scope="col">Pozo medido</th>
                <th scope="col">PSI de valvula</th>
                <th scope="col">Fecha y hora</th>
                <th scope="col">Eliminar registro</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($rows = mysqli_fetch_array($result)) : ?>
                <tr>
                    <td><?= $rows['well'] ?></td>
                    <td><?= $rows['psi'] ?></td>
                    <td><?= $rows['date'] ?></td>
                    <td>
                        <a href="./borrar-registro.php?id=<?= $rows['id'] ?>" style="width: 1rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

</body>

</html>