<?php
declare(strict_types=1);

namespace App\Web\API\Service\Finances\Transaction;

use App\Modules\Finances\Application\Transaction\Create\CreateTransactionCommand;
use App\Modules\Finances\Application\Transaction\Delete\DeleteTransactionCommand;
use App\Modules\Finances\Application\Transaction\GetAll\GetAllTransactionsQuery;
use App\Modules\Finances\Application\Transaction\GetAll\TransactionsCollection;
use App\Modules\Finances\Application\Transaction\GetAllByWallet\GetAllTransactionsByWalletQuery;
use App\Modules\Finances\Application\Transaction\GetOneById\GetOneTransactionByIdQuery;
use App\Modules\Finances\Application\Transaction\GetOneById\TransactionDTO;
use App\Modules\Finances\Application\Transaction\Update\UpdateTransactionCommand;
use App\Web\API\Request\Finances\Transaction\CreateTransactionRequest;
use App\Web\API\Request\Finances\Transaction\DeleteTransactionRequest;
use App\Web\API\Request\Finances\Transaction\GetAllTransactionsByWalletIdRequest;
use App\Web\API\Request\Finances\Transaction\GetAllTransactionsRequest;
use App\Web\API\Request\Finances\Transaction\GetTransactionByIdRequest;
use App\Web\API\Request\Finances\Transaction\UpdateTransactionRequest;
use App\Web\API\Service\Finances\User\UserService;
use App\Web\API\ViewModel\Finances\Transaction\Transaction;
use App\Web\API\ViewModel\Finances\Transaction\ViewModelMapper;
use DateTime;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class DirectCallTransactionService implements TransactionService
{
    private UserService $userService;
    private MessageBusInterface $bus;
    private ViewModelMapper $viewModelMapper;

    public function __construct(MessageBusInterface $bus, UserService $userService, ViewModelMapper $viewModelMapper)
    {
        $this->bus = $bus;
        $this->userService = $userService;
        $this->viewModelMapper = $viewModelMapper;
    }

    public function createTransaction(CreateTransactionRequest $request): void
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());

        $this->bus->dispatch(
            new CreateTransactionCommand(
                $userId,
                $request->getWalletId(),
                $request->getLinkedWalletId(),
                $request->getCategoryId(),
                $request->getTransactionType(),
                $request->getAmount(),
                $request->getDescription(),
                (new DateTime)->setTimestamp($request->getOperationAt())
            )
        );
    }

    public function deleteTransaction(DeleteTransactionRequest $request): void
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());

        $this->bus->dispatch(
            new DeleteTransactionCommand(
                $request->getTransactionId(),
                $userId
            )
        );
    }

    public function updateTransaction(UpdateTransactionRequest $request): void
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());

        $this->bus->dispatch(
            new UpdateTransactionCommand(
                $request->getTransactionId(),
                $userId,
                $request->getWalletId(),
                $request->getLinkedWalletId(),
                $request->getCategoryId(),
                $request->getTransactionType(),
                $request->getAmount(),
                $request->getDescription(),
                (new DateTime)->setTimestamp($request->getOperationAt())
            )
        );
    }

    public function getAllTransactions(GetAllTransactionsRequest $request): array
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());
        $query = new GetAllTransactionsQuery($userId);

        /** @var TransactionsCollection $result */
        $result = $this->bus->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();

        return $this->viewModelMapper->mapTransactionsCollection($result);
    }

    public function getAllTransactionsByWalletId(GetAllTransactionsByWalletIdRequest $request): array
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());

        $query = new GetAllTransactionsByWalletQuery(
            $request->getWalletId(),
            $userId
        );

        /** @var \App\Modules\Finances\Application\Transaction\GetAllByWallet\TransactionsCollection $result */
        $result = $this->bus->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();

        return $this->viewModelMapper->mapTransactionCollectionByWalletId($result);
    }

    public function getTransactionById(GetTransactionByIdRequest $request): Transaction
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());
        $query = new GetOneTransactionByIdQuery($request->getTransactionId(), $userId);

        /** @var TransactionDTO $result */
        $result = $this->bus->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();

        return $this->viewModelMapper->map($result);
    }
}
