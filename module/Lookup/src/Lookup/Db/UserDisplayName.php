<?php

namespace Lookup\Db;

use Lookup\Entity\UserDisplayName as UserDisplayNameEntity;
use Zend\Db\Sql\Sql;

class UserDisplayName
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

	public function create(UserDisplayNameEntity $userDisplayName)
	{
		$insert = $this->sql->insert();
		$insert->into(UserDisplayNameEntity::TABLE_NAME)->values(array(
			'user_id' => $userDisplayName->getUser(),
			'display_name' => $userDisplayName->getDisplayName(),
			'creation_time' => $userDisplayName->getCreationTime(),
		));

		$statement = $this->sql->prepareStatementForSqlObject($insert);
		$sqlResult = $statement->execute();
		$lastInsertRowId = $sqlResult->getGeneratedValue();
		$newUserDisplayName = clone $userDisplayName;
		$newUserDisplayName->setId((int) $lastInsertRowId);
		return $newUserDisplayName;
	}

	public function update(UserDisplayNameEntity $userDisplayName)
	{
		$update = $this->sql->update(UserDisplayNameEntity::TABLE_NAME);
		$update->set(array(
			'user_id' => $userDisplayName->getUser()->getId(),
			'display_name' => $userDisplayName->getDisplayName(),
			'creation_time' => $userDisplayName->getCreationTime(),
		));
		$update->where->equalTo('id', $userDisplayName->getId());

		$statement = $this->sql->prepareStatementForSqlObject($update);
		$sqlResult = $statement->execute();
		$lastInsertRowId = $sqlResult->getGeneratedValue();
		$newUserDisplayName = clone $userDisplayName;
		$newUserDisplayName->setId((int) $lastInsertRowId);
		return $newUserDisplayName;
	}

	/**
	 * @param string $id The user ID.
	 * @return \Lookup\Entity\UserDisplayName|NULL The display name for the user with the given ID.
	 */
	public function getByUserId($id)
	{
		$select = $this->sql->select();
		$select->from(UserDisplayNameEntity::TABLE_NAME)->where(array(
			'user_id' => $id,
		));
		$statement = $this->sql->prepareStatementForSqlObject($select);
		$results = $statement->execute();

		if ($results->count() == 0) {
			return NULL;
		}

		$row = $results->current();
		$userDisplayName = new UserDisplayNameEntity(NULL, $row['display_name'], (int) $row['creation_time']);
		$userDisplayName->setId((int) $row['id']);
		return $userDisplayName;
	}
}
