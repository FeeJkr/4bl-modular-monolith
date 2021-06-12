<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\GetUserByToken;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Accounts\Application\User\ApplicationException;
use App\Modules\Accounts\Domain\User\Token;
use App\Modules\Accounts\Domain\User\UserException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception as DriverException;
use Doctrine\DBAL\Exception;

final class GetUserByTokenHandler implements QueryHandler
{
    public function __construct(private Connection $connection) {}

    /**
     * @throws ApplicationException
     */
    public function __invoke(GetUserByTokenQuery $query): UserDTO
    {
        try {
            $row = $this->connection->createQueryBuilder()
                ->select(['id', 'email', 'username', 'token'])
                ->from('users')
                ->where('token = :token')
                ->setParameter('token', $query->getToken())
                ->execute()
                ->fetchAssociative();

            if ($row === false || empty($row)) {
                throw ApplicationException::fromDomainException(
                    UserException::notFoundByToken(new Token($query->getToken()))
                );
            }

            return new UserDTO(
                $row['id'],
                $row['email'],
                $row['username'],
                $row['token'],
            );
        } catch (Exception|DriverException) {
            throw ApplicationException::internalError();
        }
    }
}
