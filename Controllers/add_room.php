<?php
    session_start();
    require_once '../functions.php';  

    $error = $roomname = $vch = $address = "";
    $plane = "no.jpg";
    $user = $_SESSION['login']; 

    $roomname = sanitizeString($_POST['roomname']);
    $vch = sanitizeString($_POST['vch']);
    $address = sanitizeString($_POST['address']);
    $categor = sanitizeString($_POST['categor']);
    $placeOfIntellegent = sanitizeString($_POST['placeOfIntellegent']);
    if ($_POST['audioSystem'] == 1) $audioSystem = 1; else $audioSystem = 0;
    $aboutRoom = sanitizeString($_POST['aboutRoom']);

    if(isset($_FILES['plane']['name']) && $_FILES['plane']['name'] != ''){
        $plane = "$roomname.jpg"; 
        $saveto = "../img/$roomname.jpg";
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
    }

    if ($roomname == "" || $vch == "" || $address == "" )
        $error = 'Вы не заполнили все поля.';
    else{
        queryMysql("INSERT INTO `rooms` VALUES (NULL, '$roomname', '$address', '$vch', '$categor', '$plane', '$placeOfIntellegent', '$audioSystem', '$aboutRoom')");
        $roomid = mysqli_insert_id($connection);
        $res = queryMysql("SELECT id FROM `members` WHERE login = '$user'");
        $d = $res->fetch_assoc();
        $userid = $d['id'];
        queryMysql("INSERT INTO `addroom` VALUES (NULL, '$userid', '$roomid', NULL)");
        header("Location: /room.php");
    }
    echo $error;