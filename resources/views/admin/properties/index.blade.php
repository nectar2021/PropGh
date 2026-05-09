@extends('layouts.admin')

@section('title', 'Propsgh | Properties')

@section('content')
<div class="admin-page-header d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
        <h1 class="h3 mb-1">Properties</h1>
        <p class="text-body-secondary mb-0">Organize listings, track review status, and jump straight into edits.</p>
    </div>
    @if ($hasFilters)
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.properties.index') }}">Clear filters</a>
    @endif
</div>

@if (session('status'))
    <div class="alert alert-success d-flex align-items-center gap-2 mt-4">
        <i class="fi-check-circle"></i>{{ session('status') }}
    </div>
@endif

<div class="row g-3 mt-1 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body py-3 d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(var(--ad-accent), 0.1); color: rgb(var(--ad-accent));">
                    <i class="fi-grid fs-5"></i>
                </span>
                <div>
                    <div class="fw-bold fs-5">{{ $summary['total'] }}</div>
                    <div class="text-body-secondary fs-xs">Total listings</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body py-3 d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fi-check-circle fs-5"></i>
                </span>
                <div>
                    <div class="fw-bold fs-5">{{ $summary['live'] }}</div>
                    <div class="text-body-secondary fs-xs">Live listings</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body py-3 d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                    <i class="fi-clock fs-5"></i>
                </span>
                <div>
                    <div class="fw-bold fs-5">{{ $summary['review'] }}</div>
                    <div class="text-body-secondary fs-xs">Needs review</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body py-3 d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(100, 116, 139, 0.1); color: #64748b;">
                    <i class="fi-edit-2 fs-5"></i>
                </span>
                <div>
                    <div class="fw-bold fs-5">{{ $summary['draft'] }}</div>
                    <div class="text-body-secondary fs-xs">Draft listings</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body py-3">
        <form class="row g-2 g-md-3 align-items-center" method="GET" action="{{ route('admin.properties.index') }}">
            <div class="col-lg-5">
                <div class="input-group">
                    <span class="input-group-text"><i class="fi-search fs-sm"></i></span>
                    <input type="search" name="search" class="form-control" placeholder="Search by title, address, city, owner, or ID" value="{{ $search }}">
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <select class="form-select" name="status">
                    @foreach ($statusOptions as $value => $label)
                        <option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6 col-lg-2">
                <select class="form-select" name="sort">
                    @foreach ($sortOptions as $value => $label)
                        <option value="{{ $value }}" @selected($sort === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary w-100">Apply</button>
                @if ($hasFilters)
                    <a class="btn btn-outline-secondary" href="{{ route('admin.properties.index') }}">Clear</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body py-3 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div>
            <div class="fw-semibold">Listings directory</div>
            <div class="text-body-secondary fs-sm">Showing {{ $properties->firstItem() ?? 0 }}-{{ $properties->lastItem() ?? 0 }} of {{ $properties->total() }} matching listings</div>
        </div>
        <div class="text-body-secondary fs-sm">Sorted by {{ \Illuminate\Support\Str::lower((string) ($sortOptions[(string) $sort] ?? 'Newest')) }}</div>
    </div>

    <div class="table-responsive">
            <table class="table align-middle mb-0 table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Property</th>
                        <th scope="col">Owner</th>
                        <th scope="col">Price</th>
                        <th scope="col">Status</th>
                        <th scope="col">Updated</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($properties as $property)
                        @php
                            $statusClasses = [
                                'live' => 'text-bg-success',
                                'review' => 'text-bg-warning',
                                'draft' => 'text-bg-secondary',
                            ];
                            $location = collect([$property->city, $property->region])->filter()->implode(', ');
                            $pricePeriod = $property->price_period ? ' / ' . \Illuminate\Support\Str::headline($property->price_period) : '';
                        @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if ($property->cover_image?->path)
                                        <img src="{{ asset($property->cover_image->path) }}" class="rounded-3" style="width: 64px; height: 48px; object-fit: cover;" alt="{{ $property->title }}">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center rounded-3 bg-body-tertiary text-body-secondary" style="width: 64px; height: 48px;">
                                            <i class="fi-image fs-sm"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold">{{ $property->title }}</div>
                                        <div class="text-body-secondary fs-xs">PR-{{ str_pad($property->id, 3, '0', STR_PAD_LEFT) }} &middot; {{ $property->property_type_label ?? 'Property' }}</div>
                                        <div class="text-body-secondary fs-xs">{{ $location ?: 'No location added' }}</div>
                                        <div class="d-flex flex-wrap gap-1 mt-1">
                                            @if ($property->is_featured)
                                                <span class="badge bg-info bg-opacity-10 text-info">Featured</span>
                                            @endif
                                            @if ($property->is_verified)
                                                <span class="badge bg-success bg-opacity-10 text-success">Verified</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-medium">{{ $property->owner?->name ?? 'Unassigned' }}</div>
                                <div class="text-body-secondary fs-xs">{{ $property->owner?->email ?? 'No owner email' }}</div>
                            </td>
                            <td class="fw-semibold">{{ $property->formatted_price }}{{ $pricePeriod }}</td>
                            <td>
                                <span class="badge {{ $statusClasses[$property->status] ?? 'text-bg-secondary' }}">
                                    {{ ucfirst($property->status) }}
                                </span>
                            </td>
                            <td class="text-body-secondary fs-sm">{{ optional($property->updated_at ?? $property->created_at)->format('M d, Y') }}</td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('properties.show', $property) }}" target="_blank" rel="noreferrer">View</a>
                                        <a class="dropdown-item" href="{{ route('admin.properties.edit', $property) }}">Edit</a>
                                        <button type="button"
                                            class="dropdown-item text-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deletePropertyModal"
                                            data-action="{{ route('admin.properties.destroy', $property) }}"
                                            data-title="{{ $property->title }}">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-body-secondary py-5">
                                <i class="fi-grid fs-3 d-block mb-2 opacity-25"></i>
                                No properties found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
    </div>

    @if ($properties->hasPages())
        <div class="card-footer border-top bg-transparent py-3">
            {{ $properties->links() }}
        </div>
    @endif
</div>

<div class="modal fade" id="deletePropertyModal" tabindex="-1" aria-labelledby="deletePropertyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePropertyModalLabel">Delete property</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete <span class="fw-semibold" id="deletePropertyTitle">this property</span>? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deletePropertyForm" method="POST" action="#">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
  const deleteModal = document.getElementById('deletePropertyModal');
  if (deleteModal) {
    deleteModal.addEventListener('show.bs.modal', (event) => {
      const trigger = event.relatedTarget;
      if (!trigger) return;
      const action = trigger.getAttribute('data-action');
      const title = trigger.getAttribute('data-title');
      const form = deleteModal.querySelector('#deletePropertyForm');
      const titleEl = deleteModal.querySelector('#deletePropertyTitle');
      if (form && action) form.setAttribute('action', action);
      if (titleEl) titleEl.textContent = title || 'this property';
    });
  }
</script>
@endpush
