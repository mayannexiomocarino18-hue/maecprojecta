<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Welcome</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Outfit', sans-serif;
            color: #132238;
            background:
                radial-gradient(circle at top left, rgba(31, 111, 139, 0.2), transparent 24%),
                radial-gradient(circle at bottom right, rgba(232, 93, 4, 0.22), transparent 32%),
                linear-gradient(145deg, #f7fbff 0%, #fff8ef 100%);
            display: grid;
            place-items: center;
            padding: 1.5rem;
        }

        .welcome-shell {
            width: min(920px, 100%);
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 30px;
            overflow: hidden;
            border: 1px solid rgba(19, 34, 56, 0.08);
            box-shadow: 0 28px 80px rgba(19, 34, 56, 0.12);
        }

        .visual {
            min-height: 100%;
            padding: 2.5rem;
            background:
                linear-gradient(160deg, rgba(12, 40, 76, 0.96), rgba(42, 95, 152, 0.96)),
                linear-gradient(160deg, rgba(232, 93, 4, 0.26), transparent);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .visual h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(2rem, 4vw, 3.1rem);
            line-height: 1.05;
        }

        .visual p {
            color: rgba(255, 255, 255, 0.82);
            max-width: 24rem;
        }

        .chip {
            display: inline-flex;
            border-radius: 999px;
            padding: 0.65rem 0.95rem;
            background: rgba(255, 255, 255, 0.12);
            font-size: 0.92rem;
            width: fit-content;
        }

        .content {
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .eyebrow {
            text-transform: uppercase;
            letter-spacing: 0.18em;
            font-weight: 700;
            font-size: 0.8rem;
            color: #e85d04;
            margin-bottom: 0.8rem;
        }

        .name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2rem;
            margin-bottom: 0.75rem;
        }

        .summary {
            color: rgba(19, 34, 56, 0.7);
            margin-bottom: 1.6rem;
        }

        .info-card {
            border-radius: 22px;
            padding: 1.2rem 1.25rem;
            background: linear-gradient(180deg, rgba(41, 95, 152, 0.08), rgba(232, 93, 4, 0.08));
            margin-bottom: 1.6rem;
        }

        .btn-primary-hero {
            border: none;
            border-radius: 16px;
            padding: 0.95rem 1.15rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
            background: linear-gradient(135deg, #e85d04, #bb3e03);
            text-align: center;
        }

        .btn-primary-hero:hover {
            color: #fff;
        }

        .btn-soft {
            border-radius: 16px;
            padding: 0.95rem 1.15rem;
        }

        @media (max-width: 768px) {
            .welcome-shell {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-shell">
        <section class="visual">
            <div>
                <div class="chip">Student Access Approved</div>
                <h1>Welcome, {{ $student?->first_name ?? $userAccount->username }}.</h1>
                <p>Your account is active and your password has already been updated. You can now enter the student page anytime after login.</p>
            </div>
            <div class="chip">Username: {{ $userAccount->username }}</div>
        </section>

        <section class="content">
            <div class="eyebrow">Portal Ready</div>
            <div class="name">{{ $student?->first_name }} {{ $student?->last_name }}</div>
            <p class="summary">This is your student landing page. Use the button below to continue to the full student list view.</p>

            @if(session('message'))
                <div class="alert alert-success rounded-4">{{ session('message') }}</div>
            @endif

            <div class="info-card">
                <div><strong>Email:</strong> {{ $student?->email ?? $userAccount->email }}</div>
                <div><strong>Status:</strong> Active student account</div>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('students.index') }}" class="btn-primary-hero">Go to Student Page</a>
            </div>
        </section>
    </div>
</body>
</html>
