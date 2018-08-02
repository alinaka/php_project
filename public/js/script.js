//(function() {
'use strict';

function validate() {
    $.validate({
        lang: 'ru',
        modules: 'date, security, file',
        onModulesLoaded: function () {
            var optionalConfig = {
                bad: 'Very bad',
                weak: 'Weak',
                good: 'Good',
                strong: 'Strong'
            };

            $('#reg_form input[name="password"]').displayPasswordStrength(optionalConfig);
        }
    });
}

$('#registration_modal').on('hidden.bs.modal', function (e) {
    document.getElementById('reg_form').reset();
    $('.strength-meter').remove();
});

function r_handler(response) {
    try {
        var data = JSON.parse(response);
        if (data.modal) {
            $('#result_modal').modal();
            $('#result_message').text(data.msg);
            $('#result_modal').on('hidden.bs.modal', function (e) {
                if (!data.path) {
                    location.href = location.href;
                } else {
                    window.location.href = data.path;
                }
            });
        } else {
            if (!data.path) {
                location.href = location.href;
            } else {
                window.location.href = data.path;
            }
        }
    } catch (e) {
        $('#result_modal').modal();
        $('#result_message').text(response);
    }

}

function sendForm(event) {
    event.preventDefault();

    var form_data = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", this.action, true);
    xhr.send(form_data);

    xhr.onload = function (oEvent) {
        if (xhr.status == 200) {
            console.log("Ok!", xhr.responseText);
            r_handler(xhr.responseText);
        } else {
            console.log("error!");
        }
    };

}

function addFormsListener() {
    for (let i = 0; i < document.forms.length; i++) {
        document.forms[i].addEventListener('submit', sendForm);
    }
}

validate();
addFormsListener();
//})();

