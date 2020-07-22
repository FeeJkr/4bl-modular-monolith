# Finances System REST API

This is a example application for control your family or company budget in easy way.
Just now has a lot of bugs and non optimal database query :)

For future:
* Optimize database query
* Migrate controllers to ADR pattern (Action - Domain - Responder)
* Add exception handler for beautify errors messages for users
* Add error logger and user action logger
* Add event dispatcher for logging user activities
* More security...

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

#### Used ports:
* **8080** - api
* **5432** - postgres database

You can connect to database on localhost:5432

##### 

# REST API - Finances

## Categories

### Get list of categories

##### Request
`GET /api/categories/`

###### Params
> **jwtToken**: required

##### Response
    HTTP/1.1 200 OK
    Content-Type: application/json
    
    [
        {
            "id": 1, 
            "user_id": 1, 
            "name": "Test", 
            "type": "expense", 
            "icon": "home", 
            "created_at": 1595004589
        }
    ]
    
### Get Category by id

##### Request
`GET /api/categories/{id}`

###### Params
> **jwtToken**: required

##### Response
    HTTP/1.1 200 OK
    Content-Type: application/json
    
    {
        "id": 1, 
        "user_id": 1, 
        "name": "Test", 
        "type": "expense", 
        "icon": "home", 
        "created_at": 1595004589
    }
    
### Update category by id

##### Request
`PATCH /api/categories/{id}`

###### Params
> **jwtToken**: required

> **category_name**: required

> **category_type**: required ***(available values: expense, income)***

> **category_icon**: optional

##### Response
    HTTP/1.1 204 NO CONTENT
    
### Create category

##### Request
`POST /api/categories/`

###### Params
> **jwtToken**: required

> **category_name**: required

> **category_type**: required ***(available values: expense, income)***

> **category_icon**: optional

##### Response
    HTTP/1.1 204 NO CONTENT
    
### Delete category by id

##### Request
`DELETE /api/categories/{id}`

###### Params
> **jwtToken**: required

##### Response
    HTTP/1.1 204 NO CONTENT
    
    
    
    
## Wallets

### Get list of wallets

##### Request
`GET /api/wallets/`

###### Params
> **jwtToken**: required

##### Response
    HTTP/1.1 200 OK
    Content-Type: application/json
    
    [
        {
            "id": 1, 
            "name": "Wallet 1", 
            "start_balance": 0, 
            "user_ids": [1111, 2222, 3333], 
            "created_at": 1595004589
        }
    ]
    
### Get wallet by id

##### Request
`GET /api/wallets/{id}`

###### Params
> **jwtToken**: required

##### Response
    HTTP/1.1 200 OK
    Content-Type: application/json
    
    {
        "id": 1, 
        "name": "Wallet 1", 
        "start_balance": 0, 
        "user_ids": [1111, 2222, 3333], 
        "created_at": 1595004589
    }
    
### Update wallet by id

##### Request
`PATCH /api/wallets/{id}`

###### Params
> **jwtToken**: required

> **wallet_user_ids**: optional ***(must be a string of ids with `,` delimiter. Example: "1111, 2222")***

> **wallet_name**: required

> **wallet_start_balance**: required

##### Response
    HTTP/1.1 204 NO CONTENT
    
### Create wallet

##### Request
`POST /api/wallets/`

###### Params
> **jwtToken**: required

> **wallet_name**: required

> **wallet_start_balance**: required

##### Response
    HTTP/1.1 204 NO CONTENT
    
### Delete wallet by id

##### Request
`DELETE /api/wallets/{id}`

###### Params
> **jwtToken**: required

##### Response
    HTTP/1.1 204 NO CONTENT
## Transactions

### Get list of transactions for wallet

##### Request
`GET /api/wallets/{wallet_id}/transactions`

###### Params
> **jwtToken**: required

##### Response
    HTTP/1.1 200 OK
    Content-Type: application/json
    
    [
        {
            "id": 1,
            "transaction_id": null,
            "user_id": 1234,
            "wallet_id": 1,
            "category_id": 1,
            "transaction_type": "regular",
            "amount": 1000,
            "description": "test",
            "operation_at": 1595082229,
            "created_at": 1595082229
        }
    ]
    
### Get all transactions

##### Request
`GET /api/transactions/`

###### Params
> **jwtToken**: required

##### Response
    HTTP/1.1 200 OK
    Content-Type: application/json
    
    [
            {
                "id": 1,
                "transaction_id": null,
                "user_id": 1234,
                "wallet_id": 1,
                "category_id": 1,
                "transaction_type": "regular",
                "amount": 1000,
                "description": "test",
                "operation_at": 1595082229,
                "created_at": 1595082229
            }
        ]
        
### Get transaction by id

##### Request
`GET /api/transactions/{id}`

###### Params
> **jwtToken**: required

##### Response
    HTTP/1.1 200 OK
    Content-Type: application/json

    {
        "id": 1,
        "transaction_id": null,
        "user_id": 1234,
        "wallet_id": 1,
        "category_id": 1,
        "transaction_type": "regular",
        "amount": 1000,
        "description": "test",
        "operation_at": 1595082229,
        "created_at": 1595082229
    }
    
### Update transaction by id

##### Request
`PATCH /api/transactions/{id}`

###### Params
> **jwtToken**: required

> **wallet_id**: required

> **linked_wallet_id**: optional ***(required for transaction_type = transfer)***

> **category_id**: required

> **transaction_type**: required ***(available values: regular, transfer)***

> **amount**: required ***(integer)***

> **description**: optional

> **operation_at**: required ***(timestamp)***

##### Response
    HTTP/1.1 204 NO CONTENT
    
### Create transaction

##### Request
`POST /api/transactions/`

###### Params
> **jwtToken**: required

> **wallet_id**: required

> **linked_wallet_id**: optional ***(required for transaction_type = transfer)***

> **category_id**: required

> **transaction_type**: required ***(available values: regular, transfer)***

> **amount**: required ***(integer)***

> **description**: optional

> **operation_at**: required ***(timestamp)***

##### Response
    HTTP/1.1 204 NO CONTENT
    
### Delete transaction by id

##### Request
`DELETE /api/transactions/{id}`

###### Params
> **jwtToken**: required

##### Response
    HTTP/1.1 204 NO CONTENT
    
## Helpful routes

### Generate JWT Token (only for tests)
##### Request
`GET /jwt/generate`

###### Params
> **user_id**: optional ***(default: 1234)***

##### Response
    HTTP/1.1 200 OK
    Content-Type: application/json
    
    {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUz..."
    }