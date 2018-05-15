<?php 
session_start();
if (isset($_COOKIE['login'])) : 
$_SESSION['login'] = $_COOKIE['login']?>
<?php else : ?>
<form method="post" action="reg_auth_logout.php" id="auth_form">
    <label>Логин<input type="text" name="login"></label>
    <br>
    <label>Пароль<input type="password" name="password"></label>
    <br>
    <label>Запомнить меня<input type="checkbox" name="remember"></label>
    <input type="submit" value="Войти">
</form>
<script src="../js/auth.js"></script>
<?php endif; ?>