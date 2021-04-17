<div class="topbar">
    <nav class="navbar-custom">
        <ul class="list-unstyled topbar-nav float-right mb-0">
            <li class="dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <div class="user-menu d-flex mt-3 mr-3">
                        <div class="user-img d-flex align-items-center">
                            <div class="avatar avatar-lg bg-warning me-3">
                                <span class="avatar-content">{{\App\Helpers\CommonHelper::getDp()}}</span>                                    
                            </div>
                        </div>
                        <div class="user-name text-end me-3 ml-3">
                            <h6 class="mb-0 text-gray-600">{{Auth::user()->name ? ucfirst(Auth::user()->name) : Auth::user()->email}}</h6>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"><i data-feather="power"
                            class="align-self-center icon-xs icon-dual mr-1 text-danger"></i> Logout</a>
                </div>
            </li>
        </ul>
        <ul class="list-unstyled topbar-nav mb-0">
            <li>
                <button class="nav-link button-menu-mobile"><i data-feather="menu"
                        class="align-self-center topbar-icon"></i></button>
            </li>
        </ul>
    </nav>
</div>
