@extends('layouts.admin')

@section('title', 'Propsgh | Message Details')

@section('content')
<div class="admin-page-header d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
        <h1 class="h3 mb-1">Message from {{ $message->name }}</h1>
        <p class="text-body-secondary mb-0">Received {{ $message->created_at?->format('M d, Y \\a\\t H:i') }}</p>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1" href="{{ route('admin.messages.index') }}">
            <i class="fi-chevron-left fs-sm"></i> Back to inbox
        </a>
        <form method="POST" action="{{ route('admin.messages.destroy', $message) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm d-inline-flex align-items-center gap-1">
                <i class="fi-trash-2 fs-sm"></i> Delete
            </button>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="text-body-secondary fs-xs text-uppercase fw-semibold mb-1">Sender</div>
                <div class="fw-semibold">{{ $message->name }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-body-secondary fs-xs text-uppercase fw-semibold mb-1">Email</div>
                <div>
                    <a href="mailto:{{ $message->email }}" class="text-decoration-none">{{ $message->email }}</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-body-secondary fs-xs text-uppercase fw-semibold mb-1">Received</div>
                <div>{{ $message->created_at?->format('M d, Y H:i') }}</div>
            </div>
        </div>
        <div class="text-body-secondary fs-xs text-uppercase fw-semibold mb-2">Message</div>
        <div class="bg-body-tertiary rounded-4 p-4">
            <p class="mb-0">{{ $message->message }}</p>
        </div>
    </div>
</div>
@endsection
