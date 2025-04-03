@extends('backend.admin.admin_dashboard')

@section('admin')
    <div class="page-content">
        @include('_message')
        <nav class="page-breadcrumb">

            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Schedule</a></li>
                <li class="breadcrumb-item active" aria-current="page">Schedule List</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h4 class="card-title">Schedule List</h4>
                            <div class="d-flex align-items-center">

                            </div>
                        </div>

                        <div class="table-responsive pt-3">
                            <form action="{{ route('admin.schedule.update') }}" method="POST">
                                {{ csrf_field() }}
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Week</th>
                                            <th>Open/Close</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($weekRecord as $row)
                                            @php
                                                $getUserWeek = App\Models\Backend\V1\UserTimeModel::getDetail($row->id);
                                                $open_close = !empty($getUserWeek->status) ? $getUserWeek->status : '';
                                                $start_time = !empty($getUserWeek->start_time)
                                                    ? $getUserWeek->start_time
                                                    : '';
                                                $end_time = !empty($getUserWeek->end_time)
                                                    ? $getUserWeek->end_time
                                                    : '';
                                            @endphp
                                            <tr class="table-info text-dark">
                                                <td>{{ !empty($row->name) ? $row->name : '' }}</td>
                                                <td>
                                                    <input type="hidden" value="{{ $row->id }}"
                                                        name="week[{{ $row->id }}][week_id]">
                                                    <label for="" class="switch">
                                                        <input type="checkbox" class="change-availability"
                                                            name="week[{{ $row->id }}][status]"
                                                            id="{{ $row->id }}"
                                                            {{ !empty($open_close) ? 'checked' : '' }}>
                                                    </label>
                                                </td>
                                                <td>
                                                    <select name="week[{{ $row->id }}][start_time]"
                                                        class="form-control required-{{ $row->id }} show-availability-{{ $row->id }}"
                                                        style="{{ !empty($open_close) ? '' : 'display:none' }}">
                                                        <option value="">Select Start Time</option>
                                                        @foreach ($weekTimeRow as $timeRow1)
                                                            <option
                                                                {{ trim($start_time) == trim($timeRow1->name) ? 'selected' : '' }}
                                                                value="{{ $timeRow1->name }}">
                                                                {{ $timeRow1->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="week[{{ $row->id }}][end_time]"
                                                        class="form-control required-{{ $row->id }} show-availability-{{ $row->id }}"
                                                        style="{{ !empty($open_close) ? '' : 'display:none' }}">
                                                        <option value="">Select End Time</option>
                                                        @foreach ($weekTimeRow as $timeNow)
                                                            <option
                                                                {{ trim($end_time) == trim($timeNow->name) ? 'selected' : '' }}
                                                                value="{{ $timeNow->name }}">
                                                                {{ $timeNow->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                                <button type="submit" class="btn btn-primary me-2" style="float: right;">Update</button>
                            </form>
                        </div>
                        <div style="padding: 20px; float: right;">                    

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('.change-availability').click(function() {
            var id = $(this).attr('id');
            if (this.checked) {
                $('.show-availability-' + id).show();
                $('.required-' + id).prop('required', true);
            } else {
                $('.show-availability-' + id).hide();
                $('.required-' + id).prop('required', false);
            }
        });
    </script>
@endsection
