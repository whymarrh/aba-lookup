<?php

namespace Lookup\Api\ServiceFactory;

use Lookup\Api\UserType;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserTypeServiceFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		return new UserType();
	}
}
