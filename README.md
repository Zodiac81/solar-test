<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Project

Test project

##How to Install

1. run composer install
1. npm install
1. To compile npm run dev
1. copy .env.example to .env
1. connect db (mysql) in .env
1. clear cache php artisan config:clear
1. run migration and seed  php artisan migrate:refresh --seed
1. run php artisan serve --port=9005


##How to testing

Tests uses sqlite (in memory)

1. Before run tests clear cache php artisan config:clear --env=testing
1. Run vendor/bin/phpunit



