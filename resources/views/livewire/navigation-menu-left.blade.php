<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">IMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user9-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }} <span class="badge bg-purple" >{{ Auth::user()->role  }}</span>  </a>

            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon ti ti-dashboard"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon ti ti-box"></i>
                        <p>
                            Inventory
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('products') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('categories') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('suppliers') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Suppliers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('purchases') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchases</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon ti ti-shopping-cart"></i>
                        <p>
                            Sales
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('sales') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sales</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('returns') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Returns</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customers') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Customers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pos') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>POS</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('expenses') }}" class="nav-link">
                        <i class="nav-icon ti ti-credit-card"></i>
                        <p>Expenses</p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon ti ti-chart-line"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('reports.sales') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sales Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.profit') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Profit Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.stock') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stock Report</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon ti ti-users"></i>
                        <p>
                            Users
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('users') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All users</p>
                            </a>
                        </li>

                    </ul>
                </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" id="logout">
                    @csrf
                </form>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout').submit();" class="nav-link">
                    <i class="nav-icon ti ti-logout text-danger "></i>
                    <p class="text-danger">
                        Logout
                    </p>
                </a>
            </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
