<?php

namespace AbaLookup;

use Zend\EventManager\EventInterface;
use Zend\Mvc\MvcEvent;

/**
 * Module class
 */
class Module
{
	public function onBootstrap(EventInterface $event)
	{
		$em = $event->getTarget()->getEventManager();
		$em->attach(MvcEvent::EVENT_FINISH, array($this, 'contentSecurityPolicy'));
	}

	public function contentSecurityPolicy(MvcEvent $e)
	{
		$contentSecurityPolicy = new \Zend\Http\Header\ContentSecurityPolicy();
		$contentSecurityPolicy->setDirective('default-src', array('\'self\''));
		$e->getResponse()
		  ->getHeaders()
		  ->addHeader($contentSecurityPolicy);
	}

	/**
	 * Returns the module configuration
	 */
	public function getConfig()
	{
		return include realpath(sprintf('%s/config/module.config.php', __DIR__));
	}

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

	/**
	 * Returns the view helpers mapping
	 */
	public function getViewHelperConfig()
	{
		return [
			'invokables' => [
				'anchor'         => 'AbaLookup\View\Helper\AnchorLink',
				'form'           => 'AbaLookup\Form\View\Helper\Form',
				'scheduleHelper' => 'AbaLookup\View\Helper\ScheduleHelper',
				'script'         => 'AbaLookup\View\Helper\Script',
				'stylesheet'     => 'AbaLookup\View\Helper\Stylesheet',
			],
		];
	}
}
