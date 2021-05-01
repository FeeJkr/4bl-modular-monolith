<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\GetAll;

final class CompaniesCollection
{
    public function __construct(private array $companies) {}

    public function toArray(): array
    {
        return array_map(
            static fn (CompanyDTO $company): array => $company->toArray(),
            $this->companies
        );
    }
}
