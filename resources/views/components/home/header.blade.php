<title>{{ html_entity_decode($title) }}</title>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="logo navbar-brand" href="{{ route('index') }}">Thanh Ngân</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse menu" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach ($theloai as $theloai)
                            <li><a class="dropdown-item" href="#">{{ $theloai['name'] }}</a></li>
                        @endforeach
                    </ul>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li> --}}
            </ul>
            <form class="search d-flex">
                <input class="searchBar form-control me-2" type="search" placeholder="Tìm kiếm" aria-label="Search">
                <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"
                        style="color: #000000;"></i></button>
            </form>
            <div class="btnTaiKhoan dropdown">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        @if (Auth::user())
                            <a class="nav-link dropdown" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-circle-user fa-xl"
                                    style="color: #000000;"></i>&nbsp;{{ auth()->user()->name }}
                            </a>
                        @else
                            <a class="nav-link dropdown" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-circle-user fa-xl" style="color: #000000;"></i>&nbsp;Tài khoản
                            </a>
                        @endif
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @if (Auth::user())
                                <li><a class="dropdown-item" href="#">Cài đặt tài khoản</a></li>
                                @if (Auth::user()->hasAnyRole($role))
                                    <li><a class="dropdown-item" href="{{ route('admindashboard') }}">Admin</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('logoutUser') }}">Đăng xuất</a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('login') }}">Đăng nhập</a></li>
                                <li><a class="dropdown-item" href="{{ route('signup') }}">Đăng ký</a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="btnGioHang">
                <a href=""><i class="fa-solid fa-bag-shopping fa-xl" style="color: #000000;"></i>&nbsp;Giỏ
                    hàng</a>
            </div>
        </div>
    </div>
</nav>
