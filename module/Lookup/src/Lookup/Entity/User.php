<?php

namespace Lookup\Entity;

class User
{
	use Uuid;

	const TABLE_NAME = 'user';

	/**
	 * The account for this user
	 *
	 * @var Account
	 */
	private $account;

	/**
	 * The display name for user
	 *
	 * @var UserDisplayName
	 */
	private $displayName;

	/**
	 * The user type
	 *
	 * @var UserType
	 */
	private $userType;

	/**
	 * The user location
	 *
	 * @var Location
	 */
	private $location;

	/**
	 * The gender of the user
	 *
	 * @var string|NULL
	 */
	private $gender;

	/**
	 * The user's phone number
	 *
	 * @var string|NULL
	 */
	private $phoneNumber;

	/**
	 * Whether the user has completed their course
	 *
	 * @var bool
	 */
	private $abaCourse;

	/**
	 * The date on which the user last recieved their Certificate of Conduct
	 *
	 * @var int|NULL
	 */
	private $certificateOfConduct;

	/**
	 * The time at which this user was created
	 *
	 * @var int
	 */
	private $creationTime;

	/**
	 * Constructor
	 *
	 * @param Account $account The account for this user.
	 * @param UserDisplayName $displayName The display name for the user.
	 * @param UserType $userType The type of the user.
	 * @param Location $location The location of the user.
	 * @param string|NULL $gender The gender of the user.
	 * @param string|NULL $phoneNumber The phone number for the user.
	 * @param bool $abaCourse Whether the user has completed the ABA training course.
	 * @param int|NULL $certificateOfConduct The date on which the user last recieved their Certificate of Conduct.
	 * @param int $creationTime The time at which the user was created.
	 * @throws Exception\InvalidArgumentException
	 */
	public function __construct(Account $account, UserDisplayName $displayName, UserType $userType, Location $location, $gender, $phoneNumber, $abaCourse, $certificateOfConduct, $creationTime)
	{
		$this->setAccount($account);
		$this->setDisplayName($displayName);
		$this->setUserType($userType);
		$this->setLocation($location);
		$this->setGender($gender);
		$this->setPhoneNumber($phoneNumber);
		$this->setAbaCourse($abaCourse);
		$this->setCertificateOfConduct($certificateOfConduct);
		$this->setCreationTime($creationTime);
	}

	/**
	 * @param Account $account The account for the user.
	 * @return self
	 */
	public final function setAccount(Account $account)
	{
		$this->account = $account;
		return $this;
	}

	/**
	 * @param UserDisplayName $displayName The display name for the user.
	 * @return self
	 */
	public final function setDisplayName(UserDisplayName $displayName)
	{
		$this->displayName = $displayName;
		return $this;
	}

	/**
	 * @param UserType $userType The user type object.
	 * @return self
	 */
	public final function setUserType(UserType $userType)
	{
		$this->userType = $userType;
		return $this;
	}

	/**
	 * @param Location $location The user's location.
	 * @return self
	 */
	public final function setLocation(Location $location)
	{
		$this->location = $location;
		return $this;
	}

	/**
	 * @param string|NULL $gender The user's gender.
	 * @throws Exception\InvalidArgumentException If the argument type does not fit.
	 * @return self
	 */
	public final function setGender($gender)
	{
		if (!is_string($gender) && !is_null($gender)) {
			throw new Exception\InvalidArgumentException(sprintf(
				'%s expects a string or NULL value.',
				__METHOD__
			));
		}
		$this->gender = $gender;
		return $this;
	}

	/**
	 * @param string|NULL $phoneNumber The user's phone number.
	 * @throws Exception\InvalidArgumentException If the argument type does not fit.
	 * @return self
	 */
	public final function setPhoneNumber($phoneNumber)
	{
		if (!is_string($phoneNumber) && !is_null($phoneNumber)) {
			throw new Exception\InvalidArgumentException(sprintf(
				'%s expects a string or NULL.',
				__METHOD__
			));
		}
		$this->phoneNumber = $phoneNumber;
		return $this;
	}

	/**
	 * @param bool $abaCourse Whether the user has the course completed.
	 * @throws Exception\InvalidArgumentException If the argument type does not fit.
	 * @return self
	 */
	public final function setAbaCourse($abaCourse)
	{
		if (!is_bool($abaCourse)) {
			throw new Exception\InvalidArgumentException(sprintf(
				'%s expects a bool value.',
				__METHOD__
			));
		}
		$this->abaCourse = $abaCourse;
		return $this;
	}

	/**
	 * @param int|NULL $certificateOfConduct Whether the user has their Certificate of Conduct.
	 * @throws Exception\InvalidArgumentException If the argument type does not fit.
	 * @return self
	 */
	public final function setCertificateOfConduct($certificateOfConduct)
	{
		if (!is_int($certificateOfConduct) && !is_null($certificateOfConduct)) {
			throw new Exception\InvalidArgumentException(sprintf(
				'%s expects an int or NULL value.',
				__METHOD__
			));
		}
		$this->certificateOfConduct = $certificateOfConduct;
		return $this;
	}

	/**
	 * @param int $creationTime The time at which the user was created.
	 * @throws Exception\InvalidArgumentException If the argument type does not fit.
	 * @return self
	 */
	public final function setCreationTime($creationTime)
	{
		if (!is_int($creationTime)) {
			throw new Exception\InvalidArgumentException(sprintf(
				'%s expects an int.',
				__METHOD__
			));
		}
		$this->creationTime = $creationTime;
		return $this;
	}

	/**
	 * @return Account The account for this user.
	 */
	public function getAccount()
	{
		return $this->account;
	}

	/**
	 * @return UserDisplayName The display name object.
	 */
	public function getDisplayName()
	{
		return $this->displayName;
	}

	/**
	 * @return UserType The user type object.
	 */
	public function getUserType()
	{
		return $this->userType;
	}

	/**
	 * @return Location The user location.
	 */
	public function getLocation()
	{
		return $this->location;
	}

	/**
	 * @return string|NULL The gender of the user.
	 */
	public function getGender()
	{
		return $this->gender;
	}

	/**
	 * @return string|NULL The user's phone number.
	 */
	public function getPhoneNumber()
	{
		return $this->phoneNumber;
	}

	/**
	 * @return bool|NULL Whether the user has their ABA course.
	 */
	public function isAbaCourse()
	{
		return $this->abaCourse;
	}

	/**
	 * @return int|NULL The date on which the user last recieved their Certificate of Conduct.
	 */
	public function getCertificateOfConduct()
	{
		return $this->certificateOfConduct;
	}

	/**
	 * @return int The creation time of the user.
	 */
	public function getCreationTime()
	{
		return $this->creationTime;
	}
}
