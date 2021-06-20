<?php

declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210619174449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create finances module tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TYPE category_type AS ENUM ('expenses', 'income', 'transfer')");

        $this->addSql("
            create table categories
            (
                id uuid default gen_random_uuid() not null unique constraint categories_pk primary key,
                name varchar(255) not null,
                type category_type not null,
                icon varchar(255) not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ");
    }

    public function down(Schema $schema): void
    {
    }
}
