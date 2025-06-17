  @php
      use Illuminate\Support\Str;
  @endphp

  <nav class="sidebar">
      <div class="sidebar-header">
          <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
              PEMBO<span>MART</span>
          </a>
          <div class="sidebar-toggler not-active">
              <span></span>
              <span></span>
              <span></span>
          </div>
      </div>
      <div class="sidebar-body">
          <ul class="nav">
              <li class="nav-item nav-category">Main</li>
              <li class="nav-item">
                  <a href="{{ route('admin.dashboard') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Dashboard</span>
                  </a>
              </li>


              <li class="nav-item @if (Str::startsWith(Request::segment(2), 'users')) active @endif">
                  <a href="{{ route('admin.users') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Users</span>
                  </a>
              </li>

              <li class="nav-item @if (Str::startsWith(Request::segment(2), 'customers')) active @endif">
                  <a href="{{ route('admin.customers') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Customers</span>
                  </a>
              </li>

              <li class="nav-item @if (Str::startsWith(Request::segment(2), 'contact-us')) active @endif">
                  <a href="{{ route('admin.contact.us') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Contact Us</span>
                  </a>
              </li>

              <li class="nav-item @if (Str::startsWith(Request::segment(2), 'pages')) active @endif">
                  <a href="{{ route('admin.pages') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Pages</span>
                  </a>
              </li>

              <li class="nav-item @if (Str::startsWith(Request::segment(2), 'partner')) active @endif">
                  <a href="{{ route('partner') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Partner</span>
                  </a>
              </li>

              <li class="nav-item @if (Str::startsWith(Request::segment(2), 'slider')) active @endif">
                  <a href="{{ route('admin.slider') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Slider</span>
                  </a>
              </li> 

              <li class="nav-item">
                  <a href="{{ url('admin/email_otp') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Email OTP</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('colour') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Colours</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('product') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Product</span>
                  </a>
              </li>


              <li class="nav-item">
                  <a href="{{ route('orders') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Orders</span>
                  </a>
              </li>


             <li class="nav-item">
                  <a href="{{ route('blog') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Blogs</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('blog.category') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Blog Category</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('send.pdf') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Send PDF</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('transactions') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Transactions</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('change.password') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Change Password</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('discount.code') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Discount Codes</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('shipping.charge') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Shipping Charges</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('supports') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Supports</span>
                  </a>
              </li>

              <li class="nav-item nav-category">Categories</li>
              <li class="nav-item" @if (Str::startsWith(Request::segment(2), 'category')) active @endif>
                  <a href="{{ route('category') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Category</span>
                  </a>
              </li>
              
              <li class="nav-item">
                  <a href="{{ route('sub.category') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Sub Category</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('brands') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Brands</span>
                  </a>
              </li>

              <li class="nav-item nav-category">User Week</li>
              <li class="nav-item" @if (Request::segment(2) == 'week') active @endif>
                  <a href="{{ route('week.list') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Week</span>
                  </a>
              </li>


              <li class="nav-item" @if (Request::segment(2) == 'week_time') active @endif>
                  <a href="{{ route('week.time.list') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Week Time</span>
                  </a>
              </li>

              <li class="nav-item" @if (Request::segment(2) == 'schedule') active @endif>
                  <a href="{{ route('admin.schedule') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Schedule</span>
                  </a>
              </li>

              {{-- Address  --}}
              <li class="nav-item nav-category">Address</li>
              <li class="nav-item">
                  <a href="{{ route('countries') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Country</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('states') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">State</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('cities') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">City</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('admin.address') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Address</span>
                  </a>
              </li>

              <li class="nav-item nav-category">Notification</li>
              <li class="nav-item" @if (Request::segment(2) == 'notification') active @endif>
                  <a href="{{ route('notification') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Push Notification</span>
                  </a>
              </li>


              <li class="nav-item">
                  <a href="{{ route('smtp') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">SMTP</span>
                  </a>
              </li>


              <li class="nav-item nav-category">web apps</li>
              <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false"
                      aria-controls="emails">
                      <i class="link-icon" data-feather="mail"></i>
                      <span class="link-title">Email</span>
                      <i class="link-arrow" data-feather="chevron-down"></i>
                  </a>
                  <div class="collapse" id="emails">
                      <ul class="nav sub-menu">

                          <li class="nav-item">
                              <a href="{{ url('admin/email/compose') }}" class="nav-link">Compose</a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ url('admin/email/sent') }}" class="nav-link">Sent</a>
                          </li>
                      </ul>
                  </div>
              </li>

               <li class="nav-item">
                  <a href="{{ route('fullCalendar') }}" class="nav-link">
                      <i class="link-icon" data-feather="calendar"></i>
                      <span class="link-title">Full Calendar</span>
                  </a>
              </li>

              <li class="nav-item nav-category">Settings</li>
                  
                <li class="nav-item @if (Str::startsWith(Request::segment(2), 'system-setting')) active @endif">
                    <a href="{{ route('system.setting') }}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">System Settings</span>
                    </a>
                </li>

                <li class="nav-item @if (Str::startsWith(Request::segment(2), 'home-setting')) active @endif">
                    <a href="{{ route('home.setting') }}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Home Settings</span>
                    </a>
                </li>

              <li class="nav-item nav-category">Docs</li>
              <li class="nav-item">
                  <a href="#" target="_blank" class="nav-link">
                      <i class="link-icon" data-feather="hash"></i>
                      <span class="link-title">Documentation</span>
                  </a>
              </li>
          </ul>
      </div>
  </nav>
