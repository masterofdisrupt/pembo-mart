  <footer class="footer footer-dark">
        	<div class="footer-middle">
	            <div class="container">
	            	<div class="row">
	            		<div class="col-sm-6 col-lg-3">
	            			<div class="widget widget-about">
	            				<img src="{{ $getSystemSettingApp->getLogo() }}" class="footer-logo" alt="Footer Logo" width="105" height="25">
	            				<p>{{ $getSystemSettingApp->footer_desc }} </p>

	            				<div class="social-icons">
									@if (!empty($getSystemSettingApp->facebook_link))
	            					<a href="{{ $getSystemSettingApp->facebook_link }}" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>	
									@endif
									@if (!empty($getSystemSettingApp->twitter_link))
	            					<a href="{{ $getSystemSettingApp->twitter_link }}" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>				
									@endif
									@if (!empty($getSystemSettingApp->instagram_link))
	            					<a href="{{ $getSystemSettingApp->instagram_link }}" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
									@endif
									@if (!empty($getSystemSettingApp->youtube_link))
	            					<a href="{{ $getSystemSettingApp->youtube_link }}" class="social-icon" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
									@endif
									@if (!empty($getSystemSettingApp->linkedin_link))
	            					<a href="{{ $getSystemSettingApp->linkedin_link }}" class="social-icon" title="LinkedIn" target="_blank"><i class="icon-linkedin"></i></a>
									@endif
	            				</div>
	            			</div>
	            		</div>

	            		<div class="col-sm-6 col-lg-3">
	            			<div class="widget">
	            				<h4 class="widget-title">Useful Links</h4><!-- End .widget-title -->

	            				<ul class="widget-list">
	            					<li><a href="{{ route('home') }}">Home</a></li>
	            					<li><a href="{{ route('about.us') }}">About Us</a></li>
	            					{{-- <li><a href="{{ route('how.to.shop') }}">How to shop on Pembo Mart</a></li> --}}
	            					<li><a href="{{ route('faq') }}">FAQ</a></li>
	            					<li><a href="{{ route('contact.us') }}">Contact us</a></li>
	            					<li><a href="{{ route('blogs') }}">Blog</a></li>
	            					<li><a href="#signin-modal" data-toggle="modal">Log in</a></li>
	            				</ul>
	            			</div>
						</div>

	            		<div class="col-sm-6 col-lg-3">
	            			<div class="widget">
	            				<h4 class="widget-title">Customer Service</h4>

	            				<ul class="widget-list">
	            					<li><a href="{{ route('payment.methods') }}">Payment Methods</a></li>
	            					<li><a href="{{ route('money.back.guarantee') }}">Money-back guarantee!</a></li>
	            					<li><a href="{{ route('returns') }}">Returns</a></li>
	            					<li><a href="{{ route('shipping') }}">Shipping</a></li>
	            					<li><a href="{{ route('terms.and.conditions') }}">Terms and conditions</a></li>
	            					<li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
	            				</ul>
	            			</div>
	            		</div>

	            		<div class="col-sm-6 col-lg-3">
	            			<div class="widget">
	            				<h4 class="widget-title">My Account</h4>

	            				<ul class="widget-list">
	            					<li><a href=""{{ route('cart') }}>View Cart</a></li>
	            					<li><a href="{{ route('checkout') }}">Checkout</a></li>
	            					<li><a href="#">Help</a></li>
	            				</ul>
	            			</div>
	            		</div>
	            	</div>
	            </div>
	        </div>

	        <div class="footer-bottom">
	        	<div class="container">
	        		<p class="footer-copyright">Copyright © {{ date('Y') }} {{ $getSystemSettingApp->website }}. All Rights Reserved.</p>
	        		<figure class="footer-payments">
	        			<img src="{{ $getSystemSettingApp->getFooterPaymentIcon() }}" alt="Payment methods" width="272" height="20">
	        		</figure>
	        	</div>
	        </div>
        </footer>