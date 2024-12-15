<?php

include "koneksi.php";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <nav>
        <ul>
            <li><a href="index.php">Back Olah Data</a></li>
            <!-- <li><a href="peramalan.php">Forecasting</a></li> -->
        </ul>
    </nav>

    <form action="proses/hasil.php" method="post">
        <button type="submit">Ramal</button>
    </form>
</body>

</html>