@extends('layouts.app')
@section('style')

@endsection

@section('content')

<main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Checkout<span>Shop</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="checkout">
	                <div class="container">
            			
            			<form action="#">
		                	<div class="row">
		                		<div class="col-lg-9">
		                			<h2 class="checkout-title">Billing Details</h2><!-- End .checkout-title -->
		                				<div class="row">
		                					<div class="col-sm-6">
		                						<label>First Name *</label>
		                						<input type="text" class="form-control" required>
		                					</div><!-- End .col-sm-6 -->

		                					<div class="col-sm-6">
		                						<label>Last Name *</label>
		                						<input type="text" class="form-control" required>
		                					</div><!-- End .col-sm-6 -->
		                				</div><!-- End .row -->

	            						<label>Company Name (Optional)</label>
	            						<input type="text" class="form-control">

	            						<label>Country *</label>
	            						<input type="text" class="form-control" required>

	            						<label>Street address *</label>
	            						<input type="text" class="form-control" placeholder="House number and Street name" required>
	            						<input type="text" class="form-control" placeholder="Appartments, suite, unit etc ..." required>

	            						<div class="row">
		                					<div class="col-sm-6">
		                						<label>Town / City *</label>
		                						<input type="text" class="form-control" required>
		                					</div><!-- End .col-sm-6 -->

		                					<div class="col-sm-6">
		                						<label>State / County *</label>
		                						<input type="text" class="form-control" required>
		                					</div><!-- End .col-sm-6 -->
		                				</div><!-- End .row -->

		                				<div class="row">
		                					<div class="col-sm-6">
		                						<label>Postcode / ZIP *</label>
		                						<input type="text" class="form-control" required>
		                					</div><!-- End .col-sm-6 -->

		                					<div class="col-sm-6">
		                						<label>Phone *</label>
		                						<input type="tel" class="form-control" required>
		                					</div><!-- End .col-sm-6 -->
		                				</div><!-- End .row -->

	                					<label>Email address *</label>
	        							<input type="email" class="form-control" required>

	        							<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="checkout-create-acc">
											<label class="custom-control-label" for="checkout-create-acc">Create an account?</label>
										</div><!-- End .custom-checkbox -->

										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="checkout-diff-address">
											<label class="custom-control-label" for="checkout-diff-address">Ship to a different address?</label>
										</div><!-- End .custom-checkbox -->

	                					<label>Order notes (optional)</label>
	        							<textarea class="form-control" cols="30" rows="4" placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
		                		</div><!-- End .col-lg-9 -->
		                		<aside class="col-lg-3">
		                			<div class="summary">
		                				<h3 class="summary-title">Your Order</h3><!-- End .summary-title -->

		                				<table class="table table-summary">
		                					<thead>
		                						<tr>
		                							<th>Product</th>
		                							<th>Total</th>
		                						</tr>
		                					</thead>

		                					<tbody>
                                                @foreach (Cart::getContent() as $key => $cart)
                                                @php
                                                    $getCartProduct = App\Models\Backend\V1\ProductModel::getSingleRecord($cart->id);
                                                @endphp
		                						<tr>
		                							<td><a href="{{ url($getCartProduct->slug) }}">{{ $getCartProduct->title }}</a></td>
		                							<td>₦{{ number_format($cart->price * $cart->quantity, 2) }}</td>
		                						</tr>

                                                @endforeach

		                						<tr class="summary-subtotal">
		                							<td>Subtotal:</td>
		                							<td>₦{{ number_format(Cart::getSubTotal(), 2) }}</td>
		                						</tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <div class="cart-discount">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" placeholder="Discount code" id="get-discount-code">
                                                                <div class="input-group-append">
                                                                    <button type="button" id="apply-discount" style="height: 39px;" class="btn btn-outline-primary-2"><i class="icon-long-arrow-right"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Discount</td>
                                                    <td>₦<span id="discount-amount">0.00</span></td>
												</tr>
												<tr>
													<td colspan="2" id="discount-code-status"></td>
												</tr>

		                						<tr class="summary-shipping">
													<td>Shipping:</td>
													<td>&nbsp;</td>
												</tr>

												@foreach ($shippingCharges as $shipping)

												<tr class="summary-shipping-row">
	                							<td>
													<div class="custom-control custom-radio">
														<input type="radio" id="free-shipping{{ $shipping->id }}" name="shipping" 
														class="custom-control-input shipping-charge" data-price="{{ !empty($shipping->price) ? $shipping->price : 0 }}" 
														value="{{ $shipping->id }}">
														<label class="custom-control-label" for="free-shipping{{ $shipping->id }}">{{ $shipping->name }}</label>
													</div>
	                							<td>
													@if (!empty($shipping->price))
														₦{{ number_format($shipping->price, 2) }}

													@endif
												</td>
	                						</tr>
											@endforeach

		                						<tr class="summary-total">
		                							<td>
														
														Total:
													</td>
		                							<td>₦<span id="payable-total">{{ number_format(Cart::getSubTotal(), 2) }}</span></td>
		                						</tr><!-- End .summary-total -->
		                					</tbody>
		                				</table><!-- End .table table-summary -->

										<input type="hidden" name="shipping_charge" id="get-payable-total" value="{{ Cart::getSubTotal() }}">

		                				<div class="accordion-summary" id="accordion-payment">

										    <div class="card">
										        <div class="card-header" id="heading-3">
										            <h2 class="card-title">
										                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
										                    Cash on delivery
										                </a>
										            </h2>
										        </div><!-- End .card-header -->
										        <div id="collapse-3" class="collapse" aria-labelledby="heading-3" data-parent="#accordion-payment">
										            <div class="card-body">Quisque volutpat mattis eros. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. 
										            </div><!-- End .card-body -->
										        </div><!-- End .collapse -->
										    </div><!-- End .card -->

										    <div class="card">
										        <div class="card-header" id="heading-4">
										            <h2 class="card-title">
										                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
										                    PayPal <small class="float-right paypal-link">What is PayPal?</small>
										                </a>
										            </h2>
										        </div><!-- End .card-header -->
										        <div id="collapse-4" class="collapse" aria-labelledby="heading-4" data-parent="#accordion-payment">
										            <div class="card-body">
										                Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede. Donec nec justo eget felis facilisis fermentum.
										            </div><!-- End .card-body -->
										        </div><!-- End .collapse -->
										    </div><!-- End .card -->

										    <div class="card">
										        <div class="card-header" id="heading-5">
										            <h2 class="card-title">
										                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-5" aria-expanded="false" aria-controls="collapse-5">
										                    Credit Card (Stripe)
										                    <img src="assets/images/payments-summary.png" alt="payments cards">
										                </a>
										            </h2>
										        </div><!-- End .card-header -->
										        <div id="collapse-5" class="collapse" aria-labelledby="heading-5" data-parent="#accordion-payment">
										            <div class="card-body"> Donec nec justo eget felis facilisis fermentum.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Lorem ipsum dolor sit ame.
										            </div><!-- End .card-body -->
										        </div><!-- End .collapse -->
										    </div><!-- End .card -->
										</div><!-- End .accordion -->

		                				<button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
		                					<span class="btn-text">Place Order</span>
		                					<span class="btn-hover-text">Proceed to Checkout</span>
		                				</button>
		                			</div><!-- End .summary -->
		                		</aside><!-- End .col-lg-3 -->
		                	</div><!-- End .row -->
            			</form>
	                </div><!-- End .container -->
                </div><!-- End .checkout -->
            </div><!-- End .page-content -->
        </main>

@endsection
@section('script')
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    

<script type="text/javascript">
       $(document).ready(function(){
		$('.shipping-charge').on('change', function() {
    const shippingCharge = parseFloat($(this).data('price')) || 0;
    const discount = parseFloat($('#discount-amount').text().replace(/,/g, '')) || 0;
    const subtotal = {{ Cart::getSubTotal() }};
    const total = subtotal - discount + shippingCharge;

    $('#payable-total').text(total.toFixed(2));
    $('#get-payable-total').val(total.toFixed(2));
});

        $('#apply-discount').on('click', function() {
            const discountCode = $('#get-discount-code').val();

            if (!discountCode) {
                toastr.warning('Please enter a discount code');
                return;
            }

            $.ajax({
                type: 'POST',
                url: '{{ route('apply.discount') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    discount_code: discountCode
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Discount code applied successfully!');

                        $('#discount-amount').text(response.discount);
                        $('#payable-total').text(response.payable_total.toFixed(2));
						$('#get-payable-total').val(response.payable_total);
                        $('#discount-code-status').html(response.status_badge);
                    } else {
                        toastr.error('Invalid discount code.');
                        $('#discount-code-status').html('');
                    }
                },
                error: function() {
                    toastr.error('Invalid or expired discount code.');
                    $('#discount-code-status').html('');
                }
            });
        });
    });
    </script>

@endsection