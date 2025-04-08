<?php

namespace App\Helpers;

class QuizHelper
{
    public static function getQuestions()
    {
        return collect([
            [
                'question' => 'What is Laravel?',
                'options' => ['Framework', 'CMS', 'Library', 'Theme'],
                'answer' => 'Framework',
                'type' => 'easy',
            ],
            [
                'question' => 'Which command is used to create a new Laravel project?',
                'options' => ['php artisan new', 'laravel new', 'composer new laravel', 'laravel install'],
                'answer' => 'laravel new',
                'type' => 'easy',
            ],
            [
                'question' => 'What is the default database used in Laravel?',
                'options' => ['PostgreSQL', 'SQLite', 'MySQL', 'MongoDB'],
                'answer' => 'MySQL',
                'type' => 'easy',
            ],
            [
                'question' => 'Which template engine does Laravel use?',
                'options' => ['Twig', 'Blade', 'Smarty', 'Mustache'],
                'answer' => 'Blade',
                'type' => 'easy',
            ],
            [
                'question' => 'Which command is used to run Laravel development server?',
                'options' => ['php artisan run', 'php artisan up', 'php artisan serve', 'laravel serve'],
                'answer' => 'php artisan serve',
                'type' => 'easy',
            ],
            [
                'question' => 'What is a service provider in Laravel?',
                'options' => ['Middleware', 'Controller', 'Class that registers services', 'Model'],
                'answer' => 'Class that registers services',
                'type' => 'easy',
            ],
            [
                'question' => 'How can you define a route in Laravel?',
                'options' => ['Route::make()', 'Route::get()', 'Route::path()', 'Route::define()'],
                'answer' => 'Route::get()',
                'type' => 'easy',
            ],
            [
                'question' => 'What is middleware used for in Laravel?',
                'options' => ['Database connection', 'Code compiling', 'Filtering HTTP requests', 'View rendering'],
                'answer' => 'Filtering HTTP requests',
                'type' => 'medium',
            ],
            [
                'question' => 'Which directory contains route definitions in Laravel?',
                'options' => ['routes/', 'app/Routes/', 'src/routes/', 'bootstrap/routes/'],
                'answer' => 'routes/',
                'type' => 'medium',
            ],
            [
                'question' => 'How do you pass data to views in Laravel?',
                'options' => ['with()', 'send()', 'pass()', 'route()'],
                'answer' => 'with()',
                'type' => 'medium',
            ],
            [
                'question' => 'Which artisan command creates a controller?',
                'options' => ['php artisan make:controller', 'php artisan controller:create', 'php artisan build:controller', 'php artisan create:controller'],
                'answer' => 'php artisan make:controller',
                'type' => 'medium',
            ],
            [
                'question' => 'What is Eloquent in Laravel?',
                'options' => ['Routing engine', 'Query builder', 'ORM', 'Template engine'],
                'answer' => 'ORM',
                'type' => 'medium',
            ],
            [
                'question' => 'What is the purpose of migrations in Laravel?',
                'options' => ['Database seeding', 'View creation', 'Managing database schema', 'Authentication'],
                'answer' => 'Managing database schema',
                'type' => 'medium',
            ],
            [
                'question' => 'Which file stores environment configuration in Laravel?',
                'options' => ['.env', 'config.php', 'environment.json', 'settings.ini'],
                'answer' => '.env',
                'type' => 'hard',
            ],
            [
                'question' => 'What does CSRF stand for?',
                'options' => ['Cross-Site Request Filter', 'Cross-Site Resource Format', 'Cross-Site Request Forgery', 'Client-Side Routing Feature'],
                'answer' => 'Cross-Site Request Forgery',
                'type' => 'hard',
            ],
            [
                'question' => 'Which command rolls back the last database migration?',
                'options' => ['php artisan migrate:undo', 'php artisan rollback', 'php artisan migrate:rollback', 'php artisan db:rollback'],
                'answer' => 'php artisan migrate:rollback',
                'type' => 'hard',
            ],
            [
                'question' => 'What does the `hasMany` relationship represent in Eloquent?',
                'options' => ['One-to-one', 'Many-to-many', 'One-to-many', 'Polymorphic'],
                'answer' => 'One-to-many',
                'type' => 'hard',
            ],
            [
                'question' => 'What is the purpose of Laravel Sanctum?',
                'options' => ['Email verification', 'Testing', 'API authentication', 'Session management'],
                'answer' => 'API authentication',
                'type' => 'hard',
            ],
            [
                'question' => 'How do you return JSON response in Laravel?',
                'options' => ['response()->toJson()', 'json()', 'response()->json()', 'returnJson()'],
                'answer' => 'response()->json()',
                'type' => 'hard',
            ],
            [
                'question' => 'Which artisan command is used to create a model with a migration?',
                'options' => ['php artisan make:model User -m', 'php artisan model:create User', 'php artisan new:model User', 'php artisan create:model User'],
                'answer' => 'php artisan make:model User -m',
                'type' => 'medium',
            ],
            // You can continue to add more as needed up to 50
        ]);
    }
}
