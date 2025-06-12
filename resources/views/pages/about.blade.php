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
	        	<div class="page-header page-header-big text-center" style="background-image: url('{{ $getPages->getPageImages() }}')">
        			<h1 class="page-title text-white">{{ $getPages->title }}</h1>
	        	</div>
            </div>

            <div class="page-content pb-0">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 mb-3 mb-lg-0">
                            {!! $getPages->description !!}
                        </div>
                        
                    </div>

                    <div class="mb-5"></div>
                </div>

            </div>
        </main>

@endsection