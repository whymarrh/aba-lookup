<?php

return [
	'service_manager' => [
		'factories' => [
			'GitHub\Api' => 'GitHub\ServiceFactory\ApiServiceFactory',
		],
	],
];
