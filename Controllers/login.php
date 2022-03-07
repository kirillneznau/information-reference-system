<?php
    session_start();
    require_once '../functions.php';
    $error = $login = $pass = "";

    if(isset($_POST['login'])){
        $login = sanitizeString($_POST['login']);
        $pass = sanitizeString($_POST['pass']);

        if ($login == "" || $pass == "")
            $error = 'Вы не заполнили все поля.';
        else{
            $result = queryMysql("SELECT login, pass, verify FROM members WHERE login='$login'");
            if($result->num_rows == 0)
                $error = "Неверный логин.";
            else{
                $user = $result->fetch_assoc();
                if( $user['verify'] ) {
                    if(password_verify($pass, $user["pass"])){
                        $_SESSION['login'] = $login;
                        $_SESSION['pass'] = $pass;
                    }
                    else $error = "Неверный пароль.";
                }
                else $error = "Регистрация ещё не подтверждена.";
            }
        }
    }
    echo $error;