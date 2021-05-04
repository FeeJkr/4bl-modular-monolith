<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice;

use DateTime;
use DateTimeInterface;
use JetBrains\PhpStorm\ArrayShape;

class InvoiceDTO
{
    public function __construct(
        private string $id,
        private string $userId,
        private array $seller,
        private array $buyer,
        private string $invoiceNumber,
        private float $alreadyTakenPrice,
        private string $generatePlace,
        private string $currencyCode,
        private string $generatedAt,
        private string $soldAt,
        private array $products
    ){}

    public static function fromRows(array $rows): self
    {
        $row = $rows[0];

        return new self(
            $row['invoice_id'],
            $row['user_id'],
            self::buildCompany($row['seller_id'], $row['seller_name']),
            self::buildCompany($row['buyer_id'], $row['buyer_name']),
            $row['invoice_number'],
            (float) $row['already_taken_price'],
            $row['generate_place'],
            $row['currency_code'],
            DateTime::createFromFormat('Y-m-d H:i:s', $row['generated_at'])->format('d-m-Y'),
            DateTime::createFromFormat('Y-m-d H:i:s', $row['sold_at'])->format('d-m-Y'),
            self::buildProductsFromRows($rows)
        );
    }

    #[ArrayShape(['id' => "string", 'name' => "string"])]
    private static function buildCompany(string $id, string $name): array
    {
        return [
            'id' => $id,
            'name' => $name,
        ];
    }

    private static function buildProductsFromRows(array $rows): array
    {
        return array_map(
            static fn(array $row) => [
                'position' => (int) $row['product_position'],
                'name' => $row['product_name'],
                'price' => (float) $row['product_price'],
            ],
            $rows
        );
    }

    #[ArrayShape([
        'id' => "string",
        'userId' => "string",
        'seller' => [
            "id" => "string",
            "name" => "name",
        ],
        'buyer' => [
            "id" => "string",
            "name" => "name",
        ],
        'invoiceNumber' => "string",
        'alreadyTakenPrice' => "float",
        'generatePlace' => "string",
        'currencyCode' => "string",
        'generatedAt' => "string",
        'soldAt' => "string",
        'products' => [
            [
                "position" => "int",
                "name" => "string",
                "price" => "float",
            ]
        ],
        "totalPrice" => "float",
    ])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'seller' => $this->seller,
            'buyer' => $this->buyer,
            'invoiceNumber' => $this->invoiceNumber,
            'alreadyTakenPrice' => $this->alreadyTakenPrice,
            'generatePlace' => $this->generatePlace,
            'currencyCode' => $this->currencyCode,
            'generatedAt' => $this->generatedAt,
            'soldAt' => $this->soldAt,
            'products' => $this->products,
            'totalNetPrice' => array_sum(
                array_map(static fn(array $product) => $product['price'], $this->products)
            )
        ];
    }
}