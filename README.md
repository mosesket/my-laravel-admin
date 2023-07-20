# my-laravel-admin

Using Bootstrap 4 to create a beautiful admin system, ajax and laravel to perform crude operations

Laravel Bootstrap Ajax-based admin system a user-friendly interface with a navbar that allows administrators to efficiently manage tasks asynchronously. Through Ajax interactions, administrators can create, read, update, and delete tasks dynamically without page reloads. The system utilizes Bootstrap for responsive design, while error handling ensures a stable and secure environment. The admin system comprises sections for creating tasks, listing existing tasks, editing tasks through modals, and deleting tasks with confirmation. 

# Website Demo

Website Demo: [https://lara-ajax-admin.programmersmage.com/](https://lara-ajax-admin.programmersmage.com/). 

## Install Laravel

Make sure you have PHP installed on your local machine.

Install Composer (https://getcomposer.org/) if you haven't already.

Open a terminal or command prompt and run the following command to install Laravel globally:

```bash
composer global require laravel/installer
```

## Installation  the project

Clone this repo and `cd` into it
```bash
composer install
```

Rename or copy `.env.example` file to `.env`
```bash
php artisan key:generate
```

Set your DB_CONNECTION in your `.env` file to `sqlite`

`php artisan serve` or use Laravel Valet or Laravel Homestead

Visit `localhost:8000` in your browser
