@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Quizzes</h1>
    <a href="{{ route('quizzes.create') }}" class="btn btn-success mb-3">Create New Quiz</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Duration (Minutes)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quizzes as $quiz)
                <tr>
                    <td>{{ $quiz->title }}</td>
                    <td>{{ $quiz->description }}</td>
                    <td>{{ $quiz->duration }}</td>
                    <td>
                        <a href="{{ route('quizzes.take', $quiz->id) }}" class="btn btn-primary btn-sm">Take Quiz</a>
                        <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this quiz?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection