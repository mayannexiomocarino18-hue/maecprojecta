@extends('layout.format')

@section('title','Add Teacher')

@section('content')
<style>
    .teacher-form-shell {
        max-width: 760px;
        margin: 0 auto;
    }

    .teacher-form-card {
        background: rgba(255, 255, 255, 0.90);
        border: 1px solid rgba(111, 90, 168, 0.12);
        border-radius: 28px;
        box-shadow: 0 24px 60px rgba(76, 63, 114, 0.12);
    }

    .teacher-form-label {
        font-weight: 600;
        color: #4c3f72;
        margin-bottom: 0.45rem;
    }

    .teacher-form-input {
        min-height: 54px;
        border-radius: 16px;
        border-color: rgba(111, 90, 168, 0.16);
        background: rgba(255, 255, 255, 0.92);
        padding: 0.85rem 1rem;
    }

    .teacher-form-input:focus {
        box-shadow: 0 0 0 0.25rem rgba(143, 123, 199, 0.18);
        border-color: rgba(143, 123, 199, 0.52);
    }

    .btn-back-soft {
        border-radius: 16px;
        padding: 0.9rem 1.2rem;
        font-weight: 700;
        color: #5d4b86;
        background: rgba(241, 236, 251, 0.95);
        border: 1px solid rgba(111, 90, 168, 0.16);
    }

    .btn-back-soft:hover {
        color: #4c3f72;
        background: rgba(232, 224, 248, 0.95);
        border-color: rgba(111, 90, 168, 0.24);
    }
</style>

<div class="teacher-form-shell">
    <div class="section-eyebrow">Admin Portal</div>
    <h2 class="mb-3" style="font-family: 'Space Grotesk', sans-serif;">Add Teacher Account</h2>
    <p class="field-hint mb-4">Create a teacher login account with a tighter, cleaner form layout.</p>

    <form class="teacher-form-card p-4 p-md-5" id="teacher-create-panel" action="{{ route('admin.teachers.store') }}" method="POST" data-normal-submit="true" data-store-url="{{ route('admin.teachers.store') }}" data-redirect-url="{{ route('admin.students.index') }}">
        @csrf
        <div class="row g-4">
            <div class="col-12">
                <label class="teacher-form-label" for="teacher_username">Username</label>
                <input type="text" id="teacher_username" name="username" value="{{ old('username') }}" class="form-control teacher-form-input">
                <small class="text-danger" data-error-for="username">@error('username'){{ $message }}@enderror</small>
            </div>

            <div class="col-12">
                <label class="teacher-form-label" for="teacher_email">Email</label>
                <input type="email" id="teacher_email" name="email" value="{{ old('email') }}" class="form-control teacher-form-input">
                <small class="text-danger" data-error-for="email">@error('email'){{ $message }}@enderror</small>
            </div>

            <div class="col-12">
                <label class="teacher-form-label" for="teacher_password">Password</label>
                <input type="password" id="teacher_password" name="password" class="form-control teacher-form-input">
                <small class="text-danger" data-error-for="password">@error('password'){{ $message }}@enderror</small>
            </div>
        </div>

        <div class="d-flex gap-2 flex-wrap mt-4">
            <button type="submit" id="saveTeacher" class="btn btn-lavender">Save Teacher</button>
            <a href="{{ route('admin.students.index') }}" class="btn btn-back-soft">Back</a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger rounded-4 mt-4" id="teacher-create-errors">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @else
            <div class="alert alert-danger rounded-4 mt-4 d-none" id="teacher-create-errors"></div>
        @endif
    </form>
</div>
@endsection
