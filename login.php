<?php

session_start();

if ((!isset($_POST['login'])) || (!isset($_POST['password']))) {
    header('Location:index.php');
    exit();
}

require_once "connect.php";

$connect = @new mysqli($host, $db_user, $db_password, $db_name);

if ($connect->connect_errno != 0) {
    echo "Error:" . $connect->connect_errno;
} else {

    $login = $_POST['login'];
    $password = $_POST['password'];

    $login = htmlentities($login, ENT_QUOTES, "UTF-8");

    if ($result = @$connect->query(sprintf(
        "SELECT * FROM users WHERE Login='%s'",
        mysqli_real_escape_string($connect, $login),
    ))) {
        $users_nmb = $result->num_rows;
        if ($users_nmb > 0) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user['Password'])) {

                $_SESSION['logged'] = true;

                $_SESSION['user_id'] = $user['Id'];
                $_SESSION['login'] = $user['Login'];
                $_SESSION['name'] = $user['name'];


                unset($_SESSION['login_error']);
                $result->close();
                header('Location: user.php');
            } else {

            $_SESSION['login_error']  = '<span style="color:red">Nieprawidłowe hasło!</span>';
            header('Location:index.php');
            }
        } else {

            $_SESSION['login_error']  = '<span style="color:red">Nieprawidłowy login!</span>';
            header('Location:index.php');
        }
    }

    $connect->close();
}
