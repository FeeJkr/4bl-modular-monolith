<?php
declare(strict_types=1);

namespace App\DomainModel\Wallet;

interface WalletRepository
{
    public function store(Wallet $wallet): void;
}
