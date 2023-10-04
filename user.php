<?php
session_start();

if (!isset($_SESSION['logged'])) {
    header('Location:index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">

</head>

<body>
    <?php

    echo "<p>Witaj " . $_SESSION['name'] . "! <a href=logout.php>Wyloguj się</a></p>";
    echo "<p>Twój login: " . $_SESSION['login'];

    ?>
</body>

</html>