<?php include 'nav.php'; ?>
    
<section class="section row">
    <?php include 'aside.php'; ?>
    <div class="col-10">
        <h3>Мои задачи</h3>
        <?php foreach($data as $item): ?>
        <div>
            <h4><?php echo $item['title']?></h4>
            <p><?php echo $item['content']?></p>
            <a href="/task/show/<?php echo $item['id']?>">Подробнее</a>
        </div>
        <?php endforeach; ?>
    </div>
</section>
