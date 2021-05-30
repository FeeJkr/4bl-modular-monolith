<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210430135526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create invoices module tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table company_addresses
            (
                id uuid default gen_random_uuid() not null unique constraint company_addresses_pk primary key,
                street varchar(255) not null,
                zip_code varchar(7) not null,
                city varchar(255) not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ');

        $this->addSql('
            create table companies
            (
                id uuid default gen_random_uuid() not null unique constraint companies_pk primary key,
                user_id uuid not null constraint companies_users_id_fk references users on delete cascade,
                company_address_id uuid not null constraint companies_company_address_id_fk references company_addresses on delete cascade,
                name varchar(255) not null,
                identification_number varchar(30) not null,
                email varchar(255),
                phone_number varchar(30),
                payment_type varchar(255),
                payment_last_date varchar(3),
                bank varchar(255),
                account_number varchar(40),
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ');

        $this->addSql('
            create table invoices
            (
                id uuid default gen_random_uuid() not null unique constraint invoices_pk primary key,
                user_id uuid not null constraint companies_users_id_fk references users on delete cascade,
                seller_company_id uuid not null constraint invoices_seller_companies__fk references companies on delete cascade,
                buyer_company_id uuid not null constraint invoices_buyer_companies__fk references companies on delete cascade,
                invoice_number varchar(255) not null,
                generate_place varchar(255) not null,
                already_taken_price float default 0 not null,
                currency_code varchar(255),
                generated_at timestamp not null,
                sold_at timestamp not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ');

        $this->addSql('
            create table invoice_products
            (
                id uuid default gen_random_uuid() not null unique constraint invoice_products_pk primary key,
                invoice_id uuid not null constraint invoice_products_invoices_id_fk references invoices on delete cascade,
                position int not null,
                name text not null,
                price float not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
