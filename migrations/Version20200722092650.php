<?php
declare(strict_types=1);

namespace DoctrineMigrations;

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
        $table->addColumn('name', 'string');
        $table->addColumn('start_balance', 'integer', ['default' => 0]);
        $table->addColumn('created_at', 'datetime');

        $table->setPrimaryKey(['id']);

        $table = $schema->createTable('wallets_users');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('wallet_id', 'integer');
        $table->addColumn('user_id', 'integer');

        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint(
            'wallets',
            ['wallet_id'],
            ['id'],
            ['onDelete' => 'CASCADE'],
            'wallets_users_foreign_key'
        );
    }

    public function down(Schema $schema) : void
    {
        $table = $schema->getTable('wallets_users');
        $table->removeForeignKey('wallets_users_foreign_key');
        $table->dropIndex('wallets_users_foreign_key');

        $schema->dropTable('wallets_users');
        $schema->dropTable('wallets');
    }
}
