(function () {
    'use strict';
    var reg_form = document.getElementById('reg_form');
    reg_form.addEventListener('submit', submitForm);
    
    function submitForm(event) {
        event.preventDefault();        
        if(checkForm()) {
            reg_form.submit();
        }
    }
       
    function checkForm() {
        var reg_login = document.getElementById('login');
        var reg_password = document.getElementById('password');
        var password_check = document.getElementById('password_check');
        
        var regexp_login =  /[a-zA-Z]{1}\w{3,19}/; 
        var regexp_pwd = /(?=.{9,})(?=(.*\d){2,})(?=.*[a-z])(?=.*[A-Z])(?=.*\W)/g;
        
        if (reg_password.value.match(regexp_pwd)) {
            alert('Логин должен иметь длину от 4 до 20 символов, и не должен начинаться с цифры');
            return 0;
        }
        if (reg_login.value.match(regexp_login)) {
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
}());