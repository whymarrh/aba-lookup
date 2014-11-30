<?php

namespace Lookup\Db\ServiceFactory;

use Lookup\Db\Schedule as ScheduleDb;
use Zend\Db\Sql\Sql;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ScheduleServiceFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$adapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
		$sql = new Sql($adapter);
		return new ScheduleDb($sql);
	}
}
