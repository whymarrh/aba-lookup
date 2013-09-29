<?php

namespace GitHub\Api;

use
	Zend\Http\ClientStatic as HttpClient,
	Zend\Json\Json
;

class Api
{
	private $user;
	private $repo;

	public function __construct($user, $repo)
	{
		$this->user = $user;
		$this->repo = $repo;
	}

	public function getContributors()
	{
		$response = HttpClient::get(sprintf(Url::CONTRIBUTORS, $this->user, $this->repo));
		return Json::decode($response->getBody());
	}
}
