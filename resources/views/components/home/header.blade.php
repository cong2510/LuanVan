<title>{{ html_entity_decode($title) }}</title>
<style>
    a {
        font-size: 14px;
        font-weight: 700
    }

    .superNav {
        font-size: 13px;
    }

    .form-control {
        outline: none !important;
        box-shadow: none !important;
    }

    @media screen and (max-width:540px) {
        .centerOnMobile {
            text-align: center
        }
    }
</style>

<div class="superNav border-bottom py-2 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 centerOnMobile">
                <span
                    class="d-none d-lg-inline-block d-md-inline-block d-sm-inline-block d-xs-none me-3"><strong>btcong2510@gmail.com</strong></span>
                {{-- <span class="me-3"><i class="fa-solid fa-phone me-1 text-dark"></i>
                    <strong>09-355-300-85</strong></span> --}}
            </div>
            <div
                class="col-lg-6 col-md-6 col-sm-12 col-xs-12 d-none d-lg-block d-md-block-d-sm-block d-xs-none text-end">
                <span class="me-3"><i class="fa-solid fa-truck text-muted me-1"></i><a class="text-muted"
                        href="#">Shipping</a></span>
                <span class="me-3"><i class="fa-solid fa-file  text-muted me-2"></i><a class="text-muted"
                        href="#">Policy</a></span>
            </div>
        </div>
    </div>
</div>
<nav class="navbar navbar-expand-lg bg-white sticky-top navbar-light p-3 shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('index') }}"><i class="fa-solid fa-shop me-2"></i> <strong>Thanh
                Ngân</strong></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="mx-auto my-3 d-lg-none d-sm-block d-xs-block">
            <div class="input-group">
                <form class="search d-flex" action="{{ route('search') }}" method="GET">
                    <input type="text" name="search" id="search" class="form-control border-dark"
                        style="color:#7a7a7a" placeholder="Tìm kiếm">
                    <button type="submit" class="btnSearch btn btn-dark text-white"><i
                            class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class=" collapse navbar-collapse" id="navbarNavDropdown">
            <div class="ms-auto d-none d-lg-block">
                <div class="input-group">
                    <form class="search d-flex" action="{{ route('search') }}" method="GET">
                        <input type="text" name="search" id="search" class="form-control border-dark"
                            style="color:#7a7a7a" placeholder="Tìm kiếm">
                        <button type="submit" class="btnSearch btn btn-dark text-white"><i
                                class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>
            </div>
            <ul class="navbar-nav ms-auto ">
                <li class="nav-item">
                    <a class="nav-link mx-2 text-uppercase" href="{{ route('sanpham') }}">Sản phẩm</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link mx-2 text-uppercase" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Thể loại
                    </a>
                    <ul class="dropdown-menu ulTheloai" aria-labelledby="navbarDropdown">
                        @foreach ($theloai as $loai)
                            <li><a class="dropdown-item" style="color: black !important;"
                                    href="{{ route('sanphamtheloai',$loai->id) }}">{{ $loai->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link mx-2 text-uppercase" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Thương hiệu
                    </a>
                    <ul class="dropdown-menu ulTheloai" aria-labelledby="navbarDropdown">
                        @foreach ($brand as $brand)
                            <li><a class="dropdown-item" style="color: black !important;"
                                    href="{{ route('sanphambrand',$brand->id) }}">{{ $brand->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 text-uppercase" href="#">About</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto ">
                <li class="nav-item">
                    <a class="nav-link mx-2 text-uppercase" href="{{ route('cart') }}">
                        <i class="fa-solid fa-cart-shopping me-1"></i>
                        <sup>
                            <span class="badge rounded-pill badge-notification bg-danger">
                                @if (Session::has('cart'))
                                    @php
                                        $soluong = 0;
                                    @endphp
                                    @foreach ((array) session('cart') as $id => $details)
                                        @php
                                            $soluong += $details['soluong'];
                                        @endphp
                                    @endforeach
                                    {{ $soluong }}
                                @else
                                    0
                                @endif
                            </span>
                        </sup></a>
                </li>
                <li class="nav-item dropdown btnTaiKhoan">
                    @if (Auth::user())
                        <a class="nav-link dropdown" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-circle-user fa-xl"></i>&nbsp;{{ auth()->user()->name }}
                        </a>
                    @else
                        <a class="nav-link dropdown" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-circle-user fa-xl"></i>&nbsp;Tài khoản
                        </a>
                    @endif
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        @if (Auth::user())
                            <li><a class="dropdown-item" href="{{ route('inforuser') }}"
                                    style="color: black !important;">Cài đặt tài
                                    khoản</a></li>
                            @if (Auth::user()->hasAnyRole($role))
                                <li><a class="dropdown-item" href="{{ route('admindashboard') }}"
                                        style="color: black !important;">Admin</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('logoutUser') }}"
                                    style="color: black !important;">Đăng xuất</a></li>
                        @else
                            <li><a class="dropdown-item" href="{{ route('login') }}"
                                    style="color: black !important;">Đăng nhập</a></li>
                            <li><a class="dropdown-item" href="{{ route('signup') }}"
                                    style="color: black !important;">Đăng ký</a></li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="logo navbar-brand" href="{{ route('index') }}">Thanh Ngân</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse menu" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="justify-content: space-between">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('index') }}">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sanpham') }}">Sản phẩm</a>
                </li>
            </ul>
            <form class="search d-flex" action="{{ route('search') }}" method="GET">
                <input class="searchBar form-control me-2" type="search" placeholder="Tìm kiếm" aria-label="Search"
                    name="search" id="search">
                <button class="btnSearch btn btn-outline-info" type="submit"><i class="fa-solid fa-magnifying-glass"
                        style="color: #000000;"></i></button>
            </form>
            <div class="btnTaiKhoan dropdown">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        @if (Auth::user())
                            <a class="nav-link dropdown" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-circle-user fa-xl"></i>&nbsp;{{ auth()->user()->name }}
                            </a>
                        @else
                            <a class="nav-link dropdown" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-circle-user fa-xl"></i>&nbsp;Tài khoản
                            </a>
                        @endif
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @if (Auth::user())
                                <li><a class="dropdown-item" href="{{ route('inforuser') }}"
                                        style="color: black !important;">Cài đặt tài
                                        khoản</a></li>
                                @if (Auth::user()->hasAnyRole($role))
                                    <li><a class="dropdown-item" href="{{ route('admindashboard') }}"
                                            style="color: black !important;">Admin</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('logoutUser') }}"
                                        style="color: black !important;">Đăng xuất</a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('login') }}"
                                        style="color: black !important;">Đăng nhập</a></li>
                                <li><a class="dropdown-item" href="{{ route('signup') }}"
                                        style="color: black !important;">Đăng ký</a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="btnGioHang">
                <a href="{{ route('cart') }}"><i class="fa-solid fa-bag-shopping fa-xl"></i><sup><span
                            class="badge rounded-pill badge-notification bg-danger">
                            @if (Session::has('cart'))
                                @php
                                    $soluong = 0;
                                @endphp
                                @foreach ((array) session('cart') as $id => $details)
                                    @php
                                        $soluong += $details['soluong'];
                                    @endphp
                                @endforeach
                                {{ $soluong }}
                            @else
                                0
                            @endif
                        </span></sup>
                    &nbsp;Giỏ hàng</a>
            </div>
        </div>
    </div>
</nav> --}}
