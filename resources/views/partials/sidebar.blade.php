<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                @if(Auth::user()->isAdmin())
                <!-- ============================================================== -->
                <!-- Admin Role -->
                <!-- ============================================================== -->
                <li class="nav-small-cap"><span class="hide-menu">System Administrator</span></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ url('/admin') }}"
                        aria-expanded="false"><i data-feather="monitor" class="feather-icon"></i><span
                            class="hide-menu">System Dashboard</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ url('/admin/user') }}"
                        aria-expanded="false"><i data-feather="users" class="feather-icon"></i><span
                            class="hide-menu">Manage Users</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ url('/admin/store') }}"
                        aria-expanded="false"><i data-feather="shopping-cart" class="feather-icon"></i><span
                            class="hide-menu">Manage Stores</span></a></li>
                @endif

                @if(Auth::user()->isPimpinan())
                <!-- ============================================================== -->
                <!-- Pimpinan (Owner) Role -->
                <!-- ============================================================== -->
                <li class="nav-small-cap"><span class="hide-menu">Owner / Pimpinan</span></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ url('/pimpinan') }}"
                        aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span
                            class="hide-menu">Dashboard</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ url('/pimpinan/store') }}"
                        aria-expanded="false"><i data-feather="shopping-bag" class="feather-icon"></i><span
                            class="hide-menu">Store Profile</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ url('/pimpinan/kasir') }}"
                        aria-expanded="false"><i data-feather="user-check" class="feather-icon"></i><span
                            class="hide-menu">Manage Cashiers</span></a></li>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                        aria-expanded="false"><i data-feather="box" class="feather-icon"></i><span
                            class="hide-menu">Product & Stock </span></a>
                    <ul aria-expanded="false" class="collapse  first-level base-level-line">
                        <li class="sidebar-item"><a href="{{ url('/pimpinan/product') }}" class="sidebar-link"><span
                                    class="hide-menu"> Manage Products
                                </span></a>
                        </li>
                        <li class="sidebar-item"><a href="{{ url('/pimpinan/stock') }}" class="sidebar-link"><span
                                    class="hide-menu"> Stock Entry
                                </span></a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                        aria-expanded="false"><i data-feather="file-text" class="feather-icon"></i><span
                            class="hide-menu">Reports </span></a>
                    <ul aria-expanded="false" class="collapse  first-level base-level-line">
                        <li class="sidebar-item"><a href="{{ url('/pimpinan/report/transaction') }}" class="sidebar-link"><span
                                    class="hide-menu"> Transaction Report
                                </span></a>
                        </li>
                        <li class="sidebar-item"><a href="{{ url('/pimpinan/report/stock') }}" class="sidebar-link"><span
                                    class="hide-menu"> Stock Report
                                </span></a>
                        </li>
                    </ul>
                </li>
                @endif

                @if(Auth::user()->isKasir())
                <!-- ============================================================== -->
                <!-- Kasir Role -->
                <!-- ============================================================== -->
                <li class="nav-small-cap"><span class="hide-menu">Cashier / Kasir</span></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ url('/kasir') }}"
                        aria-expanded="false"><i data-feather="layers" class="feather-icon"></i><span
                            class="hide-menu">Dashboard</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ url('/kasir/transaction') }}"
                        aria-expanded="false"><i data-feather="shopping-cart" class="feather-icon"></i><span
                            class="hide-menu">Sales Transaction</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ url('/kasir/history') }}"
                        aria-expanded="false"><i data-feather="list" class="feather-icon"></i><span
                            class="hide-menu">Transaction History</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ url('/kasir/stock') }}"
                        aria-expanded="false"><i data-feather="search" class="feather-icon"></i><span
                            class="hide-menu">Monitor Stock</span></a></li>
                @endif

                <li class="list-divider"></li>

                <!-- ============================================================== -->
                <!-- Logout -->
                <!-- ============================================================== -->
                <!-- <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="javascript:void(0)"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        aria-expanded="false">
                        <i data-feather="log-out" class="feather-icon"></i><span class="hide-menu">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li> -->
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
