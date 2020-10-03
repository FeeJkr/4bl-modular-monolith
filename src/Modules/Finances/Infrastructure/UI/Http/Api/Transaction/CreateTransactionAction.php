<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Transaction;

use App\Modules\Finances\Application\Transaction\Create\CreateTransactionCommand;
use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\Transaction\TransactionType;
use App\Modules\Finances\Domain\Wallet\WalletId;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class CreateTransactionAction extends AbstractController
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->bus->dispatch(
            new CreateTransactionCommand(
                $request->get('user_id'),
                WalletId::fromInt((int) $request->get('wallet_id')),
                $request->get('linked_wallet_id') === null
                    ? WalletId::nullInstance()
                    : WalletId::fromInt((int) $request->get('linked_wallet_id')),
                CategoryId::fromInt((int) $request->get('category_id')),
                new TransactionType($request->get('transaction_type')),
                new Money((int) $request->get('amount')),
                $request->get('description'),
                (new DateTime)->setTimestamp((int) $request->get('operation_at'))
            )
        );

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
