<?php
session_start();

if ((isset($_SESSION['logged'])) && ($_SESSION['logged'] == true)) {
    header('Location:user.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <title>Zaloguj</title>
</head>

<body>
    <a href="register.php">Zarejestruj się</a><br/><br/>

    <form action="login.php" method="post">
        Login: <br /><input type="text" name="login" /><br /><br />
        Hasło: <br /><input type="password" name="password" />
        <br /><br /><input type="submit" value="Zaloguj" />
    </form>

    <?php

    if (isset($_SESSION['login_error'])) {
        echo $_SESSION['login_error'];
    }
    ?>

</body>

</html>