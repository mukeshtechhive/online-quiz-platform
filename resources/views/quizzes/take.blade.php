@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $quiz->title }}</h1>
        <p>{{ $quiz->description }}</p>
        <div id="timer" class="alert alert-info">Time Remaining: {{ $quiz->duration }}:00</div>

        <form action="{{ route('quizzes.submit', $quiz->id) }}" method="POST">
            @csrf
            @foreach ($quiz->questions as $question)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $question->question_text }}</h5>
                        @foreach ($question->options as $option)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question_{{ $question->id }}"
                                    id="option_{{ $option->id }}" value="{{ $option->id }}">
                                <label class="form-check-label"
                                    for="option_{{ $option->id }}">{{ $option->option_text }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Submit Quiz</button>
        </form>
    </div>

    <script>
        let time = {{ $quiz->duration * 60 }};
        const timer = setInterval(() => {
            const minutes = Math.floor(time / 60);
            const seconds = time % 60;
            $('#timer').text(`Time Remaining: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`);
            if (time === 0) {
                clearInterval(timer);
                alert('Time is up! Submitting quiz...');
                $('form').submit();
            }
            time--;
        }, 1000);
    </script>
@endsection
