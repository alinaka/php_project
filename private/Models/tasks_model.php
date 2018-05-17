<?php

$data = [
    [
        'id' => 1,
        'title' => 'Отредактировать тестовое задание',
        'content' => 'Переделать по новому макету',
    ],
    [
        'id' => 2,
        'title' => 'Сделать домашку по PHP',
        'content' => 'Вывод данных из массива в html, исходя из логики дипломного проекта;
                        Валидация формы на стороне клиента;
                        Получение данных форма на сервере.',
    ],
    [
        'id' => 3,
        'title' => 'Почитать книжку',
        'content' => 'content3',
    ],
    [
        'id' => 4,
        'title' => 'Посмотреть видеоурок',
        'content' => 'content4',
    ],
];

function get_data(&$data){
    return $data;
}

function get_data_by_id($data, $id) {
    if (empty($id)) {
        return false;
    }
    foreach ($data as $val) {
        if($id == $val['id']) {
            return $val;
        }
    }
}
?>