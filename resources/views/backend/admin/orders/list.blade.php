@extends('backend.admin.admin_dashboard')

@section('admin')
    <div class="page-content">
        @include('_message')
        <nav class="page-breadcrumb">

            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('orders') }}">Order</a></li>
                <li class="breadcrumb-item active" aria-current="page">Order List </li>
            </ol>
        </nav>
        
        <div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Search Order</h6>
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="" class="form-label">ID</label>
                                        <input type="text" name="id" class="form-control"
                                            value="{{ request()->id }}" placeholder="Enter ID">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="" class="form-label">First Name</label>
                                        <input type="text" name="first_name" class="form-control"
                                            value="{{ request()->first_name }}" placeholder="Enter First Name">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Last Name</label>
                                        <input type="text" name="last_name" class="form-control"
                                            value="{{ request()->last_name }}" placeholder="Enter Last Name">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Email </label>
                                        <input type="text" name="email" class="form-control"
                                            value="{{ request()->email }}" placeholder="Enter Email">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Country </label>
                                        <input type="text" name="country" class="form-control"
                                            value="{{ request()->country }}" placeholder="Enter Country">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">State </label>
                                        <input type="text" name="state" class="form-control"
                                            value="{{ request()->state }}" placeholder="Enter State">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">City </label>
                                        <input type="text" name="city" class="form-control"
                                            value="{{ request()->city }}" placeholder="Enter City">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Address</label>
                                        <input type="text" name="address_one" class="form-control"
                                            value="{{ request()->address_one }}" placeholder="Enter Address">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Phone Number</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ request()->phone }}" placeholder="Enter Phone number">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="" class="form-label">From Date</label>
                                        <input type="date" name="from_date" class="form-control"
                                            value="{{ request()->from_date }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="" class="form-label">To Date</label>
                                        <input type="date" name="to_date" class="form-control"
                                            value="{{ request()->to_date }}">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{ route('orders') }}" class="btn btn-danger">Reset</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h4 class="card-title">Orders List</h4>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('add.orders') }}" class="btn btn-primary">
                                    Add Orders
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Number</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Company Name</th>
                                        <th>Country</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Post Code</th>
                                        <th>Phone</th>
                                        <th>Discount Code</th>
                                        <th>Discount Amount (₦)</th>
                                        <th>Total (₦)</th>
                                        <th>Shipping Amount (₦)</th>
                                        <th>Payment Method</th>
                                        <th>Payment Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($getOrders as $value)
                                        <tr class="table-info text-dark">
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->order_number }}</td>
                                            <td>{{ $value->first_name }}</td>
                                            <td>{{ $value->last_name }}</td>
                                            <td>{{ $value->email }}</td>
                                            <td>{{ $value->company_name }}</td>
                                            <td>{{ $value->country }}</td>
                                            <td>{{ $value->address_one }}</td>
                                            <td>{{ $value->city }}</td>
                                            <td>{{ $value->state }}</td>
                                            <td>{{ $value->postcode }}</td>
                                            <td>{{ $value->phone }}</td>
                                            <td>{{ $value->discount_code }}</td>
                                            <td>{{ number_format($value->discount_amount, 2) }}</td>
                                            <td>{{ number_format($value->total_amount, 2) }}</td>
                                            <td>{{ number_format($value->shipping_amount, 2) }}</td>
                                            <td style="text-transform: capitalize;">{{ $value->payment_method }}</td>
                                            <td>
                                                <select class="form-control change-status" id="{{ $value->id }}" style="width: 100px;">
                                                    <option {{ ($value->status == 0) ? 'selected' : '' }} value="0">Pending</option>
                                                    <option {{ ($value->status == 1) ? 'selected' : '' }} value="1">Processing</option>
                                                    <option {{ ($value->status == 2) ? 'selected' : '' }} value="2">Delivered</option>
                                                    <option {{ ($value->status == 3) ? 'selected' : '' }} value="3">Completed</option>
                                                    <option {{ ($value->status == 4) ? 'selected' : '' }} value="4">Cancelled</option>
                                                </select>
                                            </td>
                                            <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>

                                            <td>
                                                <a href="{{ route('view.orders', $value->id) }}"
                                                    class="btn btn-primary btn-sm">View</a>


                                                <a class="dropdown-item"
                                                    href="{{ route('edit.orders', $value->id) }}"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-edit-2 icon-sm me-2">
                                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                        </path>
                                                    </svg> <span class="">Edit</span></a>

                                                <form action="{{ route('delete.orders', $value->id) }}" 
                                                    method="POST" class="d-inline-block delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item d-flex align-items-center btn-delete" 
                                                    data-item-name="order" style="border: none; background: none; cursor: pointer;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-trash icon-sm me-2">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                        </svg>
                                                        <span>Delete</span>
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                         @empty
                                        <tr>
                                            <td colspan="100%">No Record Found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div style="padding: 20px; float: right;">
                            {!! $getOrders->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('.change-status').on('change', function() {
            var orderId = $(this).attr('id');
            var status = $(this).val();
            $.ajax({
                url: "{{ route('update.order.status') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: orderId,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error('An error occurred while updating the status.');
                }
            });
        });
    });
</script>
@endsection
