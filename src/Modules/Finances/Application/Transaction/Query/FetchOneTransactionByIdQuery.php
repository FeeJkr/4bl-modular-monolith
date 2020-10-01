<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\Query;

use App\Common\User\UserId;
use App\Modules\Finances\Domain\Transaction\TransactionId;

final class FetchOneTransactionByIdQuery
{
    private TransactionId $transactionId;
    private UserId $userId;

    public function __construct(TransactionId $transactionId, UserId $userId)
    {
        $this->transactionId = $transactionId;
        $this->userId = $userId;
    }

    public function getTransactionId(): TransactionId
    {
        return $this->transactionId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
