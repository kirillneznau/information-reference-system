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
                <ul class="nav col-12 col-lg-auto me-lg-auto justify-content-center mb-md-0">
                    <li><a href="/" class="nav-link px-2 text-white a">Главная</a></li>
                    <li><a href="contacts.php" class="nav-link px-2 text-white a">Контакты</a></li>
                    <li><a href="lows.php" class="nav-link px-2 text-white a">Теория</a></li>
                    <li><a href="about.php" class="nav-link px-2 text-white a">О проекте</a></li>
                </ul>
                <div class="text-end py-3">
                    <a href="profile.php" class='me-3 btn btn-outline-warning text-white'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="42" height="22" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                        </svg>
                    </a>
                    <a class="btn btn-outline-light me-2" onclick='getConfirmation()'>Выйти</a>
                </div>
            </div>
        </div>
    </header>

<script>
    function getConfirmation(){
    var a = confirm("Вы действительно хотите выйти?");
    if( a == true ){
        document.location.href = "Controllers/logout.php"
    }
    }
</script>