<?php
namespace App\Http\Controllers;

use App\Helpers\QuizHelper;
use App\Models\Question;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuizController extends Controller
{
    public function index()
    {
        $questions = QuizHelper::getQuestions()->shuffle()->take(5);
        return Inertia::render('Home-Array', [
            'questions' => $questions
        ]);

        $questions = Question::with('options')->inRandomOrder()->limit(5)->get();
        return Inertia::render('Home', [
            'questions' => $questions
        ]);
    }

    public function submit(Request $request)
    {
        $data = $request->input('answers'); // [question_id => option_id, ...]
        $score = 0;

        foreach ($data as $questionId => $optionId) {
            $option = \App\Models\Option::where('id', $optionId)->where('is_correct', true)->first();
            if ($option) {
                $score++;
            }
        }

        return redirect()->route('quiz.result')->with('score', $score);
    }

    public function result(Request $request)
    {
        $score = $request->get('score');
        return Inertia::render('Result', [
            'score' => session('score') ?? $score
        ]);
    }
}
