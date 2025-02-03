@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">

        @include('_message')

        <div class="row inbox-wrapper">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            @include('backend.admin.email._sidebar')


                            <div class="col-lg-9">
                                <div>
                                    <div class="d-flex align-items-center p-3 border-bottom tx-16">
                                        <span data-feather="edit" class="icon-md me-2"></span>
                                        New message
                                    </div>
                                </div>
                                {{-- Form Start --}}
                                <form action="{{ url('admin/email/post') }}" method="POST">
                                    @csrf

                                    <div class="p-3 pb-0">
                                        <div class="to">
                                            <div class="row mb-3">
                                                <label class="col-md-2 col-form-label">To:</label>
                                                <div class="col-md-10">
                                                    <select class="compose-multiple-select form-select" name="user_id">
                                                        <option value="">Select Email [Agent and User]</option>
                                                        @foreach ($getEmail as $value)
                                                            <option value="{{ $value->id }}">{{ $value->email }} -
                                                                {{ $value->role }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="to cc">
                                            <div class="row mb-3">
                                                <label class="col-md-2 col-form-label">Cc</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" name="cc_email">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="subject">
                                            <div class="row mb-3">
                                                <label class="col-md-2 col-form-label">Subject</label>
                                                <div class="col-md-10">
                                                    <input class="form-control" type="text" name="subject">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-3">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label visually-hidden">Descriptions
                                                </label>
                                                <textarea class="form-control" name="description" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="col-md-12">
                                                <button class="btn btn-primary me-1 mb-1" type="submit"> Send</button>
                                                <button class="btn btn-secondary me-1 mb-1" type="button">
                                                    Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                {{-- Form End --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
