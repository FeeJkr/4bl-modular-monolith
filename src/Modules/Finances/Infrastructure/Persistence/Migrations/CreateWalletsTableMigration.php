<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;

final class CreateWalletsTableMigration
{
    public function getDescription() : string
    {
        return 'Create wallets table';
    }

    public function up(Schema $schema) : void
    {
        $sql = '
            create table wallets
            (
                id serial not null constraint wallets_pk primary key,
                user_id int not null constraint wallets_users_id_fk references users on delete cascade,
                name varchar(255) not null,
                start_balance int default 0 not null,
                created_at timestamp default now() not null
            );
        ';
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('wallets');
    }
}
