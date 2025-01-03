<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About eGuests : Ultimate Student Apartment Renting Solution
eGuest is a comprehensive apartment renting platform tailored for students. It simplifies the process of finding, renting, and managing student accommodations. With eGuest, students can easily search for apartments, connect with landlords, and manage their rental agreements all in one place. The app is designed to cater to the unique needs of students, offering a seamless and user-friendly experience.


## Features
- User-Friendly Interface: Intuitive design that makes navigation easy for students
- Simple search filters to find apartments based on location, price, amenities, and more.
- Search by apartment type, number of bedrooms, and other specific criteria.
- Detailed floor plans and 360-degree views to help students make informed decisions.
- Notifications for new messages, updates, and reminders.
- Track application status and receive updates in real-time.
- Rent payment tracking and reminders.
- Rate and review your own rental experience to help future students.
- Resources and guides on renting, moving, and living independently.


## Domain

[eguests.eu](https://eguests.eu).

## Requirements
- Node: v18.12.0 or above (LTS)
- PHP: v8.2.0 or Above
- Composer: v2.2 or Above
- Laravel: v11.0.0 or Above


## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

`API_KEY`
...


## Installation

1. Open the terminal in your root directory of Sneat Laravel.
2. Use following command to install composer
    ```bash
    composer install
    ```
3. Find .env.example file at root folder and copy it to .env by running below command Or also can manually copy it (if not having .env file):
    ```
    cp .env.example .env
    ```
4. Run the following command to generate the key
    ```
    php artisan key:generate
    ```
5. By running the following command, you will be able to get all the dependencies in your node_modules folder:
    ```
    yarn
    ```
6. To start the development server, This command will build your frontend assets with template:

    ```
    yarn build
    ```
7. To serve the application, you need to run the following command in the project directory

    ```
    php artisan serve
    ```
## Required Permissions
```
sudo chmod -R o+rw bootstrap/cache
sudo chmod -R o+rw storage
```

<p>
© 2022 ALYCENT - Tous droits réservés
