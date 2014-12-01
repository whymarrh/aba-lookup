<?php

namespace AbaLookupTest;

use Mockery;

class AuthControllerTest extends BaseControllerTestCase
{
	/**
	 * Returns an array of actions to be tested
	 */
	public function authActions()
	{
		return [
			['/users/register/parent', 'auth/register'],
			['/users/register/therapist', 'auth/register'],
			['/users/login', 'auth/login'],
		];
	}

	/**
	 * Ensures the authentication actions
	 *
	 * @dataProvider authActions
	 */
	public function testAuthActionsContainValidHtml($url, $route)
	{
		$mockUserAccountApi = Mockery::mock('Lookup\Api\UserAccount');
		$this->setService('Lookup\Api\UserAccount', $mockUserAccountApi);

		$this->dispatch($url);
		$this->assertResponseStatusCode(self::HTTP_STATUS_OK);
		$this->assertModuleName('AbaLookup');
		$this->assertControllerName('Auth');
		$this->assertControllerClass('AuthController');
		$this->assertMatchedRouteName($route);
	}
}
