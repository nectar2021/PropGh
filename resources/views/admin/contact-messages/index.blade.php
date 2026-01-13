@extends('layouts.admin')

@section('title', 'Propsgh | Contact Messages')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h1 class="h3 mb-1">Contact messages</h1>
        <p class="text-body-secondary mb-0">Review and respond to customer inquiries.</p>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form class="row g-2 g-md-3 align-items-center mb-3" method="GET" action="{{ route('admin.messages.index') }}">
            <div class="col-md-6">
                <div class="position-relative">
                    <i class="fi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-body-secondary"></i>
                    <input type="search" name="search" class="form-control form-icon-start" placeholder="Search by name, email, or message" value="{{ $search }}">
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
                        <th scope="col">Sender</th>
                        <th scope="col">Email</th>
                        <th scope="col">Message</th>
                        <th scope="col">Received</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($messages as $message)
                        <tr>
                            <td class="fw-semibold">{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
                            <td class="text-body-secondary">
                                {{ \Illuminate\Support\Str::limit($message->message, 80) }}
                            </td>
                            <td class="text-body-secondary fs-sm">{{ $message->created_at?->format('M d, Y') }}</td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('admin.messages.show', $message) }}">View</a>
                                        <button type="button"
                                            class="dropdown-item text-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteMessageModal"
                                            data-action="{{ route('admin.messages.destroy', $message) }}"
                                            data-sender="{{ $message->name }}">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-body-secondary py-4">No messages yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @php
            $startPage = max(1, $messages->currentPage() - 1);
            $endPage = min($messages->lastPage(), $messages->currentPage() + 1);
        @endphp
        <div class="d-flex align-items-center justify-content-between pt-3">
            <div class="text-body-secondary fs-sm">
                Showing {{ $messages->firstItem() ?? 0 }}-{{ $messages->lastItem() ?? 0 }} of {{ $messages->total() }} messages
            </div>
            @if ($messages->hasPages())
                <nav aria-label="Messages pagination">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item {{ $messages->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $messages->previousPageUrl() ?? '#' }}">Prev</a>
                        </li>
                        @foreach ($messages->getUrlRange($startPage, $endPage) as $page => $url)
                            <li class="page-item {{ $page === $messages->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach
                        <li class="page-item {{ $messages->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $messages->nextPageUrl() ?? '#' }}">Next</a>
                        </li>
                    </ul>
                </nav>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="deleteMessageModal" tabindex="-1" aria-labelledby="deleteMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMessageModalLabel">Delete message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Delete message from <span class="fw-semibold" id="deleteMessageSender">this sender</span>? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteMessageForm" method="POST" action="#">
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
  const deleteMessageModal = document.getElementById('deleteMessageModal');
  if (deleteMessageModal) {
    deleteMessageModal.addEventListener('show.bs.modal', (event) => {
      const trigger = event.relatedTarget;
      if (!trigger) return;
      const action = trigger.getAttribute('data-action');
      const sender = trigger.getAttribute('data-sender');
      const form = deleteMessageModal.querySelector('#deleteMessageForm');
      const senderEl = deleteMessageModal.querySelector('#deleteMessageSender');
      if (form && action) form.setAttribute('action', action);
      if (senderEl) senderEl.textContent = sender || 'this sender';
    });
  }
</script>
@endpush
