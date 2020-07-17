<?php
declare(strict_types=1);

namespace App\UI\Web\Controller;

use App\Application\Wallet\Command\CreateNewWalletCommand;
use App\Application\Wallet\WalletService;
use App\ReadModel\Wallet\Query\FetchAllQuery;
use App\ReadModel\Wallet\Query\FetchOneByIdQuery;
use App\ReadModel\Wallet\WalletReadModel;
use App\ReadModel\Wallet\WalletReadModelException;
use App\SharedKernel\Money;
use App\SharedKernel\Wallet\WalletId;
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
}
