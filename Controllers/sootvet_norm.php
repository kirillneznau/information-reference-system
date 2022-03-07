<?php
    require_once '../functions.php';

    $norm = sanitizeString($_POST['norm']);
    $roomid = sanitizeString($_POST['roomid']);

    if ($norm == ''){
        echo "Вы не ввели нормированное значение показателя противодействия акустической разведке!";
    }
    else{
        queryMysql("UPDATE `controlpoints` SET normW='$norm' WHERE roomId='$roomid'");
        $res = queryMysql("SELECT * FROM `controlpoints` WHERE roomId='$roomid'");
        while ($cp = $res->fetch_assoc()){
            if ( $cp['W'] > $norm ){
                queryMysql("UPDATE `controlpoints` SET sootvetW='0' WHERE id='$cp[id]'");
            } 
            else {
                queryMysql("UPDATE `controlpoints` SET sootvetW='1' WHERE id='$cp[id]'");
            }
            $res2 = queryMysql("SELECT * FROM `onecontrolpoint` WHERE cpid='$cp[id]'");
            $k = 0 ;
            while ($onecp = $res2->fetch_assoc()){
                $k += $onecp['sootvet'];    
            }
            if ($k == 5) {
                queryMysql("UPDATE `controlpoints` SET sootvetQ='1' WHERE id='$cp[id]'");
            } 
            else {
                queryMysql("UPDATE `controlpoints` SET sootvetQ='0' WHERE id='$cp[id]'");
            }
        }
    }

