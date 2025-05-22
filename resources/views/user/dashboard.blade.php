@extends('layouts.app')

@section('style')
<style type="text/css">
	.box-btn {
		background: #fff;
		border-radius: 5px;
		padding: 20px;
		text-align: center;
		box-shadow: 0 0 10px rgba(0,0,0,0.1);
		margin-bottom: 1.5rem; 
	}
	.stat-value {
  font-size: 20px;
  font-weight: bold;
}
.stat-label {
  font-size: 12px;
  font-weight: bold;
  color: #555;
}

</style>
@endsection

@section('content')
<main class="main">
    <div class="page-header text-center">
        <div class="container">
            <h1 class="page-title">Dashboard</h1>
        </div>
    </div>

    <div class="page-content">
        <div class="dashboard">
            <div class="container">
                <br>
                <div class="row">
                    @include('user._sidebar')

                     <div class="col-md-8 col-lg-9">
						<div class="row gy-4">
							@foreach($metrics as $metric)
								<x-statistic-card :label="$metric['label']" :value="$metric['value']" />
							@endforeach
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
