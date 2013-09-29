<?php

namespace Maps\ServiceFactory;

use
	Maps\Api as MapsApi,
	Zend\ServiceManager\FactoryInterface,
	Zend\ServiceManager\ServiceLocatorInterface
;

class ApiServiceFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$configuration = $serviceLocator->get('Config');
		return new MapsApi($configuration['MapsApi']['key']);
	}
}
