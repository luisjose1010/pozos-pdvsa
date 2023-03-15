<?php

include_once('./php/connection.php');

$well = '';
$psi = '';
$date = time();
$query = '';
$result = '';

if (isset($_GET['submit'])) {
    $well = $_GET['well'];
    $psi =  $_GET['psi'];

    if (isset($_GET['date']) && !empty($_GET['date'])) {
        $date = "'{$_GET['date']}'";
    } else {
        $date = 'now()';
    }
}

$query = "INSERT INTO logs(`well`, `psi`, `date`) VALUES ('$well', '$psi', $date)";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

mysqli_close($connection);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardando...</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        window.location.href = "./";
    </script>
</body>

</html>