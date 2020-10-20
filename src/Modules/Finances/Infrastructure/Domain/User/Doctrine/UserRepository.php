<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Domain\User\Doctrine;

use App\Modules\Finances\Domain\User\Token;
use App\Modules\Finances\Domain\User\UserException;
use App\Modules\Finances\Domain\User\UserId;
use App\Modules\Finances\Domain\User\UserRepository as UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class UserRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function fetchIdByToken(Token $token): UserId
    {
        $data = $this->entityManager->getConnection()->executeQuery("
            SELECT id FROM users WHERE token = :token
        ", [
            'token' => $token->toString(),
        ])->fetch();

        if ($data === false) {
            throw UserException::notFoundByToken($token);
        }

        return UserId::fromInt($data['id']);
    }
}
