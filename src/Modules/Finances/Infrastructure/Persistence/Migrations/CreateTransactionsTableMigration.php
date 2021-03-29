<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;

final class CreateTransactionsTableMigration
{
    public function getDescription() : string
    {
        return 'Create transactions table';
    }

    public function up(Schema $schema) : void
    {
        $sql = '
            create table transactions
            (
                id serial not null constraint transactions_pk primary key,
                transaction_id int constraint transactions_transactions_id_fk references transactions on delete set null,
                user_id int not null constraint transactions_users_id_fk references users on delete cascade,
                wallet_id int not null constraint transactions_wallets_id_fk references wallets on delete cascade,
                category_id int not null constraint transactions_categories_id_fk references categories on delete cascade,
                type varchar(255) not null,
                amount int not null,
                description text,
                operation_at timestamp not null,
                created_at timestamp default now() not null
            );
        ';
    }

    public function down(Schema $schema) : void
    {
    }
}
