@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Quiz</h1>
    <form action="{{ route('quizzes.update', $quiz->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $quiz->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ $quiz->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="duration">Duration (Minutes)</label>
            <input type="number" name="duration" id="duration" class="form-control" value="{{ $quiz->duration }}" required min="1">
        </div>

        <h3 class="mt-5">Questions</h3>
        <div id="questions-container">
            @foreach ($quiz->questions as $question)
                <div class="card mb-3 question-group">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="question_text_{{ $question->id }}">Question Text</label>
                            <textarea name="questions[{{ $question->id }}][question_text]" id="question_text_{{ $question->id }}" class="form-control" rows="2" required>{{ $question->question_text }}</textarea>
                        </div>

                        <h5>Options</h5>
                        <div class="options-container">
                            @foreach ($question->options as $option)
                                <div class="option-group mb-3">
                                    <div class="form-group">
                                        <label for="option_text_{{ $option->id }}">Option</label>
                                        <input type="text" name="questions[{{ $question->id }}][options][{{ $option->id }}][option_text]" id="option_text_{{ $option->id }}" class="form-control" value="{{ $option->option_text }}" required>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="questions[{{ $question->id }}][options][{{ $option->id }}][is_correct]" id="is_correct_{{ $option->id }}" class="form-check-input" {{ $option->is_correct ? 'checked' : '' }}>
                                        <label for="is_correct_{{ $option->id }}" class="form-check-label">Is Correct?</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm add-option" data-question="{{ $question->id }}">Add Option</button>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="button" id="add-question" class="btn btn-secondary">Add Question</button>
        <button type="submit" class="btn btn-primary">Update Quiz</button>
    </form>
</div>

<script>
    // Add more questions dynamically
    let questionCount = {{ $quiz->questions->count() }};
    document.getElementById('add-question').addEventListener('click', function () {
        const questionsContainer = document.getElementById('questions-container');
        const newQuestionGroup = document.createElement('div');
        newQuestionGroup.classList.add('card', 'mb-3', 'question-group');
        newQuestionGroup.innerHTML = `
            <div class="card-body">
                <div class="form-group">
                    <label for="question_text_new_${questionCount}">Question Text</label>
                    <textarea name="questions[new_${questionCount}][question_text]" id="question_text_new_${questionCount}" class="form-control" rows="2" required></textarea>
                </div>

                <h5>Options</h5>
                <div class="options-container">
                    <div class="option-group mb-3">
                        <div class="form-group">
                            <label for="option_text_new_${questionCount}_1">Option</label>
                            <input type="text" name="questions[new_${questionCount}][options][new_1][option_text]" id="option_text_new_${questionCount}_1" class="form-control" required>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="questions[new_${questionCount}][options][new_1][is_correct]" id="is_correct_new_${questionCount}_1" class="form-check-input">
                            <label for="is_correct_new_${questionCount}_1" class="form-check-label">Is Correct?</label>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm add-option" data-question="new_${questionCount}">Add Option</button>
            </div>
        `;
        questionsContainer.appendChild(newQuestionGroup);
        questionCount++;
    });

    // Add more options dynamically
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('add-option')) {
            const questionId = e.target.getAttribute('data-question');
            const optionsContainer = e.target.previousElementSibling;
            const optionCount = optionsContainer.querySelectorAll('.option-group').length + 1;

            const newOptionGroup = document.createElement('div');
            newOptionGroup.classList.add('option-group', 'mb-3');
            newOptionGroup.innerHTML = `
                <div class="form-group">
                    <label for="option_text_${questionId}_${optionCount}">Option</label>
                    <input type="text" name="questions[${questionId}][options][new_${optionCount}][option_text]" id="option_text_${questionId}_${optionCount}" class="form-control" required>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="questions[${questionId}][options][new_${optionCount}][is_correct]" id="is_correct_${questionId}_${optionCount}" class="form-check-input">
                    <label for="is_correct_${questionId}_${optionCount}" class="form-check-label">Is Correct?</label>
                </div>
            `;
            optionsContainer.appendChild(newOptionGroup);
        }
    });
</script>
@endsection