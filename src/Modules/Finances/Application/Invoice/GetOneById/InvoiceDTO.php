<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Invoice\GetOneById;

class InvoiceDTO
{
    public function __construct(
        private int $id,
        private string $html,
        private string $token,
    ){}

    public function getId(): int
    {
        return $this->id;
    }

    public function getHtml(): string
    {
        return $this->html;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}