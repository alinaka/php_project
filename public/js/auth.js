(function() {
    'use strict';

    var auth_form = document.getElementById('auth_form');
    if (auth_form) {
        auth_form.addEventListener('submit', submitAuthForm);
    }

    function submitAuthForm(event){
        event.preventDefault();
        send_auth_data();
    }
    
    function checkForm() {

    } 
    
    function send_auth_data(){
        var formElement = document.getElementById('auth_form');
        var formData = new FormData(formElement);

        var xhr = new XMLHttpRequest();        
        xhr.open('POST', '/account/auth'); //true - запрос синхронный        
        xhr.send(formData);
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState != 4) return;
            if (xhr.status != 200) {

                console.log( xhr.status + ': ' + xhr.statusText );
                // обработать ошибку
            }
            if (xhr.responseText == "success") {
                window.location.href="/task"
            }
        }
    }    
}());