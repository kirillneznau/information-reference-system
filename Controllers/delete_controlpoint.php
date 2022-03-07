<?php
session_start();
require_once '../functions.php';
if (isset($_SESSION['login'])){
    $cpid = $_GET['cpid'];
    $roomid = $_GET['roomid'];
    queryMysql("DELETE FROM onecontrolpoint WHERE cpid='$cpid'");
    queryMysql("DELETE FROM controlpoints WHERE id='$cpid'");
    header("Location: /detail_room.php?id=$roomid");
}