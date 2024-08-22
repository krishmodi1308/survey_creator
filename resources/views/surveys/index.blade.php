<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surveys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4 text-center">Surveys</h1>
        <div class="text-center mb-4">
            <a href="{{ route('surveys.create') }}" class="btn btn-primary">Create Survey</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($surveys as $survey)
                        <tr>
                            <td>
                                <span class="text-decoration-none">{{ $survey->name }}</span>
                            </td>
                            <td>
                                <a href="{{ route('surveys.edit', $survey) }}" class="btn btn-warning btn-sm">Edit</a>&nbsp;
                                <form action="{{ route('surveys.destroy', $survey) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>&nbsp;
                                <a href="{{ route('surveys.participate', $survey) }}" class="btn btn-success btn-sm">Participate</a>&nbsp;
                                <a href="{{ route('surveys.report', $survey) }}" class="btn btn-success btn-sm">Report</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $surveys->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
