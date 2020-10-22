<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200722092611 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create categories table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('categories');

        $table->addColumn('id', 'integer', ['autoincrement' => true,]);
        $table->addColumn('user_id', 'integer');
        $table->addColumn('name', 'string');
        $table->addColumn('type', 'string');
        $table->addColumn('icon', 'string', ['default' => 'home']);
        $table->addColumn('created_at', 'datetime');

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('categories');
    }
}
