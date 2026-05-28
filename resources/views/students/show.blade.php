@extends('layout.format')

@section('title','View Student')

@section('content')

@php
    $studentIndexRoute = session('user_role') === 'admin' ? 'admin.students.index' : 'students.index';
@endphp

<h2>Student Details</h2>

<div class="card p-3 shadow">

<p><strong>ID:</strong> {{ $student->id }}</p>
<p><strong>Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
<p><strong>Email:</strong> {{ $student->email }}</p>
<p><strong>Contact Number:</strong> {{ $student->contact_number }}</p>
<p><strong>Age:</strong> {{ $student->age }}</p>
<p><strong>Address:</strong> {{ $student->address }}</p>
<p><strong>Degree:</strong> {{ optional($student->degree)->title ?? 'No degree assigned' }}</p>

</div>

<br>

<a href="{{ route($studentIndexRoute) }}" class="btn btn-dark">Back</a>

@endsection
