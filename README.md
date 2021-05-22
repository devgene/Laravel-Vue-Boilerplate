# LaravelVueBoilerplate


<a href="https://github.com/cretueusebiu/laravel-vue-spa/actions"><img src="https://github.com/cretueusebiu/laravel-vue-spa/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/cretueusebiu/laravel-vue-spa"><img src="https://poser.pugx.org/cretueusebiu/laravel-vue-spa/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/cretueusebiu/laravel-vue-spa"><img src="https://poser.pugx.org/cretueusebiu/laravel-vue-spa/v/stable.svg" alt="Latest Stable Version"></a>

![login](https://user-images.githubusercontent.com/16412194/119227496-c3ecdc80-bb2b-11eb-9ada-25012669c7f7.png)


## Features

- Laravel 7
- Vue + VueRouter + Vuex
- Pages with dynamic import and custom layouts
- Login, register, email verification and password reset
- Passport Authentication
- Bootstrap 4 + Font Awesome 5



## Installation

- `composer create-project --prefer-dist devgene/Laravel-Vue-Boilerplate`
- Edit `.env` and set your database connection details
- (When installed via git clone or download, run `composer update` and `php artisan key:generate` )
- `php artisan migrate`
- `npm install`
- `php artisan passport:install`
- `php artisan serve`

## Usage

#### Development

```bash
# Build and watch
npm run watch

```

#### Production

```bash
npm run production
```
