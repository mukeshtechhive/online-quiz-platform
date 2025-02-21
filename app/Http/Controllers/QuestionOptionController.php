<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionOptionController extends Controller
{
    // Display the form to add options
    public function index(Question $question)
    {
        return view('quizzes.questions.options', compact('question'));
    }

    // Store a new option
    public function store(Request $request, Question $question)
    {
        $request->validate([
            'option_text' => 'required|string|max:255',
            'is_correct' => 'nullable|boolean',
        ]);

        $question->options()->create([
            'option_text' => $request->input('option_text'),
            'is_correct' => $request->has('is_correct'),
        ]);

        return redirect()->route('questions.options.index', $question->id)->with('success', 'Option added successfully!');
    }
}
