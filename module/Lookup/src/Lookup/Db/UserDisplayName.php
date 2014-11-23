<?php

namespace Lookup\Db;

use Lookup\Entity\UserDisplayName as UserDisplayNameEntity;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Sql\Predicate;

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
}
