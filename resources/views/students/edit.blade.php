@extends('layout.format')

@section('title','Edit Student')

@section('content')
@php
    $studentUpdateRoute = session('user_role') === 'admin' ? 'admin.students.update' : 'students.update';
    $studentIndexRoute = session('user_role') === 'admin' ? 'admin.students.index' : 'students.index';
@endphp

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
    <h2 class="mb-3" style="font-family: 'Space Grotesk', sans-serif;">Edit Student</h2>
    <p class="field-hint mb-4">Update the student record using the same clean, balanced layout as the create form.</p>

    <form class="form-card p-4 p-md-5" id="student-edit-panel" action="{{ route($studentUpdateRoute, $student->id) }}" method="POST" data-update-url="{{ route($studentUpdateRoute, $student->id) }}" data-redirect-url="{{ route($studentIndexRoute) }}">
        @csrf
        @method('PUT')
        <input type="hidden" id="student_id" value="{{ $student->id }}">

        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label" for="student_edit_first_name">First Name</label>
                <input type="text" id="student_edit_first_name" name="first_name" value="{{ old('first_name', $student->first_name) }}" class="form-control">
                <small class="text-danger" data-error-for="first_name"></small>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="student_edit_last_name">Last Name</label>
                <input type="text" id="student_edit_last_name" name="last_name" value="{{ old('last_name', $student->last_name) }}" class="form-control">
                <small class="text-danger" data-error-for="last_name"></small>
            </div>

            <div class="col-md-4">
                <label class="form-label" for="student_edit_age">Age</label>
                <input type="number" id="student_edit_age" name="age" value="{{ old('age', $student->age) }}" class="form-control">
                <small class="text-danger" data-error-for="age"></small>
            </div>

            <div class="col-md-8">
                <label class="form-label" for="student_edit_address">Address</label>
                <input type="text" id="student_edit_address" name="address" value="{{ old('address', $student->address) }}" class="form-control">
                <small class="text-danger" data-error-for="address"></small>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="student_edit_contact_number">Contact Number</label>
                <input type="text" id="student_edit_contact_number" name="contact_number" value="{{ old('contact_number', $student->contact_number) }}" class="form-control">
                <small class="text-danger" data-error-for="contact_number"></small>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="student_edit_email">Email</label>
                <input type="email" id="student_edit_email" name="email" value="{{ old('email', $student->email) }}" class="form-control">
                <small class="text-danger" data-error-for="email"></small>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="student_edit_degree_id">Degree</label>
                <select id="student_edit_degree_id" name="degree_id" class="form-select" required>
                    @foreach($degrees as $degree)
                        <option value="{{ $degree->id }}"
                            {{ old('degree_id', $student->degree_id) == $degree->id ? 'selected' : '' }}>
                            {{ $degree->title }}
                        </option>
                    @endforeach
                </select>
                <small class="text-danger" data-error-for="degree_id"></small>
            </div>
        </div>

        <div class="d-flex gap-2 flex-wrap mt-4">
            <button type="submit" id="updateStudentBtn" class="btn btn-lavender">Update Student</button>
            <a href="{{ route($studentIndexRoute) }}" class="btn btn-back-soft">Back</a>
        </div>

        <div class="alert alert-danger rounded-4 mt-4 d-none" id="student-edit-errors"></div>
    </form>
</div>

@endsection
