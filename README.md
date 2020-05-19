# REST API FOR CURRENCY-EXCHANGE APP

This application uses the fixer.io API and works as the REST API of the application located in this repository https://github.com/willlymendoza/currency-exchange

Every time a call is made to this app, it will check if more than an hour has passed since its last use, in which case it will update the database with the data obtained from the fixer.io API.

With this, we avoid consuming the limit of calls to the fixer.io API, limiting it to at least 24 calls a day, which is approximately 745 calls per month, which is below the limit of calls per month that fixer.io provides on a free plan.

# Installation requirements

Fixer.io API access key (Register [here](https://fixer.io/signup/free) to get your own access key)

You need to have the following installed on your pc or server:

[Composer](https://getcomposer.org/)

PHP & MYSQL (you can use [XAMPP](https://www.apachefriends.org/index.html) to install both on your pc)

# Setting up your Database in MySql

Create a user and a MySql database and name it as you like. (If you are using XAMPP you can skip creating the user and use the root user)

# Install laravel dependencies

Open the command line being located in the root directory of the project.

Install Laravel dependencies by running the following command :

```
composer install
```

# Setting up your Laravel Proyect

## Database migrations

Open the command line being located in the root directory of the project and then execute the following command:

```
php artisan migrate
```

## Create .env file

Create a new file in your root directory and name it as .env

## Generate your app encryption key

Open the command line being located in the root directory of the project and then execute the following command:

```
php artisan key:generate
```

This key will be generated inside the previously created .env file

## Edit .env file

Open your .env file and add the following data:

```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=database name
DB_USERNAME=user name
DB_PASSWORD=user access password

FIXER_KEY=your fixer.io personal access key
```

## Starting the app

Open the command line being located in the root directory of the project and execute the following command:

```
php artisan serve
```

You will see a console message similar to this:

```
Laravel development server started: http://127.0.0.1:8000
```

## You're done!!

Now you can go to http://127.0.0.1:8000/api/currencies end-point and see a result in JSON format similar to this:

```

  "currencies": [
    {
      "name": "AED",
      "value": 4.008597
    },
    {
      "name": "AFN",
      "value": 82.814851
    },
    {
      "name": "ALL",
      "value": 123.481847
    },
    {
      "name": "AMD",
      "value": 525.913293
    },
    {
      "name": "ANG",
      "value": 1.939643
    },
    ...
```
