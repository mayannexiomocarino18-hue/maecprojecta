<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Outfit', sans-serif;
            background:
                radial-gradient(circle at top right, rgba(232, 93, 4, 0.18), transparent 24%),
                radial-gradient(circle at bottom left, rgba(31, 111, 139, 0.20), transparent 30%),
                linear-gradient(135deg, #fefbf6 0%, #edf4fc 100%);
            color: #132238;
            display: grid;
            place-items: center;
            padding: 1.5rem;
        }

        .password-shell {
            width: min(780px, 100%);
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(19, 34, 56, 0.08);
            border-radius: 28px;
            box-shadow: 0 24px 70px rgba(19, 34, 56, 0.12);
            overflow: hidden;
        }

        .hero {
            padding: 2.25rem 2.25rem 1.25rem;
            background: linear-gradient(140deg, #16324f, #2a5f98);
            color: #fff;
        }

        .hero h1 {
            font-family: 'Space Grotesk', sans-serif;
            margin-bottom: 0.5rem;
        }

        .hero p {
            max-width: 38rem;
            margin-bottom: 0;
            color: rgba(255, 255, 255, 0.84);
        }

        .content {
            padding: 2rem 2.25rem 2.25rem;
        }

        .student-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1rem;
            border-radius: 999px;
            background: rgba(232, 93, 4, 0.10);
            color: #bb3e03;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .form-control {
            border-radius: 16px;
            padding: 0.92rem 1rem;
        }

        .btn-update {
            border: none;
            border-radius: 16px;
            padding: 0.95rem 1.2rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #e85d04, #bb3e03);
        }

        .btn-outline-soft {
            border-radius: 16px;
            padding: 0.95rem 1.2rem;
        }
    </style>
</head>
<body>
    <div class="password-shell">
        <div class="hero">
            <h1>First login detected</h1>
            <p>Before entering your dashboard, update your password once. After this step, future logins will take you directly to the correct landing page for your account.</p>
        </div>

        <div class="content">
            <div class="student-badge">
                Account: {{ $displayName }} | Username: {{ $userAccount->username }} | Role: {{ ucfirst($userAccount->role) }}
            </div>

            @if(session('message'))
                <div class="alert alert-success rounded-4">
                    {{ session('message') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger rounded-4">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('student.password.update') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control" placeholder="Enter current password">
                </div>

                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control" placeholder="Enter new password">
                </div>

                <div class="mb-4">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm new password">
                </div>

                <div class="d-flex gap-2 flex-wrap">
                    <button type="submit" class="btn-update">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
