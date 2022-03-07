<?php
    session_start();
    require_once '../functions.php';  

    $error = $sziname = $aboutszi = "";
    $sziimg = "no.jpg";
    $user = $_SESSION['login']; 

    $sziname = sanitizeString($_POST['sziname']);
    $aboutszi = sanitizeString($_POST['aboutszi']);

    if(isset($_FILES['sziimg']['name']) && $_FILES['sziimg']['name'] != ''){
        $sziimg = "$sziname.jpg"; 
        $saveto = "../img/$sziname.jpg";
        move_uploaded_file($_FILES['sziimg']['tmp_name'], $saveto);
        $typeok = TRUE;

        switch($_FILES['sziimg']['type']){
            case "sziimg/gif": $src = imagecreatefromgif($saveto); break;
            case "sziimg/jpeg":
            case "sziimg/pjpeg": $src = imagecreatefromjpeg($saveto); break;
            case "sziimg/png": $src = imagecreatefrompng($saveto); break;
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

    if ($sziname == "" || $aboutszi == "" )
        $error = 'Вы не заполнили все поля.';
    else{
        queryMysql("INSERT INTO `szi` VALUES (NULL, '$sziname', '$aboutszi', '$sziimg')");
        header("Location: /szi.php");
    }
    echo $error;