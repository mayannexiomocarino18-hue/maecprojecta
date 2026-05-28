@extends('layout.format')

@section('title','Students')

@section('content')
<div class="page-card p-4 p-md-5">
    <div class="section-eyebrow">{{ session('user_role') === 'admin' ? 'Admin Dashboard' : 'Student List' }}</div>
    <h2 class="mb-3" style="font-family: 'Space Grotesk', sans-serif;">Students List</h2>

    @if(session('user_role') === 'admin')
        <div class="alert alert-soft rounded-4">
            <strong>Welcome Admin</strong>
        </div>
        <div class="d-flex gap-2 flex-wrap mb-4">
            <a href="{{ route('admin.students.create') }}" class="btn btn-lavender">
                + Add Student
            </a>
            <a href="{{ route('admin.teachers.create') }}" class="btn btn-lavender">
                + Add Teacher
            </a>
        </div>
    @endif

    @if(session('message'))
        <div class="alert alert-soft rounded-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="table-shell mt-4">
    <table class="table table-theme">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact Number</th>
            <th>Degree</th>
            @if(session('user_role') === 'admin')
                <th>Actions</th>
            @endif
        </tr>
    </thead>

    <tbody>
        @foreach($students as $student)
        <tr>
            <td>{{ $student->id }}</td>
            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
            <td>{{ $student->email }}</td>
            <td>{{ $student->contact_number }}</td>
            <td>{{ optional($student->degree)->title ?? 'No degree assigned' }}</td>
            @if(session('user_role') === 'admin')
                <td>
                    <a href="{{ route('admin.students.show',$student->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('admin.students.edit',$student->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <button
                        type="button"
                        class="btn btn-danger btn-sm delete-student-btn"
                        data-delete-url="{{ route('admin.students.destroy',$student->id) }}"
                        data-redirect-url="{{ route('admin.students.index') }}">
                        Delete
                    </button>
                </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
</div>

<div class="mt-4">
    {{ $students->links() }}
</div>
</div>

@endsection
