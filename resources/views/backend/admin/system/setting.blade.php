@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">

         @include('_message')

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('brands') }}">System Setting</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add System Setting</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">

                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Add System Setting</h6>


                        <form class="forms-sample" method="POST" action="{{ route('upadate.system.setting') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Website<span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="website"
                                        placeholder="Enter Website" value="{{ $getRecord->website }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Logo <span style="color: red;"></span></label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" name="logo">
                                    @if (!empty($getRecord->getLogo()))
                                        <img src="{{ $getRecord->getLogo() }}" style="width: 100px;">
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Favicon <span style="color: red;"></span></label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" name="favicon">
                                    @if (!empty($getRecord->getFavicon()))
                                        <img src="{{ $getRecord->getFavicon() }}" style="width: 50px;">
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Footer Payment Icon</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" name="footer_payment_icon">
                                    @if (!empty($getRecord->getFooterPaymentIcon()))
                                        <img src="{{ $getRecord->getFooterPaymentIcon() }}" style="width: 100px;">
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Footer Description<span style="color: red;"></span></label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control" name="footer_desc">{{ $getRecord->footer_desc }}</textarea>
                                </div>
                            </div>

                            <hr>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Address<span style="color: red;"></span></label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control" name="address">{{ $getRecord->address }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Phone<span style="color: red;"></span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="phone"
                                        placeholder="Enter Phone" value="{{ $getRecord->phone }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Phone 2<span style="color: red;"></span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="phone_two"
                                        placeholder="Enter Phone 2" value="{{ $getRecord->phone_two }}">
                                </div>
                            </div>

                             <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Submit Contact Email<span style="color: red;"></span></label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="contact_email"
                                        placeholder="Enter Submit Contact Email" value="{{ $getRecord->contact_email }}">
                                </div>
                            </div>

                             <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Email Link<span style="color: red;"></span></label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email"
                                        placeholder="Enter Email" value="{{ $getRecord->email }}">
                                </div>
                            </div>

                             <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Email 2 Link<span style="color: red;"></span></label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email_two"
                                        placeholder="Enter Email 2" value="{{ $getRecord->email_two }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Working Hours Link<span style="color: red;"></span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="work_hour"
                                        placeholder="Enter Working Hours" value="{{ $getRecord->work_hour }}">
                                </div>
                            </div>

                            <hr>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Facebook Link<span style="color: red;"></span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="facebook_link"
                                        placeholder="Enter Facebook" value="{{ $getRecord->facebook_link }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Twitter Link<span style="color: red;"></span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="twitter_link"
                                        placeholder="Enter Twitter" value="{{ $getRecord->twitter_link }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Instagram Link<span style="color: red;"></span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="instagram_link"
                                        placeholder="Enter Instagram" value="{{ $getRecord->instagram_link }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Youtube Link<span style="color: red;"></span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="youtube_link"
                                        placeholder="Enter Youtube" value="{{ $getRecord->youtube_link }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">LinkedIn Link<span style="color: red;"></span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="linkedin_link"
                                        placeholder="Enter LinkedIn" value="{{ $getRecord->linkedin_link }}">
                                </div>
                            </div>
                                

                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <a href="{{ route('brands') }}" class="btn btn-secondary">Back</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
