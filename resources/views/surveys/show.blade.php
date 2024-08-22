@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $survey->name }}</h1>
    <ul>
        @foreach($survey->questions as $question)
            <li>{{ $question->question_text }}</li>
        @endforeach
    </ul>
    <a href="{{ route('surveys.index') }}" class="btn btn-primary">Back to Surveys</a>
</div>
@endsection
