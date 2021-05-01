<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210430133511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create users table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table users(
                id uuid default gen_random_uuid() not null unique constraint users_pk primary key,
                email varchar(255) not null,
                username varchar(255) not null,
                password varchar(255) not null,
                token varchar(255) unique default NULL::character varying,
                created_at timestamp(0) default (now()) not null,
                updated_at timestamp
            );
        ');
    }

    public function down(Schema $schema): void
    {
    }
}
