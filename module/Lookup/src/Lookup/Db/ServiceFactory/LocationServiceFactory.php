<?php

namespace Lookup\Db\ServiceFactory;

use Lookup\Db\Location as LocationDb;
use Zend\Db\Sql\Sql;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LocationServiceFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$adapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
		$sql = new Sql($adapter);
		return new LocationDb($sql);
	}
}
