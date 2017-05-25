<?php

namespace GitHub\View\Helper;

use
	InvalidArgumentException,
	Zend\View\Helper\AbstractHelper
;

/**
 * View helper for presenting GitHub avatars
 */
class Avatars extends AbstractHelper
{
	/**
	 * Generates the HTML markup for presenting a list of contributors to a
	 * GitHub repository
	 *
	 * @param array $contributors The array of contributors from the GitHub API.
	 * @param string $class The class name for the unordered list.
	 * @return string The HTML markup for the avatars.
	 * @throws InvalidArgumentException If the class name is not a string value.
	 */
	public function __invoke(array $contributors, $class = 'contributors')
	{
		if (!is_string($class)) {
			throw new InvalidArgumentException('The class name must be a string.');
		}
		$markup = sprintf('<ul class="%s">', $class);
		foreach ($contributors as $contributor) {
			$markup .= sprintf(
				'<li><a href="%s"><img src="%s" alt="%s"></a></li>',
				$contributor->html_url,
				$contributor->avatar_url,
				$contributor->login
			);
		}
		return $markup . '</ul>';
	}
}
