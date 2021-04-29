<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;

final class CreateInvoiceProductsTableMigration
{
    public function getDescription() : string
    {
        return 'Create invoices table';
    }

    public function up(Schema $schema) : void
    {
        $sql = '
            create table invoice_products
            (
                id serial not null constraint invoice_products_pk primary key,
                invoice_id int not null constraint invoice_products_invoices_id_fk references invoices on delete cascade,
                position int not null,
                name text not null,
                price float not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ';
    }

    public function down(Schema $schema) : void
    {
    }
}
