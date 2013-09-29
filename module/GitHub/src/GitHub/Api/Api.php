<?php

namespace GitHub\Api;

use
	Zend\Http\ClientStatic as HttpClient,
	Zend\Json\Json
;

class Api
{
	const SORT_BY_USERNAME = 'sortByUsername';

	private $user;
	private $repo;

	public function __construct($user, $repo)
	{
		$this->user = $user;
		$this->repo = $repo;
	}

	public function getContributors($order = NULL)
	{
		$response = HttpClient::get(sprintf(Url::CONTRIBUTORS, $this->user, $this->repo));
		$contributors = Json::decode($response->getBody());
		if (
			   isset($order)
			&& is_callable([$this, $order])
		) {
			uasort($contributors, [$this, $order]);
		}
		return $contributors;
	}

	private function sortByUsername($a, $b)
	{
		return strcasecmp($a->login, $b->login);
	}
}
