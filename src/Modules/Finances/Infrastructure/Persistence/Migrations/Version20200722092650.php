<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200722092650 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create wallets table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('wallets');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user_id', 'integer');
        $table->addColumn('name', 'string');
        $table->addColumn('start_balance', 'integer', ['default' => 0]);
        $table->addColumn('created_at', 'datetime');

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('wallets');
    }
}
