<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Invoice;

use JetBrains\PhpStorm\Pure;

class Invoice
{
    public function __construct(
        private InvoiceId $id,
        private string $html,
        private string $token,
    ){}

    #[Pure]
    public static function create(string $html, string $token): self
    {
        return new self(
            InvoiceId::nullInstance(),
            $html,
            $token
        );
    }

    public function getId(): InvoiceId
    {
        return $this->id;
    }

    public function setId(InvoiceId $id): void
    {
        $this->id = $id;
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