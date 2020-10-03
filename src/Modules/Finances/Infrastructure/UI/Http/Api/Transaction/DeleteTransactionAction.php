<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Transaction;

use App\Modules\Finances\Application\Transaction\Delete\DeleteTransactionCommand;
use App\Modules\Finances\Domain\Transaction\TransactionId;
use App\Modules\Finances\Domain\User\UserId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class DeleteTransactionAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->bus->dispatch(
            new DeleteTransactionCommand(
                TransactionId::fromInt((int) $request->get('id')),
                UserId::fromInt($request->get('user_id'))
            )
        );

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
