<?php
logout();
function logout(){
    session_start();
    unset($_SESSION['login']);
    setcookie('login', '', time() - 1);
    setcookie('pwd', '', time() - 1);
}
?>
