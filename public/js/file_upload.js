(function() {
    'use strict';

    var task_form = document.getElementById('task_form');
    if (task_form) {
        task_form.addEventListener('submit', submitTaskForm);
    }

    function submitTaskForm(event){
        event.preventDefault();
        if (validate_files()){
            upload_files();
        }
    }
    
    function validate_files() {
        //валидация!!!
        return true;
    } 
    
    function upload_files(){
        var formElement = document.getElementById('task_form');
        var formData = new FormData(formElement);

        var xhr = new XMLHttpRequest();        
        xhr.open('POST', '/task/file'); //true - запрос синхронный        
        xhr.send(formData);
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState != 4) return;
            if (xhr.status != 200) {

                console.log( xhr.status + ': ' + xhr.statusText );
                // обработать ошибку
            }
            console.log(xhr.responseText);
        }
    }    
}());