<?php
    session_start();
    require_once '../functions.php'; 
    $user = $_SESSION['login']; 
    $error = $oldpass = $newpass = $newpass2 = "";

    $newpass = sanitizeString($_POST['newpass']);
    $newpass2 = sanitizeString($_POST['newpass2']);
    $oldpass = sanitizeString($_POST['oldpass']);

    if ($oldpass == "" || $newpass == "" || $newpass2 == "")
        $error = 'Вы не заполнили все поля.';
    else{
        $res = queryMysql("SELECT * FROM members WHERE login = '$user'");
        $b = $res->fetch_assoc();
        if(password_verify($oldpass, $b["pass"])){
            if($newpass == $newpass2){
                $hashpass = password_hash($newpass, PASSWORD_DEFAULT);
                queryMysql("UPDATE members SET pass = '$hashpass' WHERE login = '$user'");
            }
            else $error = "Ошибка в подтверждении пароля.";
        }
        else $error = "Неверный старый пароль.";
    }
    echo $error;