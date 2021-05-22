# LaravelVueBoilerplate

![login](https://user-images.githubusercontent.com/16412194/119227496-c3ecdc80-bb2b-11eb-9ada-25012669c7f7.png)

After you clone this project, do the following:
##### go into the project
`cd dashboard-ticket-booking`

##### install composer dependencies
`composer update`

##### install npm dependencies
`npm install`

##### generate a key for your application
`php artisan key:generate`

##### create a local MySQL database (make sure you have MySQL up and running)
`mysql -u root`

> create database chat_db;
> exit;

##### add the database connection config to your .env file
`DB_CONNECTION=mysql`
`DB_DATABASE=chat_db`
`DB_USERNAME=root`
`DB_PASSWORD=`

##### run the migration files to generate the schema
`php artisan migrate`

##### run the passport install
`php artisan passport:install`

##### run php server
`php artisan serve`

##### run webpack and watch for changes
`npm run watch`

##### run in browser
url: http://127.0.0.1:8000/login
