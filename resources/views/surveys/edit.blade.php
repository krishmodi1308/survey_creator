<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Survey</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4 text-center">Edit Survey</h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('surveys.update', $survey->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="form-label">Survey Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $survey->name) }}" required>
                    </div>

                    <div id="questions">
                        @foreach($survey->questions as $index => $question)
                            <div class="question mb-4">
                                <div class="mb-3">
                                    <label class="form-label">Question</label>
                                    <input type="text" name="questions[{{ $index }}][text]" class="form-control" value="{{ old('questions.' . $index . '.text', $question->question_text) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Type</label>
                                    <select name="questions[{{ $index }}][type]" class="form-select">
                                        <option value="text" {{ $question->type == 'text' ? 'selected' : '' }}>Text</option>
                                        <option value="radio" {{ $question->type == 'radio' ? 'selected' : '' }}>Radio</option>
                                        <option value="checkbox" {{ $question->type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                    </select>
                                </div>
                                <div class="mb-3 options" style="{{ in_array($question->type, ['radio', 'checkbox']) ? 'display:block;' : 'display:none;' }}">
                                    <label class="form-label">Options</label>
                                    @foreach($question->options as $optionIndex => $option)
                                        <input type="text" name="questions[{{ $index }}][options][{{ $optionIndex }}]" class="form-control mt-2" value="{{ old('questions.' . $index . '.options.' . $optionIndex, $option->option_text) }}">
                                    @endforeach
                                    <!-- <button type="button" class="add-option btn btn-sm btn-secondary mt-2">Add Option</button> -->
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- <button type="button" id="add-question" class="btn btn-outline-primary mb-4">Add Question</button> -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Update Survey</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        let questionIndex = {{ count($survey->questions) }};

        document.getElementById('add-question').addEventListener('click', function () {
            let questionHtml = `
                <div class="question mb-4">
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" name="questions[${questionIndex}][text]" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="questions[${questionIndex}][type]" class="form-select">
                            <option value="text">Text</option>
                            <option value="radio">Radio</option>
                            <option value="checkbox">Checkbox</option>
                        </select>
                    </div>
                    <div class="mb-3 options" style="display:none;">
                        <label class="form-label">Options</label>
                        <input type="text" name="questions[${questionIndex}][options][]" class="form-control">
                        <button type="button" class="add-option btn btn-sm btn-secondary mt-2">Add Option</button>
                    </div>
                </div>`;
            document.getElementById('questions').insertAdjacentHTML('beforeend', questionHtml);
            questionIndex++;
        });

        document.getElementById('questions').addEventListener('change', function (e) {
            if (e.target.tagName === 'SELECT' && e.target.name.includes('[type]')) {
                const optionsDiv = e.target.closest('.question').querySelector('.options');
                if (e.target.value === 'radio' || e.target.value === 'checkbox') {
                    optionsDiv.style.display = 'block';
                } else {
                    optionsDiv.style.display = 'none';
                }
            }
        });

        document.getElementById('questions').addEventListener('click', function (e) {
            if (e.target.classList.contains('add-option')) {
                e.preventDefault();
                let optionInput = document.createElement('input');
                optionInput.type = 'text';
                optionInput.name = e.target.closest('.question').querySelector('.options input').name;
                optionInput.classList.add('form-control', 'mt-2');
                e.target.before(optionInput);
            }
        });
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
