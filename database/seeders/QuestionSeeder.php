<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Option;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        // Sample questions repeated with slight variation
        $q1 = Question::create(['question' => 'How can you create a new controller in Laravel? (1)']);
        $q1->options()->createMany([
            ['option' => 'php create controller', 'is_correct' => false],
            ['option' => 'php artisan make:controller', 'is_correct' => true],
            ['option' => 'laravel create controller', 'is_correct' => false],
            ['option' => 'php make:controller', 'is_correct' => false],
        ]);

        $q2 = Question::create(['question' => 'Which command rolls back the last database migration?']);
        $q2->options()->createMany([
            ['option' => 'php artisan migrate:undo', 'is_correct' => false],
            ['option' => 'php artisan rollback', 'is_correct' => true],
            ['option' => 'php artisan migrate:rollback', 'is_correct' => false],
            ['option' => 'php artisan db:rollback', 'is_correct' => false],
        ]);

        $q3 = Question::create(['question' => 'What is the default database used in Laravel? (3)']);
        $q3->options()->createMany([
            ['option' => 'SQLite', 'is_correct' => false],
            ['option' => 'MongoDB', 'is_correct' => false],
            ['option' => 'MySQL', 'is_correct' => true],
            ['option' => 'PostgreSQL', 'is_correct' => false],
        ]);

        $q4 = Question::create(['question' => 'What is a service provider in Laravel?']);
        $q4->options()->createMany([
            ['option' => 'Middleware', 'is_correct' => false],
            ['option' => 'Controller', 'is_correct' => false],
            ['option' => 'Class that registers services', 'is_correct' => true],
            ['option' => 'Model', 'is_correct' => false],
        ]);

        $q5 = Question::create(['question' => 'How can you define a route in Laravel?']);
        $q5->options()->createMany([
            ['option' => 'Route::make()', 'is_correct' => false],
            ['option' => 'Route::get()', 'is_correct' => true],
            ['option' => 'Route::path()', 'is_correct' => false],
            ['option' => 'Route::define()', 'is_correct' => false],
        ]);

        $q6 = Question::create(['question' => 'Which directory contains route definitions in Laravel?']);
        $q6->options()->createMany([
            ['option' => 'routes/', 'is_correct' => true],
            ['option' => 'app/Routes/', 'is_correct' => false],
            ['option' => 'src/routes/', 'is_correct' => false],
            ['option' => 'bootstrap/routes/', 'is_correct' => false],
        ]);

        // ... Repeat similar blocks up to $q50
    }
}
