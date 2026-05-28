<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --ink: #2e2344;
            --soft-panel: rgba(255, 255, 255, 0.88);
            --lavender: #8f7bc7;
            --lavender-deep: #6f5aa8;
            --lavender-mist: #f1ecfb;
            --violet-night: #4c3f72;
            --violet-shadow: #66558f;
        }

        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            background:
                radial-gradient(circle at top left, rgba(143, 123, 199, 0.26), transparent 28%),
                radial-gradient(circle at bottom right, rgba(111, 90, 168, 0.20), transparent 34%),
                linear-gradient(145deg, #fcfaff 0%, #f2eefb 52%, #ece7f8 100%);
            color: var(--ink);
            font-family: 'Outfit', sans-serif;
            padding: 1.5rem;
        }

        .auth-shell {
            width: min(960px, 100%);
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            overflow: hidden;
            border-radius: 28px;
            background: var(--soft-panel);
            border: 1px solid rgba(76, 63, 114, 0.12);
            box-shadow: 0 28px 80px rgba(76, 63, 114, 0.14);
            backdrop-filter: blur(14px);
        }

        .brand-panel {
            padding: 3rem;
            background:
                linear-gradient(160deg, rgba(111, 90, 168, 0.96), rgba(76, 63, 114, 0.98)),
                linear-gradient(160deg, rgba(177, 160, 224, 0.32), transparent);
            color: #fff;
            position: relative;
        }

        .brand-panel::after {
            content: "";
            position: absolute;
            inset: auto -40px -50px auto;
            width: 180px;
            height: 180px;
            border-radius: 32px;
            background: rgba(255, 255, 255, 0.12);
            transform: rotate(22deg);
        }

        .brand-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1;
            margin-bottom: 1rem;
        }

        .brand-copy {
            max-width: 26rem;
            color: rgba(255, 255, 255, 0.82);
            font-size: 1.02rem;
        }

        .form-panel {
            padding: 3rem;
            display: flex;
            align-items: center;
        }

        .form-card {
            width: 100%;
        }

        .eyebrow {
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--lavender-deep);
            font-size: 0.78rem;
            font-weight: 700;
            margin-bottom: 0.85rem;
        }

        .form-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            color: rgba(46, 35, 68, 0.68);
            margin-bottom: 1.8rem;
        }

        .form-control {
            border-radius: 16px;
            padding: 0.9rem 1rem;
            border-color: rgba(111, 90, 168, 0.16);
            background: rgba(255, 255, 255, 0.92);
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(143, 123, 199, 0.18);
            border-color: rgba(143, 123, 199, 0.52);
        }

        .btn-login {
            width: 100%;
            border: none;
            border-radius: 16px;
            padding: 0.95rem 1rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--lavender), var(--lavender-deep));
            box-shadow: 0 16px 30px rgba(111, 90, 168, 0.24);
        }

        .hint-box {
            margin-top: 1rem;
            padding: 0.95rem 1rem;
            border-radius: 16px;
            background: var(--lavender-mist);
            color: rgba(76, 63, 114, 0.82);
            font-size: 0.93rem;
            border: 1px solid rgba(111, 90, 168, 0.12);
        }

        @media (max-width: 768px) {
            .auth-shell {
                grid-template-columns: 1fr;
            }

            .brand-panel,
            .form-panel {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-shell">
        <section class="brand-panel">
            <div class="eyebrow text-white-50">Student Management System</div>
            <h1 class="brand-title">One login page for student, teacher, and admin accounts.</h1>
            <p class="brand-copy">Sign in using the account created by the admin. First-time users will be asked to update their password before accessing their assigned dashboard.</p>
        </section>

        <section class="form-panel">
            <div class="form-card">
                <div class="eyebrow">Login</div>
                <h2 class="form-title">Welcome back</h2>
                <p class="form-subtitle">Sign in using your assigned account to continue to the correct dashboard for your role.</p>

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

                <form action="{{ route('student.login.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="Enter your username">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password">
                    </div>

                    <button type="submit" class="btn-login">Login to Portal</button>
                </form>

                <div class="hint-box">
                    New student and teacher accounts will go to a password update screen first before opening their destination page.
                </div>
            </div>
        </section>
    </div>
</body>
</html>
