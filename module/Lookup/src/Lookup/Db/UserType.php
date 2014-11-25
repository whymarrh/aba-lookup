<?php

namespace Lookup\Db;

use Lookup\Entity\UserType as UserTypeEntity;
use Zend\Db\Sql\Sql;

class UserType
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

	/**
	 * @param int $id The user type ID.
	 * @return \Lookup\Entity\UserType|NULL The user type for the given ID.
	 */
	public function getById($id)
	{
		$select = $this->sql->select();
		$select->from(UserTypeEntity::TABLE_NAME)->where(array(
			'id' => $id,
		));
		$statement = $this->sql->prepareStatementForSqlObject($select);
		$results = $statement->execute();

		if ($results->count() == 0) {
			return NULL;
		}

		$row = $results->current();
		$userType = new UserTypeEntity($row['name']);
		$userType->setId((int) $row['id']);
		return $userType;
	}

	/**
	 * Returns the user type that matches the given user type.
	 *
	 * @param \Lookup\Entity\UserType $userType
	 * @return \Lookup\Entity\UserType|NULL
	 */
	public function get(UserTypeEntity $userType)
	{
		$select = $this->sql->select();
		$select->from(UserTypeEntity::TABLE_NAME)->where(array(
			'name' => $userType->getName(),
		));
		$statement = $this->sql->prepareStatementForSqlObject($select);
		$results = $statement->execute();

		if ($results->count() == 0) {
			return NULL;
		}

		$row = $results->current();
		$result = clone $userType;
		$result->setId((int) $row['id']);
		return $result;
	}
}
