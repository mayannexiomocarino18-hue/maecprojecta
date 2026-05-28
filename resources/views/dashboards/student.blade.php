@extends('layout.format')

@section('title','Student Dashboard')

@section('content')
<div class="page-card p-4 p-md-5">
    <div class="section-eyebrow">Student Dashboard</div>
    <h1 class="mb-3" style="font-family: 'Space Grotesk', sans-serif;">Welcome {{ $userAccount->username }}</h1>
    <p class="lead mb-4">You are now logged in to your student account.</p>

    @if(session('message'))
        <div class="alert alert-soft rounded-4">{{ session('message') }}</div>
    @endif

    <div class="soft-panel mb-4">
        <div><strong>Username:</strong> {{ $userAccount->username }}</div>
        <div><strong>Email:</strong> {{ $userAccount->email }}</div>
        <div><strong>Role:</strong> Student</div>
    </div>
</div>
@endsection
