<?php include 'nav.php'; ?>
    
<section class="section row">
    <?php include 'aside.php'; ?>
    <div class="content col-10">
        <h3 class="content__header">Мои задачи</h3>
        <a class="btn btn-primary btn-md content__add_button" href="/task/add" role="button">Новая задача</a>
        <table class="table">
        <tr>
            <th>Задача</th>
            <th>Срок выполнения</th>
            <th>Время факт</th>
            <th>Время план</th>
            <th>Ответственный</th>
        </tr>
        <?php foreach($data as $item): ?>
        <tr>
            <td><a href="/task/show/<?php echo $item['task_id']?>"><?php echo $item['title']?></a></td>
            <td><?php echo $item['date_end_plan']?></td>
            <td><?php echo $item['time_fact']?></td>
            <td><?php echo $item['time_plan']?></td>
            <td><?php echo $item['resp_id']?></td>
<!--             <p><?php echo $item['description']?></p> -->
        </tr>
        <?php endforeach; ?>
        </table>
    </div>
</section>
