<main class="main container pt-3">
    <a href="javascript:history.back()" class='text-dark'>
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
        </svg>
    </a>
    <div class="card my-4 shadow-sm mb-5">
    <div class="card-header">
    <h1 class="text-center">Личный кабинет</h1>
    </div>
    <?php
        $result = queryMysql("SELECT * FROM members WHERE login='$user'");
        $b = $result->fetch_assoc();
    ?>
    
        <div class="card-body p-5">
            <h5>Ваш логин: <?php echo $b["login"];?></h5>
            <h5>Фамилия И.О.: <?php echo $b["name"];?></h5>
            <h5>Должность: <?php echo $b["doljnost"];?></h5>
            <div class='d-flex justify-content-end mb-5'>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#login">Изменить данные</button>
            </div>
            <h5 class="mb-4">Чтобы изменить пароль:</h5>
            <form method="post" action="Controllers/chenge_pass.php">
                <div class="badge bg-danger mb-3" id="error2"></div>
                <div class="row mb-3">
                    <label for="login" class="col-sm-3 col-form-label">Введите старый пароль: </label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="oldpass" name="oldpass" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="login" class="col-sm-3 col-form-label">Введите новый пароль: </label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="newpass" name="newpass" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="login" class="col-sm-3 col-form-label">Повторите новый пароль: </label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="newpass2" name="newpass2" required>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-5">
                    <button type="button" class="btn btn-warning" onclick="chengepass()">Изменить пароль</button>
                </div>
            </form>
            <h2>Пользователи:</h2>
            <table class="table text-center table-white table-hover mt-3">
                <thead class="align-middle">
                    <tr class="align-middle">
                        <td>id</td>
                        <td>Должность</td>
                        <td>Ф.И.О.</td>
                        <td>Логин</td>
                        <td>Дата регистрации</td>
                        <td>Подтверждение регистрации</td>
                    </tr>
                </thead>
                <?php
                    if ($user == "root"){
                        $res = queryMysql("SELECT * FROM members");
                        while($d = $res->fetch_assoc())
                        {
                            echo <<<_CARD
                                <tbody>
                                    <tr class="align-middle">
                                        <td>$d[id]</td>
                                        <td>$d[doljnost]</td>
                                        <td>$d[name]</td>
                                        <td>$d[login]</td>
                                        <td>$d[dateReg]</td>
                            _CARD;
                                    if ($d['verify'] == 1) $check = "checked"; else $check = "";
                                    echo "<td><input class='form-check-input' type='checkbox' $check></td></tr></tbody>";
                        }
                        echo<<<_CARD1
                            </table>
                            <div class="d-flex justify-content-end mt-5">
                                <button type="button" class="btn btn-warning" onclick="">Подтвердить</button>
                            </div>
                        _CARD1;
                    }
                ?>
            
        </div>
    </div>
</main>

<div class="modal fade" tabindex="-1" id="login" aria-hidden="true" aria-labelledby="login">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Настройки профиля</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="badge bg-danger mb-3" id="error1"></div>
                <form method="post" action="Controllers/update_profile.php">
                    <div class="row mb-3">
                        <label for="name" class="col-sm-4 col-form-label">Фамилия И.О.</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-4 col-form-label">Должность</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="doljnost" name="doljnost" required>
                        </div>
                    </div>
                    <div class="d-grid gap-2 mt-5">
                        <button type="button" class="btn btn-warning" onclick="sendpostupdateprofile()">Изменить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>