<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;

final class CreateCategoriesTableMigration
{
    public function getDescription() : string
    {
        return 'Create categories table';
    }

    public function up(Schema $schema) : void
    {
        $sql = "
            create table categories
            (
                id serial not null constraint categories_pk primary key,
                user_id int not null constraint categories_users_id_fk references users on delete cascade,
                name varchar(255) not null,
                type varchar(255) not null,
                icon varchar(255) default 'home' not null,
                created_at timestamp default now() not null
            );
        ";
    }

    public function down(Schema $schema) : void
    {
        // implement down method
    }
}
