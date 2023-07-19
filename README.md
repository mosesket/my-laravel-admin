# my-laravel-admin

Use Bootstrap 4 to create a beautiful admin system
first I create an index.html and build boostrap to beautify the page

## Install Laravel

Make sure you have PHP installed on your local machine.

Install Composer (https://getcomposer.org/) if you haven't already.

Open a terminal or command prompt and run the following command to install Laravel globally:

```bash
composer global require laravel/installer
```

## Installation  the project

1. Clone this repo and `cd` into it
```bash
composer install
```
1. Rename or copy `.env.example` file to `.env`
```bash
php artisan key:generate
```
1. Set your DB_CONNECTION in your `.env` file to `sqlite`
1. `php artisan serve` or use Laravel Valet or Laravel Homestead
1. Visit `localhost:8000` in your browser
