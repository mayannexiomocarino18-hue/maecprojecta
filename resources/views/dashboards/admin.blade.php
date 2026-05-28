@extends('layout.format')

@section('title','Admin Dashboard')

@section('content')
<div class="page-card p-4 p-md-5">
    <div class="mb-3 text-uppercase fw-bold" style="letter-spacing: 0.18em; color: #6f5aa8;">Admin Dashboard</div>
    <h1 class="mb-3" style="font-family: 'Space Grotesk', sans-serif;">Welcome Admin</h1>
    <p class="lead mb-4">Hello, <strong>{{ $displayName }}</strong>. You can manage student and teacher accounts from here.</p>

    @if(session('message'))
        <div class="alert alert-success rounded-4">{{ session('message') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-md-4">
            <div class="rounded-4 h-100 p-4" style="background: linear-gradient(180deg, rgba(143, 123, 199, 0.10), rgba(111, 90, 168, 0.12));">
                <h4>Add Student</h4>
                <p class="mb-4">Create a new student record and student account.</p>
                <a href="{{ route('students.create') }}" class="btn btn-success">Go to Student Form</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="rounded-4 h-100 p-4" style="background: linear-gradient(180deg, rgba(143, 123, 199, 0.10), rgba(111, 90, 168, 0.12));">
                <h4>Add Teacher</h4>
                <p class="mb-4">Create a teacher account with first-login password update.</p>
                <a href="{{ route('teachers.create') }}" class="btn btn-primary">Go to Teacher Form</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="rounded-4 h-100 p-4" style="background: linear-gradient(180deg, rgba(143, 123, 199, 0.10), rgba(111, 90, 168, 0.12));">
                <h4>Student List</h4>
                <p class="mb-4">View and manage the current student records.</p>
                <a href="{{ route('students.index') }}" class="btn btn-dark">Open Students</a>
            </div>
        </div>
    </div>
</div>
@endsection
