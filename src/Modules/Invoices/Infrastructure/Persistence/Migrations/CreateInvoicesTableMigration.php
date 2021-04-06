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
	            html text not null,
	            token varchar(255),
	            created_at timestamp default now() not null,
	            updated_at timestamp
            );
        ';
    }

    public function down(Schema $schema) : void
    {
    }
}
