<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;

final class CreateCompaniesTableMigration
{
    public function getDescription() : string
    {
        return 'Create companies table';
    }

    public function up(Schema $schema) : void
    {
        $sql = '
            create table companies
            (
                id serial not null constraint companies_pk primary key,
                user_id int not null constraint companies_users_id_fk references users on delete cascade,
                company_address_id int not null constraint companies_company_address_id_fk references company_addresses on delete cascade,
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
        ';
    }

    public function down(Schema $schema) : void
    {
    }
}
