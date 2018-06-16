(function() {
    'use strict';

    var reg_form = document.getElementById('reg_form');
    var result_message = document.getElementById('result_message');
    
    if (reg_form) {
        reg_form.addEventListener('submit', submitForm);
    }
 
    function submitForm(event){
        event.preventDefault();
        if(checkForm()){
         send_reg_data();
        }
    }
    
    function checkForm() {
        var reg_login = document.getElementById('login');
        var reg_password = document.getElementById('password');
        var password_check = document.getElementById('password_check');
        
        var regexp_login =  /[a-zA-Z]{1}\w{3,19}/; 
        var regexp_pwd = /(?=.{7,})(?=(.*\d){1,})(?=.*[a-z])(?=.*[A-Z])/g;
        
        if (!reg_login.value.match(regexp_login)) {
            show_message('login');
            return 0;
        }
        if (!reg_password.value.match(regexp_pwd)) {
            show_message('pwd');
            return 0;
        }
        if (password_check.value !== reg_password.value) {
            show_message('second pwd');
            return 0;
        }
        return 1;
    }

    function show_message(result){
        switch(result) {
            case 'pwd': 
                result_message.innerText = `Пароль должен удовлетворять следующим требованиям:
	                       - длина от 7 символов;
	                       - содержит обязательно только латинские буквы верхнего и нижнего регистра;
	                       - содержит хотя бы одну цифру`;
                break;
            case 'second pwd': 
                result_message.innerText = `Введенные пароли не соответствуют друг другу`;
                break;
            case 'login': 
                result_message.innerText = "Логин должен иметь длину от 4 до 20 символов, и не должен начинаться с цифры";
                break;
            case 1: 
                $('#registration_modal').modal('hide');
                var result_modal_title = document.getElementById('result_modal_title');
                result_modal_title.innerText = "Поздравляем!";
                result_message.innerText = "Вы успешно зарегистрированы";
                break;
            case 0: 
                result_message.innerText = "Пользователь с таким логином уже существует";
                break;
            default: 
                result_message.innerText = "Заполните все поля формы";
        }
        $('#result_modal').modal();
    }
    
    function send_reg_data(){
        var formElement = reg_form;
        var formData = new FormData(formElement);

        var xhr = new XMLHttpRequest();        
        xhr.open('POST', '/account/registration');      
        xhr.send(formData);
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState != 4) return;
            if (xhr.status != 200) {
                console.log( xhr.status + ': ' + xhr.statusText );
                // обработать ошибку
            }
            
            if (xhr.responseText == 1) {
                show_message(1);
            } else {
                show_message(0);
            }
        }
    }  

}());