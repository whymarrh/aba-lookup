<?php

namespace Lookup\Db;

use Lookup\Entity\Schedule as ScheduleEntity;
use Lookup\Entity\User as UserEntity;
use Rhumsaa\Uuid\Uuid;
use Zend\Db\Sql\Sql;

class Schedule
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

	public function createSchedule()
	{
		$uuid = $uuid = Uuid::uuid4()->toString();

		$insert = $this->sql->insert();
		$insert->into(ScheduleEntity::TABLE_NAME)->values(array(
			'name' => $uuid,
			'enabled' => TRUE,
		));

		$statement = $this->sql->prepareStatementForSqlObject($insert);
		$sqlResult = $statement->execute();
		$lastInsertRowId = $sqlResult->getGeneratedValue();
		$schedule = new ScheduleEntity($uuid, TRUE);
		$schedule->setId((int) $lastInsertRowId);

		return $schedule;
	}

	public function assign(UserEntity $user, ScheduleEntity $schedule)
	{
		$insert = $this->sql->insert();
		$insert->into('user_schedule')->values(array(
			'user_id' => $user->getId(),
			'schedule_id' => $schedule->getId(),
		));
		$statement = $this->sql->prepareStatementForSqlObject($insert);
		$sqlResult = $statement->execute();
	}

	public function getByUserId($id)
	{
		$predicate = array(
			'user_id' => $id,
		);

		$select = $this->sql->select();
		$select->from('user_schedule')
		       ->join('schedule', 'user_schedule.schedule_id = schedule.id')
		       ->where($predicate);
		$statement = $this->sql->prepareStatementForSqlObject($select);
		$results = $statement->execute();

		if ($results->count() == 0) {
			return NULL;
		}

		$row = $results->current();
		$schedule = new ScheduleEntity($row['name'], (bool) $row['enabled']);
		$schedule->setId((int) $row['schedule_id']);
		return $schedule;
	}
}
