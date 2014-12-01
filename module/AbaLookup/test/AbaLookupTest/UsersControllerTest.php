<?php

namespace AbaLookupTest;

use Mockery;

class UsersControllerTest extends BaseControllerTestCase
{
	/**
	 * Returns an array of actions to be tested
	 */
	public function usersActions()
	{
		return [
			['/users/c03fe04f-341b-41f5-9dde-3225228cdfc4/profile', 'users'],
			['/users/c03fe04f-341b-41f5-9dde-3225228cdfc4/schedule', 'users'],
			['/users/c03fe04f-341b-41f5-9dde-3225228cdfc4/matches', 'users'],
		];
	}

	/**
	 * Tests that certain URLs should redirect to the login page
	 *
	 * A user attempting to view their profile, schedule, or matches without
	 * logging in first should redirect them to the login page.
	 *
	 * @dataProvider usersActions
	 */
	public function testRedirectsToLoginPage($url, $route)
	{
		$mockUserAccountApi = Mockery::mock('Lookup\Api\UserAccount', array(
			'getById' => NULL,
		));
		$this->setService('Lookup\Api\UserAccount', $mockUserAccountApi);

		$this->dispatch($url);
		$this->assertResponseStatusCode(self::HTTP_STATUS_MOVED_TEMPORARILY);
		$this->assertRedirectTo('/users/login');
	}
}
