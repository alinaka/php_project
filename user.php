<?php session_start() ?>

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
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Главная страница</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php if (isset($_SESSION['login'])): ?>
    <?php include 'header.php'?>
    <a href="reg/logout.php">Выйти</a>
    <?php include 'aside.php'?>
    <div class="container">
        <section class="section">
            <h4>Добро пожаловать, <?php echo $_SESSION['login']?></h4>
            <h3>Мои задачи</h3>
            <?php foreach($data as $item): ?>
            <div>
                <h4><?php echo $item['title']?></h4>
                <p><?php echo $item['content']?></p>
                <a href="data.php?id=<?php echo $item['id']?>">Подробнее</a>
            </div>
            <?php endforeach; ?>
        </section>
        <?php include 'footer.php'?>
    </div>
<?php else: ?>
<?php include 'index.php'; endif;?>
</body>
</html>
