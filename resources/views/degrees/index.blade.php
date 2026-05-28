@extends('layout.format')

@section('title','Degrees')

@section('content')
<div class="page-card p-4 p-md-5">
    <div class="section-eyebrow">Admin Dashboard</div>
    <h2 class="mb-3" style="font-family: 'Space Grotesk', sans-serif;">Degrees List</h2>

    <div class="alert alert-soft rounded-4">
        <strong>Welcome Admin</strong>
    </div>

    <div class="d-flex gap-2 flex-wrap mb-4">
        <a href="{{ route('admin.degrees.create') }}" class="btn btn-lavender">
            + Add Degree
        </a>
    </div>

    @if(session('message'))
        <div class="alert alert-soft rounded-4">
            {{ session('message') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger rounded-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-shell mt-4">
        <table class="table table-theme">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Degree Name</th>
                    <th>No. of Students</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($degrees as $degree)
                <tr>
                    <td>{{ $degree->id }}</td>
                    <td>{{ $degree->title }}</td>
                    <td>{{ $degree->students()->count() }}</td>
                    <td>
                        <a href="{{ route('admin.degrees.show',$degree->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('admin.degrees.edit',$degree->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button
                            type="button"
                            class="btn btn-danger btn-sm delete-degree-btn"
                            data-delete-url="{{ route('admin.degrees.destroy',$degree->id) }}"
                            data-redirect-url="{{ route('admin.degrees.index') }}">
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
