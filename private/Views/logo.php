<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="/">
                	<i class="fas fa-clock"></i>
                	<h2>TimeTrack</h2>
                </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    	<ul class="navbar-nav mr-auto"> 
                <li class="nav-item">
                    <a class="nav-link" id="reg_btn" data-toggle="modal" data-target="#registration_modal" href="#">
                    Создать аккаунт</a>
                </li>
        </ul>
        <form id="auth_form" class="form-inline my-2 my-lg-0">
            <input class="form-control form-group mr-sm-2" type="text" name="login" placeholder="Логин" aria-label="login">
            <input class="form-control form-group mr-sm-2" type="password" name="password" placeholder="Пароль" aria-label="password">
             <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" id="check" name="remember">
                <label class="form-check-label mr-sm-2" for="check">Запомнить меня</label>
            </div>
            <input form="auth_form" class="btn btn-secondary my-2 my-sm-0" type="submit" value="Войти">
        </form>
    </div>
</nav>
<?php include_once "registration_modal.php";?>
<?php include_once "result_modal.php";?>
<script src="/js/auth.js"></script>
