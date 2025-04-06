@extends('backend.admin.admin_dashboard')

@section('admin')
<div class="page-content">
    @include('_message')
    
    <!-- Breadcrumb & Stats -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Discount Codes</li>
            </ol>
        </nav>
        <div class="d-flex gap-2">
            <span class="badge bg-primary">Total: {{ $getRecord->total() }}</span>
            <span class="badge bg-success">Active: {{ $activeCount }}</span>
             <span class="badge bg-warning">Expiring Soon: {{ $expiringCount }}</span>
            <span class="badge bg-danger">Expired: {{ $expiredCount }}</span>
        </div>
    </div>

    <!-- Search Form -->
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('discount.code') }}" method="GET" id="search-form">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label" for="search-id">ID</label>
                        <input type="text" 
                               id="search-id"
                               name="id" 
                               class="form-control"
                               value="{{ request('id') }}" 
                               placeholder="Search by ID">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="search-username">Username</label>
                        <input type="text" 
                               id="search-username"
                               name="username" 
                               class="form-control"
                               value="{{ request('username') }}" 
                               placeholder="Search by username">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="search-code">Discount Code</label>
                        <input type="text" 
                               id="search-code"
                               name="discount_code" 
                               class="form-control"
                               value="{{ request('discount_code') }}" 
                               placeholder="Search by code">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="search-price">Price Range</label>
                        <div class="input-group">
                            <input type="number" 
                                   id="search-price"
                                   name="price_min" 
                                   class="form-control"
                                   value="{{ request('price_min') }}" 
                                   placeholder="Min">
                            <input type="number" 
                                   name="price_max" 
                                   class="form-control"
                                   value="{{ request('price_max') }}" 
                                   placeholder="Max">
                        </div>
                    </div>

                    <div class="col-md-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
        <option value="">All Status</option>
        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
        <option value="expiring" {{ request('status') == 'expiring' ? 'selected' : '' }}>Expiring Soon</option>
    </select>
</div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary me-2">
                            <i data-feather="search" class="icon-sm me-2"></i> Search
                        </button>
                        <a href="{{ route('discount.code') }}" class="btn btn-light">
                            <i data-feather="refresh-cw" class="icon-sm me-2"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Discount Codes</h5>
                <a href="{{ route('discount.code.add') }}" class="btn btn-primary">
                    <i data-feather="plus" class="icon-sm me-2"></i> New Discount Code
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">Code</th>
                            <th scope="col">Value</th>
                            <th scope="col">Type</th>
                            <th scope="col">Usage</th>
                            <th scope="col">Expires</th>
                            <th scope="col">Status</th>
                            <th scope="col" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($getRecord as $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->username }}</td>
                                <td><code>{{ $value->discount_code }}</code></td>
                                <td>{{ $value->type == 0 ? $value->discount_price . '%' : '₱' . number_format($value->discount_price, 2) }}</td>
                                <td>{{ $value->type == 0 ? 'Percentage' : 'Fixed Amount' }}</td>
                                <td>{{ $value->usages == 1 ? 'Unlimited' : 'One-time' }}</td>
                                <td>
                                    @php
                                        $expiryDate = \Carbon\Carbon::parse($value->expiry_date);
                                        $today = \Carbon\Carbon::today();
                                    @endphp
                                    <span class="badge {{ $expiryDate->isPast() ? 'bg-danger' : ($expiryDate->diffInDays($today) <= 7 ? 'bg-warning' : 'bg-success') }}">
                                        {{ $expiryDate->format('M d, Y') }}
                                    </span>
                                </td>
                                <td>{!! $value->getStatusBadge() !!}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('discount.code.edit', $value->id) }}" 
                                           class="btn btn-sm btn-primary"
                                           data-bs-toggle="tooltip"
                                           title="Edit">
                                            <i data-feather="edit-2" class="icon-sm"></i>
                                        </a>
                                        
                                        <form action="{{ route('discount.code.delete', $value->id) }}" 
                                              method="POST" 
                                              class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger btn-delete"
                                                    data-item-name="discount code"
                                                    data-bs-toggle="tooltip"
                                                    title="Delete">
                                                <i data-feather="trash-2" class="icon-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">No discount codes found</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                {{ $getRecord->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize Feather Icons
    feather.replace();
    
    // Enable tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Add debounce to search
    let searchTimeout;
    const searchForm = document.getElementById('search-form');
    const searchInputs = searchForm.querySelectorAll('input');

    searchInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                searchForm.submit();
            }, 500);
        });
    });
</script>
@endpush