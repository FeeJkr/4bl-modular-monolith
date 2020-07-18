<?php
declare(strict_types=1);

namespace App\UI\Web\Controller;

use App\Application\Wallet\Command\CreateNewWalletCommand;
use App\Application\Wallet\Command\DeleteWalletCommand;
use App\Application\Wallet\Command\UpdateWalletCommand;
use App\Application\Wallet\WalletService;
use App\ReadModel\Wallet\Query\FetchAllQuery;
use App\ReadModel\Wallet\Query\FetchOneByIdQuery;
use App\ReadModel\Wallet\WalletReadModel;
use App\ReadModel\Wallet\WalletReadModelException;
use App\SharedKernel\Money;
use App\SharedKernel\User\UserId;
use App\SharedKernel\Wallet\WalletId;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class WalletController extends AbstractController
{
    private $walletReadModel;
    private $walletService;

    public function __construct(WalletReadModel $walletReadModel, WalletService $walletService)
    {
        $this->walletReadModel = $walletReadModel;
        $this->walletService = $walletService;
    }

    public function fetchAll(Request $request): Response
    {
        return $this->json(
            $this->walletReadModel->fetchAll(
                new FetchAllQuery($request->get('user_id'))
            )->toArray()
        );
    }

    public function fetchOneById(Request $request): Response
    {
        try {
            return $this->json(
                $this->walletReadModel->fetchOneById(
                    new FetchOneByIdQuery(
                        WalletId::fromInt((int) $request->get('id')),
                        $request->get('user_id')
                    )
                )
            );
        } catch (WalletReadModelException $exception) {
            return $this->json(['error' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function create(Request $request): Response
    {
        $this->walletService->createNewWallet(
            new CreateNewWalletCommand(
                $request->get('wallet_name'),
                new Money((int) $request->get('wallet_start_balance')),
                $request->get('user_id')
            )
        );

        return $this->json([], Response::HTTP_NO_CONTENT);
    }

    public function delete(Request $request): Response
    {
        $this->walletService->deleteWallet(
            new DeleteWalletCommand(
                WalletId::fromInt((int) $request->get('id')),
                $request->get('user_id')
            )
        );

        return $this->json([], Response::HTTP_NO_CONTENT);
    }

    public function update(Request $request): Response
    {
        $userIds = (new ArrayCollection(explode(', ', $request->get('wallet_user_ids'))))
            ->map(static function (string $id): UserId { return UserId::fromInt((int) $id); });

        $userIds->add($request->get('user_id'));

        $this->walletService->updateWallet(
            new UpdateWalletCommand(
                WalletId::fromInt((int) $request->get('id')),
                $request->get('user_id'),
                $request->get('wallet_name'),
                new Money((int) $request->get('wallet_start_balance')),
                $userIds
            )
        );

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
