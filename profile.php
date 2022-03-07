<?php
session_start();
require_once 'functions.php';
if (isset($_SESSION['login'])){
    $user = $_SESSION['login'];
    $loggedin = TRUE;
}
else $loggedin = FALSE;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Личный кабинет</title>
</head>
<body class="bg-light">
<?php 
if ($loggedin){
    require_once 'Interfaces/nav-auth.php';
    require_once 'Interfaces/profile_interface.php';
    require_once 'Interfaces/footer.php';   
}
else{
    require_once 'Interfaces/hello_nav_modal_reg.php'; 
    require_once 'Interfaces/hello_interface.php';
    require_once 'Interfaces/footer.php';
}?>


<script src="js/script.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>