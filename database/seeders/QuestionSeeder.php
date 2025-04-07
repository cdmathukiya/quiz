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

        $q2 = Question::create(['question' => 'How can you create a new controller in Laravel? (2)']);
        $q2->options()->createMany([
            ['option' => 'php create controller', 'is_correct' => false],
            ['option' => 'php artisan make:controller', 'is_correct' => true],
            ['option' => 'laravel create controller', 'is_correct' => false],
            ['option' => 'php make:controller', 'is_correct' => false],
        ]);

        $q3 = Question::create(['question' => 'What is the default database used in Laravel? (3)']);
        $q3->options()->createMany([
            ['option' => 'SQLite', 'is_correct' => false],
            ['option' => 'MongoDB', 'is_correct' => false],
            ['option' => 'MySQL', 'is_correct' => true],
            ['option' => 'PostgreSQL', 'is_correct' => false],
        ]);

        // ... Repeat similar blocks up to $q50
    }
}
