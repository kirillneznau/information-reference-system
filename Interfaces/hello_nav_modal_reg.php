<div class="wrapper">
    <header class="header bg-dark text-white d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <svg class="position-absolute bi me-2" width="40" height="28"><use xlink:href="#bootstrap"></use></svg>
            </a>
            <div class="emblema-cont d-flex align-items-center justify-content-center">
                <a href="/" class="nav-link text-center"><img class="emblema" src="img/logo.png"></a>
            </div>
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="contacts.php" class="nav-link px-2 text-white a">Контакты</a></li>
                <li><a href="about.php" class="nav-link px-2 text-white a">О проекте</a></li>
            </ul>

            <div class="text-end py-3">
                <button type="button" class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#login">Войти</button>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#signup">Зарегистрироваться</button>
            </div>
            </div>
        </div>
    </header>

<div class="modal fade" tabindex="-1" id="login" aria-hidden="true" aria-labelledby="login">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Форма авторизации</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="badge bg-danger mb-3" id="error1"></div>
            <form method="post" action="Controllers/login.php">
                <div class="row mb-3">
                    <label for="login" class="col-sm-2 col-form-label">Логин</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="login1" name="login" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="pass" class="col-sm-2 col-form-label">Пароль</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="pass1" name="pass" required>
                    </div>
                </div>
                <div class="d-grid gap-2 mt-5">
                    <button type="button" class="btn btn-warning" onclick="sendpostauth()">Войти</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="signup" aria-hidden="true" aria-labelledby="signup">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Форма регистрации</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="badge bg-danger mb-3" id="error2"></div>
            <form method="post" action="Controllers/signup.php">
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
                <div class="row mb-3">
                    <label for="login" class="col-sm-4 col-form-label">Логин</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="login2" name="login" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="pass" class="col-sm-4 col-form-label">Пароль</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="pass" name="pass" required>
                    </div>
                </div>
                <div class="d-grid gap-2 mt-5">
                    <button type="button" class="btn btn-warning" onclick="sendpostreg()">Зарегистрироваться</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>