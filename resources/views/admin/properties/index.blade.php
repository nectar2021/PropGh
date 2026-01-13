@extends('layouts.admin')

@section('title', 'Propsgh | Properties')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h1 class="h3 mb-1">Properties</h1>
        <p class="text-body-secondary mb-0">Manage listings, pricing, and availability.</p>
    </div>
    <div class="d-flex gap-2">
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('properties.index') }}">
            <i class="fi-eye fs-sm me-1"></i>
            Preview site
        </a>
        <a class="btn btn-primary btn-sm" href="{{ route('admin.properties.create') }}">
            <i class="fi-plus fs-sm me-1"></i>
            Add property
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form class="row g-2 g-md-3 align-items-center mb-3" method="GET" action="{{ route('admin.properties.index') }}">
            <div class="col-md-5">
                <div class="position-relative">
                    <i class="fi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-body-secondary"></i>
                    <input type="search" name="search" class="form-control form-icon-start" placeholder="Search by address, ID, or owner" value="{{ $search }}">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" name="status">
                    @foreach ($statusOptions as $value => $label)
                        <option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="sort">
                    @foreach ($sortOptions as $value => $label)
                        <option value="{{ $value }}" @selected($sort === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-secondary w-100">Apply</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Property</th>
                        <th scope="col">Location</th>
                        <th scope="col">Price</th>
                        <th scope="col">Status</th>
                        <th scope="col">Listed</th>
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
                            $coverImage = $property->cover_image?->path ?? 'assets/img/listings/real-estate/01.jpg';
                            $location = collect([$property->city, $property->region])->filter()->implode(', ');
                            $pricePeriod = $property->price_period ? '/' . $property->price_period : '';
                        @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset($coverImage) }}" class="rounded-3" style="width: 64px; height: 48px; object-fit: cover;" alt="{{ $property->title }}">
                                    <div>
                                        <div class="fw-semibold">{{ $property->title }}</div>
                                        <div class="text-body-secondary fs-xs">PR-{{ str_pad($property->id, 3, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-body-secondary">{{ $location ?: '—' }}</td>
                            <td class="fw-semibold">${{ number_format($property->price) }}{{ $pricePeriod }}</td>
                            <td>
                                <span class="badge {{ $statusClasses[$property->status] ?? 'text-bg-secondary' }}">
                                    {{ ucfirst($property->status) }}
                                </span>
                            </td>
                            <td class="text-body-secondary fs-sm">{{ optional($property->published_at ?? $property->created_at)->format('M d, Y') }}</td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('properties.show', $property) }}">View</a>
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
                            <td colspan="6" class="text-center text-body-secondary py-4">No properties found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @php
            $startPage = max(1, $properties->currentPage() - 1);
            $endPage = min($properties->lastPage(), $properties->currentPage() + 1);
        @endphp
        <div class="d-flex align-items-center justify-content-between pt-3">
            <div class="text-body-secondary fs-sm">
                Showing {{ $properties->firstItem() ?? 0 }}-{{ $properties->lastItem() ?? 0 }} of {{ $properties->total() }} properties
            </div>
            @if ($properties->hasPages())
                <nav aria-label="Properties pagination">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item {{ $properties->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $properties->previousPageUrl() ?? '#' }}">Prev</a>
                        </li>
                        @foreach ($properties->getUrlRange($startPage, $endPage) as $page => $url)
                            <li class="page-item {{ $page === $properties->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach
                        <li class="page-item {{ $properties->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $properties->nextPageUrl() ?? '#' }}">Next</a>
                        </li>
                    </ul>
                </nav>
            @endif
        </div>
    </div>
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
