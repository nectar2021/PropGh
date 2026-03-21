@extends('layouts.admin')

@section('title', 'Propsgh | Inquiries')

@section('content')
<div class="admin-page-header d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
        <h1 class="h3 mb-1">Property Inquiries</h1>
        <p class="text-body-secondary mb-0">Tour requests and messages from potential clients.</p>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success d-flex align-items-center gap-2">
        <i class="fi-check-circle"></i>{{ session('status') }}
    </div>
@endif

{{-- Filters --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.inquiries.index') }}" class="d-flex flex-wrap align-items-center gap-3">
            <div class="flex-grow-1" style="min-width: 200px; max-width: 360px;">
                <div class="input-group">
                    <span class="input-group-text"><i class="fi-search fs-sm"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by name, email, or property" value="{{ request('search') }}">
                </div>
            </div>
            <select name="type" class="form-select" style="width: auto; min-width: 150px;">
                <option value="">All types</option>
                <option value="tour" {{ request('type') === 'tour' ? 'selected' : '' }}>Tour requests</option>
                <option value="message" {{ request('type') === 'message' ? 'selected' : '' }}>Messages</option>
            </select>
            <button type="submit" class="btn btn-outline-primary btn-sm">Filter</button>
            @if (request()->hasAny(['search', 'type']))
                <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
            @endif
        </form>
    </div>
</div>

{{-- Stats --}}
@php
    $totalInquiries = \App\Models\PropertyInquiry::count();
    $tourCount = \App\Models\PropertyInquiry::where('type', 'tour')->count();
    $messageCount = \App\Models\PropertyInquiry::where('type', 'message')->count();
@endphp
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body py-3 d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(var(--ad-accent), 0.1); color: rgb(var(--ad-accent));">
                    <i class="fi-inbox fs-5"></i>
                </span>
                <div>
                    <div class="fw-bold fs-5">{{ $totalInquiries }}</div>
                    <div class="text-body-secondary fs-xs">Total inquiries</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body py-3 d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fi-calendar fs-5"></i>
                </span>
                <div>
                    <div class="fw-bold fs-5">{{ $tourCount }}</div>
                    <div class="text-body-secondary fs-xs">Tour requests</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body py-3 d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                    <i class="fi-mail fs-5"></i>
                </span>
                <div>
                    <div class="fw-bold fs-5">{{ $messageCount }}</div>
                    <div class="text-body-secondary fs-xs">Messages</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Type</th>
                    <th style="min-width: 180px;">From</th>
                    <th>Property</th>
                    <th>Details</th>
                    <th>Date</th>
                    <th class="text-end" style="width: 80px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($inquiries as $inquiry)
                    <tr>
                        <td>
                            @if ($inquiry->type === 'tour')
                                <span class="badge bg-success bg-opacity-10 text-success fw-semibold" style="font-size: 0.72rem;">
                                    <i class="fi-calendar me-1"></i>Tour
                                </span>
                            @else
                                <span class="badge bg-warning bg-opacity-10 text-warning fw-semibold" style="font-size: 0.72rem;">
                                    <i class="fi-mail me-1"></i>Message
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold fs-sm">{{ $inquiry->name }}</div>
                            <div class="text-body-secondary fs-xs">{{ $inquiry->email }}</div>
                            @if ($inquiry->phone)
                                <div class="text-body-secondary fs-xs">{{ $inquiry->phone }}</div>
                            @endif
                        </td>
                        <td>
                            @if ($inquiry->property)
                                <a href="{{ route('properties.show', $inquiry->property) }}" class="text-body fw-medium fs-sm hover-effect-underline" target="_blank">
                                    {{ \Illuminate\Support\Str::limit($inquiry->property->title, 30) }}
                                </a>
                            @else
                                <span class="text-body-secondary fs-xs">Deleted</span>
                            @endif
                        </td>
                        <td>
                            @if ($inquiry->type === 'tour')
                                <div class="fs-sm">
                                    {{ $inquiry->tour_date?->format('M j, Y') }} at {{ $inquiry->tour_time }}
                                    <span class="badge bg-light text-dark ms-1">{{ ucfirst($inquiry->tour_type) }}</span>
                                </div>
                            @else
                                <div class="fs-sm text-body-secondary" title="{{ $inquiry->message }}">
                                    {{ \Illuminate\Support\Str::limit($inquiry->message, 60) }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="text-body-secondary fs-sm">{{ $inquiry->created_at->format('M j, Y') }}</span>
                        </td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry) }}" class="d-inline" onsubmit="return confirm('Delete this inquiry?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center">
                                    <i class="fi-trash fs-xs"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-body-secondary">
                            <i class="fi-inbox fs-3 d-block mb-2 opacity-25"></i>
                            No inquiries yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($inquiries->hasPages())
        <div class="card-footer border-top bg-transparent py-3">
            {{ $inquiries->links() }}
        </div>
    @endif
</div>
@endsection
