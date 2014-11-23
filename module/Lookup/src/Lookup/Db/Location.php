<?php

namespace Lookup\Db;

use Lookup\Entity\Location as LocationEntity;
use Zend\Db\Adapter\Exception\InvalidQueryException;
use Zend\Db\Sql\Sql;

class Location
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

	public function get(LocationEntity $location)
	{
		$select = $this->sql->select();
		$select->from(LocationEntity::TABLE_NAME)->where(array(
			'city' => $location->getCity(),
			'postal_code' => $location->getPostalCode(),
		));
		$statement = $this->sql->prepareStatementForSqlObject($select);
		$results = $statement->execute();

		if ($results->count() == 0) {
			return NULL;
		}

		$row = $results->current();
		$result = clone $location;
		$result->setId((int) $row['id']);
		return $result;
	}

	/**
	 * @param \Lookup\Entity\Location $location
	 * @return \Lookup\Entity\Location
	 * @throws \Zend\Db\Adapter\Exception\InvalidQueryException
	 */
	public function create(LocationEntity $location)
	{
		$insert = $this->sql->insert();
		$insert->into(LocationEntity::TABLE_NAME)->values(array(
			'city' => $location->getCity(),
			'postal_code' => $location->getPostalCode(),
		));
		$statement = $this->sql->prepareStatementForSqlObject($insert);
		$sqlResult = $statement->execute();
		$lastInsertRowId = $sqlResult->getGeneratedValue();
		$newLocation = clone $location;
		$newLocation->setId((int) $lastInsertRowId);
		return $newLocation;
	}

	/**
	 * @param \Lookup\Entity\Location $location
	 * @return \Lookup\Entity\Location
	 */
	public function getOrCreate(LocationEntity $location)
	{
		$result = $this->get($location);
		if ($result == NULL) {
			$result = $this->create($location);
		}
		return $result;
	}
}
