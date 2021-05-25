<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Persistence\Doctrine\Mapping\User;

use App\Modules\Accounts\Domain\User\Token;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use JetBrains\PhpStorm\Pure;

final class TokenType extends StringType
{
    private const TOKEN = 'token';

    #[Pure]
    public function convertToPHPValue($value, AbstractPlatform $platform): Token
    {
        return new Token($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->toString();
    }

    public function getName(): string
    {
        return self::TOKEN;
    }
}