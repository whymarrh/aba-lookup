<?php

return [
	'db' => [
		'driver' => 'Pdo',
		'dsn' => sprintf('%s:%s', 'sqlite', realpath(sprintf('%s/%s', __DIR__, '../../database/db.sqlite3'))),
	],
	'service_manager' => [
		'factories' => [
			'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
		],
	],
];
