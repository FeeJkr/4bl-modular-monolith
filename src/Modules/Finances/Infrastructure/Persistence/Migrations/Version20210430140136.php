<?php

declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210430140136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create finances tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            create table categories
            (
                id uuid default gen_random_uuid() not null unique constraint categories_pk primary key,
                user_id uuid not null constraint categories_users_id_fk references users on delete cascade,
                name varchar(255) not null,
                type varchar(255) not null,
                icon varchar(255) default 'home' not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ");

        $this->addSql('
            create table wallets
            (
                id uuid default gen_random_uuid() not null unique constraint wallets_pk primary key,
                user_id uuid not null constraint wallets_users_id_fk references users on delete cascade,
                name varchar(255) not null,
                start_balance int default 0 not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ');

        $this->addSql('
            create table transactions
            (
                id uuid default gen_random_uuid() not null constraint transactions_pk primary key,
                transaction_id uuid constraint transactions_transactions_id_fk references transactions on delete set null,
                user_id uuid not null constraint transactions_users_id_fk references users on delete cascade,
                wallet_id uuid not null constraint transactions_wallets_id_fk references wallets on delete cascade,
                category_id uuid not null constraint transactions_categories_id_fk references categories on delete cascade,
                type varchar(255) not null,
                amount int not null,
                description text,
                operation_at timestamp not null,
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
