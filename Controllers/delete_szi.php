<?php
session_start();
require_once '../functions.php';
if (isset($_SESSION['login'])){
    $id = $_GET['id'];
    $res = queryMysql("SELECT img FROM szi WHERE id='$id'");
    $b = $res->fetch_assoc();
    if ($b["img"] != "no.jpg") unlink("../img/$b[img]");
    queryMysql("DELETE FROM szi WHERE id='$id'");
    header("Location: /szi.php");
}