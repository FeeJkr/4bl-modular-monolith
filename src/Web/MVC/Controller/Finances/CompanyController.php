<?php
declare(strict_types=1);

namespace App\Web\MVC\Controller\Finances;

use App\Modules\Finances\Application\Company\Create\CreateCompanyCommand;
use App\Modules\Finances\Application\Company\Delete\DeleteCompanyCommand;
use App\Modules\Finances\Application\Company\GetAll\CompaniesCollection;
use App\Modules\Finances\Application\Company\GetAll\GetAllCompaniesQuery;
use App\Modules\Finances\Application\Company\GetOneById\CompanyDTO;
use App\Modules\Finances\Application\Company\GetOneById\GetOneCompanyByIdQuery;
use App\Modules\Finances\Application\Company\Update\UpdateCompanyCommand;
use App\Web\MVC\Controller\AbstractController;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

class CompanyController extends AbstractController
{
    public function __construct(private MessageBusInterface $bus){}

    public function showCompaniesPage(): Response
    {
        /** @var CompaniesCollection $companies */
        $companies = $this->bus->dispatch(new GetAllCompaniesQuery())->last(HandledStamp::class)->getResult();

        return $this->render('finances/company/index.html.twig', [
            'companies' => $companies->toArray(),
        ]);
    }

    public function showCreateCompanyPage(): Response
    {
        return $this->render('finances/company/create.html.twig');
    }

    public function showEditCompanyPage(Request $request): Response
    {
        /** @var CompanyDTO $company */
        $company = $this->bus
            ->dispatch(new GetOneCompanyByIdQuery((int) $request->get('id')))
            ->last(HandledStamp::class)
            ->getResult();

        return $this->render('finances/company/edit.html.twig', [
            'company' => $company,
        ]);
    }

    public function createCompany(Request $request): Response
    {
        $name = $request->get('name');
        $identificationNumber = $request->get('identificationNumber');
        $email = $request->get('email');
        $phoneNumber = $request->get('phoneNumber');
        $paymentType = $request->get('paymentType');
        $paymentLastDate = $request->get('paymentLastDate');
        $bank = $request->get('bank');
        $accountNumber = $request->get('accountNumber');
        $street = $request->get('street');
        $zipCode = $request->get('zipCode');
        $city = $request->get('city');

        Assert::lazy()
            ->that($name, 'name')->notEmpty()
            ->that($identificationNumber, 'identificationNumber')->notEmpty()
            ->that($email, 'email')->nullOr()->email()
            ->that($phoneNumber, 'phoneNumber')->nullOr()->startsWith('+')
            ->that($paymentType, 'paymentType')->nullOr()->notEmpty()
            ->that($paymentLastDate, 'paymentLastDate')->nullOr()->numeric()
            ->that($bank, 'bank')->nullOr()->notEmpty()
            ->that($accountNumber, 'accountNumber')->nullOr()->notEmpty()
            ->that($street, 'street')->notEmpty()
            ->that($zipCode, 'zipCode')->notEmpty()
            ->that($city, 'city')->notEmpty()
            ->verifyNow();

        $this->bus->dispatch(
            new CreateCompanyCommand(
                $street,
                $zipCode,
                $city,
                $name,
                $identificationNumber,
                $email,
                $phoneNumber,
                $paymentType,
                $paymentLastDate,
                $bank,
                $accountNumber,
            )
        );

        $this->addFlash('success', 'New company was successfully added.');

        return $this->json(['status' => 'success']);
    }

    public function editCompany(Request $request): Response
    {
        $id = (int) $request->get('id');
        $name = $request->get('name');
        $identificationNumber = $request->get('identificationNumber');
        $email = $request->get('email');
        $phoneNumber = $request->get('phoneNumber');
        $paymentType = $request->get('paymentType');
        $paymentLastDate = $request->get('paymentLastDate');
        $bank = $request->get('bank');
        $accountNumber = $request->get('accountNumber');
        $street = $request->get('street');
        $zipCode = $request->get('zipCode');
        $city = $request->get('city');

        Assert::lazy()
            ->that($id, 'id')->notEmpty()->numeric()
            ->that($name, 'name')->notEmpty()
            ->that($identificationNumber, 'identificationNumber')->notEmpty()
            ->that($email, 'email')->nullOr()->email()
            ->that($phoneNumber, 'phoneNumber')->nullOr()->startsWith('+')
            ->that($paymentType, 'paymentType')->nullOr()->notEmpty()
            ->that($paymentLastDate, 'paymentLastDate')->nullOr()->numeric()
            ->that($bank, 'bank')->nullOr()->notEmpty()
            ->that($accountNumber, 'accountNumber')->nullOr()->notEmpty()
            ->that($street, 'street')->notEmpty()
            ->that($zipCode, 'zipCode')->notEmpty()
            ->that($city, 'city')->notEmpty()
            ->verifyNow();

        $this->bus->dispatch(
            new UpdateCompanyCommand(
                $id,
                $street,
                $zipCode,
                $city,
                $name,
                $identificationNumber,
                $email,
                $phoneNumber,
                $paymentType,
                $paymentLastDate,
                $bank,
                $accountNumber
            )
        );

        $this->addFlash('success', 'Company was successfully updated.');

        return $this->json(['status' => 'success']);
    }

    public function deleteCompany(Request $request): Response
    {
        try {
            $id = (int) $request->get('id');
            $this->bus->dispatch(new DeleteCompanyCommand($id));

            $this->addFlash('success', 'Company was successfully deleted.');

            return $this->json(['status' => 'success']);
        } catch (Throwable $exception) {
            return $this->json(
                [
                    'status' => 'error',
                    'exception' => $exception->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}