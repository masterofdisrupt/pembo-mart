@extends('backend.admin.admin_dashboard')

@section('admin')
<div class="page-content">
    @include('_message')
    
       <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Pages</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Pages List</h5>
                
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Title</th>
                          
                            <th scope="col" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($getPages as $page)
                            <tr>
                                <td>{{ $page->id }}</td>
                                <td>{{ $page->name }}</td>
                                <td>{{ $page->title }}</td>
                                  
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('pages.edit', $page->id) }}" 
                                           class="btn btn-sm btn-primary"
                                           data-bs-toggle="tooltip"
                                           title="Edit">
                                            <i data-feather="edit-2" class="icon-sm"></i>
                                        </a>
                                        
                                        
                                    </div>
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
                {{-- {{ $getPages->withQueryString()->links() }} --}}
            </div>
        </div>
    </div>
</div>
@endsection

