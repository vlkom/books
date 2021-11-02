<?php

require_once __DIR__ . '/Autoloader.php';

Autoloader::register();

$authors = \Services\MySql::getInstance()->fetchAll('SELECT * FROM book_authors');
var_dump($authors);die();