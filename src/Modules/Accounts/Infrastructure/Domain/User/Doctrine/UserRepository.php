<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\User\Doctrine;

use App\Modules\Accounts\Domain\User\Token;
use App\Modules\Accounts\Domain\User\User;
use App\Modules\Accounts\Domain\User\UserException;
use App\Modules\Accounts\Domain\User\UserRepository as UserRepositoryInterface;
use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class UserRepository implements UserRepositoryInterface
{
    public function __construct(private Connection $connection) {}

    /**
     * @throws Exception
     */
    public function store(User $user): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->insert('users')
            ->values([
                'id' => ':id',
                'email' => ':email',
                'username' => ':username',
                'password' => ':password',
                'token' => ':token',
            ])
            ->setParameters([
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'username' => $user->getUsername(),
                'password' => $user->getPassword(),
                'token' => $user->getToken()->toString(),
            ])
            ->execute();
    }

    /**
     * @throws Exception
     */
    public function save(User $user): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->update('users')
            ->set('email', ':email')
            ->set('username', ':username')
            ->set('password', ':password')
            ->set('token', ':token')
            ->set('updated_at', ':updatedAt')
            ->where('id = :id')
            ->setParameters([
                'id' => $user->getId()->toString(),
                'email' => $user->getEmail(),
                'username' => $user->getUsername(),
                'password' => $user->getPassword(),
                'token' => $user->getToken()->toString(),
                'updatedAt' => (new DateTime)->format('Y-m-d H:i:s'),
            ])
            ->execute();
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function fetchByEmail(string $email): ?User
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $row = $queryBuilder->select([
            'id',
            'email',
            'username',
            'password',
            'token'
        ])
            ->from('users')
            ->where('email = :email')
            ->setParameter('email', $email)
            ->execute()
            ->fetchAssociative();

        if ($row === false) {
            return null;
        }

        return User::fromRow($row);
    }

    /**
     * @throws UserException
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function fetchByToken(Token $token): User
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $row = $queryBuilder->select([
            'id',
            'email',
            'username',
            'password',
            'token'
        ])
            ->from('users')
            ->where('token = :token')
            ->setParameter('token', $token->toString())
            ->execute()
            ->fetchAssociative();

        if ($row === false) {
            throw UserException::notFoundByToken($token);
        }

        return User::fromRow($row);
    }

    /**
     * @throws Exception
     */
    public function existsByEmailOrUsername(string $email, string $username): bool
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $count = $queryBuilder
            ->select(['id'])
            ->from('users')
            ->where('email = :email')
            ->orWhere('username = :username')
            ->setParameters([
                'email' => $email,
                'username' => $username,
            ])
            ->execute()
            ->rowCount();

        return $count > 0;
    }
}
