<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @include('cdn')
    <x-home.header :theloai="$theloai" :role="$role" :brand="$brand" title="Trang Chủ" />
</head>

<body>
    <br>
    <div class="container" style="margin-bottom: 50px">
        <div>
            <swiper-container class="mySwiper" pagination="true" pagination-dynamic-bullets="true" centered-slides="true"
                autoplay-delay="5000" autoplay-disable-on-interaction="false" navigation="true" loop="true"
                style="--swiper-navigation-size: 32px;--swiper-navigation-color: black;">
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
                    <a href="/sanpham/theloai/{{ $loai->id }}" style="text-decoration: none;font-family: monospace;font-weight: bold">
                        <button type="button" class="btn btn-outline-dark btn-square-md"
                            data-mdb-ripple-color="dark">
                            {{ $loai->name }}
                        </button>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <br>
    <div class="container" style="margin-bottom: 50px">
        <div class="text-center" style="margin-bottom: 30px">
            <h5>
                <a class="theloaiTitle" href="{{ route('sanphamtheloai', 1) }}">
                    ĐỒ CHƠI THÚ BÔNG
                </a>
            </h5>
        </div>
        <swiper-container class="mySwiper" space-between="30" slides-per-view="4" pagination="true"
            pagination-dynamic-bullets="true" autoplay-delay="5000" navigation="true" loop="true"
            style="--swiper-navigation-size: 32px;--swiper-navigation-color: black;">
            @foreach ($thubong as $thubong)
                <swiper-slide>
                    <div class="card border-0" style="background-color: transparent !important;">
                        @foreach ($image as $hinh)
                            @if ($thubong->id == $hinh->sanpham_id)
                                <a href="{{ route('detailsanpham', $thubong->id) }}"><img class="card-img-top"
                                        src="{{ asset('images/Sanpham/' . $hinh->image) }}" style="width: 98%;" /></a>
                            @break
                        @endif
                    @endforeach
                    <div class="card-body" style="height:120px">
                        <div class="text-center">
                            <a href="{{ route('detailsanpham', $thubong->id) }}"
                                class="sanphamName">{{ $thubong->name }}</a>
                            </a>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <h6 class="text-muted mb-0">Còn: <span
                                    class="fw-bold text-danger">{{ $thubong->soluong }}</span>
                            </h6>
                            <h5 class="text-dark mb-0" style="font-size: 14px">
                                {{ number_format($thubong->gia, 0, ',', '.') }}đ</h5>
                        </div>
                    </div>
                </div>
            </swiper-slide>
        @endforeach
    </swiper-container>
</div>
</body>
<x-home.footer />

</html>
