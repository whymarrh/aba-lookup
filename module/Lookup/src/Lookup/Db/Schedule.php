<?php

namespace Lookup\Db;

use Lookup\Entity\Schedule as ScheduleEntity;
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
