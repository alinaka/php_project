<?php include 'nav.php'; ?>
<section class="section row">
 <?php include 'aside.php'; ?>
<div class="wrapper mx-auto col-10">
		<h3><?php echo $header; ?></h3>	
		<form method="post" id="task_form">
		    <div class="form-group">
		    	<label for="title">Название</label>
		    	<input class="form-control" type="text" name="title" id="title"> 
			</div>
		    <div class="form-group">
		    	<label for="description">Описание</label>
		    	<textarea class="form-control" name="description" id="description"></textarea>
			</div>
		    <div class="form-group">
		    	<label for="date_start_plan">Дата начала</label>
		    	<input class="form-control" type="date" name="date_start_plan" id="date_start_plan"> 
			</div>
			<div class="form-group">
		    	<label for="date_end_plan">Дата завершения</label>
		    	<input class="form-control" type="date" name="date_end_plan" id="date_end_plan"> 
			</div>
			<div class="form-group">
		    	<label for="time_plan">Планируемое время выполнения</label>
		    	<input class="form-control" type="time" name="time_plan" id="time_plan"> 
			</div>
		    <input type="submit" class="btn btn-primary btn-md" value="Добавить задачу">
		</form>
</div>
</section>
<script src="/js/addTask.js"></script>