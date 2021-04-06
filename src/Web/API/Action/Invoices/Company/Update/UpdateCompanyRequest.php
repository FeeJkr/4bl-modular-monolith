<?php
declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Update;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

class UpdateCompanyRequest extends Request
{
	public function __construct(
		private int $companyId,
		private string $name,
		private string $identificationNumber,
		private ?string $email,
		private ?string $phoneNumber,
		private string $street,
		private string $zipCode,
		private string $city,
	){}

	public static function createFromServerRequest(ServerRequest $request): self
	{
		$id = (int) $request->get('id');
		$name = $request->get('name');
		$identificationNumber = $request->get('identificationNumber');
		$email = $request->get('email');
		$phoneNumber = $request->get('phoneNumber');
		$street = $request->get('street');
		$zipCode = $request->get('zipCode');
		$city = $request->get('city');

		Assert::lazy()
			->that($id, 'id')->notEmpty()->numeric()
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

	public function getCompanyId(): int
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