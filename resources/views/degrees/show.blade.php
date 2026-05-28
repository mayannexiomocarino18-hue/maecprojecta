@extends('layout.format')

@section('title','View Degree')

@section('content')

<h2>Degree Details</h2>

<div class="card p-3 shadow">

<p><strong>ID:</strong> {{ $degree->id }}</p>
<p><strong>Degree:</strong> {{ $degree->title }}</p>
<p><strong>Total Students:</strong> {{ $degree->students_count }}</p>

</div>

<br>

<a href="{{ route('admin.degrees.index') }}" class="btn btn-dark">Back</a>

@endsection
