<?php

namespace AbaLookup;

use AbaLookup\Form\LoginForm;
use AbaLookup\Form\RegisterForm;
use AbaLookup\Session\Session;

class AuthController extends AbaLookupController
{
	/**
	 * Contains logic common to all actions and is run on each dispatch
	 *
	 * @return void
	 */
	public function action()
	{
		$id = Session::getId();
		if ($id !== NULL) {
			return $this->redirect()->toRoute('users', array('id' => $id, 'action' => 'profile'));
		}
		$this->prepareLayout();
	}

	/**
	 * Registers the account or shows a registration form
	 *
	 * @return array|Zend\Http\Response
	 */
	public function registerAction()
	{
		$type = $this->params('type');
		$form = new RegisterForm($type);

		if (!$this->request->isPost()) {
			return [
				'form' => $form,
				'type' => $type,
			];
		}

		$data = $this->params()->fromPost();
		try {
			$id = $this->getService('Lookup\Api\UserAccount')->create($data);
		} catch (\Lookup\Api\Exception\InvalidArgumentException $e) {
			return [
				'error' => $e->getMessage(),
				'form'  => $form,
				'type'  => $type,
			];
		}
		Session::setId($id);
		return $this->redirect()->toRoute('users', array('id' => $id, 'action' => 'profile'));
	}

	/**
	 * Kicks off the session
	 *
	 * @return array|Zend\Http\Response
	 */
	public function loginAction()
	{
		$form = new LoginForm();

		if (!$this->request->isPost()) {
			return [
				'form' => $form,
			];
		}

		$data = $this->params()->fromPost();
		$id = $this->getService('Lookup\Api\UserAccount')->getByCredentials($data);
		if (!$id) {
			return [
				'error' => TRUE,
				'form' => $form,
			];
		}
		Session::setId($id, (bool) $data[$form::ELEMENT_NAME_REMEMBER_ME]);
		return $this->redirect()->toRoute('users', array('id' => $id, 'action' => 'profile'));
	}

	/**
	 * Unset the current session identifier.
	 *
	 * @return Zend\Http\Response
	 */
	public function logoutAction()
	{
		Session::unsetId();
		return $this->redirect()->toRoute('home');
	}
}
