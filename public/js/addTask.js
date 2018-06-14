(function() {
    'use strict';
    var task_form = document.getElementById('task_form');
    task_form.addEventListener('submit', submitForm);

    function submitForm(event){
        event.preventDefault();
        send_data();
    }
    
    function send_data(){
        var formElement = task_form;
        var formData = new FormData(formElement);

        var xhr = new XMLHttpRequest();        
        xhr.open('POST', '/task/add', true); //true - запрос синхронный        
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