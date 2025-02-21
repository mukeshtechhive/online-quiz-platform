@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Quiz</h1>
        <form action="{{ route('quizzes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="duration">Duration (Minutes)</label>
                <input type="number" name="duration" id="duration" class="form-control" required min="1">
            </div>

            <h3>Questions</h3>
            <div id="questions-container">
                <div class="question-group mb-4">
                    <div class="form-group">
                        <label for="question_text_1">Question 1</label>
                        <textarea name="questions[0][question_text]" id="question_text_1" class="form-control" rows="2" required></textarea>
                    </div>

                    <h5>Options</h5>
                    <div class="options-container">
                        <div class="option-group mb-3">
                            <div class="form-group">
                                <label for="option_text_1_1">Option 1</label>
                                <input type="text" name="questions[0][options][0][option_text]" id="option_text_1_1"
                                    class="form-control" required>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="questions[0][options][0][is_correct]" id="is_correct_1_1"
                                    class="form-check-input">
                                <label for="is_correct_1_1" class="form-check-label">Is Correct?</label>
                            </div>
                        </div>
                        <div class="option-group mb-3">
                            <div class="form-group">
                                <label for="option_text_1_2">Option 2</label>
                                <input type="text" name="questions[0][options][1][option_text]" id="option_text_1_2"
                                    class="form-control" required>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="questions[0][options][1][is_correct]" id="is_correct_1_2"
                                    class="form-check-input">
                                <label for="is_correct_1_2" class="form-check-label">Is Correct?</label>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm add-option" data-question="0">Add Option</button>
                </div>
            </div>

            <button type="button" id="add-question" class="btn btn-secondary">Add Another Question</button>
            <button type="submit" class="btn btn-primary">Create Quiz</button>
        </form>
    </div>

    <script>
        // Add more questions dynamically
        let questionCount = 1;
        document.getElementById('add-question').addEventListener('click', function() {
            const questionsContainer = document.getElementById('questions-container');
            const newQuestionGroup = document.createElement('div');
            newQuestionGroup.classList.add('question-group', 'mb-4');
            newQuestionGroup.innerHTML = `
            <div class="form-group">
                <label for="question_text_${questionCount + 1}">Question ${questionCount + 1}</label>
                <textarea name="questions[${questionCount}][question_text]" id="question_text_${questionCount + 1}" class="form-control" rows="2" required></textarea>
            </div>

            <h5>Options</h5>
            <div class="options-container">
                <div class="option-group mb-3">
                    <div class="form-group">
                        <label for="option_text_${questionCount + 1}_1">Option 1</label>
                        <input type="text" name="questions[${questionCount}][options][0][option_text]" id="option_text_${questionCount + 1}_1" class="form-control" required>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="questions[${questionCount}][options][0][is_correct]" id="is_correct_${questionCount + 1}_1" class="form-check-input">
                        <label for="is_correct_${questionCount + 1}_1" class="form-check-label">Is Correct?</label>
                    </div>
                </div>
                <div class="option-group mb-3">
                    <div class="form-group">
                        <label for="option_text_${questionCount + 1}_2">Option 2</label>
                        <input type="text" name="questions[${questionCount}][options][1][option_text]" id="option_text_${questionCount + 1}_2" class="form-control" required>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="questions[${questionCount}][options][1][is_correct]" id="is_correct_${questionCount + 1}_2" class="form-check-input">
                        <label for="is_correct_${questionCount + 1}_2" class="form-check-label">Is Correct?</label>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary btn-sm add-option" data-question="${questionCount}">Add Option</button>
        `;
            questionsContainer.appendChild(newQuestionGroup);
            questionCount++;
        });

        // Add more options dynamically
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('add-option')) {
                const questionIndex = e.target.getAttribute('data-question');
                const optionsContainer = e.target.previousElementSibling;
                const optionCount = optionsContainer.querySelectorAll('.option-group').length;

                const newOptionGroup = document.createElement('div');
                newOptionGroup.classList.add('option-group', 'mb-3');
                newOptionGroup.innerHTML = `
                <div class="form-group">
                    <label for="option_text_${questionIndex}_${optionCount + 1}">Option ${optionCount + 1}</label>
                    <input type="text" name="questions[${questionIndex}][options][${optionCount}][option_text]" id="option_text_${questionIndex}_${optionCount + 1}" class="form-control" required>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="questions[${questionIndex}][options][${optionCount}][is_correct]" id="is_correct_${questionIndex}_${optionCount + 1}" class="form-check-input">
                    <label for="is_correct_${questionIndex}_${optionCount + 1}" class="form-check-label">Is Correct?</label>
                </div>
            `;
                optionsContainer.appendChild(newOptionGroup);
            }
        });
    </script>
@endsection
