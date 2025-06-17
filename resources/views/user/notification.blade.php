@extends('layouts.app')

@section('style')
@endsection

@section('content')
<main class="main">
    <div class="page-header text-center">
        <div class="container">
            <h1 class="page-title">Notifications</h1>
        </div>
    </div>

    <div class="page-content py-4">
        <div class="dashboard">
            <div class="container">
                <div class="row">
                    @include('user._sidebar')

                    <div class="col-md-8 col-lg-9">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-hover align-middle" style="min-width: 100%;">
                                        <tbody>
                                            @forelse ($getRecord as $value)
                                                <tr style="{{ empty($value->is_read) ? 'background-color: #f8f9fa;' : '' }}">
                                                    <td style="padding: 6px 10px; line-height: 1.6;">
                                                        <a href="{{ $value->url }}?notif_id={{ $value->id }}" 
                                                        style="color: #000; text-decoration: none; {{ empty($value->is_read) ? 'font-weight: bold;' : '' }}">
                                                            {{ $value->message }}
                                                        </a>
                                                    </td>
                                                    <td style="padding: 6px 10px; white-space: nowrap; line-height: 1.6;">
                                                        {{ $value->created_at->diffForHumans() }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">No records found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    {!! $getRecord->appends(request()->except('page'))->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
@endsection
