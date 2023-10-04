<?php
session_start();

if (!isset($_SESSION['reg_complete'])) {
    header('Location:index.php');
    exit();
} else {
    unset($_SESSION['reg_complete']);
}

if(isset($_SESSION['fr_name'])) unset($_SESSION['fr_name']);
if(isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
if(isset($_SESSION['fr_pass1'])) unset($_SESSION['fr_pass1']);
if(isset($_SESSION['fr_pass2'])) unset($_SESSION['fr_pass2']);
if(isset($_SESSION['fr_statue'])) unset($_SESSION['fr_statue']);

if(isset($_SESSION['e_name'])) unset($_SESSION['e_name']);
if(isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
if(isset($_SESSION['e_pass'])) unset($_SESSION['e_pass']);
if(isset($_SESSION['e_pass2'])) unset($_SESSION['e_pass2']);
if(isset($_SESSION['e_statue'])) unset($_SESSION['e_statue']);
?>

<!DOCTYPE HTML>

<html>

<head>
    <title>Rejestracja udana</title>
</head>

<body>
    Dziękujemy za rejestrację w serwisie!<br /><br />
    <a href="login.php">Zaloguj się</a>
</body>

</html>