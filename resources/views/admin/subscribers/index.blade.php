@extends('layouts.admin')

@section('title', 'Propsgh | Subscribers')

@section('content')
<div class="admin-page-header d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
        <h1 class="h3 mb-1">Newsletter subscribers</h1>
        <p class="text-body-secondary mb-0">{{ $subscribers->total() }} subscribers &middot; People who signed up via the footer newsletter.</p>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success d-flex align-items-center gap-2">
        <i class="fi-check-circle"></i>{{ session('status') }}
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form class="row g-2 g-md-3 align-items-center mb-3" method="GET" action="{{ route('admin.subscribers.index') }}">
            <div class="col-md-6">
                <div class="position-relative">
                    <i class="fi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-body-secondary"></i>
                    <input type="search" name="search" class="form-control form-icon-start" placeholder="Search by email" value="{{ $search }}">
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-outline-secondary w-100">Search</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Email</th>
                        <th scope="col">Subscribed</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subscribers as $subscriber)
                        <tr>
                            <td class="text-body-secondary fs-sm">{{ $subscriber->id }}</td>
                            <td class="fw-semibold">{{ $subscriber->email }}</td>
                            <td class="text-body-secondary fs-sm">{{ $subscriber->subscribed_at?->format('M d, Y') ?? $subscriber->created_at?->format('M d, Y') }}</td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('admin.subscribers.destroy', $subscriber) }}" onsubmit="return confirm('Remove this subscriber?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fi-trash fs-sm me-1"></i> Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-body-secondary py-4">No subscribers yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($subscribers->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $subscribers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
