<?php
namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizTakeController extends Controller
{
    // Display the quiz with questions
    public function show(Quiz $quiz)
    {
        $quiz->load('questions.options'); // Eager load questions and options
        return view('quizzes.take', compact('quiz'));
    }

    // Submit the quiz and calculate results
    public function submit(Request $request, Quiz $quiz)
    {
        $score = 0;
        $totalQuestions = $quiz->questions->count();

        foreach ($quiz->questions as $question) {
            $selectedOptionId = $request->input('question_' . $question->id);
            $correctOptionId = $question->options->where('is_correct', true)->first()->id;

            if ($selectedOptionId == $correctOptionId) {
                $score++;
            }
        }

        // Save the result
        Result::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'score' => $score,
        ]);

        return redirect()->route('quizzes.result', ['quiz' => $quiz->id, 'score' => $score, 'totalQuestions' => $totalQuestions]);
    }

    // Display the quiz result
    public function result(Quiz $quiz, $score, $totalQuestions)
    {
        return view('quizzes.result', compact('quiz', 'score', 'totalQuestions'));
    }
}