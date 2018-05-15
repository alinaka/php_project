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

$get = $_GET;
$id = $get['id'];

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

$res = get_data_by_id($data, $id);

?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Главная страница</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <?php include 'header.php'?>
        <?php include 'aside.php'?>
        <section class="section">
            <h3>Задача</h3>
            <div>
                <h3><?php echo $res['title']?></h3>
                <p><?php echo $res['content']?></p>
                <button>Изменить</button>
            </div>
        </section>
        <?php include 'footer.php'?>
    </div>
</body>
</html>