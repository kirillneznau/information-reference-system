<?php
    require_once '../functions.php';  

    $error = $name = $doljnost = $login = $pass = "";
    if(isset($_SESSION['login'])) destroySession();

    if(isset($_POST['login'])){
        $name = sanitizeString($_POST['name']);
        $doljnost = sanitizeString($_POST['doljnost']);
        $login = sanitizeString($_POST['login']);
        $pass = sanitizeString($_POST['pass']);
        

        if ($name == "" || $doljnost == "" || $login == "" || $pass == "")
            $error = 'Вы не заполнили все поля.';
        else{
            $result = queryMysql("SELECT * FROM members WHERE login='$login'");

            if($result->num_rows)
                $error = "Этот логин уже занят.";
            else{
                $hashpass = password_hash($pass, PASSWORD_DEFAULT);
                queryMysql("INSERT INTO members VALUES(NULL,'$name','$doljnost','$login','$hashpass', NULL, 0)");
            }
        }
    }
    echo $error;
