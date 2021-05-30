<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Persistence\Doctrine\Mapping\Invoice;

use App\Modules\Invoices\Domain\Invoice\InvoiceProductId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use JetBrains\PhpStorm\Pure;

final class InvoiceProductIdType extends GuidType
{
    private const Uuid = 'uuid';

    #[Pure]
    public function convertToPHPValue($value, AbstractPlatform $platform): InvoiceProductId
    {
        return InvoiceProductId::fromString($value);
    }

    #[Pure]
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->toString();
    }

    public function getName(): string
    {
        return self::Uuid;
    }
}