<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Wallet;

use App\Modules\Finances\Application\Wallet\Create\CreateWalletCommand;
use App\Modules\Finances\Domain\Money;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class CreateWalletAction extends AbstractController
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->bus->dispatch(
            new CreateWalletCommand(
                $request->get('wallet_name'),
                new Money((int) $request->get('wallet_start_balance')),
                $request->get('user_id')
            )
        );

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
