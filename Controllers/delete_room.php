<?php
session_start();
require_once '../functions.php';
if (isset($_SESSION['login'])){
    $id = $_GET['id'];
    $res = queryMysql("SELECT plan FROM rooms WHERE id='$id'");
    $b = $res->fetch_assoc();
    if ($b["plan"] != "no.jpg") unlink("../img/$b[plan]");

    queryMysql("DELETE FROM addroom WHERE roomid='$id'");


    $res1 = queryMysql("SELECT id FROM controlpoints WHERE roomId='$id'");
    while ($d = $res1->fetch_assoc()){
        queryMysql("DELETE FROM onecontrolpoint WHERE cpid='$d[id]'");
    }
   
    queryMysql("DELETE FROM controlpoints WHERE roomId='$id'");
    queryMysql("DELETE FROM rooms WHERE id='$id'");
    
    header("Location: /room.php");
}