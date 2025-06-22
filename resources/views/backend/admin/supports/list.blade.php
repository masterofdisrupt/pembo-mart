@php
    use App\Models\Backend\V1\SupportsModel;
@endphp

@extends('backend.admin.admin_dashboard')

@section('admin')
<div class="page-content">
    @include('_message')

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Support Tickets</li>
        </ol>
    </nav>

    <!-- Stats Cards -->
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Tickets</h5>
                    <p class="h3">{{ $statusCounts['total'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Open</h5>
                    <p class="h3">{{ $statusCounts['open'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Pending</h5>
                    <p class="h3">{{ $statusCounts['pending'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Closed</h5>
                    <p class="h3">{{ $statusCounts['closed'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Filters -->
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('supports') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Ticket ID</label>
                    <input type="text" name="id" class="form-control" 
                    value="{{ request('id') }}" placeholder="Enter Ticket ID">
                </div>

                  <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <select name="user_id" class="form-control">
                                            <option value="">Select Username</option>
                                            @foreach ($users as $user)
                                                <option {{ request('user_id') == $user->id ? 'selected' : '' }}
                                                    value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>


                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label class="form-label">Subject</label>
                                        <input type="text" name="title" class="form-control"
                                            value="{{ request('title') }}" placeholder="Enter Subject">
                                    </div>
                                </div>

               <div class="col-md-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
        <option value="">All Status</option>
        @foreach(SupportsModel::STATUSES as $value => $label)
            <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>
                <div class="col-md-3">
                    <label class="form-label">Date Range</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary me-2">
                        <i data-feather="search" class="icon-sm me-2"></i> Search
                    </button>
                    <a href="{{ route('supports') }}" class="btn btn-light">
                        <i data-feather="refresh-cw" class="icon-sm me-2"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tickets Table -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Support Tickets</h5>
                <a href="" class="btn btn-secondary">
                    <i data-feather="download" class="icon-sm me-2"></i> Export
                </a>
            </div>

            @if(isset($error))
                <div class="alert alert-danger">{{ $error }}</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>On/Off</th>
                                <th>Priority</th>
                                <th>Last Update</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr>
                                    <td>#{{ $ticket->id }}</td>
                                    <td>
                                        @if($ticket->user)
                                            
                                                    <div>{{ $ticket->user->name }}</div>
                                                    <small class="text-muted">{{ $ticket->user->email }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">User deleted</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($ticket->title, 50) }}</td>
                                    <td>
                                        @if(Auth::user()->isAdmin())
                                            <select name="status" 
        id="status_{{ $ticket->id }}"
        class="form-select form-select-sm ChangeSupportStatus" 
        data-ticket-id="{{ $ticket->id }}">
    @foreach(SupportsModel::STATUSES as $value => $label)
        <option value="{{ $value }}" 
                {{ $ticket->status == $value ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>
                                        @else
                                            <span class="badge bg-{{ $ticket->status_color }}">
                                                {{ SupportsModel::STATUSES[$ticket->status] }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" 
                                            class="btn btn-sm {{ $ticket->status == 0 ? 'btn-success' : 'btn-danger' }}"
                                            onclick="updateTicketStatus('{{ $ticket->id }}', '{{ $ticket->status == 0 ? '1' : '0' }}')">
                                            <i data-feather="{{ $ticket->status == 0 ? 'check-circle' : 'x-circle' }}" class="icon-sm"></i>
                                            {{ $ticket->status == 0 ? 'Active' : 'Inactive' }}
                                        </button>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $ticket->priority_color ?? 'secondary' }}">
                                            {{ SupportsModel::PRIORITIES[$ticket->priority] ?? 'Not Set' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div data-bs-toggle="tooltip" 
                                             title="{{ $ticket->updated_at->format('M d, Y H:i') }}">
                                            {{ $ticket->updated_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('support.reply', $ticket->id) }}" 
                                               class="btn btn-sm btn-primary"
                                               data-bs-toggle="tooltip"
                                               title="View Details">
                                                <i data-feather="eye" class="icon-sm"></i>
                                                View
                                            </a>
                                            @if(auth()->user()->isAdmin())
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger delete-ticket"
                                                        data-ticket-id="{{ $ticket->id }}"
                                                        data-bs-toggle="tooltip"
                                                        title="Delete Ticket">
                                                    <i data-feather="trash-2" class="icon-sm"></i>
                                                    Delete
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">No support tickets found</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Showing {{ $tickets->firstItem() }} to {{ $tickets->lastItem() }} 
                        of {{ $tickets->total() }} tickets
                    </div>
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

{{-- @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Feather Icons
    feather.replace();
    
    // Enable tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Handle status changes
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const ticketId = this.dataset.ticketId;
            const status = this.value;

            fetch(`/admin/support/ticket/${ticketId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success('Ticket status updated successfully');
                } else {
                    toastr.error('Failed to update ticket status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error('An error occurred while updating status');
            });
        });
    });

    // Handle ticket deletion
    document.querySelectorAll('.delete-ticket').forEach(button => {
        button.addEventListener('click', function() {
            const ticketId = this.dataset.ticketId;
            
            if (confirm('Are you sure you want to delete this ticket?')) {
                fetch(`/admin/support/ticket/${ticketId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        toastr.error('Failed to delete ticket');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred while deleting ticket');
                });
            }
        });
    });
});

function updateTicketStatus(ticketId, newStatus) {
    fetch(`/admin/support/status/${ticketId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            toastr.error('Failed to update ticket status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('An error occurred while updating status');
    });
}
</script>
@endpush --}}