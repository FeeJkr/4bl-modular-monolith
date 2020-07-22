<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200722093924 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create transactions table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('transactions');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('transaction_id', 'integer', ['notnull' => false]);
        $table->addColumn('user_id', 'integer');
        $table->addColumn('wallet_id', 'integer');
        $table->addColumn('category_id', 'integer');
        $table->addColumn('type', 'string');
        $table->addColumn('amount', 'integer');
        $table->addColumn('description', 'string', ['notnull' => false]);
        $table->addColumn('operation_at', 'datetime');
        $table->addColumn('created_at', 'datetime');

        $table->addForeignKeyConstraint('transactions', ['transaction_id'], ['id'], ['onDelete' => 'SET NULL'], 'transactions_transactions_foreign_key');
        $table->addForeignKeyConstraint('wallets', ['wallet_id'], ['id'], ['onDelete' => 'CASCADE'], 'transactions_wallets_foreign_key');
        $table->addForeignKeyConstraint('categories', ['category_id'], ['id'], ['onDelete' => 'CASCADE'], 'transactions_categories_foreign_key');

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema) : void
    {
        $table = $schema->getTable('transactions');
        $table->removeForeignKey('transactions_transactions_foreign_key');
        $table->removeForeignKey('transactions_wallets_foreign_key');
        $table->removeForeignKey('transactions_categories_foreign_key');

        $schema->dropTable('transactions');
    }
}
