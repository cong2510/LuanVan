<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @include('cdn')
    <x-home.header :theloai="$theloai" :role="$role" :brand="$brand" title="Trang Chủ" />
    <link rel="stylesheet" href="{{ asset('owl/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('owl/owl.theme.default.css') }}">
    <style>
        .product-item {
            border: 1px solid rgb(219, 219, 219);
        }

        .product-img {
            position: relative;
            overflow: hidden;
        }

        .btns {
            position: absolute;
            left: 0;
            bottom: -100%;
            font-size: 15px;
            font-weight: 300;
            transition: all 0.3s ease-in-out;
        }

        .btns button {
            border: none;
            background-color: rgb(39, 39, 39);
            color: #fff;
            transition: all 0.3s ease-in-out;
        }

        .btns button:hover {
            color: #fcb941;
        }

        .product-img:hover .btns {
            bottom: 0;
        }

        a.product-name {
            transition: all 0.3s ease-in-out;
            font-size: 16px;
        }

        a.product-name:hover {
            color: grey !important;
        }

        .product-price {
            color: red;
        }

        .product-item {
            width: 300px;
        }
    </style>
</head>

<body>
    <br>
    <div class="container" style="margin-bottom: 50px">
        <div>
            <swiper-container class="mySwiper" pagination="true" pagination-dynamic-bullets="true"
                centered-slides="true" autoplay-delay="5000" autoplay-disable-on-interaction="false" navigation="true"
                loop="true" style="--swiper-navigation-size: 32px;--swiper-navigation-color: black;">
                <swiper-slide><img style="width: 100%" src="{{ asset('images/banner1.jpg') }}"
                        alt=""></swiper-slide>
                <swiper-slide><img style="width: 100%" src="{{ asset('images/banner2.jpg') }}"
                        alt=""></swiper-slide>
                <swiper-slide><img style="width: 100%" src="{{ asset('images/banner3.png') }}"
                        alt=""></swiper-slide>
            </swiper-container>
        </div>
    </div>
    <br>
    <div class="container" style="margin-bottom: 50px">
        <div class="text-center" style="margin-bottom: 30px">
            <h5>
                <a class="theloaiTitle">
                    THỂ LOẠI ĐỒ CHƠI
                </a>
            </h5>
        </div>
        <div class="row row-cols-auto justify-content-md-center">
            @foreach ($theloai as $loai)
                <div class="col">
                    <a href="/sanpham/theloai/{{ $loai->id }}"
                        style="text-decoration: none;font-family: monospace;font-weight: bold">
                        <button type="button" class="btn btn-outline-dark btn-square-md" data-mdb-ripple-color="dark">
                            {{ $loai->name }}
                        </button>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <br>
    @if (count($favorites) > 0)
        <div class="container" style="margin-bottom: 50px">
            <div class="text-center" style="margin-bottom: 30px">
                <h5>
                    <a class="theloaiTitle">
                        ĐỒ CHƠI ĐƯỢC YÊU THÍCH
                    </a>
                </h5>
            </div>
            <div class = "row g-4 my-5 mx-auto owl-carousel owl-theme">
                @foreach ($favorites as $favorite)
                    @foreach ($sanphams as $sanpham)
                        @if ($sanpham->id == $favorite->sanpham_id)
                            <div class = "col product-item mx-auto">
                                <div class = "product-img">
                                    @foreach ($image as $hinh)
                                        @if ($sanpham->id == $hinh->sanpham_id)
                                            <a href="{{ route('detailsanpham', $sanpham->id) }}">
                                                <img src = "{{ asset('images/Sanpham/' . $hinh->image) }}"
                                                    alt = "" class = "img-fluid d-block mx-auto">
                                            </a>
                                        @break
                                    @endif
                                @endforeach
                                <div class = "row btns w-100 mx-auto text-center">
                                    <a href="{{ route('detailsanpham', $sanpham->id) }}">
                                        <button type = "button" class = "col-12 py-2">
                                            <i class = "fa fa-binoculars"></i> Chi tiết
                                        </button>
                                    </a>
                                </div>
                            </div>

                            <div class = "product-info p-3">
                                <a href = "{{ route('detailsanpham', $sanpham->id) }}"
                                    class = "d-block text-dark text-decoration-none py-2 product-name">
                                    {{ $sanpham->name }}
                                </a>
                                <span
                                    class = "product-price">{{ number_format($sanpham->gia, 0, ',', '.') }}đ</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>
@endif
<br>
@if (count($dochoitheloai) > 0)
    <div class="container" style="margin-bottom: 50px">
        <div class="text-center" style="margin-bottom: 30px">
            <h5>
                <a class="theloaiTitle" href="{{ route('sanphamtheloai', $loaidochoi) }}">
                    ĐỒ CHƠI
                    @foreach ($theloai as $loai)
                        @if ($loai->id == $loaidochoi)
                            {{ Str::upper($loai->name) }}
                        @endif
                    @endforeach
                </a>
            </h5>
        </div>
        <div class = "row g-4 my-5 mx-auto owl-carousel owl-theme">
            @foreach ($dochoitheloai as $dochoi)
                <div class = "col product-item mx-auto">
                    <div class = "product-img">
                        @foreach ($image as $hinh)
                            @if ($dochoi->id == $hinh->sanpham_id)
                                <a href="{{ route('detailsanpham', $dochoi->id) }}">
                                    <img src = "{{ asset('images/Sanpham/' . $hinh->image) }}" alt = ""
                                        class = "img-fluid d-block mx-auto">
                                </a>
                            @break
                        @endif
                    @endforeach
                    <div class = "row btns w-100 mx-auto text-center">
                        <a href="{{ route('detailsanpham', $dochoi->id) }}">
                            <button type = "button" class = "col-12 py-2">
                                <i class = "fa fa-binoculars"></i> Chi tiết
                            </button>
                        </a>
                    </div>
                </div>

                <div class = "product-info p-3">
                    <a href = "{{ route('detailsanpham', $dochoi->id) }}"
                        class = "d-block text-dark text-decoration-none py-2 product-name">
                        {{ $dochoi->name }}
                    </a>
                    <span class = "product-price">{{ number_format($dochoi->gia, 0, ',', '.') }}đ</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif
<br>
</body>
<script src="{{ asset('owl/owl.carousel.js') }}"></script>
<script>
    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 0,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 2,
            },
            1100: {
                items: 3,
            },
            1400: {
                items: 4,
                loop: false,
            }
        }
    });
</script>
<x-home.footer />

</html>
