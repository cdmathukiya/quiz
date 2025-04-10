<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Question;
use App\Helpers\QuizHelper;
use Illuminate\Http\Request;
use Laravel\Prompts\Support\Result;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'easy');
        // $questions = QuizHelper::getQuestions()
        //     ->where('type', $type)
        //     ->random(3);

        // return Inertia::render('Home-Array', [
        //     'questions' => $questions
        // ]);

        $questions = Question::query()
            ->with('options')
            ->where('type', $type)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        return Inertia::render('Home', [
            'questions' => $questions,
        ]);
    }

    public function submit(Request $request)
    {
        $data = $request->input('answers'); // [question_id => option_id, ...]
        $score = 0;
        $questions = [];

        foreach ($data as $questionId => $optionId) {
            $option = \App\Models\Option::where('id', $optionId)->where('is_correct', true)->first();
            $question = Question::find($questionId);
            if ($option) {
                $score++;
            }
            if ($question) {
                $questions[] = $question;
            }
        }

        // return Inertia::render('Result', [
        //     'score' => session('score') ?? $score,
        //     'questions' => $questions,
        // ]);

        return redirect()->route('quiz.result')->with([
            'score' => session('score') ?? $score,
            'questions' => $questions,
        ]);
    }

    public function result(Request $request)
    {
        $score = $request->session()->get('score');
        $questions = $request->session()->get('questions');
    
        return Inertia::render('Result', [
            'score' => $score,
            'questions' => $questions,
        ]);
    }
}    
