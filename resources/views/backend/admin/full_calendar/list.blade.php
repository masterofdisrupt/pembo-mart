@extends('backend.admin.admin_dashboard')

@section('admin')
    <div class="page-content">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        <div id="calendar"></div>
    </div>
@endsection
