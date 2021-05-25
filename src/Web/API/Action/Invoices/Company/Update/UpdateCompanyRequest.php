<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Update;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

class UpdateCompanyRequest extends Request
{
	public function __construct(
		private string $companyId,
		private string $name,
		private string $identificationNumber,
		private ?string $email,
		private ?string $phoneNumber,
		private string $street,
		private string $zipCode,
		private string $city,
	){}

	public static function fromRequest(ServerRequest $request): self
	{
		$requestData = $request->toArray();
		$id = $request->get('id');
		$name = $requestData['name'] ?? null;
		$identificationNumber = $requestData['identificationNumber'] ?? null;
		$email = $requestData['email'] ?? null;
		$phoneNumber = $requestData['phoneNumber'] ?? null;
		$street = $requestData['street'] ?? null;
		$zipCode = $requestData['zipCode'] ?? null;
		$city = $requestData['city'] ?? null;

		Assert::lazy()
			->that($id, 'id')->notEmpty()->uuid()
			->that($name, 'name')->notEmpty()
			->that($identificationNumber, 'identificationNumber')->notEmpty()
			->that($email, 'email')->nullOr()->email()
			->that($phoneNumber, 'phoneNumber')->nullOr()->startsWith('+')
			->that($street, 'street')->notEmpty()
			->that($zipCode, 'zipCode')->notEmpty()
			->that($city, 'city')->notEmpty()
			->verifyNow();

		return new self(
			$id,
			$name,
			$identificationNumber,
			$email,
			$phoneNumber,
			$street,
			$zipCode,
			$city
		);
	}

	public function getCompanyId(): string
	{
		return $this->companyId;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getIdentificationNumber(): string
	{
		return $this->identificationNumber;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function getPhoneNumber(): ?string
	{
		return $this->phoneNumber;
	}

	public function getStreet(): string
	{
		return $this->street;
	}

	public function getZipCode(): string
	{
		return $this->zipCode;
	}

	public function getCity(): string
	{
		return $this->city;
	}
}