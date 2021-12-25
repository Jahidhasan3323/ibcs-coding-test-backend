# IBCS-Primax coding test frontend

## Installation

Clone the repository

    git clone https://github.com/Jahidhasan3323/ibcs-coding-test-backend.git

Switch to the repo folder

    cd ecommerce-backend

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file for mail and other stubs

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run migration and seed for user and product

    php artisan migrate --seed

Run storage link command

 ```php artisan storage:link```

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000 

set APP_FRONTEND_URL for fronend application in ```.env```

### Default Login credentials

```
=========Admin============
User: admin@gmail.com
Password: 12345678

=========Customer============
User: customer@gmail.com
Password: 12345678
```
