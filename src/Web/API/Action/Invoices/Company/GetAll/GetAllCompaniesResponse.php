<?php
declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\GetAll;

use App\Modules\Invoices\Application\Company\GetAll\CompaniesCollection;
use App\Web\API\Action\Response;

final class GetAllCompaniesResponse extends Response
{
    public static function respond(CompaniesCollection $companies): self
    {
        return new self($companies->toArray());
    }
}