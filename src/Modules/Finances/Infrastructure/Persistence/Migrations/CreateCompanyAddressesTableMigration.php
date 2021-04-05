<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;

final class CreateCompanyAddressesTableMigration
{
    public function getDescription() : string
    {
        return 'Create company_addresses table';
    }

    public function up(Schema $schema) : void
    {
        $sql = '
            create table company_addresses
            (
                id serial not null constraint company_addresses_pk primary key,
                street varchar(255) not null,
                zip_code varchar(7) not null,
                city varchar(255) not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ';
    }

    public function down(Schema $schema) : void
    {
    }
}
