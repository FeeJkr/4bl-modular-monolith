<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\User\Doctrine;

use App\Modules\Accounts\Domain\User\Token;
use App\Modules\Accounts\Domain\User\User;
use App\Modules\Accounts\Domain\User\UserException;
use App\Modules\Accounts\Domain\User\UserId;
use App\Modules\Accounts\Domain\User\UserRepository as UserRepositoryInterface;
use DateTime;
use Doctrine\DBAL\Connection;

final class UserRepository implements UserRepositoryInterface
{
    public function __construct(private Connection $db) {}

    public function store(User $user): void
    {
        $this->db->executeQuery(
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
        $this->db->executeQuery("
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
        $data = $this->db->executeQuery("
            SELECT * FROM users WHERE email = :email
        ", [
            'email' => $email,
        ])->fetchAssociative();

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
        $data = $this->db->executeQuery("
            SELECT * FROM users WHERE token = :token
        ", [
            'token' => $token->toString(),
        ])->fetchAssociative();

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
        $data = $this->db->executeQuery("
            SELECT id FROM users WHERE email = :email or username = :username
        ", [
            'email' => $email,
            'username' => $username,
        ])->rowCount();

        return $data > 0;
    }
}
