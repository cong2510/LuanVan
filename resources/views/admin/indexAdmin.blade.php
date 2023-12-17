<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    @include('cdn')
    <link href="{{ asset('template/css/sb-admin-2.css') }}" rel="stylesheet">
    <title>@yield('page_title')</title>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                href="{{ route('admindashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa-solid fa-briefcase fa-2xl" style="color: #ffffff;"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Thanh<sup>Ngân</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('admindashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Quản lý cửa hàng
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            @if (Auth::user()->hasAnyPermission(['allProduct', 'allCategory', 'allBrand']))
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProducts"
                        aria-expanded="true" aria-controls="collapseProducts">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Danh mục sản phẩm</span>
                    </a>
                    <div id="collapseProducts" class="collapse" aria-labelledby="headingPages"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            @if (Auth::user()->can('allProduct'))
                                <a class="collapse-item" href="{{ route('all.product') }}">Danh sách sản phẩm</a>
                            @endif
                            @if (Auth::user()->can('allCategory'))
                                <a class="collapse-item" href="{{ route('all.category') }}">Danh sách thể loại</a>
                            @endif
                            @if (Auth::user()->can('allBrand'))
                                <a class="collapse-item" href="{{ route('all.brand') }}">Danh sách thương hiệu</a>
                            @endif
                        </div>
                    </div>
                </li>
            @endif

            <!-- Nav Item - Pages Collapse Menu -->
            @if (Auth::user()->hasAnyPermission(['allPermission', 'allRole', 'allRolePermission', 'allUser']))
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRoles"
                        aria-expanded="true" aria-controls="collapseRoles">
                        <i class="fa-solid fa-users"></i></i>
                        <span>Role & Permission</span>
                    </a>
                    <div id="collapseRoles" class="collapse" aria-labelledby="headingPages"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            @if (Auth::user()->can('allPermission'))
                                <a class="collapse-item" href="{{ route('all.permission') }}">Quản lý quyền</a>
                            @endif
                            @if (Auth::user()->can('allRole'))
                                <a class="collapse-item" href="{{ route('all.roles') }}">Quản lý vai trò</a>
                            @endif
                            @if (Auth::user()->can('allRolePermission'))
                                <a class="collapse-item" href="{{ route('all.roles.permission') }}">Danh sách vai trò có
                                    quyền</a>
                            @endif
                            @if (Auth::user()->can('allUser'))
                                <a class="collapse-item" href="{{ route('all.roles.user') }}">Quản lý tài khoản</a>
                            @endif
                        </div>
                    </div>
                </li>
            @endif

            @if (Auth::user()->hasAnyPermission(['allOrder']))
                <hr class="sidebar-divider">
                <div class="sidebar-heading">
                    Quản lý đơn hàng
                </div>
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('all.order') }}">
                        <i class="fa-solid fa-receipt"></i>
                        <span>Quản lý đơn hàng</span>
                    </a>
                </li>
            @endif

            @if (Auth::user()->hasAnyPermission(['allPromo']))
                <hr class="sidebar-divider">
                <div class="sidebar-heading">
                    Quản lý mã khuyễn mãi
                </div>
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('all.promo') }}">
                        <i class="fa-solid fa-ticket-simple"></i>
                        <span>Quản lý mã khuyễn mãi</span>
                    </a>
                </li>
            @endif

            {{-- @if (Auth::user()->hasAnyPermission(['allPromo'])) --}}
                <hr class="sidebar-divider">
                <div class="sidebar-heading">
                    Quản lý đánh giá
                </div>
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('all.rating') }}">
                        <i class="fa-solid fa-star"></i>
                        <span>Quản lý đánh giá sản phẩm</span>
                    </a>
                </li>
            {{-- @endif --}}

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


            {{-- <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="" alt="...">
                <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components,
                    and more!</p>
                <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to
                    Pro!</a>
            </div> --}}

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle text-dark" href="#" id="userDropdown"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if (Auth::user())
                                    {{-- <img class="img-profile rounded-circle" src="">&nbsp;&nbsp; --}}
                                    <i class="fa-solid fa-circle-user fa-xl"></i>&nbsp;{{ auth()->user()->name }}
                                @endif
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('index') }}">
                                    <i class="fas fa-home fa-sm fa-fw mr-2 text-gray-700"></i>
                                    Về trang chủ
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logoutUser') }}">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-700"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->
            </div>

            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Bùi Thành Công - DH51901734</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

</body>
<script>
    $("#sidebarToggle").click(function() {
        if ($("body").hasClass("sidebar-toggled")) {
            $("body").removeClass("sidebar-toggled");
            $("ul.sidebar").removeClass("toggled");
        } else {
            $("body").addClass("sidebar-toggled");
            $("ul.sidebar").addClass("toggled");
        }
    });

    $("#sidebarToggleTop").click(function() {
        if ($("body").hasClass("sidebar-toggled")) {
            $("body").removeClass("sidebar-toggled");
            $("ul.sidebar").removeClass("toggled");
        } else {
            $("body").addClass("sidebar-toggled");
            $("ul.sidebar").addClass("toggled");
        }
    });
</script>

</html>
