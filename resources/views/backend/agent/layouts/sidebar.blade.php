 <nav class="sidebar">
     <div class="sidebar-header">
         <a href="" class="sidebar-brand">
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
                 <a href="{{ route('agent.dashboard') }}" class="nav-link">
                     <i class="link-icon" data-feather="box"></i>
                     <span class="link-title">Dashboard</span>
                 </a>
             </li>
             <li class="nav-item nav-category">Role</li>
             <li class="nav-item">
                 <a href="" class="nav-link">
                     <i class="link-icon" data-feather="box"></i>
                     <span class="link-title">Agent</span>
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
                             <a href="{{ url('agent/email/inbox') }}" class="nav-link">Inbox</a>
                         </li>
                         <li class="nav-item">
                             <a href="" class="nav-link">Compose</a>
                         </li>
                         <li class="nav-item">
                             <a href="" class="nav-link">Sent</a>
                         </li>
                     </ul>
                 </div>
             </li>

             <li class="nav-item" @if (Request::segment(2) == 'transactions') active @endif>
                 <a href="{{ route('agent.transactions') }}" class="nav-link">
                     <i class="link-icon" data-feather="calendar"></i>
                     <span class="link-title">Transactions</span>
                 </a>
             </li>

             <li class="nav-item">
                 <a href="{{ route('agent.transactions.list') }}" class="nav-link">
                     <i class="link-icon" data-feather="calendar"></i>
                     <span class="link-title">Transactions List</span>
                 </a>
             </li>

             <li class="nav-item nav-category">Components</li>
             <li class="nav-item">
                 <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="false"
                     aria-controls="uiComponents">
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
                 <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false"
                     aria-controls="advancedUI">
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
