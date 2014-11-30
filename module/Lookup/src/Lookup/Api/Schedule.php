<?php

namespace Lookup\Api;

use Lookup\Db\Schedule as ScheduleDb;
use Lookup\Entity\User as UserEntity;

class Schedule
{
	/**
	 * @var \Lookup\Db\Schedule
	 */
	private $scheduleDb;

	/**
	 * Constructor
	 *
	 * @param \Lookup\Db\Schedule $scheduleDb
	 */
	public function __construct(ScheduleDb $scheduleDb)
	{
		$this->scheduleDb = $scheduleDb;
	}

	public function create(UserEntity $user)
	{
		$schedule = $this->scheduleDb->createSchedule($user);
		$this->scheduleDb->assign($user, $schedule);
		return $schedule;
	}

	/**
	 * @param string $id The user ID.
	 * @return \Lookup\Entity\Schedule The user's schedule.
	 */
	public function getByUserId($id)
	{
		return $this->scheduleDb->getByUserId($id);
	}

	/**
	 * @param string $userId The user ID.
	 * @param array $data
	 * @return \Lookup\Entity\Schedule The updated schedule.
	 */
	public function update($userId, array $data)
	{
		dd($userId, $data);
	}
}
