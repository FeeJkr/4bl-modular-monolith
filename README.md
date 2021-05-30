# 4BL Project

This is a example application for control your family or company in easy way. 
It will be contained a lot of different modules for automate everyday tasks, such as
budget control, invoice generation for company, invoice control, creating and controling
to-do lists and more.

#### Run application locally

##### Docker
* `cd docker`
* `cp .env.example .env` After this you can change default settings in .env file
* `docker-compose up -d`
* `docker-compose exec -u root app bash`
* After in container bush run follow commands:
    * `composer install` for install php dependencies
    * `npm install` for install react dependencies
    * `npm run build` for build react application
    * `php bin/console doctrine:database:create`
    * `php bin/console doctrine:migrations:migrate`

Application will be available on localhost:{$PORT}. 