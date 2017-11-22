<?php

namespace Runtest;

	use PDO;

	class TestConfig
	{
		static $dbConfig = [
			'type' => 'mysql',
			'dsn' => 'mysql:host=localhost;dbname=test',
			'user' => 'test',
			'password' => 'test',
			'options' => [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'],
			'attrs' => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
		];
	}

	$dir = __DIR__ . DIRECTORY_SEPARATOR;

	require_once $dir . 'vendor/autoload.php';
	require_once $dir . '../autoload.php';