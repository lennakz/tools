<?php

$host = ($_SERVER['REMOTE_ADDR'] == '107.180.24.240') ? 'localhost' : '107.180.24.240';

return [
	'class' => 'yii\db\Connection',
	'dsn' => "mysql:host={$host};dbname=eurohouse_tools",
	'username' => 'eurohouse_tools',
	'password' => 'mathers',
	'charset' => 'utf8',
];
