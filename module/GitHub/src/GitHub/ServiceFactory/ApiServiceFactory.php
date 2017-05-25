<?php

namespace GitHub\ServiceFactory;

use
	GitHub\Api\Api as GitHubApi,
	Zend\ServiceManager\FactoryInterface,
	Zend\ServiceManager\ServiceLocatorInterface
;

class ApiServiceFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$configuration = $serviceLocator->get('Config');
		return new GitHubApi(
			$configuration['GitHub']['user'],
			$configuration['GitHub']['repo']
		);
	}
}
