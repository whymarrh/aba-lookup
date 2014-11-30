<?php

return array(
	'service_manager' => array(
		'factories' => array(
			'Lookup\Api\Schedule' => 'Lookup\Api\ServiceFactory\ScheduleServiceFactory',
			'Lookup\Api\UserAccount' => 'Lookup\Api\ServiceFactory\UserAccountServiceFactory',
			'Lookup\Db\Location' => 'Lookup\Db\ServiceFactory\LocationServiceFactory',
			'Lookup\Db\Schedule' => 'Lookup\Db\ServiceFactory\ScheduleServiceFactory',
			'Lookup\Db\UserAccount' => 'Lookup\Db\ServiceFactory\UserAccountServiceFactory',
			'Lookup\Db\UserDisplayName' => 'Lookup\Db\ServiceFactory\UserDisplayNameServiceFactory',
			'Lookup\Db\UserType' => 'Lookup\Db\ServiceFactory\UserTypeServiceFactory',
		),
	),
);
