@extends('layouts.admin')

@section('title', 'Propsgh | Agents')

@section('content')
<div class="admin-page-header d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
        <h1 class="h3 mb-1">Agents</h1>
        <p class="text-body-secondary mb-0">Review, verify, and manage agent accounts.</p>
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
        <form method="GET" action="{{ route('admin.agents.index') }}" class="d-flex flex-wrap align-items-center gap-3">
            <div class="flex-grow-1" style="min-width: 200px; max-width: 360px;">
                <div class="input-group">
                    <span class="input-group-text"><i class="fi-search fs-sm"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by name, email, or company" value="{{ request('search') }}">
                </div>
            </div>
            <select name="status" class="form-select" style="width: auto; min-width: 150px;">
                <option value="">All agents</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified</option>
            </select>
            <button type="submit" class="btn btn-outline-primary btn-sm">Filter</button>
            @if (request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.agents.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
            @endif
        </form>
    </div>
</div>

{{-- Stats --}}
@php
    $totalAgents = \App\Models\User::where('role', 'agent')->count();
    $pendingAgents = \App\Models\User::where('role', 'agent')->where('is_verified', false)->count();
    $verifiedAgents = \App\Models\User::where('role', 'agent')->where('is_verified', true)->count();
@endphp
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body py-3 d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(var(--ad-accent), 0.1); color: rgb(var(--ad-accent));">
                    <i class="fi-users fs-5"></i>
                </span>
                <div>
                    <div class="fw-bold fs-5">{{ $totalAgents }}</div>
                    <div class="text-body-secondary fs-xs">Total agents</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body py-3 d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                    <i class="fi-clock fs-5"></i>
                </span>
                <div>
                    <div class="fw-bold fs-5">{{ $pendingAgents }}</div>
                    <div class="text-body-secondary fs-xs">Pending review</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body py-3 d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fi-check-circle fs-5"></i>
                </span>
                <div>
                    <div class="fw-bold fs-5">{{ $verifiedAgents }}</div>
                    <div class="text-body-secondary fs-xs">Verified</div>
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
                    <th style="min-width: 200px;">Agent</th>
                    <th>Company</th>
                    <th>Properties</th>
                    <th>Status</th>
                    <th>Registered</th>
                    <th class="text-end" style="width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($agents as $agent)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; background: rgba(var(--ad-accent), 0.1); color: rgb(var(--ad-accent)); font-size: 0.8rem; font-weight: 600; flex-shrink: 0;">
                                    {{ strtoupper(substr($agent->name, 0, 2)) }}
                                </span>
                                <div>
                                    <div class="fw-semibold">{{ $agent->name }}</div>
                                    <div class="text-body-secondary fs-xs">{{ $agent->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if ($agent->company_name)
                                <span class="fs-sm">{{ $agent->company_name }}</span>
                            @else
                                <span class="text-body-secondary fs-xs">—</span>
                            @endif
                        </td>
                        <td>
                            @php $propertyCount = $agent->properties_count ?? \App\Models\Property::where('owner_id', $agent->id)->count(); @endphp
                            <span class="badge bg-light text-dark">{{ $propertyCount }}</span>
                        </td>
                        <td>
                            @if ($agent->is_verified)
                                <span class="badge bg-success bg-opacity-10 text-success fw-semibold" style="font-size: 0.72rem;">
                                    <i class="fi-check-circle me-1"></i>Verified
                                </span>
                            @else
                                <span class="badge bg-warning bg-opacity-10 text-warning fw-semibold" style="font-size: 0.72rem;">
                                    <i class="fi-clock me-1"></i>Pending
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="text-body-secondary fs-sm">{{ $agent->created_at->format('M j, Y') }}</span>
                        </td>
                        <td class="text-end">
                            @if ($agent->is_verified)
                                <form method="POST" action="{{ route('admin.agents.unverify', $agent) }}" class="d-inline" onsubmit="return confirm('Revoke verification for {{ $agent->name }}?')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-outline-warning d-inline-flex align-items-center gap-1">
                                        <i class="fi-x fs-xs"></i> Revoke
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.agents.verify', $agent) }}" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1">
                                        <i class="fi-check fs-xs"></i> Verify
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-body-secondary">
                            <i class="fi-users fs-3 d-block mb-2 opacity-25"></i>
                            No agents found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($agents->hasPages())
        <div class="card-footer border-top bg-transparent py-3">
            {{ $agents->links() }}
        </div>
    @endif
</div>
@endsection
