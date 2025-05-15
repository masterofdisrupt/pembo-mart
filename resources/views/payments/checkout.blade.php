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
            			
            			<form action="{{ route('checkout.place.order') }}" id="submit-form" method="POST">
							@csrf
		                	<div class="row">
		                		<div class="col-lg-9">
		                			<h2 class="checkout-title">Billing Details</h2><!-- End .checkout-title -->
		                				<div class="row">
		                					<div class="col-sm-6">
		                						<label for="first-name">First Name *</label>
		                						<input type="text" name="first_name" id="first-name" class="form-control" required>
		                					</div><!-- End .col-sm-6 -->

		                					<div class="col-sm-6">
		                						<label for="last-name">Last Name *</label>
		                						<input type="text" name="last_name" id="last-name" class="form-control" required>
		                					</div><!-- End .col-sm-6 -->
		                				</div><!-- End .row -->

	            						<label for="company-name">Company Name (Optional)</label>
	            						<input type="text" name="company_name" id="company-name" class="form-control">

	            						<label for="country">Country *</label>
	            						<input type="text" name="country"  id="country" class="form-control" required>

	            						<label for="street-address">Street address *</label>
	            						<input type="text" name="address_one"  id="address-one" class="form-control" placeholder="House number and Street name" required>
	            						<input type="text" name="address_two" id="address-two" class="form-control" placeholder="Appartments, suite, unit etc ..." required>

	            						<div class="row">
		                					<div class="col-sm-6">
		                						<label for="town-city">Town / City *</label>
		                						<input type="text" name="city" id="city" class="form-control" required>
		                					</div><!-- End .col-sm-6 -->

		                					<div class="col-sm-6">
		                						<label for="state">State *</label>
		                						<input type="text" name="state"  id="state" class="form-control" required>
		                					</div><!-- End .col-sm-6 -->
		                				</div><!-- End .row -->

		                				<div class="row">
		                					<div class="col-sm-6">
		                						<label for="post-code">Postcode / ZIP *</label>
		                						<input type="text" name="postcode" id="post-code" class="form-control" required>
		                					</div><!-- End .col-sm-6 -->

		                					<div class="col-sm-6">
		                						<label for="phone">Phone *</label>
		                						<input type="tel" name="phone" id="phone" class="form-control" required>
		                					</div><!-- End .col-sm-6 -->
		                				</div><!-- End .row -->

	                					<label for="email">Email *</label>
	        							<input type="email" name="email" id="email" class="form-control" required>

										@guest
	        							<div class="custom-control custom-checkbox">
											<input type="checkbox" name="is_create" class="custom-control-input checkout-create-account" id="checkout-create-acc">
											<label class="custom-control-label" for="checkout-create-acc">Create an account?</label>
										</div><!-- End .custom-checkbox -->

										<div id="checkout-password" style="display: none;">
											<p>Your password must be at least 8 characters long.</p>
	        							<label>Password</label>
	        							<input type="text" name="password" id="input-password" class="form-control" placeholder="Password">
										</div>
										@endguest

										
	                					<label>Order notes (optional)</label>
	        							<textarea class="form-control" name="notes" cols="30" rows="4" placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
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
                                                @foreach ($cartItems as $cart)
		                						<tr>
		                							<td><a href="{{ route('product.details', $cart->product->slug) }}">{{ $cart->product->title }}</a></td>
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
                                                                <input type="text" name="discount_code" class="form-control" placeholder="Discount code" id="get-discount-code">
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
														value="{{ $shipping->id }}" required>
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

											<div class="custom-control custom-radio">
												<input type="radio" id="payment-1" value="wallet" name="payment_method" class="custom-control-input" value="1" checked>
												<label class="custom-control-label" for="payment-1">Wallet</label>
											</div>

											<div class="custom-control custom-radio" style="margin-top: 0.5px;">
												<input type="radio" id="payment-2" value="cash" name="payment_method" class="custom-control-input" value="1" checked>
												<label class="custom-control-label" for="payment-2">Cash on delivery</label>
											</div>
										        										                
										</div>

		                				<button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
		                					<span class="btn-text">Place Order</span>
		                					<span class="btn-hover-text">Proceed to Checkout</span>
		                				</button>
										<br><br>
										<img src="{{ url('assets/images/payments-summary.png') }}">
		                			</div>
		                		</aside>
		                	</div>
            			</form>
	                </div>
                </div>
            </div>
        </main>

@endsection
@section('script')
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    

<script type="text/javascript">
    $(document).ready(function(){
		$('.checkout-create-account').on('change', function() {
			if ($(this).is(':checked')) {
				$('#checkout-password').show();
				$('#input-password').prop('required', true);
			} else {
				$('#checkout-password').hide();
				$('#input-password').prop('required', false);
			}
		});

		$('#submit-form').on('submit', function(e) {
    e.preventDefault();

    // Clear previous error states
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    $.ajax({
        type: 'POST',
        url: "{{ route('checkout.place.order') }}",
        data: new FormData(this),
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                toastr.success(response.message || 'Order placed successfully!');
                window.location.href = response.redirect_url || '{{ route('home') }}';
            } else {
                toastr.error(response.message || 'Failed to place order. Please try again.');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                let firstErrorField = null;

                for (const field in errors) {
                    if (errors.hasOwnProperty(field)) {
                        const input = $(`[name="${field}"]`);

                        toastr.error(errors[field][0]);
                        input.addClass('is-invalid');

                        if (input.length && input.next('.invalid-feedback').length === 0) {
                            input.after(`<div class="invalid-feedback d-block">${errors[field][0]}</div>`);
                        }

                        if (!firstErrorField) {
                            firstErrorField = input;
                        }
                    }
                }

                if (firstErrorField && firstErrorField.offset()) {
                    $('html, body').animate({
                        scrollTop: firstErrorField.offset().top - 100
                    }, 500, function() {
                        firstErrorField.focus();
                    });
                }
            } else {
                toastr.error(xhr.responseJSON?.message || 'Something went wrong. Please try again.');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
    });
});

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