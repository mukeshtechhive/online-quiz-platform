@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Options to Question</h1>
    <p><strong>Question:</strong> {{ $question->question_text }}</p>

    <form action="{{ route('questions.options.store', $question->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="option_text">Option Text</label>
            <input type="text" name="option_text" id="option_text" class="form-control" required>
        </div>
        <div class="form-check">
            <input type="checkbox" name="is_correct" id="is_correct" class="form-check-input">
            <label for="is_correct" class="form-check-label">Is Correct?</label>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Add Option</button>
    </form>

    <h3 class="mt-5">Options</h3>
    <ul class="list-group">
        @foreach ($question->options as $option)
            <li class="list-group-item">
                {{ $option->option_text }}
                @if ($option->is_correct)
                    <span class="badge badge-success">Correct</span>
                @endif
            </li>
        @endforeach
    </ul>
</div>
@endsection