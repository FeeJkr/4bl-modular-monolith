<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Transaction;

use App\Modules\Finances\Application\Transaction\FetchOneById\FetchOneTransactionByIdQuery;
use App\Modules\Finances\Domain\Transaction\TransactionId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class FetchOneTransactionByIdAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new FetchOneTransactionByIdQuery(
            TransactionId::fromInt((int) $request->get('id')),
            $request->get('user_id')
        );

        $result = $this->bus->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();

        return new JsonResponse($result);
    }
}
