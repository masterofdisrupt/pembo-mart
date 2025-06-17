@extends('backend.admin.admin_dashboard')

@section('admin')
<div class="page-content">
    @include('_message')
    
       <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Notifications</li>
            </ol>
        </nav>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Notifications</h5>
                
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <tbody>
                        @forelse ($getRecord as $value)
                            <tr class="{{ empty($value->is_read) ? 'table-active' : '' }}">
                                <td>
                                    <a href="{{ $value->url }}?notif_id={{ $value->id }}" 
                                    style="color: #fff; {{ empty($value->is_read) ? 'font-weight: bold;' : '' }}">
                                        {{ $value->message }}
                                    </a>
                                </td>
                                <td class="text-nowrap">
                                    {{ $value->created_at->diffForHumans() }}
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

