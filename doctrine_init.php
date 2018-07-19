<?php
require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$config = Setup::createAnnotationMetadataConfiguration(
	array(__DIR__."/private/Models"),
	true
);

$conn = array(
	'driver'=> 'pdo_mysql',
	'user'=> 'root',
	'password'=> '',
	'dbname'=> 'tt_project'
);

$entityManager = EntityManager::create($conn, $config);