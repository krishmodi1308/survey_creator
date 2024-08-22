<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey: {{ $survey->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .survey-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-title {
            margin-bottom: 30px;
            text-align: center;
            color: #343a40;
        }
        .form-group label {
            font-weight: bold;
            color: #495057;
        }
        .btn-custom {
            background-color: #28a745;
            color: #ffffff;
            border-radius: 25px;
            padding: 10px 30px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
        .form-check-label {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="survey-container mx-auto col-lg-8">
            <h1 class="form-title">Survey: {{ $survey->name }}</h1>
            <form action="{{ route('surveys.submit', $survey) }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" name="user[name]" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label for="age" class="form-label">Age:</label>
                    <input type="number" name="user[age]" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label for="sex" class="form-label">Sex:</label>
                    <select name="user[sex]" class="form-select" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                @foreach($survey->questions as $question)
                    <div class="mb-4">
                        <label class="form-label">{{ $question->question_text }}</label>
                        @if($question->type == 'text')
                            <input type="text" name="answers[{{ $question->id }}]" class="form-control">
                        @elseif($question->type == 'radio')
                            @foreach($question->options as $option)
                                <div class="form-check">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->option_text }}" class="form-check-input">
                                    <label class="form-check-label">{{ $option->option_text }}</label>
                                </div>
                            @endforeach
                        @elseif($question->type == 'checkbox')
                            @foreach($question->options as $option)
                                <div class="form-check">
                                    <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option->option_text }}" class="form-check-input">
                                    <label class="form-check-label">{{ $option->option_text }}</label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endforeach

                <div class="text-center">
                    <button type="submit" class="btn btn-custom">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
