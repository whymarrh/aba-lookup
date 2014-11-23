<?php

namespace Lookup\Api\ServiceFactory;

use Lookup\Api\UserAccount;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserAccountServiceFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$locationDb = $serviceLocator->get('Lookup\Db\Location');
		$userAccountDb = $serviceLocator->get('Lookup\Db\UserAccount');
		$userDisplayNameDb = $serviceLocator->get('Lookup\Db\UserDisplayName');
		$userTypeDb = $serviceLocator->get('Lookup\Db\UserType');
		return new UserAccount($locationDb, $userAccountDb, $userDisplayNameDb, $userTypeDb);
	}
}
