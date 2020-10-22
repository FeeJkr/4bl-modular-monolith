<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20201005160810 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create users table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('users');

        $table->addColumn('id', 'integer', ['autoincrement' => true,]);
        $table->addColumn('email', 'string');
        $table->addColumn('username', 'string');
        $table->addColumn('password', 'string');
        $table->addColumn('token', 'string', ['notnull' => false]);
        $table->addColumn('created_at', 'datetime');

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('users');
    }
}
