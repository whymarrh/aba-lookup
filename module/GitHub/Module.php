<?php

namespace GitHub;

class Module
{
	public function getAutoloaderConfig()
	{
		return [
			'Zend\Loader\StandardAutoloader' => [
				'namespaces' => [
					__NAMESPACE__ => realpath(sprintf('%s/src/%s', __DIR__, __NAMESPACE__))
				],
			],
		];
	}

	public function getConfig()
	{
		return include realpath(sprintf('%s/config/module.config.php', __DIR__));
	}

	public function getViewHelperConfig()
	{
		return [
			'invokables' => [
				'avatars' => 'GitHub\View\Helper\Avatars',
			],
		];
	}
}
