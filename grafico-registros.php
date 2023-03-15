<?php

include_once('./php/connection.php');

$fromDate = '';
$toDate = '';
$rows = array();
$data = array('labels' => [], 'datasets' => []);

$query = "SELECT * FROM logs ORDER BY `date` ASC";

if (isset($_GET['fecha-desde']) && isset($_GET['fecha-hasta'])) {
    $fromDate = $_GET['fecha-desde'];
    $toDate = $_GET['fecha-hasta'];

    $query = "SELECT * FROM logs WHERE `date` BETWEEN '$fromDate' AND '$toDate' ORDER BY `date` ASC";
}

$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
$random_int = 'random_int';
$result = mysqli_fetch_all($result);
$resultGroup = array();

$i = 0; // Iterador

// Agrupa pozos
foreach ($result as $value) {
    $resultGroup[$value[1]][] = $value;
}

// Define fechas del gráfico
foreach ($result as $key => $value) {
    $data['labels'][$key] = $value[3];
}

foreach ($resultGroup as $key => $value) {
    foreach ($value as $key2 => $value2) {
        $data['datasets'][$i]['label'] = $value2[1];
        $data['datasets'][$i]['backgroundColor'] = "rgba({$random_int(0, 255)}, {$random_int(0, 255)}, {$random_int(0, 255)}, 0.6)";
        $data['datasets'][$i]['borderColor'] = "black";
        $data['datasets'][$i]['borderWidth'] = 2;

        $data['datasets'][$i]['data'][$key2]['x'] = $value2[3];
        $data['datasets'][$i]['data'][$key2]['y'] = floatval($value2[2]);
    }
    $i++;
}



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

            <form action="./grafico-registros.php" method="get" class="form-inline">
                <input id="" name="fecha-desde" type="datetime-local" class="form-control m-1" required>
                <input id="" name="fecha-hasta" type="datetime-local" class="form-control m-1" required>
                <button id="" type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </nav>
    </header>

    <div class="container">
        <h2>Gráfico de mediciones de válvulas PDVSA</h2>
        <div>
            <canvas id="myChart"></canvas>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

    <script>
        $(document).ready(function() {
            var ctx = document.getElementById("myChart").getContext("2d");
            console.log(JSON.parse('<?= json_encode($data) ?>'));

            var myChart = new Chart(ctx, {
                type: 'line',
                options: {
                    scales: {
                        xAxes: [{
                            type: 'time',
                            time: {
                                unit: 'day',
                            }
                        }]
                    }
                },
                data: JSON.parse('<?= json_encode($data) ?>'),
            });
        })
    </script>
</body>

</html>