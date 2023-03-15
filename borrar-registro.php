<?php

include_once('./php/connection.php');

$id = '';
$query = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$query = "DELETE FROM `logs` WHERE logs.`id` = $id";
mysqli_query($connection, $query) or die(mysqli_error($connection));

mysqli_close($connection);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminando...</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        window.location.href = "./listar-registros";
    </script>
</body>

</html>