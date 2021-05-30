<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Persistence\Doctrine\Mapping\Invoice;

use App\Modules\Invoices\Domain\Invoice\InvoiceId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use JetBrains\PhpStorm\Pure;

final class InvoiceIdType extends GuidType
{
    private const Uuid = 'uuid';

    #[Pure]
    public function convertToPHPValue($value, AbstractPlatform $platform): InvoiceId
    {
        return InvoiceId::fromString($value);
    }

    #[Pure]
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof InvoiceId) {
            return $value->toString();
        }

        return $value;
    }

    public function getName(): string
    {
        return self::Uuid;
    }
}