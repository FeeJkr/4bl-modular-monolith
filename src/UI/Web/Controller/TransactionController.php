<?php
declare(strict_types=1);

namespace App\UI\Web\Controller;

use App\Application\Transaction\Command\CreateNewTransactionCommand;
use App\Application\Transaction\Command\DeleteTransactionCommand;
use App\Application\Transaction\Command\UpdateTransactionCommand;
use App\Application\Transaction\TransactionService;
use App\ReadModel\Transaction\Query\FetchAllByWalletQuery;
use App\ReadModel\Transaction\Query\FetchAllQuery;
use App\ReadModel\Transaction\Query\FetchOneByIdQuery;
use App\ReadModel\Transaction\TransactionReadModel;
use App\ReadModel\Transaction\TransactionReadModelException;
use App\SharedKernel\Category\CategoryId;
use App\SharedKernel\Money;
use App\SharedKernel\Transaction\TransactionId;
use App\SharedKernel\Transaction\TransactionType;
use App\SharedKernel\Wallet\WalletId;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class TransactionController extends AbstractController
{
    private $transactionReadModel;
    private $transactionService;

    public function __construct(TransactionReadModel $transactionReadModel, TransactionService $transactionService)
    {
        $this->transactionReadModel = $transactionReadModel;
        $this->transactionService = $transactionService;
    }

    public function fetchAllByWallet(Request $request): Response
    {
        return $this->json(
            $this->transactionReadModel->fetchAllByWallet(
                new FetchAllByWalletQuery(
                    WalletId::fromInt((int) $request->get('wallet_id')),
                    $request->get('user_id')
                )
            )->toArray()
        );
    }

    public function fetchOneById(Request $request): Response
    {
        try {
            return $this->json(
                $this->transactionReadModel->fetchOneById(
                    new FetchOneByIdQuery(
                        TransactionId::fromInt((int) $request->get('id')),
                        $request->get('user_id')
                    )
                )
            );
        } catch (TransactionReadModelException $exception) {
            return $this->json(['error' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function fetchAll(Request $request): Response
    {
        return $this->json(
            $this->transactionReadModel->fetchAll(
                new FetchAllQuery(
                    $request->get('user_id')
                )
            )->toArray()
        );
    }

    public function create(Request $request): Response
    {
        $this->transactionService->createNew(
            new CreateNewTransactionCommand(
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

    public function update(Request $request): Response
    {
        $this->transactionService->updateTransaction(
            new UpdateTransactionCommand(
                TransactionId::fromInt((int) $request->get('id')),
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

    public function delete(Request $request): Response
    {
        $this->transactionService->deleteTransaction(
            new DeleteTransactionCommand(
                TransactionId::fromInt((int) $request->get('id')),
                $request->get('user_id')
            )
        );

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
