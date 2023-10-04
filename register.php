<?php
session_start();

if (isset($_POST['email'])) {
    $validate = true;

    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass1 = $_POST['password1'];
    $pass2 = $_POST['password2'];

    if ((strlen($name) < 3) || (strlen($name) > 20)) {
        $validate = false;
        $_SESSION['e_name'] = 'Imię powinno mieć długość od 3 do 20 znaków!';
    }

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if ((!filter_var($email, FILTER_VALIDATE_EMAIL))) {
        $validate = false;
        $_SESSION['e_email'] = 'Błędny adres e-mail!';
    }

    if ((strlen($pass1) < 8) || (strlen($pass1) > 20)) {
        $validate = false;
        $_SESSION['e_pass'] = 'Hasło musi mieć długość od 8 do 20 znaków!';
    }

    if ($pass1 != $pass2) {
        $validate = false;
        $_SESSION['e_pass2'] = 'Hasła są różne!';
    }

    $hash_pass = password_hash($pass1, PASSWORD_DEFAULT);

    if (!isset($_POST['statue'])) {
        $validate = false;
        $_SESSION['e_statue'] = 'Zaakceptuj regulamin!';
    }

    $_SESSION['fr_email'] = $email;
    $_SESSION['fr_pass1'] = $pass1;
    $_SESSION['fr_pass2'] = $pass2;
    $_SESSION['fr_name'] = $name;
    if (isset($_POST['statue'])) $_SESSION['fr_statue'] = true;

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $connect = new mysqli($host, $db_user, $db_password, $db_name);

        if ($connect->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {

            $result = $connect->query("SELECT id FROM users WHERE Login='$email'");

            if (!$result) throw new Exception($connect->error);

            $result_nmb = $result->num_rows;

            if ($result_nmb > 0) {
                $validate = false;
                $_SESSION['e_email'] = 'Użytkownik o podanym adresie e-mail już istnieje';
            }

            if ($validate == true) {

                if ($connect->query("INSERT INTO users VALUES(NULL, '$email', '$hash_pass', '$name')")) {
                    $_SESSION['reg_complete'] = true;
                    header('Location: reg_complete.php');
                } else {
                    throw new Exception(($connect->error));
                }

                exit();
            }

            $connect->close();
        }
    } catch (Exception $e) {
        echo '<span class="error">Błąd serwera! Przepraszamy, spróbuj później.</span>';
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Zarejestruj sie</title>
    <style>
        .error {
            color: red;
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <form method="post">

        Imię: <br /><input type="text" name="name" value="<?php if (isset($_SESSION['fr_name'])) {
                                                                echo $_SESSION['fr_name'];
                                                                unset($_SESSION['fr_name']);
                                                            } ?>" /><br />

        <?php

        if (isset($_SESSION['e_name'])) {
            echo '<div class="error">' . $_SESSION['e_name'] . '</div>';
            unset($_SESSION['e_name']);
        }
        ?>

        E-mail: <br /><input type="text" name="email" value="<?php if (isset($_SESSION['fr_email'])) {
                                                                    echo $_SESSION['fr_email'];
                                                                    unset($_SESSION['fr_email']);
                                                                } ?>" /><br />

        <?php

        if (isset($_SESSION['e_email'])) {
            echo '<div class="error">' . $_SESSION['e_email'] . '</div>';
            unset($_SESSION['e_email']);
        }
        ?>

        Hasło: <br /><input type="password" name="password1" value="<?php if (isset($_SESSION['fr_pass1'])) {
                                                                        echo $_SESSION['fr_pass1'];
                                                                        unset($_SESSION['fr_pass1']);
                                                                    } ?>" /><br />

        <?php

        if (isset($_SESSION['e_pass'])) {
            echo '<div class="error">' . $_SESSION['e_pass'] . '</div>';
            unset($_SESSION['e_pass']);
        }
        ?>

        Powtórz hasło: <br /><input type="password" name="password2" value="<?php if (isset($_SESSION['fr_pass2'])) {
                                                                                echo $_SESSION['fr_pass2'];
                                                                                unset($_SESSION['fr_pass2']);
                                                                            } ?>" /><br /><br />

        <?php

        if (isset($_SESSION['e_pass2'])) {
            echo '<div class="error">' . $_SESSION['e_pass2'] . '</div>';
            unset($_SESSION['e_pass2']);
        }
        ?>

        <label>
            <input type="checkbox" name="statue" <?php
                                                    if (isset($_SESSION['fr_statue'])) {
                                                        echo 'checked';
                                                        unset($_SESSION['fr_statue']);
                                                    } ?> />Akceptuję regulamin
        </label><br />

        <?php

        if (isset($_SESSION['e_statue'])) {
            echo '<div class="error">' . $_SESSION['e_statue'] . '</div>';
            unset($_SESSION['e_statue']);
        }
        ?>

        <input type="submit" value="Zarejestruj się" />

    </form>


</body>

</html>