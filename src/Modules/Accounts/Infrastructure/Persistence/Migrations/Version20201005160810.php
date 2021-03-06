<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Persistence\Migrations;

final class Version20201005160810
{
    public function getDescription() : string
    {
        return 'Create users table';
    }

    public function up() : void
    {
        $sql = '
            create table users(
                id serial not null constraint users_pkey primary key,
                email varchar(255) not null,
                username varchar(255) not null,
                password varchar(255) not null,
                token varchar(255) default NULL::character varying,
                created_at timestamp(0) not null
            );
        ';
    }
}
