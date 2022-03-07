
<?php
    require_once 'functions.php';
    if (isset($_GET["order"])) { if ($_GET["order"] == "DESC") $order = "DESC"; else $order="DESC"; if ($_GET["order"] == "ASC") $order = "ASC"; else $order="DESC"; } else $order="DESC";
    if (isset($_GET["page"])) $page = $_GET["page"]; else $page= 1;
    if (isset($_POST["search"])) $search = sanitizeString($_POST["search"]);
    $url = $_SERVER['REQUEST_URI'];
    $card_on_page = 8;
    $start = ( $page - 1 ) * $card_on_page;
    $end = $start + $card_on_page;
?>
<main class="main container mt-2">
    <h1 class="my-5">Перечень объектов оценки:</h1>
    <div class="row align-items-center">
        <div class="col">
            <a class="btn btn-warning" href="room.php?order=ASC">
                По дате 
                <svg width="25" height="25" fill="currentColor" class="bi bi-sort-down-alt" viewBox="0 0 16 16">
                    <path d="M3.5 3.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 12.293V3.5zm4 .5a.5.5 0 0 1 0-1h1a.5.5 0 0 1 0 1h-1zm0 3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 0 1h-3zm0 3a.5.5 0 0 1 0-1h5a.5.5 0 0 1 0 1h-5zM7 12.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5z"/>
                </svg>
            </a>
            <a class="btn btn-warning mx-1" href="room.php?order=DESC">
                По дате 
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-sort-down" viewBox="0 0 16 16">
                    <path d="M3.5 2.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 11.293V2.5zm3.5 1a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/>
                </svg>
            </a>
        </div>
    </div>
    <form method="post" action="<?php echo $url;?>">
    <div class="row mb-5 mt-2">
        <div class="container-fluid d-flex">
            <button type="button" class="form-control btn btn-warning btn-block me-2" data-bs-toggle="modal" data-bs-target="#add">Добавить новый объект оценки</button>
            <input class="form-control me-2" name="search" id="search" type="text" value="<?php echo $search; ?>" placeholder="Поиск объекта">
            <button type="submit" class="btn btn-outline-dark">Искать</button>
        </div>
    </div>
    </form>
<?php
    $res = queryMysql("SELECT rooms.*, addroom.date FROM `rooms` INNER JOIN `addroom` ON (rooms.id=addroom.roomid) WHERE name LIKE '%$search%' ORDER BY id $order");
    $rows = $res->fetch_all(MYSQLI_ASSOC);
    $array_card_on_page = array_slice($rows, $start, $end); 
    foreach ($array_card_on_page as $d) {
    $date = date("d.m.Y H:i",strtotime($d['date']));
    $room = $d['id'];
echo <<<_CARD
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <p class="text-muted m-0">$date</p>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#delete$room" class="btn-close"></button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <img class="room-img" src="img/$d[plan]" alt="">
                </div>
                <div class="col-md-8">
                    <h1 class="card-title pricing-card-title">$d[name]</h1>
                    <ul class="list-unstyled mt-3 mb-4">
                    <li>Адрес: $d[address]</li>
                    <li>Войсковая часть №(организация) $d[VCh]</li>
                    <li>Категория: $d[categor]</li>
                    </ul>
                </div>
                <div class='d-flex justify-content-end'>
                    <a href='detail_room.php?id=$d[id]' class="btn btn-warning">Подробнее</a>
                </div>
            </div> 
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="delete$room" aria-hidden="true" aria-labelledby="delete$room">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Удалить?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="modal-title">Вы действительно хотите удалить помещение?<br> Все данные о нем будут удалены.</з>
                    <div class="row my-3">
                        <div class="col-sm-6">
                            <a href='Controllers/delete_room.php?id=$d[id]' class="d-grid gap-2 btn btn-warning">Да</a>
                        </div>
                        <div class="d-grid gap-2 col-sm-6">
                            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-dark">Нет</button> 
                        </div>
                    </div>        
                </div>
            </div>
        </div>
    </div>
_CARD;
}
$num_cards = $res->num_rows;
$num_li = ceil( $num_cards / $card_on_page );
?>
    <ul class="pagination justify-content-center">
        <?php 
            for( $i = 1 ; $i <= $num_li ; $i++ ) {
                if ( $i == $page )
                    echo "<li class='page-item active'><a class='page-link' href='$url&page=$i'>$i</a></li>"; 
                else 
                    echo "<li class='page-item'><a class='page-link' href='$url&page=$i'>$i</a></li>"; 
            }
        ?>
    </ul>
    <div class="row">
        <button type="button" class="btn btn-warning btn-block mb-5" data-bs-toggle="modal" data-bs-target="#add">Добавить новый объект оценки</button>    
    </div>
</main>

<div class="modal fade" tabindex="-1" id="add" aria-hidden="true" aria-labelledby="add">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Новый объект оценки</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-2">
            <div class="badge bg-danger mb-3" id="error1"></div>
            <form method="post" enctype="multipart/form-data" action="Controllers/add_room.php">
                <div class="row mb-3">
                    <label for="roomname" class="col-sm-4 col-form-label">Наименование объекта</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="roomname" name="roomname" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="address" class="col-sm-4 col-form-label">Адрес</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <label for="vch" class="col-sm-4 col-form-label">Войсковая часть № (организация)</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="vch" name="vch" required>
                    </div>
                </div>
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-4">
                        <label for="categor" class="col-form-label">Категория</label>
                    </div>
                    <div class="col-sm-8">    
                        <select class="form-select" id="categor" name="categor" aria-label="Default select example">
                            <option value="1">1 категория </option>
                            <option value="2">2 категория</option>
                            <option value="3">3 категория</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-4">
                        <label for="placeOfIntellegent" class="col-form-label">Место возможного перехвата речевой информации из помещения</label>
                    </div>
                    <div class="col-sm-8">    
                        <select class="form-select" id="placeOfIntellegent" name="placeOfIntellegent" aria-label="Default select example">
                            <option value="1">Смежное помещение</option>
                            <option value="2">Улица без транспорта</option>
                            <option value="3">Улица с транспортом</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8">
                        <input class="form-check-input" type="checkbox" value="1" name="audioSystem" id="audioSystem">
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
                        <textarea class="form-control" id="aboutRoom" name="aboutRoom"></textarea>
                    </div>
                </div>
                
                <div class="d-grid gap-2 mt-5">
                    <button type="submit" class="btn btn-warning">Добавить</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>