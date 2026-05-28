<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --ink: #2e2344;
            --lavender: #8f7bc7;
            --lavender-deep: #6f5aa8;
            --lavender-mist: #f1ecfb;
            --violet-night: #4c3f72;
            --violet-shadow: #66558f;
            --panel: rgba(255, 255, 255, 0.88);
            --line: rgba(111, 90, 168, 0.12);
        }

        html, body {
            height: 100%;
            background:
                radial-gradient(circle at top left, rgba(143, 123, 199, 0.24), transparent 30%),
                radial-gradient(circle at bottom right, rgba(111, 90, 168, 0.18), transparent 32%),
                linear-gradient(145deg, #fcfaff 0%, #f2eefb 52%, #ece7f8 100%);
            color: var(--ink);
            font-family: 'Outfit', sans-serif;
        }

        .wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1;
        }

        .navbar {
            background: rgba(76, 63, 114, 0.94) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-brand {
            font-family: 'Space Grotesk', sans-serif;
            letter-spacing: 0.04em;
            font-weight: 700;
        }

        .nav-shell {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .nav-form {
            display: flex;
            align-items: center;
            margin: 0;
        }

        .btn-ghost-light {
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.22);
            color: #fff;
            background: rgba(255, 255, 255, 0.06);
            padding-inline: 0.95rem;
        }

        .btn-ghost-light:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.14);
            border-color: rgba(255, 255, 255, 0.35);
        }

        .page-card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 28px;
            box-shadow: 0 28px 80px rgba(76, 63, 114, 0.14);
            backdrop-filter: blur(14px);
        }

        .btn-accent {
            background: linear-gradient(135deg, var(--lavender), var(--lavender-deep));
            border: none;
            color: #fff;
        }

        .btn-accent:hover {
            color: #fff;
            opacity: 0.95;
        }

        .section-eyebrow {
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--lavender-deep);
            font-size: 0.78rem;
            font-weight: 700;
            margin-bottom: 0.85rem;
        }

        .soft-panel {
            border-radius: 24px;
            padding: 1.5rem;
            background: linear-gradient(180deg, rgba(143, 123, 199, 0.08), rgba(111, 90, 168, 0.10));
            border: 1px solid rgba(111, 90, 168, 0.10);
        }

        .btn-lavender {
            border: none;
            border-radius: 16px;
            padding: 0.9rem 1.15rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--lavender), var(--lavender-deep));
            box-shadow: 0 16px 30px rgba(111, 90, 168, 0.22);
        }

        .btn-lavender:hover {
            color: #fff;
            opacity: 0.96;
        }

        .alert-soft {
            border: 1px solid rgba(111, 90, 168, 0.12);
            background: var(--lavender-mist);
            color: var(--violet-night);
        }

        .table-shell {
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(111, 90, 168, 0.12);
            box-shadow: 0 18px 50px rgba(76, 63, 114, 0.10);
            background: rgba(255, 255, 255, 0.78);
        }

        .table-theme {
            margin-bottom: 0;
        }

        .table-theme thead th {
            background: linear-gradient(135deg, rgba(76, 63, 114, 0.98), rgba(111, 90, 168, 0.96));
            color: #fff;
            border-color: rgba(255, 255, 255, 0.06);
        }

        .table-theme tbody tr:nth-child(even) {
            background: rgba(241, 236, 251, 0.45);
        }

        .table-theme tbody td {
            border-color: rgba(111, 90, 168, 0.10);
            vertical-align: middle;
        }

        .confirm-overlay {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background: rgba(46, 35, 68, 0.30);
            backdrop-filter: blur(8px);
            z-index: 1080;
        }

        .confirm-overlay.is-visible {
            display: flex;
        }

        .confirm-dialog {
            width: min(100%, 460px);
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid rgba(111, 90, 168, 0.14);
            border-radius: 28px;
            box-shadow: 0 24px 70px rgba(76, 63, 114, 0.20);
            padding: 1.75rem;
        }

        .confirm-eyebrow {
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--lavender-deep);
            font-size: 0.76rem;
            font-weight: 700;
            margin-bottom: 0.9rem;
        }

        .confirm-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.6rem;
            line-height: 1.2;
            color: var(--violet-night);
            margin-bottom: 0.75rem;
        }

        .confirm-message {
            color: rgba(46, 35, 68, 0.82);
            margin-bottom: 1.5rem;
        }

        .confirm-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-confirm-cancel {
            border-radius: 16px;
            padding: 0.8rem 1.15rem;
            font-weight: 700;
            color: #5d4b86;
            background: rgba(241, 236, 251, 0.95);
            border: 1px solid rgba(111, 90, 168, 0.16);
        }

        .btn-confirm-cancel:hover {
            color: #4c3f72;
            background: rgba(232, 224, 248, 0.95);
            border-color: rgba(111, 90, 168, 0.24);
        }

        .btn-confirm-danger {
            border: none;
            border-radius: 16px;
            padding: 0.8rem 1.15rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #ec5b75, #d83d5b);
            box-shadow: 0 16px 30px rgba(216, 61, 91, 0.24);
        }

        .btn-confirm-danger:hover {
            color: #fff;
            opacity: 0.96;
        }

        footer {
            background: rgba(76, 63, 114, 0.98);
            color: white;
            text-align: center;
            padding: 14px;
            font-size: 0.92rem;
            letter-spacing: 0.03em;
        }
    </style>
</head>

<body>

<div class="wrapper">
    <nav class="navbar navbar-dark">
        <div class="container">
            <span class="navbar-brand">Student Management System</span>

            <div class="nav-shell">
                @if(session()->has('user_account_id') && session('user_role') === 'admin')
                    <a href="{{ route('admin.students.index') }}" class="btn btn-ghost-light btn-sm">Students</a>
                    <a href="{{ route('admin.degrees.index') }}" class="btn btn-ghost-light btn-sm">Degrees</a>
                    <a href="{{ route('admin.pdf.report') }}" class="btn btn-ghost-light btn-sm">PDF Report</a>
                @endif
                @if(!session()->has('user_account_id') || session('user_role') === 'admin')
                    <a href="/about" class="btn btn-ghost-light btn-sm">About</a>
                @endif
                @if(session()->has('user_account_id'))
                    <form action="{{ route('logout') }}" method="POST" class="nav-form">
                        @csrf
                        <button class="btn btn-accent btn-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('student.login') }}" class="btn btn-accent btn-sm">Login</a>
                @endif
            </div>
        </div>
    </nav>

    <div class="container mt-4 content">
        @yield('content')
    </div>

    <footer>
        &copy; 2026 | Anne Alleje | Student Management System | All Rights Reserved.
    </footer>
</div>

<div class="confirm-overlay" id="confirmOverlay" aria-hidden="true">
    <div class="confirm-dialog">
        <div class="confirm-eyebrow" id="confirmEyebrow">Please Confirm</div>
        <div class="confirm-title" id="confirmTitle">Delete Student</div>
        <div class="confirm-message" id="confirmMessage">Are you sure you want to delete this record?</div>
        <div class="confirm-actions">
            <button type="button" class="btn btn-confirm-cancel" id="confirmCancelBtn">Cancel</button>
            <button type="button" class="btn btn-confirm-danger" id="confirmOkBtn">Delete</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
@if (file_exists(public_path('build/manifest.json')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    <script src="{{ asset('js/app.js') }}"></script>
@endif
@stack('scripts')
</body>
</html>
