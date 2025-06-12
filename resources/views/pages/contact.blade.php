@extends('layouts.app')

@section('meta_title', $getPages->meta_title)
@section('meta_description', $getPages->meta_description)
@section('meta_keywords', $getPages->meta_keywords)

@section('content')

<main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $getPages->title }}</li>
                    </ol>
                </div>
            </nav>
            <div class="container">
	        	<div class="page-header page-header-big text-center" style="background-image: url('assets/images/contact-header-bg.jpg')">
        			<h1 class="page-title text-white">{{ $getPages->title }}</h1>
	        	</div>
            </div>
			
            <div class="page-content pb-0">
                <div class="container">
                	<div class="row">
                		<div class="col-lg-6 mb-2 mb-lg-0">
                			{!! $getPages->description !!}
                			<div class="row">
                				<div class="col-sm-7">
                					<div class="contact-info">

                						<ul class="contact-list">
											@if (!empty($getSystemSettingApp->address))
												<li>
                								<i class="icon-map-marker"></i>
	                						    {{ $getSystemSettingApp->address }}
	                						</li>
											@endif
                							@if (!empty($getSystemSettingApp->phone))
												<li>
													<i class="icon-phone"></i>
													<a href="tel:{{ $getSystemSettingApp->phone }}">{{ $getSystemSettingApp->phone }}</a>
												</li>
												
											@endif

											@if (!empty($getSystemSettingApp->phone_two))
												<li>
													<i class="icon-phone"></i>
													<a href="tel:{{ $getSystemSettingApp->phone_two }}">{{ $getSystemSettingApp->phone_two }}</a>
												</li>
												
											@endif
                							@if (!empty($getSystemSettingApp->email))
												<li>
                								<i class="icon-envelope"></i>
                								<a href="mailto:{{ $getSystemSettingApp->email }}">{{ $getSystemSettingApp->email }}</a>
                							</li>
											@endif

											@if (!empty($getSystemSettingApp->email_two))
												<li>
                								<i class="icon-envelope"></i>
                								<a href="mailto:{{ $getSystemSettingApp->email_two }}">{{ $getSystemSettingApp->email_two }}</a>
                							</li>
											@endif
                							
                						</ul>
                					</div>
                				</div>

                				<div class="col-sm-5">
                					<div class="contact-info">

                						<ul class="contact-list">
											@if (!empty($getSystemSettingApp->work_hour))
												<li>
                								<i class="icon-clock-o"></i>
	                								{{ $getSystemSettingApp->work_hour }}
	                						</li>
											@endif
                							
                						</ul>                					</div>
                				</div>
                			</div>
                		</div>
                		<div class="col-lg-6">
                			<h2 class="title mb-1">Got Any Questions?</h2>
                			<p class="mb-2">Use the form below to get in touch with the sales team</p>

                			<form action="{{ route('submit.contact') }}" method="POST" autocomplete="off" class="contact-form mb-3">
								@csrf
                				<div class="row">
                					<div class="col-sm-6">
                                        <label for="cname" class="sr-only">Name</label>
                						<input type="text" class="form-control" name="name" id="cname" placeholder="Name *" required>
                					</div>

                					<div class="col-sm-6">
                                        <label for="cemail" class="sr-only">Email</label>
                						<input type="email" class="form-control" name="email" id="cemail" placeholder="Email *" required>
                					</div>
                				</div>

                				<div class="row">
                					<div class="col-sm-6">
                                        <label for="cphone" class="sr-only">Phone</label>
                						<input type="tel" class="form-control" name="phone" id="cphone" placeholder="Phone">
                					</div>

                					<div class="col-sm-6">
                                        <label for="csubject" class="sr-only">Subject</label>
                						<input type="text" class="form-control" name="subject" id="csubject" placeholder="Subject" required>
                					</div>
                				</div>
                                <label for="cmessage" class="sr-only">Message</label>
                				<textarea class="form-control" name="message" cols="30" rows="4" id="cmessage" required placeholder="Message *"></textarea>

								<div class="row">
                					<div class="col-sm-12">
                                        <label for="verification">{{ $first_number }} + {{ $second_number }} = ?</label>
                						<input type="text" class="form-control" name="verification" id="verification" placeholder="Verification Sum">
                					</div>
								</div>

                				<button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm">
                					<span>SUBMIT</span>
            						<i class="icon-long-arrow-right"></i>
                				</button>
                			</form>
                		</div>
                	</div>

                </div>
            </div>
        </main>
        
@endsection