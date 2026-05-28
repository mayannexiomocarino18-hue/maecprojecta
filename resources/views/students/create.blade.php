@extends('layout.format')

@section('title','Add Student')

@section('content')
<style>
    .form-shell {
        max-width: 980px;
        margin: 0 auto;
    }

    .form-card {
        background: rgba(255, 255, 255, 0.90);
        border: 1px solid rgba(111, 90, 168, 0.12);
        border-radius: 28px;
        box-shadow: 0 24px 60px rgba(76, 63, 114, 0.12);
    }

    .form-label {
        font-weight: 600;
        color: #4c3f72;
        margin-bottom: 0.45rem;
    }

    .form-control,
    .form-select {
        min-height: 54px;
        border-radius: 16px;
        border-color: rgba(111, 90, 168, 0.16);
        background: rgba(255, 255, 255, 0.92);
        padding: 0.85rem 1rem;
    }

    .form-control:focus,
    .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(143, 123, 199, 0.18);
        border-color: rgba(143, 123, 199, 0.52);
    }

    .field-hint {
        font-size: 0.92rem;
        color: rgba(76, 63, 114, 0.72);
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

<div class="form-shell">
    <div class="section-eyebrow">Admin Portal</div>
    <h2 class="mb-3" style="font-family: 'Space Grotesk', sans-serif;">Add Student</h2>
    <p class="field-hint mb-4">Create a student record and login account with a balanced, clean form layout.</p>

    <form class="form-card p-4 p-md-5" id="student-create-panel" action="{{ route('admin.students.store') }}" method="POST" data-normal-submit="true" data-store-url="{{ route('admin.students.store') }}" data-redirect-url="{{ route('admin.students.index') }}">
        @csrf
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label" for="student_first_name">First Name</label>
                <input type="text" id="student_first_name" name="first_name" value="{{ old('first_name') }}" class="form-control">
                <small class="text-danger" data-error-for="first_name">@error('first_name'){{ $message }}@enderror</small>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="student_last_name">Last Name</label>
                <input type="text" id="student_last_name" name="last_name" value="{{ old('last_name') }}" class="form-control">
                <small class="text-danger" data-error-for="last_name">@error('last_name'){{ $message }}@enderror</small>
            </div>

            <div class="col-md-4">
                <label class="form-label" for="student_age">Age</label>
                <input type="number" id="student_age" name="age" value="{{ old('age') }}" class="form-control">
                <small class="text-danger" data-error-for="age">@error('age'){{ $message }}@enderror</small>
            </div>

            <div class="col-md-8">
                <label class="form-label" for="student_address">Address</label>
                <input type="text" id="student_address" name="address" value="{{ old('address') }}" class="form-control">
                <small class="text-danger" data-error-for="address">@error('address'){{ $message }}@enderror</small>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="student_contact_number">Contact Number</label>
                <input type="text" id="student_contact_number" name="contact_number" value="{{ old('contact_number') }}" class="form-control">
                <small class="text-danger" data-error-for="contact_number">@error('contact_number'){{ $message }}@enderror</small>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="student_email">Email</label>
                <input type="email" id="student_email" name="email" value="{{ old('email') }}" class="form-control">
                <small class="text-danger" data-error-for="email">@error('email'){{ $message }}@enderror</small>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="student_username">Username</label>
                <input type="text" id="student_username" name="username" value="{{ old('username') }}" class="form-control">
                <small class="text-danger" data-error-for="username">@error('username'){{ $message }}@enderror</small>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="student_password">Password</label>
                <input type="password" id="student_password" name="password" class="form-control">
                <small class="text-danger" data-error-for="password">@error('password'){{ $message }}@enderror</small>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="student_degree_id">Degree</label>
                <select id="student_degree_id" name="degree_id" class="form-select">
                    <option value="">-- Select Degree --</option>
                    @foreach($degrees as $degree)
                        <option value="{{ $degree->id }}" {{ old('degree_id') == $degree->id ? 'selected' : '' }}>
                            {{ $degree->title }}
                        </option>
                    @endforeach
                </select>
                <small class="text-danger" data-error-for="degree_id">@error('degree_id'){{ $message }}@enderror</small>
            </div>
        </div>

        <div class="d-flex gap-2 flex-wrap mt-4">
            <button type="submit" id="saveStudent" class="btn btn-lavender">Save Student</button>
            <a href="{{ route('admin.students.index') }}" class="btn btn-back-soft">Back</a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger rounded-4 mt-4" id="student-create-errors">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @else
            <div class="alert alert-danger rounded-4 mt-4 d-none" id="student-create-errors"></div>
        @endif
    </form>
</div>

@endsection
