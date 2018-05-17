<section class="section">
    <h4>Добро пожаловать, <?php echo $_SESSION['login']?></h4>
    <a href="logout">Выйти</a>
    <h3>Мои задачи</h3>
    <?php foreach($data as $item): ?>
    <div>
        <h4><?php echo $item['title']?></h4>
        <p><?php echo $item['content']?></p>
        <a href="/task?id=<?php echo $item['id']?>">Подробнее</a>
    </div>
    <?php endforeach; ?>
</section>
