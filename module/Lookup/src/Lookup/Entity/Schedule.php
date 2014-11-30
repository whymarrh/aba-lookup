<?php

namespace Lookup\Entity;

class Schedule
{
	use Id;

	const TABLE_NAME = 'schedule';

	/**
	 * The name of the schedule
	 *
	 * @var string|NULL
	 */
	private $name;

	/**
	 * Whether the schedule is active
	 *
	 * @var bool
	 */
	private $enabled;

	/**
	 * The array of available intervals for this schedule.
	 *
	 * @var \Lookup\Entity\ScheduleInterval[]
	 */
	private $intervals;

	/**
	 * Constructor
	 *
	 * @param string $name The name for the schedule.
	 * @param bool $enabled Is the schedule active?
	 * @throws Exception\InvalidArgumentException
	 */
	public function __construct($name, $enabled)
	{
		$this->setEnabled($enabled);
		$this->setName($name);
	}

	/**
	 * @param string|NULL $name The name for the schedule.
	 * @throws Exception\InvalidArgumentException If the name is not a string.
	 * @return self
	 */
	public final function setName($name)
	{
		if (!is_string($name) && !is_null($name)) {
			throw new Exception\InvalidArgumentException(sprintf(
				'%s expects a string or NULL value.',
				__METHOD__
			));
		}
		$this->name = $name;
		return $this;
	}

	/**
	 * @param bool $enabled Whether the schedule should be enabled.
	 * @throws Exception\InvalidArgumentException If not passed a bool value.
	 * @return self
	 */
	public final function setEnabled($enabled)
	{
		if (!is_bool($enabled)) {
			throw new Exception\InvalidArgumentException(sprintf(
				'%s expects a bool value.',
				__METHOD__
			));
		}
		$this->enabled = $enabled;
		return $this;
	}

	/**
	 * @param \Lookup\Entity\ScheduleInterval[] $intervals
	 * @return self
	 */
	public final function setIntervals(array $intervals)
	{
		$this->intervals = $intervals;
		return $this;
	}

	/**
	 * @return string The name for this schedule.
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return bool Whether the schedule is enabled.
	 */
	public function isEnabled()
	{
		return $this->enabled;
	}

	/**
	 * @return \Lookup\Entity\ScheduleInterval[]
	 */
	public function getIntervals()
	{
		return $this->intervals;
	}
}
