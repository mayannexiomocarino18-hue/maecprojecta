@extends('layout.format')

@section('title','Edit Degree')

@section('content')
<style>
    .degree-form-shell {
        max-width: 720px;
        margin: 0 auto;
    }

    .degree-form-card {
        background: rgba(255, 255, 255, 0.90);
        border: 1px solid rgba(111, 90, 168, 0.12);
        border-radius: 28px;
        box-shadow: 0 24px 60px rgba(76, 63, 114, 0.12);
    }

    .degree-form-label {
        font-weight: 600;
        color: #4c3f72;
        margin-bottom: 0.45rem;
    }

    .degree-form-input {
        min-height: 54px;
        border-radius: 16px;
        border-color: rgba(111, 90, 168, 0.16);
        background: rgba(255, 255, 255, 0.92);
        padding: 0.85rem 1rem;
    }

    .degree-form-input:focus {
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

<div class="degree-form-shell">
    <div class="section-eyebrow">Admin Portal</div>
    <h2 class="mb-3" style="font-family: 'Space Grotesk', sans-serif;">Edit Degree</h2>

    <form class="degree-form-card p-4 p-md-5" id="degree-edit-panel" action="{{ route('admin.degrees.update',$degree->id) }}" method="POST" data-update-url="{{ route('admin.degrees.update',$degree->id) }}" data-redirect-url="{{ route('admin.degrees.index') }}">
        @csrf
        @method('PUT')
        <input type="hidden" id="degree_id" value="{{ $degree->id }}">

        <div class="mb-3">
            <label class="degree-form-label" for="degree_edit_title">Degree Name</label>
            <input type="text" id="degree_edit_title" name="title" class="form-control degree-form-input" value="{{ old('title', $degree->title) }}">
            <small class="text-danger" data-error-for="title">@error('title') {{ $message }} @enderror</small>
        </div>

        <div class="d-flex gap-2 flex-wrap mt-4">
            <button type="submit" id="updateDegreeBtn" class="btn btn-lavender">Update Degree</button>
            <a href="{{ route('admin.degrees.index') }}" class="btn btn-back-soft">Back</a>
        </div>

        <div class="alert alert-danger rounded-4 mt-4 d-none" id="degree-edit-errors"></div>
    </form>
</div>

@endsection
