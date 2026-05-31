<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #2e2344;
            font-size: 12px;
        }

        h1 {
            margin-bottom: 8px;
            color: #4c3f72;
        }

        .meta {
            margin-bottom: 18px;
            color: #6f5aa8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #d8d0ec;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f1ecfb;
            color: #4c3f72;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p class="meta">Date: {{ $date }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Degree</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ trim($student->first_name . ' ' . $student->last_name) }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->contact_number }}</td>
                    <td>{{ optional($student->degree)->title ?? 'No degree assigned' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No student records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
