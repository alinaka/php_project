(function() {
    'use strict';

    var reg_form = document.getElementById('reg_form');
    if(reg_form) {
        reg_form.addEventListener('submit', submitForm);
    }
    var auth_form = document.getElementById('auth_form');
    if(auth_form) {
        auth_form.addEventListener('submit', submitAuthForm);
    }

    function submitAuthForm(event){
        event.preventDefault();
        send_data();
    }

    function submitForm(event){
        event.preventDefault();
        alert('rff');

        if(checkForm()){
            send_data();
        }
    }
    
    function checkForm() {
        var reg_login = document.getElementById('login');
        var reg_password = document.getElementById('password');
        var password_check = document.getElementById('password_check');
        
        var regexp_login =  /[a-zA-Z]{1}\w{3,19}/; 
        var regexp_pwd = /(?=.{9,})(?=(.*\d){2,})(?=.*[a-z])(?=.*[A-Z])(?=.*\W)/g;
        
        if (!reg_login.value.match(regexp_login)) {
            alert('Логин должен иметь длину от 4 до 20 символов, и не должен начинаться с цифры');
            return 0;
        }
        if (!reg_password.value.match(regexp_pwd)) {
            alert(`Пароль должен удовлетворять следующим требованиям:
	                       - длина от 9 символов;
	                       - содержит обязательно только латинские буквы верхнего и нижнего регистра;
	                       - содержит более двух цифр;
	                       - содержит обязательно один из неалфавитных символов (например, !, $, #, %).'`);
            return 0;
        }
        if (password_check.value !== reg_password.value) {
            alert('Введенные пароли не соответствуют друг другу');
            return 0;
        }
        console.log('подходит');
        return 1;
    } 
    
    function send_data(){
        var formElement = document.forms[0];
        var formData = new FormData(formElement);

        var xhr = new XMLHttpRequest();        
        xhr.open('POST', '/account/post', true); //true - запрос синхронный        
        xhr.send(formData);
        
        xhr.onreadystatechange = function() {
            // (0 → 1 → 2 → 3 → … → 3 → 4)
            if (xhr.readyState != 4) return;
            if (xhr.status != 200) {

                console.log( xhr.status + ': ' + xhr.statusText );
                // обработать ошибку
            } else {
                window.location.href="/user"
            }
        }
    }    
}());