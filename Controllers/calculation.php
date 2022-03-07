<?php
    require_once '../functions.php';
    $place = sanitizeString($_POST['place']);
    $a1 = sanitizeString($_POST['a1']);
    $a2 = sanitizeString($_POST['a2']);
    $a3 = sanitizeString($_POST['a3']);
    $b1 = sanitizeString($_POST['b1']);
    $b2 = sanitizeString($_POST['b2']);
    $b3 = sanitizeString($_POST['b3']);
    $c1 = sanitizeString($_POST['c1']);
    $c2 = sanitizeString($_POST['c2']);
    $c3 = sanitizeString($_POST['c3']);
    $d1 = sanitizeString($_POST['d1']);
    $d2 = sanitizeString($_POST['d2']);
    $d3 = sanitizeString($_POST['d3']);
    $e1 = sanitizeString($_POST['e1']);
    $e2 = sanitizeString($_POST['e2']);
    $e3 = sanitizeString($_POST['e3']);
    $Lc = sanitizeString($_POST['Lc']);
    $roomid = sanitizeString($_POST['roomid']);

    if($place == '' || $a1 == '' || $a2 == '' || $a3 == '' || $b1 == '' || $b2 == '' || $b3 == '' || $c1 == '' || $c2 == '' || $c3 == '' || $d1 == '' || $d2 == '' || $d3 == '' || $e1 == '' || $e2 == '' || $e3 == '' || $Lc == '')
    echo "Вы не заполнили все поля!";
    else{

    # Рассчет окавных коэффициентов звукоизоляции

    if (($a3 - $a1) >= 10) $reza = $a3;
    elseif (($a3 - $a1) < 10 && ($a3 -$a1) >= 6 ) $reza = $a3 - 1;
    elseif (($a3 - $a1) < 6 && ($a3 -$a1) >= 4 ) $reza = $a3 - 2;
    elseif (($a3 - $a1) < 4 && ($a3 -$a1) >= 3 ) $reza = $a3 - 3;
    elseif (($a3 - $a1) < 3 && ($a3 -$a1) >= 2 ) $reza = $a3 - 4;
    elseif (($a3 - $a1) < 2 && ($a3 -$a1) >= 1 ) $reza = $a3 - 7;
    elseif (($a3 - $a1) < 1) $reza = $a3 - 10;

    if (($b3 - $b1) >= 10) $rezb = $b3;
    elseif (($b3 - $b1) < 10 && ($b3 -$b1) >= 6 ) $rezb = $b3 - 1;
    elseif (($b3 - $b1) < 6 && ($b3 -$b1) >= 4 ) $rezb = $b3 - 2;
    elseif (($b3 - $b1) < 4 && ($b3 -$b1) >= 3 ) $rezb = $b3 - 3;
    elseif (($b3 - $b1) < 3 && ($b3 -$b1) >= 2 ) $rezb = $b3 - 4;
    elseif (($b3 - $b1) < 2 && ($b3 -$b1) >= 1 ) $rezb = $b3 - 7;
    elseif (($b3 - $b1) < 1) $rezb = $b3 - 10;

    if (($c3 - $c1) >= 10) $rezc = $c3;
    elseif (($c3 - $c1) < 10 && ($c3 -$c1) >= 6 ) $rezc = $c3 - 1;
    elseif (($c3 - $c1) < 6 && ($c3 -$c1) >= 4 ) $rezc = $c3 - 2;
    elseif (($c3 - $c1) < 4 && ($c3 -$c1) >= 3 ) $rezc = $c3 - 3;
    elseif (($c3 - $c1) < 3 && ($c3 -$c1) >= 2 ) $rezc = $c3 - 4;
    elseif (($c3 - $c1) < 2 && ($c3 -$c1) >= 1 ) $rezc = $c3 - 7;
    elseif (($c3 - $c1) < 1) $rezc = $c3 - 10;

    if (($d3 - $d1) >= 10) $rezd = $d3;
    elseif (($d3 - $d1) < 10 && ($d3 -$d1) >= 6 ) $rezd = $d3 - 1;
    elseif (($d3 - $d1) < 6 && ($d3 -$d1) >= 4 ) $rezd = $d3 - 2;
    elseif (($d3 - $d1) < 4 && ($d3 -$d1) >= 3 ) $rezd = $d3 - 3;
    elseif (($d3 - $d1) < 3 && ($d3 -$d1) >= 2 ) $rezd = $d3 - 4;
    elseif (($d3 - $d1) < 2 && ($d3 -$d1) >= 1 ) $rezd = $d3 - 7;
    elseif (($d3 - $d1) < 1) $rezd = $d3 - 10;

    if (($e3 - $e1) >= 10) $reze = $e3;
    elseif (($e3 - $e1) < 10 && ($e3 -$e1) >= 6 ) $reze = $e3 - 1;
    elseif (($e3 - $e1) < 6 && ($e3 -$e1) >= 4 ) $reze = $e3 - 2;
    elseif (($e3 - $e1) < 4 && ($e3 -$e1) >= 3 ) $reze = $e3 - 3;
    elseif (($e3 - $e1) < 3 && ($e3 -$e1) >= 2 ) $reze = $e3 - 4;
    elseif (($e3 - $e1) < 2 && ($e3 -$e1) >= 1 ) $reze = $e3 - 7;
    elseif (($e3 - $e1) < 1) $reze = $e3 - 10;

    $Qa = $a2 - $reza;
    $Qb = $b2 - $rezb;
    $Qc = $c2 - $rezc;
    $Qd = $d2 - $rezd;
    $Qe = $e2 - $reze;


    # Сравнение с нормой окавных коэффициентов звукоизоляции
    $result = queryMysql("SELECT placeOfIntellegent, audioSystem FROM rooms WHERE id='$roomid'");
    $inf = $result->fetch_assoc(); 
    

    if ($inf['placeOfIntellegent'] == 1 && $inf['audioSystem'] == 0) 
    {
        if($Qa >= 46) $sootveta = 1;
        else $sootveta = 0;
    }
    if ($inf['placeOfIntellegent'] == 1 && $inf['audioSystem'] == 1) 
    {
        if($Qa >= 60) $sootveta = 1;
        else $sootveta = 0;
    }
    if ($inf['placeOfIntellegent'] == 2 && $inf['audioSystem'] == 0) 
    {
        if($Qa >= 36) $sootveta = 1;
        else $sootveta = 0;
    }
    if ($inf['placeOfIntellegent'] == 2 && $inf['audioSystem'] == 1) 
    {
        if($Qa >= 50) $sootveta = 1;
        else $sootveta = 0;
    }
    if ($inf['placeOfIntellegent'] == 3 && $inf['audioSystem'] == 0) 
    {
        if($Qa >= 26) $sootveta = 1;
        else $sootveta = 0;
    }
    if ($inf['placeOfIntellegent'] == 3 && $inf['audioSystem'] == 1) 
    {
        if($Qa >= 40) $sootveta = 1;
        else $sootveta = 0;
    }

    if ($inf['placeOfIntellegent'] == 1 && $inf['audioSystem'] == 0) 
    {
        if($Qb >= 46) $sootvetb = 1;
        else $sootvetb = 0;
    }
    if ($inf['placeOfIntellegent'] == 1 && $inf['audioSystem'] == 1) 
    {
        if($Qb >= 60) $sootvetb = 1;
        else $sootvetb = 0;
    }
    if ($inf['placeOfIntellegent'] == 2 && $inf['audioSystem'] == 0) 
    {
        if($Qb >= 36) $sootvetb = 1;
        else $sootvetb = 0;
    }
    if ($inf['placeOfIntellegent'] == 2 && $inf['audioSystem'] == 1) 
    {
        if($Qb >= 50) $sootvetb = 1;
        else $sootvetb = 0;
    }
    if ($inf['placeOfIntellegent'] == 3 && $inf['audioSystem'] == 0) 
    {
        if($Qb >= 26) $sootvetb = 1;
        else $sootvetb = 0;
    }
    if ($inf['placeOfIntellegent'] == 3 && $inf['audioSystem'] == 1) 
    {
        if($Qb >= 40) $sootvetb = 1;
        else $sootvetb = 0;
    }

    if ($inf['placeOfIntellegent'] == 1 && $inf['audioSystem'] == 0) 
    {
        if($Qc >= 46) $sootvetc = 1;
        else $sootvetc = 0;
    }
    if ($inf['placeOfIntellegent'] == 1 && $inf['audioSystem'] == 1) 
    {
        if($Qc >= 60) $sootvetc = 1;
        else $sootvetc = 0;
    }
    if ($inf['placeOfIntellegent'] == 2 && $inf['audioSystem'] == 0) 
    {
        if($Qc >= 36) $sootvetc = 1;
        else $sootvetc = 0;
    }
    if ($inf['placeOfIntellegent'] == 2 && $inf['audioSystem'] == 1) 
    {
        if($Qc >= 50) $sootvetc = 1;
        else $sootvetc = 0;
    }
    if ($inf['placeOfIntellegent'] == 3 && $inf['audioSystem'] == 0) 
    {
        if($Qc >= 26) $sootvetc = 1;
        else $sootvetc = 0;
    }
    if ($inf['placeOfIntellegent'] == 3 && $inf['audioSystem'] == 1) 
    {
        if($Qc >= 40) $sootvetc = 1;
        else $sootvetc = 0;
    }

    if ($inf['placeOfIntellegent'] == 1 && $inf['audioSystem'] == 0) 
    {
        if($Qd >= 46) $sootvetd = 1;
        else $sootvetd = 0;
    }
    if ($inf['placeOfIntellegent'] == 1 && $inf['audioSystem'] == 1) 
    {
        if($Qd >= 60) $sootvetd = 1;
        else $sootvetd = 0;
    }
    if ($inf['placeOfIntellegent'] == 2 && $inf['audioSystem'] == 0) 
    {
        if($Qd >= 36) $sootvetd = 1;
        else $sootvetd = 0;
    }
    if ($inf['placeOfIntellegent'] == 2 && $inf['audioSystem'] == 1) 
    {
        if($Qd >= 50) $sootvetd = 1;
        else $sootvetd = 0;
    }
    if ($inf['placeOfIntellegent'] == 3 && $inf['audioSystem'] == 0) 
    {
        if($Qd >= 26) $sootvetd = 1;
        else $sootvetd = 0;
    }
    if ($inf['placeOfIntellegent'] == 3 && $inf['audioSystem'] == 1) 
    {
        if($Qd >= 40) $sootvetd = 1;
        else $sootvetd = 0;
    }

    if ($inf['placeOfIntellegent'] == 1 && $inf['audioSystem'] == 0) 
    {
        if($Qe >= 46) $sootvete = 1;
        else $sootvete = 0;
    }
    if ($inf['placeOfIntellegent'] == 1 && $inf['audioSystem'] == 1) 
    {
        if($Qe >= 60) $sootvete = 1;
        else $sootvete = 0;
    }
    if ($inf['placeOfIntellegent'] == 2 && $inf['audioSystem'] == 0) 
    {
        if($Qe >= 36) $sootvete = 1;
        else $sootvete = 0;
    }
    if ($inf['placeOfIntellegent'] == 2 && $inf['audioSystem'] == 1) 
    {
        if($Qe >= 50) $sootvete = 1;
        else $sootvete = 0;
    }
    if ($inf['placeOfIntellegent'] == 3 && $inf['audioSystem'] == 0) 
    {
        if($Qe >= 26) $sootvete = 1;
        else $sootvete = 0;
    }
    if ($inf['placeOfIntellegent'] == 3 && $inf['audioSystem'] == 1) 
    {
        if($Qe >= 40) $sootvete = 1;
        else $sootvete = 0;
    }
    
    # Рассчет словестной разборчивости

    $deltAi = [ 18, 14, 9, 6, 5 ];
    $ki = [ 0.03 , 0.12, 0.2, 0.3, 0.26 ];
    $Lsi = [ $Lc-4, $Lc-4, $Lc-9, $Lc-14, $Lc-17 ];

    $Ireli = [ 
        $Lsi[0] - $Qa - $a1 - $deltAi[0],
        $Lsi[1] - $Qb - $b1 - $deltAi[1],
        $Lsi[2] - $Qc - $c1 - $deltAi[2],
        $Lsi[3] - $Qd - $d1 - $deltAi[3],
        $Lsi[4] - $Qe - $e1 - $deltAi[4] 
    ];
    
    $pi = [];

    for( $i=0 ; $i < 5 ; $i++ ){
        if ( $Ireli[$i] <= 0 ){
            $pi[] = ( 0.78 + 5.46 * exp(-4.3 * 0.001 * ( 27.3 - abs($Ireli[$i]) ) ** 2) ) / ( 1 +  pow(10, 0.1 * abs($Ireli[$i]) ) );
        }
        else{
            $pi[] = 1 - ( ( 0.78 + 5.46 * exp(-4.3 * 0.001 * ( 27.3 - abs($Ireli[$i]) ) ** 2) ) / ( 1 +  pow(10, 0.1 * abs($Ireli[$i])) ) );
        }
    }

    $Ri = [];

    for( $i=0 ; $i < 5 ; $i++ ){
        $Ri[] = $pi[$i] * $ki[$i];
    }

    $R = array_sum($Ri);

    if ( $R < 0.15 ){
        $W = 1.54 * pow($R, 0.25) * ( 1 - exp(-11 * $R) );
    }
    else{
        $W = 1 - exp(-11 * $R / ( 1 + 0.7 * $R ));
    }
    $R = round($R, 4);
    $W = round($W, 4);
    for( $i=0 ; $i < 5 ; $i++ ){
        $Ri[$i] = round($Ri[$i], 4);
    }

    queryMysql("INSERT INTO `controlpoints` VALUES(NULL, '$place', '$roomid', '$R', '$W', NULL, NULL, NULL)");
    $cpid = mysqli_insert_id($connection);
    
    queryMysql("INSERT INTO `onecontrolpoint` VALUES(NULL, '$cpid', NULL, '$a1', '$a2', '$a3', '$reza', '$Qa', '$sootveta', '$Ri[0]')");
    queryMysql("INSERT INTO `onecontrolpoint` VALUES(NULL, '$cpid', NULL, '$b1', '$b2', '$b3', '$rezb', '$Qb', '$sootvetb', '$Ri[1]')");
    queryMysql("INSERT INTO `onecontrolpoint` VALUES(NULL, '$cpid', NULL, '$c1', '$c2', '$c3', '$rezc', '$Qc', '$sootvetc', '$Ri[2]')");
    queryMysql("INSERT INTO `onecontrolpoint` VALUES(NULL, '$cpid', NULL, '$d1', '$d2', '$d3', '$rezd', '$Qd', '$sootvetd', '$Ri[3]')");
    queryMysql("INSERT INTO `onecontrolpoint` VALUES(NULL, '$cpid', NULL, '$e1', '$e2', '$e3', '$reze', '$Qe', '$sootvete', '$Ri[4]')");

}