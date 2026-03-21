@extends('layouts.admin')

@section('title', 'Propsgh | Clients')

@section('content')
<div class="admin-page-header d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
        <h1 class="h3 mb-1">Clients</h1>
        <p class="text-body-secondary mb-0">Browse and manage individual user accounts.</p>
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
        <form method="GET" action="{{ route('admin.clients.index') }}" class="d-flex flex-wrap align-items-center gap-3">
            <div class="flex-grow-1" style="min-width: 200px; max-width: 360px;">
                <div class="input-group">
                    <span class="input-group-text"><i class="fi-search fs-sm"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by name or email" value="{{ request('search') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-outline-primary btn-sm">Search</button>
            @if (request('search'))
                <a href="{{ route('admin.clients.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
            @endif
        </form>
    </div>
</div>

{{-- Stats --}}
@php
    $totalClients = \App\Models\User::where('role', 'client')->count();
    $recentClients = \App\Models\User::where('role', 'client')->where('created_at', '>=', now()->subDays(30))->count();
@endphp
<div class="row g-3 mb-4">
    <div class="col-sm-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body py-3 d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(var(--ad-accent), 0.1); color: rgb(var(--ad-accent));">
                    <i class="fi-users fs-5"></i>
                </span>
                <div>
                    <div class="fw-bold fs-5">{{ $totalClients }}</div>
                    <div class="text-body-secondary fs-xs">Total clients</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body py-3 d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fi-user-plus fs-5"></i>
                </span>
                <div>
                    <div class="fw-bold fs-5">{{ $recentClients }}</div>
                    <div class="text-body-secondary fs-xs">Joined last 30 days</div>
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
                    <th style="min-width: 200px;">Client</th>
                    <th>Phone</th>
                    <th>Registered</th>
                    <th class="text-end" style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($clients as $client)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; background: rgba(var(--ad-accent), 0.1); color: rgb(var(--ad-accent)); font-size: 0.8rem; font-weight: 600; flex-shrink: 0;">
                                    {{ strtoupper(substr($client->name, 0, 2)) }}
                                </span>
                                <div>
                                    <div class="fw-semibold">{{ $client->name }}</div>
                                    <div class="text-body-secondary fs-xs">{{ $client->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if ($client->phone)
                                <span class="fs-sm">{{ $client->phone }}</span>
                            @else
                                <span class="text-body-secondary fs-xs">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-body-secondary fs-sm">{{ $client->created_at->format('M j, Y') }}</span>
                        </td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" class="d-inline" onsubmit="return confirm('Remove client {{ $client->name }}? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1">
                                    <i class="fi-trash fs-xs"></i> Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-body-secondary">
                            <i class="fi-users fs-3 d-block mb-2 opacity-25"></i>
                            No clients found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($clients->hasPages())
        <div class="card-footer border-top bg-transparent py-3">
            {{ $clients->links() }}
        </div>
    @endif
</div>
@endsection
