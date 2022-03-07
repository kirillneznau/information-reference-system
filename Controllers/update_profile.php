<?php
    session_start();
    require_once '../functions.php'; 
    $user = $_SESSION['login']; 
    $error = $name = $doljnost = "";

    $name = sanitizeString($_POST['name']);
    $doljnost = sanitizeString($_POST['doljnost']);

    if ($name == "" || $doljnost == "")
        $error = 'Вы не заполнили все поля.';
    else{
        queryMysql("UPDATE members SET name = '$name', doljnost = '$doljnost' WHERE login = '$user'");
    }
    echo $error;