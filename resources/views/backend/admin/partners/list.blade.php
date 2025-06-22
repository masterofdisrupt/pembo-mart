@extends('backend.admin.admin_dashboard')

@section('admin')
<div class="page-content">
    @include('_message')
    
    <!-- Breadcrumb & Stats -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Partner</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Partner</h5>
                <a href="{{ route('add.partner') }}" class="btn btn-primary">
                    <i data-feather="plus" class="icon-sm me-2"></i> New Partner
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Image</th>
                            <th scope="col">Link</th>
                            <th scope="col">Status</th>
                            <th scope="col">Created At</th>
                            <th scope="col" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($getRecord as $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>
                                    @if (!empty($value->getPartnerImage()))
                                        <img src="{{ $value->getPartnerImage() }}" 
                                             alt="Partner Image" 
                                             class="img-fluid" 
                                             style="max-width: 100px;">
                                    @else
                                        <img src="" 
                                             alt="No Image" 
                                             class="img-fluid" 
                                             style="max-width: 100px;">
                                        
                                    @endif
                                </td>
                                <td>{{ $value->button_link }}</td>
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
                                        <a href="{{ route('edit.partner', $value->id) }}" 
                                           class="btn btn-sm btn-primary"
                                           data-bs-toggle="tooltip"
                                           title="Edit">
                                            <i data-feather="edit-2" class="icon-sm"></i>
                                        </a>
                                        
                                        <form action="{{ route('delete.partner', $value->id) }}" 
                                              method="POST" 
                                              class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger btn-delete"
                                                    data-item-name="partner"
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
                                    <div class="text-muted">No Partner Record found</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection

