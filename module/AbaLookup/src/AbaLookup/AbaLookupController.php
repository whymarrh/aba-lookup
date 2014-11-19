<?php

namespace AbaLookup;

use Lookup\Entity\User;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

abstract class AbaLookupController extends AbstractActionController implements ServiceLocatorAwareInterface
{
	const EVENT_PRIORITY_BEFORE_ACTION = 100;

	/**
	 * The service manager
	 * @var ServiceLocatorInterface
	 */
	protected $services;

	/**
	 * Set the event manager instance used by this context
	 *
	 * @param EventManagerInterface $eventManager
	 * @return AbstractController
	 */
	public function setEventManager(EventManagerInterface $eventManager)
	{
		parent::setEventManager($eventManager);
		// Attach callable to run before each controller action
		$eventManager->attach(
			MvcEvent::EVENT_DISPATCH,
			[$this, 'action'],
			self::EVENT_PRIORITY_BEFORE_ACTION
		);
	}

	/**
	 * Set service locator
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->services = $serviceLocator;
	}

	/**
	 * Get service locator
	 *
	 * @return ServiceLocatorInterface
	 */
	public function getServiceLocator()
	{
		return $this->services;
	}

	/**
	 * Retrieve a registered service instance
	 *
	 * @param  string  $name
	 * @throws Exception\ServiceNotFoundException
	 * @return object|array
	 */
	public function getService($name)
	{
		return $this->getServiceLocator()->get($name);
	}

	/**
	 * Prepares the layout to be displayed
	 *
	 * @param Lookup\Entity\User $user
	 * @return void
	 */
	protected function prepareLayout(User $user = NULL)
	{
		$layout = $this->layout();
		$footer = new ViewModel();
		$footer->setTemplate('widget/footer');
		$layout->addChild($footer, 'footer');
		$layout->setVariable('user', $user);
	}
}
