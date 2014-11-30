<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

set_include_path(implode(PATH_SEPARATOR, [
	'vendor/zf2/library/',
	'module/',
	get_include_path(),
]));

require 'autoloader.php';

function dd($data) {
	call_user_func_array('var_dump', func_get_args());
	die();
}

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
