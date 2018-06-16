(function() {
    'use strict';
    var task_form = document.getElementById('task_form');
    var result_message = document.getElementById('result_message');
    task_form.addEventListener('submit', submitForm);

    function submitForm(event){
        event.preventDefault();
        send_data();
    }
    
    function show_message(result){
        switch(result) {
            case 1: 
                var result_modal_title = document.getElementById('result_modal_title');
                result_modal_title.innerText = "Поздравляем!";
                result_message.innerText = "Задача успешно добавлена";
                break;
            case 0: 
                result_message.innerText = "Не удалось добавить запись";
                break;
            default: 
                result_message.innerText = "Заполните все поля формы";
        }
        $('#result_modal').modal();
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
                        
            if (xhr.responseText == 1) {
                show_message(1);
                        //window.location.href="/task";
            } else {
                show_message(0);
            }
        }
    }    
}());