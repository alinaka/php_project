<?php

namespace alina\project\App;

class Request
{
	private $getVars;
	private $postVars;
	private $serverVars;
	private $filesVars;
	// private $sessionVars;
	private $cookieVars;

	public function __construct(){
		// $this->getVars = new VarsCollection($_GET);
		$this->getVars = $_GET;
		$this->postVars = $_POST;
		$this->serverVar = $_SERVER;
		$this->filesVars = $_FILES;
		$this->cookieVars = $_COOKIE;
	}

	public function get(){
		return $this->getVars;
	}

	public function post(){
		return $this->postVars;
	}

	public function server(){
		return $this->serverVar;
	}

	public function files(){
		return $this->filesVars;
	}

	public function cookie(){
		return $this->cookieVars;
	}

	public function getUri(){
		return $this->serverVar['REQUEST_URI'];
	}
}