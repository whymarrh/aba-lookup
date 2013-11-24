<?php

namespace Lookup\Db;

use PDO;

class User
{
	const TABLE_NAME = 'user';

	/**
	 * Constants for column names
	 *
	 * Prefixed with ':' for use in prepared statements
	 */
	const COLUMN_NAME_ID                     = ':id';
	const COLUMN_NAME_USER_DISPLAY_NAME_ID   = ':user_display_name_id';
	const COLUMN_NAME_USER_TYPE_ID           = ':user_type_id';
	const COLUMN_NAME_LOCATION_ID            = ':location_id';
	const COLUMN_NAME_GENDER                 = ':gender';
	const COLUMN_NAME_PHONE_NUMBER           = ':phone_number';
	const COLUMN_NAME_ABA_COURSE             = ':aba_course';
	const COLUMN_NAME_CERTIFICATE_OF_CONDUCT = ':certificate_of_conduct';
	const COLUMN_NAME_CREATION_TIME          = ':creation_time';

	/**
	 * The PDO connection
	 */
	private $pdo;

	/**
	 * @param PDO $pdo The active PDO connection.
	 */
	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	/**
	 * Inserts the given user into the database
	 *
	 * @param User $user The user to insert into the database.
	 * @return PDOStatement
	 */
	public function insert(User $user)
	{
		$sql = sprintf(
			'INSERT INTO %s VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)',
			self::TABLE_NAME,
			self::COLUMN_NAME_ID,
			self::COLUMN_NAME_USER_DISPLAY_NAME_ID,
			self::COLUMN_NAME_USER_TYPE_ID,
			self::COLUMN_NAME_LOCATION_ID,
			self::COLUMN_NAME_GENDER,
			self::COLUMN_NAME_PHONE_NUMBER,
			self::COLUMN_NAME_ABA_COURSE,
			self::COLUMN_NAME_CERTIFICATE_OF_CONDUCT,
			self::COLUMN_NAME_CREATION_TIME
		);
		$statement = $pdo->prepare($sql);
		$statement->bindParam(self::COLUMN_NAME_ID, $user->getId());
		$statement->bindParam(self::COLUMN_NAME_USER_DISPLAY_NAME_ID, $user->getDisplayName()->getId());
		$statement->bindParam(self::COLUMN_NAME_USER_TYPE_ID, $user->getUserType()->getId());
		$statement->bindParam(self::COLUMN_NAME_LOCATION_ID, $user->getLocation()->getId());
		$statement->bindParam(self::COLUMN_NAME_GENDER, $user->getGender());
		$statement->bindParam(self::COLUMN_NAME_PHONE_NUMBER, $user->getPhoneNumber());
		$statement->bindParam(self::COLUMN_NAME_ABA_COURSE, $user->getAbaCourse());
		$statement->bindParam(self::COLUMN_NAME_CERTIFICATE_OF_CONDUCT, $user->getCertificateOfConduct());
		$statement->bindParam(self::COLUMN_NAME_CREATION_TIME, $user->getCreationTime());
		$successful = $statement->execute();
		if (!$successful) {
			return NULL;
		}
		return $user->getId();
	}

	/**
	 * Query the database for a given user ID
	 *
	 * @param int $id The user ID.
	 * @return PDOStatement The results.
	 */
	public function getById($id)
	{
		$sql = sprintf(
			'SELECT * FROM %s WHERE id = %s',
			self::TABLE_NAME,
			self::COLUMN_NAME_ID
		);
		$statement = $pdo->prepare($sql);
		$statement->bindParam(self::COLUMN_NAME_ID, $id);
		$statement->execute();
		return $statment;
	}

	/**
	 * @param int $id The user ID.
	 * @return PDOStatement
	 */
	public function update($id, array $options)
	{
		$sql = sprintf(
			'UPDATE %s SET %s WHERE id = %s',
			self::TABLE_NAME,
			sprintf(str_repeat()),
			self::COLUMN_NAME_ID
		);
		$statement->bindParam(self::COLUMN_NAME_ID, $id);
		$successful = $statement->execute();
		if (!$successful) {
			// TODO - Throw up
		}
		return $statement;
	}

	public function deleteById($id)
	{
		// TODO
	}
}
