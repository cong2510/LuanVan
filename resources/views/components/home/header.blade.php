<title>{{ html_entity_decode($title) }}</title>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="logo navbar-brand" href="{{ route('index') }}">Thanh Ngân</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Thể loại
                    </a>
                    <ul class="dropdown-menu ulTheloai" aria-labelledby="navbarDropdown">
                        @foreach ($theloai as $loai)
                            <li><a class="dropdown-item" style="color: black !important;"
                                    href="{{ route('sanphamtheloai', $loai->id) }}">{{ $loai->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li> --}}
            </ul>
            <form class="search d-flex" action="{{ route('search') }}" method="GET">
                <input class="searchBar form-control me-2" type="search" placeholder="Tìm kiếm" aria-label="Search" name="search" id="search">
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
                                <li><a class="dropdown-item" href="{{ route('inforuser') }}" style="color: black !important;">Cài đặt tài
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
                            <!-- If the session has cart in it get total quantity -->
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
</nav>

