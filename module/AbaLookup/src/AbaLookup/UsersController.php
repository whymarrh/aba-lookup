<?php

namespace AbaLookup;

use AbaLookup\Form\ProfileEditForm;
use AbaLookup\Form\ScheduleForm;
use AbaLookup\Session\Session;

class UsersController extends AbaLookupController
{
	/**
	 * The current user in session.
	 *
	 * @var Lookup\Entity\User
	 */
	private $user;

	/**
	 * Contains logic common to all actions and is run on each dispatch
	 *
	 * @return void
	 */
	public function action()
	{
		$id = Session::getId();
		$this->user = $this->getService('Lookup\Api\UserAccount')->getById($id);
		if ($this->user == NULL) {
			return $this->redirect()->toRoute('auth/login');
		}
		$this->prepareLayout($this->user);
	}

	/**
	 * Displays the user profile
	 *
	 * @return array|Zend\Http\Response
	 */
	public function profileAction()
	{
		$form = new ProfileEditForm($this->user);

		if (!$this->request->isPost()) {
			return [
				'form' => $form,
				'user' => $this->user,
			];
		}

		$data = $this->params()->fromPost();
		try {
			$this->getService('Lookup\Api\UserAccount')->update($this->user, $data);
		} catch (\Lookup\Api\Exception\InvalidArgumentException $e) {
			return [
				'error' => $e->getMessage(),
				'form'  => $form,
				'user'  => $this->user,
			];
		}

		return $this->redirect()->toRoute('users', array(
			'id' => $this->user->getId(),
			'action' => 'profile',
		));
	}

	/**
	 * Displays the schedule
	 *
	 * @return array|Zend\Http\Response
	 */
	public function scheduleAction()
	{
		$id = $this->user->getId();
		$form = new ScheduleForm();
		if ($this->request->isPost()) {
			$data = $this->param()->fromPost();
			$this->getService('Lookup\Api\Schedule')->update($id, $data);
			return $this->redirect()->toRoute('users', array(
				'id' => $id,
				'action' => 'schedule',
			));
		} else {
			$schedule = $this->getService('Lookup\Api\Schedule')->getByUserId($id);
			$user = $this->user;
			return [
				'form' => $form,
				'user' => $user,
				'schedule' => $schedule,
			];
		}
	}

	/**
	 * Displays to the list of matches
	 *
	 * @return array|Zend\Http\Response
	 */
	public function matchesAction()
	{
		return [
			'user' => $this->user,
		];
	}
}
