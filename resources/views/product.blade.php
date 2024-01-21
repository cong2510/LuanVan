<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('cdn')
    <x-home.header :theloai="$theloai" :role="$role" :brand="$brand" title="Danh sách sản phẩm" />
    <style>
        img:hover {
            transform: scale(1.008);
            transition: all .2s linear;
        }

        .icon-control {
            margin-top: 5px;
            float: right;
            font-size: 80%;
        }

        .btn-light {
            background-color: #fff;
            border-color: #e4e4e4;
        }

        .list-menu {
            list-style: none;
            margin: 0;
            padding-left: 0;
        }

        .list-menu a {
            color: #343a40;
            text-decoration: none;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .list-menu a:hover {
            text-decoration: none;
            color: gray !important;
        }

        .list-menu li {
            margin-bottom: 6px;
        }

        .img-wrap {
            overflow: hidden;
            position: relative;
        }
    </style>
</head>
<br>

<body>
    <div class="container">
        <div class="row">
            <!-- sidebar -->
            <div class="col-lg-3">
                <article class="filter-group">
                    <header class="card-header">
                        <a href="#" data-toggle="collapse" data-target="#collapse_1" aria-expanded="true"
                            class="sanphamName">
                            <i class="icon-control fa fa-chevron-down"></i>
                            <h6 class="title">Loại đồ chơi</h6>
                        </a>
                    </header>
                    <div class="filter-content collapse show" id="collapse_1" style="">
                        <div class="card-body">
                            <ul class="list-menu">
                                <li>
                                    <a href="{{ route('sanpham') }}">
                                        Tất cả
                                    </a>
                                </li>
                                @foreach ($theloai as $loai)
                                    <li>
                                        <a href="{{ route('sanphamtheloai', $loai->id) }}">
                                            {{ $loai->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div> <!-- card-body.// -->
                    </div>
                </article> <!-- filter-group  .// -->
                <article class="filter-group">
                    <header class="card-header">
                        <a href="#" data-toggle="collapse" data-target="#collapse_2" aria-expanded="true"
                            class="sanphamName">
                            <i class="icon-control fa fa-chevron-down"></i>
                            <h6 class="title">Thương hiệu</h6>
                        </a>
                    </header>
                    <div class="filter-content collapse show" id="collapse_2" style="">
                        <div class="card-body">
                            <ul class="list-menu">
                                <li>
                                    <a href="{{ route('sanpham') }}">
                                        Tất cả
                                    </a>
                                </li>
                                @foreach ($brand as $brand)
                                    <li>
                                        <a href="{{ route('sanphambrand',$brand->id) }}">
                                            {{ $brand->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div> <!-- card-body.// -->
                    </div>
                </article> <!-- filter-group  .// -->
            </div>
            <!-- sidebar -->
            <!-- content -->
            <div class="col-lg-9">
                <header class="d-sm-flex align-items-center border-bottom mb-4 pb-3">
                    <strong class="d-block py-2">Có {{ $allProduct }} sản phẩm</strong>
                    <form class="ms-auto" action="{{ route('sanpham') }}" method="GET" id="form">
                        <div class="">
                            <select class="form-select d-inline-block w-auto border pt-1" name="sortBy" id="sortBy">
                                <option value="">Mặc định</option>
                                <option value="lowest" {{ Request::get('sortBy') === 'lowest' ? 'selected' : '' }}>
                                    Giá thấp nhất
                                </option>
                                <option value="highest" {{ Request::get('sortBy') === 'highest' ? 'selected' : '' }}>
                                    Giá cao nhất
                                </option>
                                <option value="AZ" {{ Request::get('sortBy') === 'AZ' ? 'selected' : '' }}>
                                    Theo tên A => Z
                                </option>
                                <option value="ZA" {{ Request::get('sortBy') === 'ZA' ? 'selected' : '' }}>
                                    Theo tên Z => A
                                </option>
                            </select>
                        </div>
                    </form>
                </header>
                <div class="container">
                    <div class="row">
                        @foreach ($sanphamsort as $sanpham)
                            <!-- Single Product -->
                            <div class="col-md-4">
                                <div class="card text-center" style="margin-bottom: 20px">
                                    @foreach ($image as $hinh)
                                        @if ($sanpham->id == $hinh->sanpham_id)
                                            <a href="{{ route('detailsanpham', $sanpham->id) }}"><img
                                                    class="card-img-top"
                                                    src="{{ asset('images/Sanpham/' . $hinh->image) }}"
                                                    style="width: 98%;" /></a>
                                        @break
                                    @endif
                                @endforeach
                                <div class="card-body">
                                    <div class="d-flex justify-content-left">
                                        @foreach ($sanpham->theloai as $loai)
                                            <p class="small"><a href="{{ route('sanphamtheloai', $loai->id) }}"
                                                    class="text-muted">{{ $loai->name }}</a></p>
                                            &nbsp;&nbsp;
                                        @endforeach
                                    </div>

                                    <div class="d-flex mb-3">
                                        <h5 class="mb-0" style="font-size: 14px"><a
                                                href="{{ route('detailsanpham', $sanpham->id) }}"
                                                class="sanphamName">{{ $sanpham->name }}</a></h5>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <h6 class="text-muted mb-0">Còn: <span
                                                class="fw-bold text-danger">{{ $sanpham->soluong }}</span>
                                        </h6>
                                        <h5 class="text-dark mb-0" style="font-size: 14px">
                                            {{ number_format($sanpham->gia, 0, ',', '.') }}đ</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- Single Product -->
                </div>
                {{ $sanphamsort->links() }}
            </div>
            <!-- Pagination -->
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    $("select").change(function() {
        $(form).submit();
    });
</script>
<x-home.footer />

</html>
