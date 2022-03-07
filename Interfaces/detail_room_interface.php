<?php
    require_once 'functions.php';
    $roomid = $_GET['id'];
    $res = queryMysql("SELECT rooms.*, addroom.date FROM `rooms` INNER JOIN `addroom` ON(rooms.id=addroom.roomid) WHERE rooms.id='$roomid'");
    $d = $res->fetch_assoc();
?>

<main class="main container">
    <a href="javascript:history.back()" class='text-dark'>
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
        </svg>
    </a>



    <div class="card my-4 shadow-sm mb-5">
        <div class="card-header">
            <h1 class="text-center"><?php echo $d['name']; ?></h1>
        </div>
        <div class="card-body p-5">
            <div class="row justify-content-center">
                <img class="big-room-img" src="img/<?php echo $d['plan']; ?>"  alt="...">
            </div>
            <div class="row mt-5">
                <h3>Сведения об объекте:</h3>
                <div class="mx-3">
                    <h5>Адрес (место дислокации объекта): <?php echo $d['address']; ?></h5>
                    <h5>Войсковая часть № (организация): <?php echo $d['VCh']; ?></h5>
                    <h5>Категория выделенного помещения: <?php echo $d['categor']; ?> категория</h5>
                    <h5>Оборудованно системами звукоусиления: <?php if ($d['audioSystem'] == 0) echo "нет"; else echo "да"; ?></h5>
                    <h5>Место возможного перехвата речевой информации из помещения: <?php if ($d['placeOfIntellegent'] == 1) echo "смежное помещение"; elseif ($d['placeOfIntellegent'] == 2) echo "улица без транспорта"; else echo "улица с транспортом"; ?></h5>
                    <h5>Описание (дополнительная информация об объекте): <?php echo $d['aboutRoom']; ?></h5>
                </div>
                <div class='d-flex justify-content-end my-3'>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateroominf">Изменить сведения</button>
                </div>
            </div>
            <div class="row mt-5 align-items-center">
                <div class="col-sm-9">
                    <h5>Количество выбранных контрольных точек (контрольные точки выбираются в местах, наиболее опасных с точки зрения перехвата информации)</h5>
                </div>
                <div class="col-sm-3 text-center">
                    <h1><?php 
                    $rescp = queryMysql("SELECT * FROM `controlpoints` WHERE roomId='$roomid'");
                    $num_cp = $rescp->num_rows;
                    echo $num_cp;?></h1>
                </div>
            </div>
            <div class="row mt-5 align-items-center">
                <?php
                    $i=1;
                    if ($num_cp > 0){
                        echo <<<_END
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Соответствие норме<br>коэффициента звукоизоляции</th>
                                    <th scope="col">Соответствие норме<br>коэффициента разборчивости речи</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                        <tbody>
                        _END;
                    }
                    while ($cp = $rescp->fetch_assoc()){
                        if ($cp['sootvetW'] == 0) { $sootvetW = "Не соответствует"; $colorW="danger\" data-bs-toggle=\"modal\" data-bs-target=\"#nonorm\""; }
                        else { $sootvetW = "Соответствует"; $colorW="success"; }
                        if ($cp['sootvetQ'] == 0) { $sootvetQ = "Не соответствует"; $colorQ="danger\" data-bs-toggle=\"modal\" data-bs-target=\"#nonorm\""; }
                        else { $sootvetQ = "Соответствует"; $colorQ="success"; }
                        echo <<<_END
                                <tr>
                                    <th>Контрольная точка №$i<br>[ $cp[place] ]</th>
                                    <th><button class="badge mt-3 fs-6 bg-$colorQ">$sootvetQ</button></th>
                                    <th><button class="badge mt-3 fs-6 bg-$colorW">$sootvetW</button></th>
                                    <th>
                                        <div class="d-flex mt-3 justify-content-end">
                                            <a href="Controllers/delete_controlpoint.php?cpid=$cp[id]&roomid=$roomid" class="btn-close"></a>
                                        </div>
                                    </th>
                                </tr>
                        _END;
                        $i++;
                        $normW = $cp['normW'];
                    }
                    echo "</tbody></table>";

                ?>
             
            <form method="post" enctype="multipart/form-data" action="Controllers/sootvet_norm.php"> 
                <div class="row mt-3 align-items-center">
                        <label for="norm" class="col-sm-3 col-form-label text-center">Нормированное значение показателя противодействия акустической разведке: </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="norm" name="norm" value="<?php echo $normW; ?>" required>
                        </div>
                </div>
                    <div class="badge bg-danger" id="errornorm"></div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-warning" onclick="sendnorm()">Обновить</button>
                    </div>  
                </div>
            </form> 
            <form method="post" enctype="multipart/form-data" action="Controllers/calculation.php">
                <div class="row mt-5 text-center align-items-center">
                    <h2>Оценка защищенности объекта информатизации</h2>
                    <table class="table table-dark table-hover mt-3">
                        <thead class="align-middle">
                            <tr>
                                <td colspan="4">
                                    <div class="row mx-5 align-items-center">
                                        <div class="col-sm-6 text-start">
                                            <h5 class="m-0">Местоположение контрольной точки:</h5>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="place" name="place" required>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="align-middle">
                                <td>Номер октавной полосы, i</td>
                                <td>Измеренный уровень акустического шума в конторолируемой точке L<sub>шi</sub>, дБ</td>
                                <td>Уровень тестового сигнала L<sub>с1i</sub>, дБ</td>
                                <td>Уровень измеренного акустического сигнала и акустического шума в контролируемой точке L<sub>(с1+ш)i</sub>, дБ</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><input class="text-center" name="a1" id="a1" style="width: 60px;" type="number" step="any" required></td>
                                <td><input class="text-center" name="a2" id="a2" style="width: 60px;" type="number" step="any" required></td>
                                <td><input class="text-center" name="a3" id="a3" style="width: 60px;" type="number" step="any" required></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><input class="text-center" name="b1" id="b1" style="width: 60px;" type="number" step="any" required></td>
                                <td><input class="text-center" name="b2" id="b2" style="width: 60px;" type="number" step="any" required></td>
                                <td><input class="text-center" name="b3" id="b3" style="width: 60px;" type="number" step="any" required></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><input class="text-center" name="c1" id="c1" style="width: 60px;" type="number" step="any" required></td>
                                <td><input class="text-center" name="c2" id="c2" style="width: 60px;" type="number" step="any" required></td>
                                <td><input class="text-center" name="c3" id="c3" style="width: 60px;" type="number" step="any" required></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><input class="text-center" name="d1" id="d1" style="width: 60px;" type="number" step="any" required></td>
                                <td><input class="text-center" name="d2" id="d2" style="width: 60px;" type="number" step="any" required></td>
                                <td><input class="text-center" name="d3" id="d3" style="width: 60px;" type="number" step="any" required></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td><input class="text-center" name="e1" id="e1" style="width: 60px;" type="number" step="any" required></td>
                                <td><input class="text-center" name="e2" id="e2" style="width: 60px;" type="number" step="any" required></td>
                                <td><input class="text-center" name="e3" id="e3" style="width: 60px;" type="number" step="any" required></td>
                            </tr>  
                            <tr>
                                <td colspan="3">
                                        <div class="class="text-center">
                                            <h5 class="m-0">Уровень акустического (речевого) сигнала L<sub>c</sub>, дБ:</h5>
                                        </div>
                                </td>
                                <td colspan="1">
                                        <div class="class="text-center">
                                            <input class="text-center" id="Lc" name="Lc" style="width: 60px;" type="number" step="any" required>
                                        </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="badge bg-danger" id="error2"></div>
                <div class='d-flex justify-content-end'>
                    <button type="button" class="btn btn-warning" onclick="sendcontrolpoint()">Обработать</button>
                </div>
            </form>
            

            <div class="row mt-5 text-center">
                <h3>Путём расчета октавных коэффициентов звукоизоляции:</h3>
            </div>
            <?php
                $res1 = queryMysql("SELECT * FROM `controlpoints` WHERE roomId='$roomid'");
                $i=1;
                while ($cpid = $res1->fetch_assoc()){
                    $res = queryMysql("SELECT * FROM `onecontrolpoint` WHERE cpid = '$cpid[id]' ORDER BY id");
                    echo <<<_CARD1
                        <div class="row text-center">
                            <table class="table table-dark table-hover mt-3">
                                <thead class="align-middle">
                                    <tr><td colspan="7"><h5 class="m-0">Контрольная точка №$i</h5></td></tr>
                                    <tr class="align-middle">
                                        <td>Номер октавной полосы, i</td>
                                        <td>Измеренный уровень акустического шума в конторолируемой точке L<sub>шi</sub>, дБ</td>
                                        <td>Уровень тестового сигнала L<sub>с1i</sub>, дБ</td>
                                        <td>Уровень измеренного акустического сигнала и акустического шума в контролируемой точке L<sub>(с1+ш)i</sub>, дБ</td>
                                        <td>Расчетный уровень акустического сигнала в конторолируемой точке L<sub>c2i</sub>, дБ</td>
                                        <td>Октавные уровни звукоизоляции в контролируемой точке Q<sub>i</sub>, дБ</td>
                                        <td>Соответствие нормам</td>
                                    </tr>
                                </thead>
                            <tbody>
                    _CARD1;
                    $j=1;
                    while($d = $res->fetch_assoc()){
                        if ($d['sootvet']==0) { $sootvet = "Не соответствует"; $color="danger"; }
                        else { $sootvet = "Соответствует"; $color="success"; }
                        echo <<<_SAM
                            <tr class="align-middle">
                                <td>$j</td>
                                <td>$d[shum]</td>
                                <td>$d[lvlSignal]</td>
                                <td>$d[signalShum]</td>
                                <td>$d[rez]</td>
                                <td>$d[otvet]</td>
                                <td><div class="badge bg-$color">$sootvet</div></td>
                            </tr>
                        _SAM;
                        $j++;
                    } 
                    echo "</tbody></table></div>";
                    echo <<<R
                        <div class='mb-4 d-flex justify-content-end'>
                            <a href="Controllers/delete_controlpoint.php?cpid=$cpid[id]&roomid=$roomid" class="btn btn-warning" >Удалить</a>
                        </div>
                    R;
                    $i++;
                }
            ?>
            <div class="row mt-5 text-center">
                <h3>Путём расчета коэффициента противодействия акустической речевой разведки (словесной разборчивости речи):</h3>
            </div>
            <?php
                $res1 = queryMysql("SELECT * FROM `controlpoints` WHERE roomId='$roomid'");
                $i=1;
                while ($cpid = $res1->fetch_assoc()){
                    $res = queryMysql("SELECT * FROM `onecontrolpoint` WHERE cpid = '$cpid[id]' ORDER BY id");
                    echo <<<_CARD1
                        <div class="row text-center">
                            <table class="table table-dark mt-3">
                                <thead class="align-middle">
                                    <tr><td colspan="7"><h5 class="m-0">Контрольная точка №$i</h5></td></tr>
                                    <tr class="align-middle">
                                        <td>Номер октавной полосы, i</td>
                                        <td>Значение октавного индекса артикуляции, r<sub>i</sub></td>
                                        <td>Значение интегрального индекса артикуляции, R</td>
                                        <td>Значение показателя противодействия (словесной разборчивости), W</td>
                                    </tr>
                                </thead>
                            <tbody>
                            
                    _CARD1;
                    $j=1;
                    while($d = $res->fetch_assoc()){
                        echo <<<_SAM
                            <tr class="align-middle">
                                <td>$j</td>
                                <td>$d[spectrIndexArticul]</td>
                        _SAM;
                        if ( $j == 1 ) echo "<td rowspan='6' class='fs-2'>$cpid[integrIndexArticul]</td><td rowspan='6' class='fs-2'>$cpid[W]</td></tr>";
                        $j++;
                    }

                    echo "</tbody></table></div>";
                    echo <<<R
                        <div class='mb-4 d-flex justify-content-end'>
                            <a href="Controllers/delete_controlpoint.php?cpid=$cpid[id]&roomid=$roomid" class="btn btn-warning" >Удалить</a>
                        </div>
                    R;
                    $i++;
                }
            ?>
        </div>
    </div> 
</main>




<?php
$q = queryMysql("SELECT * FROM `rooms` WHERE id='$roomid'");
$c = $q->fetch_assoc();
?>










<div class="modal fade" tabindex="-1" id="updateroominf" aria-hidden="true" aria-labelledby="updateroominf">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Изменить сведения об объекте</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-2">
                <div class="badge bg-danger mb-3" id="error1"></div>
                <form method="post" enctype="multipart/form-data" action="Controllers/update_room_inf.php?roomid=<?php echo $roomid;?>">
                    <div class="row mb-3">
                        <label for="roomname" class="col-sm-4 col-form-label">Наименование объекта</label>
                        <div class="col-sm-8">
                            <input type="text" value="<?php echo $c['name'] ?>" class="form-control" id="roomname" name="roomname" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="address" class="col-sm-4 col-form-label">Адрес</label>
                        <div class="col-sm-8">
                            <input type="text" value="<?php echo $c['address'] ?>" class="form-control" id="address" name="address" required>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <label for="vch" class="col-sm-4 col-form-label">Войсковая часть № (организация)</label>
                        <div class="col-sm-8">
                            <input type="text" value="<?php echo $c['VCh'] ?>" class="form-control" id="vch" name="vch" required>
                        </div>
                    </div>
                    <div class="row mb-2 align-items-center">
                        <div class="col-sm-4">
                            <label for="categor" class="col-form-label">Категория</label>
                        </div>
                        <div class="col-sm-8">    
                            <select class="form-select" id="categor" name="categor" aria-label="Default select example" default="<?php echo $c['categor'] ?>">
                                <option value="1" <?php if ($c["categor"]==1) echo "selected" ?>>1 категория </option>
                                <option value="2" <?php if ($c["categor"]==2) echo "selected" ?>>2 категория</option>
                                <option value="3" <?php if ($c["categor"]==3) echo "selected" ?>>3 категория</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2 align-items-center">
                        <div class="col-sm-4">
                            <label for="placeOfIntellegent" class="col-form-label">Место возможного перехвата речевой информации из помещения</label>
                        </div>
                        <div class="col-sm-8">    
                            <select class="form-select" id="placeOfIntellegent" name="placeOfIntellegent" aria-label="Default select example">
                                <option value="1" <?php if ($c["placeOfIntellegent"]==1) echo "selected" ?>>Смежное помещение</option>
                                <option value="2" <?php if ($c["placeOfIntellegent"]==2) echo "selected" ?>>Улица без транспорта</option>
                                <option value="3" <?php if ($c["placeOfIntellegent"]==3) echo "selected" ?>>Улица с транспортом</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <input class="form-check-input"<?php if ($c["audioSystem"]==1) echo "checked"?> type="checkbox" value="1" name="audioSystem" id="audioSystem">
                            <label class="form-check-label" for="audioSystem">Оборудовано системами звукоусиления</label>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <label for="address" class="col-sm-4 col-form-label">План/Схема/Фото</label>
                        <div class="col-sm-8">
                            <input type="file" name='plane' id='plane'>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-start">
                        <label for="aboutRoom" class="col-sm-4 col-form-label">Описание (доп. информация)</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="aboutRoom" name="aboutRoom"><?php echo $c['aboutRoom'] ?></textarea>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mt-5">
                        <button type="submit" class="btn btn-warning">Изменить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="nonorm" aria-hidden="true" aria-labelledby="nonorm">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Значение контролируемого параметра превысило нормированное значение</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-2">
                <p>Для обеспечения безопасности обсуждаемой информации необходимо установить активные срадства защиты информации от утечки по акустическому каналу</p>
            <?php

                $res = queryMysql("SELECT * FROM `szi` ORDER BY RAND() LIMIT 3");

                while($d = $res->fetch_assoc())
                {
                $szi = $d['id'];
                echo <<<_CARD
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img class="szi-img" src="img/$d[img]" alt="">
                            </div>
                            <div class="col-md-8">
                                <h5 class="card-title pricing-card-title">$d[name]</h5>
                            </div>
                        </div> 
                    </div>
                </div>
                _CARD;
                }
            ?>
                <div class="d-grid gap-2 mt-5">
                    <a href="szi.php" class="btn btn-warning">Другие СЗИ</a>
                </div>
            </div>
        </div>
    </div>
</div>