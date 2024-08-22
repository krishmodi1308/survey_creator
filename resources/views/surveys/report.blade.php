<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Survey Report</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Question</th>
                                <th>Type</th>
                                <th>Answer 1</th>
                                <th>Answer 2</th>
                                <th>Answer 3</th>
                                <th>Answer 4</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reportData as $data)
                            <tr>
                                <td>{{ $data['question'] }}</td>
                                <td>{{ ucfirst($data['type']) }}</td>
                                @foreach($data['answers'] as $answer)
                                <td>{{ $answer }}</td>
                                @endforeach
                                @for($i = count($data['answers']); $i < 4; $i++)
                                <td></td>
                                @endfor
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-muted text-center">
                Survey Report generated on {{ now()->format('F j, Y') }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
