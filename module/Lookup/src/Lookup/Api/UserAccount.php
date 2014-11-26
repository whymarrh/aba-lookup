<?php

namespace Lookup\Api;

use Lookup\Db\Location as LocationDb;
use Lookup\Db\UserAccount as UserAccountDb;
use Lookup\Db\UserDisplayName as UserDisplayNameDb;
use Lookup\Db\UserType as UserTypeDb;
use Lookup\Entity\Account;
use Lookup\Entity\Location;
use Lookup\Entity\User;
use Lookup\Entity\UserDisplayName;
use Lookup\Entity\UserType;

class UserAccount
{
	/**
	 * @var \Lookup\Db\Location
	 */
	private $locationDb;

	/**
	 * @var \Lookup\Db\UserAccount
	 */
	private $userAccountDb;

	/**
	 * @var \Lookup\Db\UserDisplayName
	 */
	private $userDisplayNameDb;

	/**
	 * @var \Lookup\Db\UserType
	 */
	private $userTypeDb;

	/**
	 * Constructor
	 *
	 * @param \Lookup\Db\Location $locationDb
	 * @param \Lookup\Db\UserAccount $userAccountDb
	 * @param \Lookup\Db\UserDisplayName $userDisplayNameDb
	 * @param \Lookup\Db\UserType $userTypeDb
	 */
	public function __construct(LocationDb $locationDb, UserAccountDb $userAccountDb, UserDisplayNameDb $userDisplayNameDb, UserTypeDb $userTypeDb)
	{
		$this->locationDb = $locationDb;
		$this->userAccountDb = $userAccountDb;
		$this->userDisplayNameDb = $userDisplayNameDb;
		$this->userTypeDb = $userTypeDb;
	}

	/**
	 * @param array $data
	 * @return \Lookup\Entity\User The created user.
	 */
	public function create(array $data)
	{
		$creationTime = time();

		$location = new Location(
			$data['city'],
			$data['postal-code']
		);
		$location = $this->locationDb->getOrCreate($location);

		$account = new Account(
			$data['password'],
			NULL,
			$data['email-address'],
			FALSE,
			NULL,
			0,
			0,
			$creationTime
		);
		$account = $this->userAccountDb->createAccount($account);

		$userDisplayName = new UserDisplayName(
			NULL,
			$data['display-name'],
			$creationTime
		);
		$userDisplayName = $this->userDisplayNameDb->create($userDisplayName);

		$userType = new UserType(
			$data['user-type']
		);
		$userType = $this->userTypeDb->get($userType);

		$user = new User(
			$account,
			$userDisplayName,
			$userType,
			$location,
			$data['gender'],
			$data['phone-number'],
			(bool) $data['aba-course'],
			(int) $data['certificate-of-conduct'],
			$creationTime
		);
		$user = $this->userAccountDb->createUser($user);

		$userDisplayName->setUser($user);
		$this->userDisplayNameDb->update($userDisplayName);

		return $user;
	}

	/**
	 * @param mixed|NULL $id The user ID.
	 * @return \Lookup\Entity\User|NULL
	 */
	public function getById($id)
	{
		if ($id == NULL) {
			return NULL;
		}

		$userDisplayName = $this->userDisplayNameDb->getByUserId($id);

		$locationId = $this->userAccountDb->getLocationIdForUserId($id);
		$location = $this->locationDb->getById($locationId);

		$userTypeId = $this->userAccountDb->getUserTypeIdForUserId($id);
		$userType = $this->userTypeDb->getById($userTypeId);

		$accountId = $this->userAccountDb->getAccountIdForUserId($id);
		$account = $this->userAccountDb->getAccountById($accountId);

		$user = $this->userAccountDb->getUser($id, $account, $userDisplayName, $userType, $location);

		return $user;
	}

	/**
	 * @param array $data
	 * @return \Lookup\Entity\Account|NULL
	 */
	public function getAccountForCredentials(array $data)
	{
		return $this->userAccountDb->getAccountByEmail($data['email-address']);
	}

	/**
	 * @param \Lookup\Entity\Account $account
	 * @return \Lookup\Entity\User|NULL
	 */
	public function getUserForAccount(Account $account)
	{
		$userId = $this->userAccountDb->getUserIdForAccountId($account->getId());

		$userDisplayName = $this->userDisplayNameDb->getByUserId($userId);

		$locationId = $this->userAccountDb->getLocationIdForUserId($userId);
		$location = $this->locationDb->getById($locationId);

		$userTypeId = $this->userAccountDb->getUserTypeIdForUserId($userId);
		$userType = $this->userTypeDb->getById($userTypeId);

		$user = $this->userAccountDb->getUser($userId, $account, $userDisplayName, $userType, $location);

		return $user;
	}
}
