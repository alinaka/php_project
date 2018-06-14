<?php include 'nav.php'; ?>
<section class="section row">
	<?php include 'aside.php'; ?>
    <div class="col-10">
        <h3><?php echo $task['title'] ?></h3>
        <p>Описание: <?php echo $task['description'] ?></p>
        <p>Дата начала: <?php echo $task['date_start_plan'] ?></p>
        <p>Дата завершения: <?php echo $task['date_end_plan'] ?></p>
        <p>Планируемое время выполнения: <?php echo $task['time_plan'] ?></p>
        <a class="btn btn-primary btn-md" href="/task/edit">Изменить</a>
    </div>
</section>
