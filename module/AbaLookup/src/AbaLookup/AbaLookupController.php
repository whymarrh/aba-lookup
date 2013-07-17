<?php

namespace AbaLookup;

use
	Doctrine\ORM\EntityManager,
	Zend\Mvc\Controller\AbstractActionController,
	Zend\Session\Container,
	Zend\View\Model\ViewModel
;

abstract class AbaLookupController extends AbstractActionController
{
	/**
	 * The key used to store the user in session
	 */
	const SESSION_KEY = 'user';

	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	private $entityManager;

	/**
	 * Return the Entity Manager
	 */
	protected function getEntityManager()
	{
		if ($this->entityManager === NULL) {
			$this->entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		}
		return $this->entityManager;
	}

	/**
	 * Return whether a user is currently in session
	 */
	protected function userLoggedIn()
	{
		$session = new Container();
		return $session->offsetExists(self::SESSION_KEY);
	}

	/**
	 * Return the current user in session
	 */
	protected function currentUser()
	{
		if (!$this->userLoggedIn()) {
			return NULL;
		}
		$session = new Container();
		return $this->getEntityManager()
		            ->getRepository('AbaLookup\Entity\User')
		            ->findOneBy(['id' => $session->offsetGet(self::SESSION_KEY)]);
	}

	/**
	 * Prepare the given layout to be displayed for the given user
	 *
	 * Nests the footer widget into the layout and adds the current
	 * user's base URL to the layout.
	 */
	protected function prepareLayout(&$layout, &$user = NULL)
	{
		// add the footer
		$footer = new ViewModel();
		$footer->setTemplate('widget/footer');
		$layout->addChild($footer, 'footer');
		// add the user's URL
		if (!isset($user)) {
			return;
		}
		$layout->setVariable('user', $user);
	}
}
