<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;

final class CreateInvoicesTableMigration
{
    public function getDescription() : string
    {
        return 'Create invoices table';
    }

    public function up(Schema $schema) : void
    {
        $sql = '
            create table invoices
            (
                id serial not null constraint invoices_pk primary key,
                user_id int not null constraint companies_users_id_fk references users on delete cascade,
                seller_company_id int not null constraint invoices_seller_companies__fk references companies on delete cascade,
                buyer_company_id int not null constraint invoices_buyer_companies__fk references companies on delete cascade,
                invoice_number varchar(255) not null,
                already_taken_price float default 0 not null,
                currency_code varchar(255),
                generated_at timestamp not null,
                sold_at timestamp not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ';
    }

    public function down(Schema $schema) : void
    {
    }
}
