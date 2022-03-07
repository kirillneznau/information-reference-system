
<?php
    require_once 'functions.php';
?>
<main class="main container mt-2">
    <h1 class="my-5">Перечень средств защиты информации от утечки по акустическому каналу:</h1>
    <div class="row mb-5 mt-2">
        <div class="container-fluid d-flex">
            <button type="button" class="form-control btn btn-warning btn-block me-2" data-bs-toggle="modal" data-bs-target="#add">Добавить средство защиты информации</button>
        </div>
    </div>
<?php

    $res = queryMysql("SELECT * FROM `szi` ORDER BY id DESC");

    while($d = $res->fetch_assoc())
{
    $szi = $d['id'];
echo <<<_CARD
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
                <div class="d-flex justify-content-end">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#delete$szi" class="btn-close"></button>
                </div>

            <div class="row">
                <div class="col-md-4">
                    <img class="room-img" src="img/$d[img]" alt="">
                </div>
                <div class="col-md-8">
                    <h1 class="card-title pricing-card-title">$d[name]</h1>
                    <p class="mt-3">$d[text]</p>
                </div>
            </div> 
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="delete$szi" aria-hidden="true" aria-labelledby="delete$szi">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Удалить?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="modal-title">Вы действительно хотите удалить средсто защиты информации?<br> Все данные о нем будут удалены.</з>
                    <div class="row my-3">
                        <div class="col-sm-6">
                            <a href='Controllers/delete_szi.php?id=$d[id]' class="d-grid gap-2 btn btn-warning">Да</a>
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
?>

    <div class="row">
    <button type="button" class="btn btn-warning btn-block mb-5" data-bs-toggle="modal" data-bs-target="#add">Добавить средсво защиты информации</button>    
    </div>
</main>

<div class="modal fade" tabindex="-1" id="add" aria-hidden="true" aria-labelledby="add">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Новое средство защиты информации</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-2">
            <div class="badge bg-danger mb-3" id="error1"></div>
            <form method="post" enctype="multipart/form-data" action="Controllers/add_szi.php">
                <div class="row mb-3">
                    <label for="sziname" class="col-sm-4 col-form-label">Наименование СЗИ</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="sziname" name="sziname" required>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <label for="sziimg" class="col-sm-4 col-form-label">Изображение/фото</label>
                    <div class="col-sm-8">
                      <input type="file" name='sziimg' id='sziimg'>
                    </div>
                </div>
                <div class="row mb-3 align-items-start">
                    <label for="aboutszi" class="col-sm-4 col-form-label">Описание (сведения, доп. информация)</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" id="aboutszi" name="aboutszi" rows="10"></textarea>
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