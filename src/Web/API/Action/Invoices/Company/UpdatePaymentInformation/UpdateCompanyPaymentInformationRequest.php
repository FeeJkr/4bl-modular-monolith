<?php
declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\UpdatePaymentInformation;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

class UpdateCompanyPaymentInformationRequest extends Request
{
	public function __construct(
		private int $id,
		private string $paymentType,
		private int $paymentLastDate,
		private string $bank,
		private string $accountNumber
	){}

	public static function createFromServerRequest(ServerRequest $request): self
	{
		$id = (int) $request->get('id');
		$paymentType = $request->get('paymentType');
		$paymentLastDate = (int) $request->get('paymentLastDate');
		$bank = $request->get('bank');
		$accountNumber = $request->get('accountNumber');

		Assert::lazy()
			->that($id, 'id')->notEmpty()->numeric()
			->that($paymentType, 'paymentType')->notEmpty()
			->that($paymentLastDate, 'paymentLastDate')->notEmpty()->numeric()
			->that($bank, 'bank')->notEmpty()
			->that($accountNumber, 'accountNumber')->notEmpty()
			->verifyNow();

		return new self(
			$id,
			$paymentType,
			$paymentLastDate,
			$bank,
			$accountNumber
		);
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getPaymentType(): string
	{
		return $this->paymentType;
	}

	public function getPaymentLastDate(): int
	{
		return $this->paymentLastDate;
	}

	public function getBank(): string
	{
		return $this->bank;
	}

	public function getAccountNumber(): string
	{
		return $this->accountNumber;
	}
}