<?php

require_once "doctrine_init.php";
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);

//php vendor/doctrine/orm/bin/doctrine.php orm:schema-tool:create
//php vendor/doctrine/orm/bin/doctrine.php orm:schema-tool:create --dump-sql