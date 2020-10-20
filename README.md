# 4BL Project

This is a example application for control your family or company budget in easy way.
Just now has a lot of bugs and non optimal database queries :)

#### Run application locally

##### Docker
`git clone https://github.com/FeeJkr/4bl-finances.git`

`cd 4bl-finances`

`docker-compose up -d`

`docker-compose exec web composer install` 

`Change .env file if you want (this part can be skipped)`

`docker-compose exec web php bin/console doctrine:database:create`

`docker-compose exec web php bin/console doctrine:migrations:migrate`

`Type yes to console`

`After database migrations your application must be available on http://localhost:8080`
