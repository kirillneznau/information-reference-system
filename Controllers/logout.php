<?php
    session_start();
    require_once '../functions.php';
    if(isset($_SESSION['login'])){
        destroySession();
    }
    header('Location: /');