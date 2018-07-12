//(function() {
'use strict';

$.validate({
    lang: 'ru',
    modules: 'date, security, file',
    onError: function ($form) {
        showIcons();
        console.log('Validation of form ' + $form.attr('id') + ' failed!');
    },
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

$('input').on('blur', showIcons);

function showIcons() {
    $('.has-success i').html('<i class="fa fa-check-circle text-success"></i>');
    $('.has-error i').html('<i class="fa fa-exclamation-circle text-danger"></i>');
}

$('#registration_modal').on('hidden.bs.modal', function (e) {
    document.getElementById('reg_form').reset();
    $('i').html('');
    $('i').html('');
    $('.strength-meter').remove();
});

function r_handler(response) {
    switch (response) {
        case "Comment_success":
            $('#result_modal_title').text("Поздравляем!");
            $('#result_message').text("Ваш комментарий добавлен, обновите страницу");
            break;
        case "Avatar_success":
            $('#result_modal_title').text("Поздравляем!");
            $('#result_message').text("Изображение добавлено, обновите страницу");
            break;
        case "Reg_success":
            $('#registration_modal').modal('hide');
            $('#result_modal_title').text("Поздравляем!");
            $('#result_message').text("Вы успешно зарегистрированы");
            $('#result_modal').on('hidden.bs.modal', function (e) {
                window.location.href = "/task";
            });
            break;
        case "Reg_fail_user_exists":
            $('#result_message').text("Пользователь с таким логином уже существует");
            break;
        case "Auth_success":
            $('#result_modal').modal('hide');
            window.location.href = "/task";
            break;
        case "Auth_fail_pwd":
            $('#result_message').text("Неверный пароль");
            break;
        case "Auth_fail_login":
            $('#result_message').text("Пользователя с таким логином не существует");
            break;
        case "Task_new_success":
            $('#result_modal_title').text("Поздравляем!");
            $('#result_message').text("Задача успешно добавлена");
            break;
        case "Entry_new_success":
            $('#result_modal_title').text("Поздравляем!");
            $('#result_message').text("Время успешно учтено");
            $('#result_modal').on('hidden.bs.modal', function (e) {
                window.location.href = "/task";
            });
            break;
        case "Task_new_fail":
            $('#result_message').text("Не удалось добавить запись");
            break;
        case "Task_edit_success":
            $('#result_modal_title').text("Поздравляем!");
            $('#result_message').text("Изменения успешно сохранены");
            break;
        case "Task_edit_fail":
            $('#result_message').text("Не удалось внести изменения. Попробуйте еще раз");
            break;
        default:
            $('#result_message').text("Что-то пошло не так");
    }
    $('#result_modal').modal();
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

addFormsListener();
//})();

