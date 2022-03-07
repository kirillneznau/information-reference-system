<?php
    session_start();
    require_once '../functions.php';  

    $error = ""; 
    $roomid = $_GET['roomid'];

    $roomname = sanitizeString($_POST['roomname']);
    $vch = sanitizeString($_POST['vch']);
    $address = sanitizeString($_POST['address']);
    $categor = sanitizeString($_POST['categor']);
    $placeOfIntellegent = sanitizeString($_POST['placeOfIntellegent']);
    if ($_POST['audioSystem'] == 1) $audioSystem = 1; else $audioSystem = 0;
    $aboutRoom = sanitizeString($_POST['aboutRoom']);

    if(isset($_FILES['plane']['name']) && $_FILES['plane']['name'] != ''){
        $res = queryMysql("SELECT plan FROM rooms WHERE id='$roomid'");
        $b = $res->fetch_assoc();
        if ($b["plan"] != "no.jpg") unlink("../img/$b[plan]");
        $cacheId = rand(1000,10000);
        $plane = $roomname . $cacheId . ".jpg"; 
        $saveto = "../img/".$plane;
        move_uploaded_file($_FILES['plane']['tmp_name'], $saveto);
        $typeok = TRUE;

        switch($_FILES['plane']['type']){
            case "plane/gif": $src = imagecreatefromgif($saveto); break;
            case "plane/jpeg":
            case "plane/pjpeg": $src = imagecreatefromjpeg($saveto); break;
            case "plane/png": $src = imagecreatefrompng($saveto); break;
            default: $typeok = FALSE; break;
        }

        if($typeok){
            list($w, $h) = getimagesize($saveto);

            $max = 100;
            $tw = $w;
            $th = $h;

            if($w > $h && $max < $w){
                $th = $max / $w * $h;
                $tw = $max;
            }
            elseif($h > $w && $max < $h){
                $tw = $max / $h * $w;
                $th = $max;
            }
            elseif($max < $w){
                $tw = $th = $max;
            }

            $tmp = imagecreatetruecolor($tw, $th);
            imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
            imageconvolution($tmp, array(array(-1, -1, -1), array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
            imagejpeg($tmp, $saveto);
            imagedestroy($tmp);
            imagedestroy($src);
        }

        queryMysql("UPDATE `rooms` SET plan = '$plane' WHERE id ='$roomid'");

    }
    

    queryMysql("UPDATE `rooms`  SET name = '$roomname', address = '$address', VCh = '$vch', categor = '$categor', placeOfIntellegent = '$placeOfIntellegent', audioSystem = '$audioSystem', aboutRoom = '$aboutRoom' WHERE id ='$roomid'");

    header("Location: /detail_room.php?id=$roomid");