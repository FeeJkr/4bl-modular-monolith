<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\User\Doctrine;

use App\Modules\Accounts\Domain\User\Token;
use App\Modules\Accounts\Domain\User\User;
use App\Modules\Accounts\Domain\User\UserException;
use App\Modules\Accounts\Domain\User\UserId;
use App\Modules\Accounts\Domain\User\UserRepository as UserRepositoryInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

final class UserRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function store(User $user): void
    {
        $this->entityManager->getConnection()->executeQuery(
            "INSERT INTO users (email, username, password, token, created_at) VALUES (:email, :username, :password, :token, :created_at)",
            [
                'email' => $user->getEmail(),
                'username' => $user->getUsername(),
                'password' => $user->getPassword(),
                'token' => $user->getToken()->toString(),
                'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
            ]
        );
    }

    public function save(User $user): void
    {
        $this->entityManager->getConnection()->executeQuery("
            UPDATE users SET email = :email, username = :username, password = :password, token = :token WHERE id = :id;
        ", [
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'token' => $user->getToken()->toString(),
            'id' => $user->getId()->toInt(),
        ]);
    }

    public function fetchByEmail(string $email): ?User
    {
        $data = $this->entityManager->getConnection()->executeQuery("
            SELECT * FROM users WHERE email = :email
        ", [
            'email' => $email,
        ])->fetch();

        if ($data === false) {
            return null;
        }

        return new User(
            UserId::fromInt($data['id']),
            $data['email'],
            $data['username'],
            $data['password'],
            new Token($data['token'])
        );
    }

    public function fetchByToken(Token $token): User
    {
        $data = $this->entityManager->getConnection()->executeQuery("
            SELECT * FROM users WHERE token = :token
        ", [
            'token' => $token->toString(),
        ])->fetch();

        if ($data === false) {
            throw UserException::notFoundByToken($token);
        }

        return new User(
            UserId::fromInt($data['id']),
            $data['email'],
            $data['username'],
            $data['password'],
            new Token($data['token'])
        );
    }

    public function existsByEmailOrUsername(string $email, string $username): bool
    {
        $data = $this->entityManager->getConnection()->executeQuery("
            SELECT id FROM users WHERE email = :email or username = :username
        ", [
            'email' => $email,
            'username' => $username,
        ])->rowCount();

        return $data > 0;
    }
}
