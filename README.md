# ![Laravel Example App]
A simple book management system (REST API, Laravel, VueJs)

----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x/installation#installation)


Clone the repository

    gh repo clone Yorhmzy/Book-Management-System

Switch to the repo folder

    cd Book-Management-System

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Install Passport via the Composer package manager:

    composer require laravel/passport

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate
    
Create the encryption keys needed to generate secure access tokens

    php artisan passport:install

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000 
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Front End

This application uses Vue Js for the front-end

Install Dependencies

    npm install

Install Vue JS and Vue Router

    npm install vue, vue-router

Run all Mix tasks...

    npm run dev

Run all Mix tasks and minify output.

    npm run production

# Code overview

## Dependencies

- [passport](https://laravel.com/docs/8.x/passport) - For authentication using JSON Web Tokens
