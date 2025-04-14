@php
    use App\Models\Backend\V1\SupportsModel;
@endphp

@extends('backend.admin.admin_dashboard')

@section('admin')
<div class="page-content">
    @include('_message')

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="page-title mb-1">Support Ticket #{{ $ticket->id }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('supports') }}">Tickets</a></li>
                    <li class="breadcrumb-item active">Reply</li>
                </ol>
            </nav>
        </div>
        <div>
            <span class="badge bg-{{ $ticket->status_color }} me-2">
                {{ SupportsModel::STATUSES[$ticket->status] }}
            </span>
            <span class="badge bg-{{ $ticket->priority_color }}">
                {{ SupportsModel::PRIORITIES[$ticket->priority] }}
            </span>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- Ticket Details -->
                    <div class="ticket-details mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <img src="{{ $ticket->user->avatar_url }}" 
                                     class="rounded-circle" 
                                     width="48" 
                                     alt="{{ $ticket->user->name }}">
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $ticket->title }}</h5>
                                <div class="text-muted">
                                    Opened by {{ $ticket->user->name }} 
                                    {{ $ticket->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="ticket-description">
                            {{ $ticket->description }}
                        </div>
                    </div>

                    <!-- Replies Section -->
                    <div class="replies mb-4">
                        @forelse($replies as $reply)
                            <div class="reply-item mb-3 {{ $reply->user_id === auth()->id() ? 'ms-4' : '' }}">
                                <div class="d-flex">
                                    @if($reply->user_id !== auth()->id())
                                        <div class="me-3">
                                            <img src="{{ $reply->user->avatar_url }}" 
                                                 class="rounded-circle" 
                                                 width="32" 
                                                 alt="{{ $reply->user->name }}">
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <div class="reply-bubble p-3 rounded {{ $reply->user_id === auth()->id() ? 'bg-light' : 'bg-primary text-white' }}">
                                            {{ $reply->description }}
                                            <div class="reply-meta mt-2 small {{ $reply->user_id === auth()->id() ? 'text-muted' : 'text-white-50' }}">
                                                {{ $reply->user->name }} • {{ $reply->created_at->format('M d, Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                    @if($reply->user_id === auth()->id())
                                        <div class="ms-3">
                                            <img src="{{ auth()->user()->photo }}" 
                                                 class="rounded-circle" 
                                                 width="32" 
                                                 alt="{{ auth()->user()->name }}">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                No replies yet
                            </div>
                        @endforelse

                        {{ $replies->links() }}
                    </div>

                    <!-- Reply Form -->
                    @if($ticket->isOpen())
                        <form action="{{ route('support.reply.store', $ticket->id) }}" 
                              method="POST" 
                              class="reply-form">
                            @csrf
                            <div class="form-group">
                                <textarea name="description" 
                                          class="form-control @error('description') is-invalid @enderror" 
                                          rows="3" 
                                          placeholder="Type your reply here..."
                                          required></textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="form-check">
                                    <input type="checkbox" 
                                           name="close_ticket" 
                                           class="form-check-input" 
                                           id="closeTicket">
                                    <label class="form-check-label" for="closeTicket">
                                        Close ticket after reply
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i data-feather="send" class="icon-sm me-1"></i> Send Reply
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i data-feather="lock" class="icon-sm me-2"></i>
                            This ticket is closed. Contact support to reopen it.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.reply-bubble {
    border-radius: 1rem;
    max-width: 80%;
}

.ticket-description {
    white-space: pre-wrap;
}
</style>
@endpush