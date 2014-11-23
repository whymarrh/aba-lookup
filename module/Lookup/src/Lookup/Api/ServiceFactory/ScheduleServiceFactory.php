<?php

namespace Lookup\Api\ServiceFactory;

use Lookup\Api\Schedule;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ScheduleServiceFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		return new Schedule();
	}
}
