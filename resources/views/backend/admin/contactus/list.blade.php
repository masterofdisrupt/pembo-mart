@extends('backend.admin.admin_dashboard')

@section('admin')
<div class="page-content">
    @include('_message')
    
       <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Contact Us</li>
            </ol>
        </nav>
    </div>

    <!-- Search Form -->
    <div class="card mb-3">
        <div class="card-body">
            <form action="" method="GET">
                <div class="row g-3">
                    <div class="col-md-2">
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
                        <label class="form-label">Email</label>
                        <input type="text" 
                               name="email" 
                               class="form-control"
                               value="{{ request('email') }}" 
                               placeholder="Search by email">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Phone</label>
                        <input type="text" 
                               name="phone" 
                               class="form-control"
                               value="{{ request('phone') }}" 
                               placeholder="Search by phone">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Subject</label>
                        <input type="text" 
                               name="subject" 
                               class="form-control"
                               value="{{ request('subject') }}" 
                               placeholder="Search by subject">
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary me-2">
                            <i data-feather="search" class="icon-sm me-2"></i> Search
                        </button>
                        <a href="{{ route('admin.contact.us') }}" class="btn btn-light">
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
                <h5 class="card-title mb-0">Contact Us</h5>
                
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Login Name</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Message</th>
                            <th scope="col">Created Date</th>
                          
                            <th scope="col" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($getRecord as $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ !empty($value->getUser) ? $value->getUser->name : '' }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->email }}</td>
                                <td>{{ $value->phone }}</td>
                                <td>{{ $value->subject }}</td>
                                <td>{{ $value->message }}</td>
                                <td>{{ $value->created_at }}</td>
                                <td>
                                    <form action="{{ route('contact.us.delete', $value->id) }}" 
                                        method="POST" class="d-inline-block delete-form">
                                        
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item d-flex align-items-center btn-delete" 
                                        data-item-name="record" style="border: none; background: none; cursor: pointer;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-trash icon-sm me-2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                        <span>Delete</span>
                                    </button>
                                </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">No pages found</div>
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

