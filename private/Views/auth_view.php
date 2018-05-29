<?php include 'logo.php'; ?>
<div class="wrapper">
		<form method="post" id="auth_form">
			<div class="form-group">
		    	<label for="login">Логин</label>
		    	<input class="form-control" type="text" name="login" id="login"> 
			</div>
			<div class="form-group">
		    	<label for="password">Пароль</label>
		    	<input class="form-control" type="password" id="password" name="password">
		    </div>
		    <div class="form-group form-check">
		    	<input class="form-check-input" type="checkbox" id="check" name="remember">
		    	<label class="form-check-label" for="check">Запомнить меня</label>
		    </div>
		    <input type="submit" value="Войти">    
		</form>
</div>
