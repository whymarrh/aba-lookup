<?php

namespace AbaLookup\Form;

use Lookup\Entity\Account;
use Lookup\Entity\User;

class ProfileEditForm extends AbstractBaseForm
{
	/**
	 * @param \Lookup\Entity\User $user
	 */
	public function __construct(User $user)
	{
		parent::__construct();

		$account = $user->getAccount();
		$location = $user->getLocation();
		$userDisplayName = $user->getDisplayName();
		$userType = $user->getUserType();

		// Display name
		$this->add([
			'name' => self::ELEMENT_NAME_DISPLAY_NAME,
			'type' => 'text',
			'attributes' => [
				'id'    => self::ELEMENT_NAME_DISPLAY_NAME,
				'value' => $userDisplayName->getDisplayName(),
			],
			'options' => [
				'label' => 'Your display name'
			],
		]);
		// Email address
		$this->add([
			'name' => self::ELEMENT_NAME_EMAIL_ADDRESS,
			'type' => 'email',
			'attributes' => [
				'id'    => self::ELEMENT_NAME_EMAIL_ADDRESS,
				'value' => $account->getEmail(),
			],
			'options' => [
				'label' => 'Your email address'
			],
		]);
		// Phone number
		$this->add([
			'name' => self::ELEMENT_NAME_PHONE_NUMBER,
			'type' => 'text',
			'attributes' => [
				'id'    => self::ELEMENT_NAME_PHONE_NUMBER,
				'type'  => 'tel',
				'value' => $user->getPhoneNumber(),
			],
			'options' => [
				'label' => 'Your phone number (optional)'
			],
		]);
		// Postal code
		$this->add([
			'name' => self::ELEMENT_NAME_POSTAL_CODE,
			'type' => 'text',
			'attributes' => [
				'id'    => self::ELEMENT_NAME_POSTAL_CODE,
				'value' => $location->getPostalCode(),
			],
			'options' => [
				'label' => 'Postal code (optional)',
			],
		]);
		// Hidden user type field
		$this->add([
			'name' => self::ELEMENT_NAME_USER_TYPE,
			'attributes' => [
				'type'  => 'hidden',
				'value' => $userType->getName(),
			],
		]);

		// Show therapist-only fields?
		if ($userType->getName() === self::USER_TYPE_ABA_THERAPIST) {
			// ABA training course
			$this->add([
				'name' => self::ELEMENT_NAME_ABA_COURSE,
				'type' => 'checkbox',
				'attributes' => [
					'id'      => self::ELEMENT_NAME_ABA_COURSE,
					'checked' => $user->isAbaCourse(),
				],
				'options' => [
					'label'         => 'Completed ABA training course',
					'checked_value' => TRUE,
				],
			]);
			// Certificate of Conduct and its date
			$date = $user->getCertificateOfConduct();
			$this->add([
				'name' => self::ELEMENT_NAME_CERTIFICATE_OF_CONDUCT,
				'type' => 'checkbox',
				'attributes' => [
					'id'      => self::ELEMENT_NAME_CERTIFICATE_OF_CONDUCT,
					'checked' => (bool) $date,
				],
				'options' => [
					'label'         => 'Certificate of Conduct',
					'checked_value' => TRUE,
				],
			]);
			$dateFormElement = [
				'name' => self::ELEMENT_NAME_CERTIFICATE_OF_CONDUCT_DATE,
				'type' => 'text',
				'attributes' => [
					'id'    => self::ELEMENT_NAME_CERTIFICATE_OF_CONDUCT_DATE,
					'type'  => 'date',
					'max'   => date('Y-m-d'), // Today
				],
				'options' => [
					'label' => 'Date on Certificate of Conduct',
				],
			];
			if ($date) {
				$dateFormElement['attributes']['value'] = date('Y-m-d', $date);
			}
			$this->add($dateFormElement);
		}

		// Submit btn
		$this->add([
			'type' => 'submit',
			'name' => 'update',
			'attributes' => [
				'value' => 'Update your information',
			],
		]);
	}
}
