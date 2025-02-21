@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Question</h1>
        <form action="{{ route('quizzes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="quiz_id">Quiz</label>
                <select name="quiz_id" id="quiz_id" class="form-control" required>
                    @foreach ($quizzes as $quiz)
                        <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="question_text">Question Text</label>
                <textarea name="question_text" id="question_text" class="form-control" rows="3" required></textarea>
            </div>

            <h3>Options</h3>
            <div id="options-container">
                <div class="option-group mb-3">
                    <div class="form-group">
                        <label for="option_text_1">Option 1</label>
                        <input type="text" name="options[0][option_text]" id="option_text_1" class="form-control"
                            required>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="options[0][is_correct]" id="is_correct_1" class="form-check-input">
                        <label for="is_correct_1" class="form-check-label">Is Correct?</label>
                    </div>
                </div>
            </div>

            <button type="button" id="add-option" class="btn btn-secondary">Add Another Option</button>
            <button type="submit" class="btn btn-primary">Create Question</button>
        </form>
    </div>

    <script>
        // Add more option fields dynamically
        let optionCount = 1;
        document.getElementById('add-option').addEventListener('click', function() {
            const optionsContainer = document.getElementById('options-container');
            const newOptionGroup = document.createElement('div');
            newOptionGroup.classList.add('option-group', 'mb-3');
            newOptionGroup.innerHTML = `
            <div class="form-group">
                <label for="option_text_${optionCount + 1}">Option ${optionCount + 1}</label>
                <input type="text" name="options[${optionCount}][option_text]" id="option_text_${optionCount + 1}" class="form-control" required>
            </div>
            <div class="form-check">
                <input type="checkbox" name="options[${optionCount}][is_correct]" id="is_correct_${optionCount + 1}" class="form-check-input">
                <label for="is_correct_${optionCount + 1}" class="form-check-label">Is Correct?</label>
            </div>
        `;
            optionsContainer.appendChild(newOptionGroup);
            optionCount++;
        });
    </script>
@endsection
