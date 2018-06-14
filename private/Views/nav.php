<nav class="navbar navbar-expand-lg">
  <a class="navbar-brand" href="/"><i class="fas fa-clock"></i>TimeTrack</a>
  <div class="navbar-collapse">
  	<form class="form-inline my-2 my-lg-0 mr-auto">
      <input class="form-control mr-sm-2" type="search" placeholder="Искать" aria-label="Искать">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Искать</button>
    </form>
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#">Личная страница <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Текущая задача</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['login']?></a>
	        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
	          <a class="dropdown-item" href="/account">Личная информация</a>
	          <a class="dropdown-item" href="#">Настройки</a>
            <a class="dropdown-item" href="#">Помощь</a>
	          <div class="dropdown-divider"></div>
	          <a class="dropdown-item" href="/account/logout">Выйти</a>
	        </div>
      </li>
    </ul>
  </div>
</nav>