@extends('backend.admin.admin_dashboard')

@section('admin')
<div class="page-content">
    @include('_message')
    
    <!-- Breadcrumb & Stats -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Shipping Charges</li>
            </ol>
        </nav>
    </div>

    <!-- Search Form -->
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('shipping.charge') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">ID</label>
                        <input type="text" 
                               name="id" 
                               class="form-control"
                               value="{{ request('id') }}" 
                               placeholder="Search by ID">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Name</label>
                        <input type="text" 
                               name="name" 
                               class="form-control"
                               value="{{ request('name') }}" 
                               placeholder="Search by name">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Price</label>
                        <div class="input-group">
                            <input type="number" 
                                   name="price" 
                                   class="form-control"
                                   value="{{ request('price') }}" 
                                   placeholder="Price">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>

                        </select>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary me-2">
                            <i data-feather="search" class="icon-sm me-2"></i> Search
                        </button>
                        <a href="{{ route('shipping.charge') }}" class="btn btn-light">
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
                <h5 class="card-title mb-0">Shipping Charges</h5>
                <a href="{{ route('shipping.charge.add') }}" class="btn btn-primary">
                    <i data-feather="plus" class="icon-sm me-2"></i> New Shipping Charge
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Status</th>
                            <th scope="col">Created At</th>
                            <th scope="col" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($shippingCharges as $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->name }}</td>
                                <td><code>{{ $value->price }}</code></td>
                                <td>
                                    @if ($value->status == 1)
                                        <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                </td>
                                <td>
                                    @php
                                        $createdAt = \Carbon\Carbon::parse($value->created_at);
                                        $createdAtFormatted = $createdAt->format('d M Y');
                                    @endphp
                                    @if ($createdAt->isToday())
                                        <span class="badge bg-primary">Today</span>
                                    @elseif ($createdAt->isYesterday())
                                        <span class="badge bg-secondary">Yesterday</span>
                                    @else
                                        <span class="badge bg-light text-dark">{{ $createdAtFormatted }}</span>
                                    @endif
                                </td>   
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('shipping.charge.edit', $value->id) }}" 
                                           class="btn btn-sm btn-primary"
                                           data-bs-toggle="tooltip"
                                           title="Edit">
                                            <i data-feather="edit-2" class="icon-sm"></i>
                                        </a>
                                        
                                        <form action="{{ route('shipping.charge.delete', $value->id) }}" 
                                              method="POST" 
                                              class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger btn-delete"
                                                    data-item-name="shipping charge"
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
                                    <div class="text-muted">No shipping charges found</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $shippingCharges->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

