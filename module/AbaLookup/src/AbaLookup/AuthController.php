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
			$user = $this->getService('Lookup\Api\UserAccount')->create($data);
			$this->getService('Lookup\Api\Schedule')->create($user);
		} catch (\Lookup\Api\Exception\InvalidArgumentException $e) {
			return [
				'error' => $e->getMessage(),
				'form'  => $form,
				'type'  => $type,
			];
		}

		$id = $user->getId();
		Session::setId($id);
		return $this->redirect()->toRoute('users', array(
			'id' => $id,
			'action' => 'profile'
		));
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

		$userAccountApi = $this->getService('Lookup\Api\UserAccount');

		$data = $this->params()->fromPost();
		$account = $userAccountApi->getAccountForCredentials($data);

		if (
			   !$account
			|| ($data['password'] !== $account->getPassword())
		) {
			return [
				'error' => TRUE,
				'form' => $form,
			];
		}

		$user = $userAccountApi->getUserForAccount($account);
		$id = $user->getId();
		Session::setId($id, (bool) $data[$form::ELEMENT_NAME_REMEMBER_ME]);
		return $this->redirect()->toRoute('users', array(
			'id' => $id,
			'action' => 'profile',
		));
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
