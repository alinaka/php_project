<?php include 'logo.php'; ?>
<div class="wrapper">		
		<form method="post" id="reg_form">
		    <div class="form-group">
		    	<label for="login">Логин</label>
		    	<input class="form-control" type="text" name="login" id="login"> 
			</div>
		    <div class="form-group">
		    	<label for="email">E-mail</label>
		    	<input class="form-control" type="email" name="email" id="email"> 
			</div>
		    <div class="form-group">
		    	<label for="password">Пароль</label>
		    	<input class="form-control" type="password" name="password" id="password"> 
			</div>
			<div class="form-group">
		    	<label for="password_check">Повторите пароль</label>
		    	<input class="form-control" 
		    			type="password" 
		    			name="password_check" 
		    			id="password_check"> 
			</div>
		    <input type="submit" value="Зарегистрироваться" onsubmit=>
		</form>
</div>