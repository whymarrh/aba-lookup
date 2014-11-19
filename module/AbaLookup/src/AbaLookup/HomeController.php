<?php

namespace AbaLookup;

use AbaLookup\Session\Session;

class HomeController extends AbaLookupController
{
	protected $user;

	public function action()
	{
		$this->layout('layout/home');
		$id = Session::getId();
		if (isset($id)) {
			$this->user = $this->getService('Lookup\Api\UserAccount')->getById($id);
		}
		$this->prepareLayout($this->user);
	}

	public function indexAction()
	{
		return [
			'user' => $this->user,
		];
	}

	public function privacyAction()
	{
		return [
			'user' => $this->user,
		];
	}

	public function aboutAction()
	{
		return [
			'user' => $this->user,
		];
	}

	public function termsAction()
	{
		return [
			'user' => $this->user,
		];
	}

	public function sponsorsAction()
	{
		return [
			'user' => $this->user,
		];
	}

	public function colophonAction()
	{
		return [
			'user' => $this->user,
		];
	}
}
