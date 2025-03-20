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


              <li class="nav-item">
                  <a href="{{ url('admin/email_otp') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Email OTP</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('colour') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Colour</span>
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
                      <span class="link-title">Blog</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ url('admin/send_pdf') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Send PDF</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ url('admin/transactions') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Transactions</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ url('admin/full_calendar') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Full Calendar</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ url('admin/change_password') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Change Password</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ url('admin/discount_code') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Discount Code</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ url('admin/support') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Support</span>
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
                      <span class="link-title">Countries</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('states') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">States</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('cities') }}" class="nav-link">
                      <i class="link-icon" data-feather="box"></i>
                      <span class="link-title">Cities</span>
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
                  <a href="pages/apps/calendar.html" class="nav-link">
                      <i class="link-icon" data-feather="calendar"></i>
                      <span class="link-title">Calendar</span>
                  </a>
              </li>
              <li class="nav-item nav-category">Components</li>
              <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button"
                      aria-expanded="false" aria-controls="uiComponents">
                      <i class="link-icon" data-feather="feather"></i>
                      <span class="link-title">UI Kit</span>
                      <i class="link-arrow" data-feather="chevron-down"></i>
                  </a>
                  <div class="collapse" id="uiComponents">
                      <ul class="nav sub-menu">
                          <li class="nav-item">
                              <a href="pages/ui-components/accordion.html" class="nav-link">Accordion</a>
                          </li>
                          <li class="nav-item">
                              <a href="pages/ui-components/alerts.html" class="nav-link">Alerts</a>
                          </li>

                      </ul>
                  </div>
              </li>
              <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button"
                      aria-expanded="false" aria-controls="advancedUI">
                      <i class="link-icon" data-feather="anchor"></i>
                      <span class="link-title">Advanced UI</span>
                      <i class="link-arrow" data-feather="chevron-down"></i>
                  </a>
                  <div class="collapse" id="advancedUI">
                      <ul class="nav sub-menu">
                          <li class="nav-item">
                              <a href="pages/advanced-ui/cropper.html" class="nav-link">Cropper</a>
                          </li>
                          <li class="nav-item">
                              <a href="pages/advanced-ui/owl-carousel.html" class="nav-link">Owl carousel</a>
                          </li>

                      </ul>
                  </div>
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
