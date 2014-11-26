<?php

namespace Lookup\Db;

use Lookup\Entity\Account as AccountEntity;
use Lookup\Entity\Location as LocationEntity;
use Lookup\Entity\User as UserEntity;
use Lookup\Entity\UserDisplayName as UserDisplayNameEntity;
use Lookup\Entity\UserType as UserTypeEntity;
use Rhumsaa\Uuid\Uuid;
use Zend\Db\Sql\Sql;

class UserAccount
{
	/**
	 * @var \Zend\Db\Sql\Sql
	 */
	private $sql;

	/**
	 * @param \Zend\Db\Sql\Sql $sql
	 */
	public function __construct(Sql $sql)
	{
		$this->sql = $sql;
	}

	public function createAccount(AccountEntity $account)
	{
		$uuid = Uuid::uuid4()->toString();

		$insert = $this->sql->insert();
		$insert->into(AccountEntity::TABLE_NAME)->values(array(
			'id' => $uuid,
			'password' => $account->getPassword(),
			'password_reset_code' => $account->getPasswordResetCode(),
			'email' => $account->getEmail(),
			'email_confirmed' => $account->isEmailConfirmed(),
			'email_confirm_code' => $account->getEmailConfirmCode(),
			'access_level' => $account->getAccessLevel(),
			'terms_of_service' => $account->getTermsOfService(),
			'creation_time' => $account->getCreationTime(),
		));

		$statement = $this->sql->prepareStatementForSqlObject($insert);
		$sqlResult = $statement->execute();
		$newAccount = clone $account;
		$newAccount->setId($uuid);
		return $newAccount;
	}

	public function createUser(UserEntity $user)
	{
		$uuid = Uuid::uuid4()->toString();

		$insert = $this->sql->insert();
		$insert->into(UserEntity::TABLE_NAME)->values(array(
			'id' => $uuid,
			'account_id' => $user->getAccount()->getId(),
			'user_display_name_id' => $user->getDisplayName()->getId(),
			'user_type_id' => $user->getUserType()->getId(),
			'location_id' => $user->getLocation()->getId(),
			'gender' => $user->getGender(),
			'phone_number' => $user->getPhoneNumber(),
			'aba_course' => $user->isAbaCourse(),
			'certificate_of_conduct' => $user->getCertificateOfConduct(),
			'creation_time' => $user->getCreationTime(),
		));

		$statement = $this->sql->prepareStatementForSqlObject($insert);
		$sqlResult = $statement->execute();
		$newUser = clone $user;
		$newUser->setId($uuid);
		return $newUser;
	}

	/**
	 * @param string $email The account email address.
	 * @return \Lookup\Entity\Account|NULL The account for the given email address.
	 */
	public function getAccountByEmail($email)
	{
		$select = $this->sql->select();
		$select->from(AccountEntity::TABLE_NAME)->where(array(
			'email' => $email,
		));
		$statement = $this->sql->prepareStatementForSqlObject($select);
		$results = $statement->execute();

		if ($results->count() == 0) {
			return NULL;
		}

		$row = $results->current();
		$account = new AccountEntity(
			$row['password'],
			$row['password_reset_code'],
			$row['email'],
			(bool) $row['email_confirmed'],
			$row['email_confirm_code'],
			(int) $row['access_level'],
			(int) $row['terms_of_service'],
			(int) $row['creation_time']
		);
		$account->setId($row['id']);
		return $account;
	}

	/**
	 * @param string $id The user ID.
	 * @return string|NULL The account ID for the given user ID.
	 */
	public function getAccountIdForUserId($id)
	{
		$select = $this->sql->select();
		$select->from(UserEntity::TABLE_NAME)->where(array(
			'id' => $id,
		));
		$statement = $this->sql->prepareStatementForSqlObject($select);
		$results = $statement->execute();

		if ($results->count() == 0) {
			return NULL;
		}

		$row = $results->current();
		return $row['account_id'];
	}

	/**
	 * @param string $id The account ID.
	 * @return \Lookup\Entity\Account|NULL The account for the ID.
	 */
	public function getAccountById($id)
	{
		$select = $this->sql->select();
		$select->from(AccountEntity::TABLE_NAME)->where(array(
			'id' => $id,
		));
		$statement = $this->sql->prepareStatementForSqlObject($select);
		$results = $statement->execute();

		if ($results->count() == 0) {
			return NULL;
		}

		$row = $results->current();
		$account = new AccountEntity(
			$row['password'],
			$row['password_reset_code'],
			$row['email'],
			(bool) $row['email_confirmed'],
			$row['email_confirm_code'],
			(int) $row['access_level'],
			(int) $row['terms_of_service'],
			(int) $row['creation_time']
		);
		$account->setId($row['id']);
		return $account;
	}

	/**
	 * @param string $id A user ID.
	 * @return int|NULL The ID of the user type for the user.
	 */
	public function getUserTypeIdForUserId($id)
	{
		$select = $this->sql->select();
		$select->from(UserEntity::TABLE_NAME)->where(array(
			'id' => $id,
		));
		$statement = $this->sql->prepareStatementForSqlObject($select);
		$results = $statement->execute();

		if ($results->count() == 0) {
			return NULL;
		}

		$row = $results->current();
		return (int) $row['user_type_id'];
	}

	/**
	 * @param string $id The user ID.
	 * @return int|NULL The ID of the location for the user.
	 */
	public function getLocationIdForUserId($id)
	{
		$select = $this->sql->select();
		$select->from(UserEntity::TABLE_NAME)->where(array(
			'id' => $id,
		));
		$statement = $this->sql->prepareStatementForSqlObject($select);
		$results = $statement->execute();

		if ($results->count() == 0) {
			return NULL;
		}

		$row = $results->current();
		return (int) $row['location_id'];
	}

	public function getUserIdForAccountId($id)
	{
		$select = $this->sql->select();
		$select->from(UserEntity::TABLE_NAME)->where(array(
			'account_id' => $id,
		));
		$statement = $this->sql->prepareStatementForSqlObject($select);
		$results = $statement->execute();

		if ($results->count() == 0) {
			return NULL;
		}

		$row = $results->current();
		return $row['id'];
	}

	/**
	 * Returns the user for the given ID, populated with given account, display name,
	 * user type, and location.
	 *
	 * @param string $id A user ID.
	 * @param \Lookup\Entity\Account $account The account for this user.
	 * @param \Lookup\Entity\UserDisplayName $userDisplayName The display name for this user.
	 * @param \Lookup\Entity\UserType $userType The type of the user.
	 * @param \Lookup\Entity\Location $location The location of the user.
	 * @return \Lookup\Entity\User|NULL The user with the given ID.
	 */
	public function getUser($id, AccountEntity $account, UserDisplayNameEntity $userDisplayName, UserTypeEntity $userType, LocationEntity $location)
	{
		$select = $this->sql->select();
		$select->from(UserEntity::TABLE_NAME)->where(array(
			'id' => $id,
		));
		$statement = $this->sql->prepareStatementForSqlObject($select);
		$results = $statement->execute();

		if ($results->count() == 0) {
			return NULL;
		}

		$row = $results->current();
		$user = new UserEntity(
			$account,
			$userDisplayName,
			$userType,
			$location,
			$row['gender'],
			$row['phone_number'],
			(bool) $row['aba_course'],
			(int) $row['certificate_of_conduct'],
			(int) $row['creation_time']
		);
		$user->setId($row['id']);
		return $user;
	}
}
