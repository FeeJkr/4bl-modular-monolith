<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Messenger;

use Doctrine\DBAL\Connection;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Throwable;

class DatabaseTransactionMiddleware implements MiddlewareInterface
{
    public function __construct(private Connection $connection){}

    /**
     * @throws Throwable
     */
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        try {
            $this->connection->beginTransaction();

            $envelope = $stack->next()->handle($envelope, $stack);

            $this->connection->commit();

            return $envelope;
        } catch (Throwable $exception) {
            $this->connection->rollBack();

            throw $exception;
        }
    }
}