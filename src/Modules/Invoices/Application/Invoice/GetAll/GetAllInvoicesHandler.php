<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetAll;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Application\Invoice\InvoiceDTO;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository;
use App\Modules\Invoices\Domain\User\UserContext;
use Doctrine\DBAL\Connection;

class GetAllInvoicesHandler implements QueryHandler
{
    public function __construct(private InvoiceRepository $repository, private UserContext $userContext){}

    public function __invoke(GetAllInvoicesQuery $query): array
    {
        return $this->repository->fetchAll($this->userContext->getUserId());
    }
}