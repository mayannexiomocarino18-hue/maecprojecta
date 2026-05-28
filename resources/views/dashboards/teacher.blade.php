@extends('layout.format')

@section('title','Teacher Dashboard')

@section('content')
<div class="page-card p-4 p-md-5">
    <div class="section-eyebrow">Teacher Dashboard</div>
    <h1 class="mb-3" style="font-family: 'Space Grotesk', sans-serif;">Welcome Teacher</h1>
    <p class="lead mb-4">Hello, <strong>{{ $displayName }}</strong>. You are now logged in using your teacher account.</p>

    @if(session('message'))
        <div class="alert alert-soft rounded-4">{{ session('message') }}</div>
    @endif

    <div class="soft-panel">
        <div><strong>Account:</strong> {{ $userAccount->username }}</div>
        <div><strong>Email:</strong> {{ $userAccount->email }}</div>
        <div><strong>Role:</strong> Teacher</div>
    </div>
</div>
@endsection
