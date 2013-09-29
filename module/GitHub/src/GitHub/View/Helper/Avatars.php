<?php

namespace GitHub\View\Helper;

use
	Zend\View\Helper\AbstractHelper
;

class Avatars extends AbstractHelper
{
	public function __invoke(array $contributors)
	{
		$markup = '';
		foreach ($contributors as $contributor) {
			$markup .= sprintf('<img src="%s">', $contributor->avatar_url);
		}
		return $markup;
	}
}
