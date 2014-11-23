<?php

namespace Lookup\Db;

use Lookup\Entity\Account as AccountEntity;
use Lookup\Entity\User as UserEntity;
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
}
