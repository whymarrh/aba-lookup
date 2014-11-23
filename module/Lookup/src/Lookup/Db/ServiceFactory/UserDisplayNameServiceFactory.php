<?php

namespace Lookup\Db\ServiceFactory;

use Lookup\Db\UserDisplayName as UserDisplayNameDb;
use Zend\Db\Sql\Sql;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserDisplayNameServiceFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$adapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
		$sql = new Sql($adapter);
		return new UserDisplayNameDb($sql);
	}
}
