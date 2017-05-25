<?php

return [
	'GitHub' => [
		'user' => 'MUNComputerScienceSociety',
		'repo' => 'ABALookup',
	],
	'doctrine' => [
		'connection' => [
			'orm_default' => [
				'driverClass' => 'Doctrine\DBAL\Driver\PDOSqlite\Driver',
				'params'      => [
					'path' => 'database/db.sqlite3',
				],
			],
		],
	],
];
