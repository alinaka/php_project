(function() {
    'use strict';
    
    var reg_form = document.getElementById('reg_form');
    reg_form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        var formElement = document.forms[0];
        var formData = new FormData(formElement);

        var xhr = new XMLHttpRequest();        
        xhr.open('POST', 'reg_auth_logout.php', true); //true - запрос синхронный        
        xhr.send(formData);
        
        xhr.onreadystatechange = function() {
            // (0 → 1 → 2 → 3 → … → 3 → 4)
            if (xhr.readyState != 4) return;
            if (xhr.status != 200) {

                console.log( xhr.status + ': ' + xhr.statusText );
                // обработать ошибку
            } else {

                console.log(xhr.responseText);
                // вывести результат
            }
        }
    });
    
    
}());