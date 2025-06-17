<aside class="col-md-4 col-lg-3">
    <ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
        <li class="nav-item">
            <a href="{{ route('user.dashboard') }}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif ">Dashboard</a>
        </li>

        <li class="nav-item">
            <a href="{{ route('user.wallet') }}" class="nav-link @if(Request::segment(2) == 'wallet') active @endif ">Wallet</a>
        </li>

        <li class="nav-item">
            <a href="{{ route('user.orders') }}" class="nav-link @if(Request::segment(2) == 'orders') active @endif ">Orders</a>
        </li>
        
        <li class="nav-item">
            <a href="{{ route('user.edit.profile') }}" class="nav-link @if(Request::segment(2) == 'edit-profile') active @endif ">Edit Profile</a>
        </li>

        <li class="nav-item">
            @php
                $unreadNotificationsCount = App\Models\Backend\V1\NotificationModel::unreadNotificationsCount();
            @endphp
            <a href="{{ route('user.notification') }}" class="nav-link @if(Request::segment(2) == 'notifications') active @endif ">Notification ({{ $unreadNotificationsCount }})</a>
        </li>

        <li class="nav-item">
            <a href="{{ route('user.change.password') }}" class="nav-link @if(Request::segment(2) == 'change-password') active @endif ">Change Password</a>
        </li>

        <li class="nav-item">
           
             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link @if(Request::segment(2) == 'logout') active @endif ">
                Log Out
            </a>

        </li>
    </ul>
</aside>