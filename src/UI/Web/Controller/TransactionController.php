<?php
declare(strict_types=1);

namespace App\UI\Web\Controller;

use App\ReadModel\Transaction\Query\FetchAllByWalletQuery;
use App\ReadModel\Transaction\Query\FetchAllQuery;
use App\ReadModel\Transaction\Query\FetchOneByIdQuery;
use App\ReadModel\Transaction\TransactionReadModel;
use App\ReadModel\Transaction\TransactionReadModelException;
use App\SharedKernel\Transaction\TransactionId;
use App\SharedKernel\Wallet\WalletId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class TransactionController extends AbstractController
{
    private $transactionReadModel;

    public function __construct(TransactionReadModel $transactionReadModel)
    {
        $this->transactionReadModel = $transactionReadModel;
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
}
