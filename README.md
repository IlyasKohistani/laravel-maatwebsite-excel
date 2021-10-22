requirement: "php": "^7.1 || ^8.0", MYSQL  8.0.11 , LARAVEL FRAMEWORK 8 , COMPOSER 2.1.9.

DATABASE-INFO: {
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shop_packages
DB_USERNAME=root
DB_PASSWORD=
}

CREATE A DATABASE AND NAME IT AS "shop_packages".

IF YOUR DATABASE INFO IS DIFFERENT, YOU CAN CHANGE THE ABOVE INFORMATION IN .env FILE IN THE ROOT DIRECTORY.

RUN THE FOLLOWING COMMANDS FOR INITIALIZING THE PROJECT

composer install
composer update
copy .env.example .env
start chrome 127.0.0.1:8000
php artisan project:init


IF YOUR PORT NUMBER 8000 IS NOT AVAILABLE THEN RUN CHROME AND OPEN 127.0.0.1 WITH THE PORT NUMBER LARAVEL WILL SERVE AFTER ABOVE COMMANDS.