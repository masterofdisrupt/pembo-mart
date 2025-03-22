@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        @include('_message')
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('send.pdf') }}">Send PDF</a></li>
                <li class="breadcrumb-item active" aria-current="page">Send PDF</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Send PDF Email</h6>

                        <form class="forms-sample" method="POST" action="{{ route('send.pdf.sent') }}"
                            enctype="multipart/form-data">
                            @csrf


                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Email ID<span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="email" autocomplete="off"
                                        placeholder="Enter Email ID (johndoe@email.com)" value="" required>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Subject <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="subject" autocomplete="off"
                                        placeholder="Enter Subject" value="" required>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Message <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control" name="message" autocomplete="off" placeholder="Enter Message" required></textarea>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">PDF File<span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" name="doc_file" autocomplete="off"
                                        accept="application/pdf" required>

                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Send PDF Email</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
