<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Persistence\Doctrine\Mapping\Company;

use App\Modules\Invoices\Domain\Company\CompanyId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use JetBrains\PhpStorm\Pure;

final class CompanyIdType extends GuidType
{
    private const Uuid = 'uuid';

    #[Pure]
    public function convertToPHPValue($value, AbstractPlatform $platform): CompanyId
    {
        return CompanyId::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->toString();
    }

    public function getName(): string
    {
        return self::Uuid;
    }
}