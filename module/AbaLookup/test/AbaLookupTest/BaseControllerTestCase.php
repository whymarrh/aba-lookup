<?php

namespace AbaLookupTest;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class BaseControllerTestCase extends AbstractHttpControllerTestCase
{
	/**
	 * Common HTTP response codes
	 */
	const HTTP_STATUS_OK                = 200;
	const HTTP_STATUS_MOVED_PERMANENTLY = 301;
	const HTTP_STATUS_MOVED_TEMPORARILY = 302;
	const HTTP_STATUS_NOT_FOUND         = 404;
	const HTTP_STATUS_SERVER_ERROR      = 500;

	/**
	 * Resets the application for isolation
	 */
	public function setUp()
	{
		$this->setApplicationConfig(
			include realpath(sprintf('%s/../../../../config/application.config.php', __DIR__))
		);
		parent::setUp();
	}

	public function setService($serviceName, $service)
	{
		$serviceManager = $this->getApplicationServiceLocator();
		$serviceManager->setAllowOverride(true);
		$serviceManager->setService($serviceName, $service);
	}
}
