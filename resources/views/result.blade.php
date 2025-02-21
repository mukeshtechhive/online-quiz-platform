@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Quiz Result</h1>
        <div class="alert alert-success">
            <h4>Your Score: {{ $score }}/{{ $totalQuestions }}</h4>
        </div>
        <a href="{{ route('quizzes.index') }}" class="btn btn-primary">Back to Quizzes</a>
    </div>
@endsection
