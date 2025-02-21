<?php
namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    // Display a list of quizzes
    public function index()
    {
        $quizzes = Quiz::all();
        return view('quizzes.index', compact('quizzes'));
    }

    // Show the form for creating a new quiz
    public function create()
    {
        return view('quizzes.create');
    }

    // Store a newly created quiz
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
        ]);

        Quiz::create($request->all());
        return redirect()->route('quizzes.index')->with('success', 'Quiz created successfully!');
    }

    // Show the form for editing a quiz
    public function edit(Quiz $quiz)
    {
        $quiz->load('questions.options'); // Eager load questions and options
        return view('quizzes.edit', compact('quiz'));
    }

    // Update the specified quiz
    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'questions' => 'nullable|array',
            'questions.*.question_text' => 'required|string|max:255',
            'questions.*.options' => 'nullable|array',
            'questions.*.options.*.option_text' => 'required|string|max:255',
            'questions.*.options.*.is_correct' => 'nullable|boolean',
        ]);

        // Update the quiz
        $quiz->update($request->only(['title', 'description', 'duration']));

        // Update or create questions and options
        if ($request->has('questions')) {
            foreach ($request->input('questions') as $questionData) {
                $question = $quiz->questions()->updateOrCreate(
                    ['id' => $questionData['id'] ?? null], // Update if ID exists, else create
                    ['question_text' => $questionData['question_text']]
                );

                // Update or create options
                if (isset($questionData['options'])) {
                    foreach ($questionData['options'] as $optionData) {
                        $question->options()->updateOrCreate(
                            ['id' => $optionData['id'] ?? null], // Update if ID exists, else create
                            [
                                'option_text' => $optionData['option_text'],
                                'is_correct' => $optionData['is_correct'] ?? false,
                            ]
                        );
                    }
                }
            }
        }

        return redirect()->route('quizzes.index')->with('success', 'Quiz updated successfully!');
    }

    // Delete the specified quiz
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully!');
    }
}