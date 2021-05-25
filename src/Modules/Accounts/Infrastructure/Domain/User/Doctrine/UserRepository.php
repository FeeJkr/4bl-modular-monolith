<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\User\Doctrine;

use App\Modules\Accounts\Domain\User\Token;
use App\Modules\Accounts\Domain\User\User;
use App\Modules\Accounts\Domain\User\UserRepository as UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

final class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @throws ORMException
     */
    public function store(User $user): void
    {
        $this->getEntityManager()->persist($user);
    }

    public function fetchByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function fetchByToken(Token $token): ?User
    {
        return $this->findOneBy(['token' => $token]);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function existsByEmailOrUsername(string $email, string $username): bool
    {
        $builder = $this->createQueryBuilder('u');
        $builder
            ->where('u.email = :email')
            ->orWhere('u.username = :username')
            ->setParameters([
                'email' => $email,
                'username' => $username,
            ])
            ->select('1');


        return null !== $builder->getQuery()->getOneOrNullResult();
    }
}
