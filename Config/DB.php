<?php

namespace App\Config {
	$data['type'] = 'mysql';

	$data['options'] = [
		'MYSQL_ATTR_INIT_COMMAND' => "SET NAMES 'UTF8'"
	];

	$data['attrs'] = [
		\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
	];

	return $data;
}