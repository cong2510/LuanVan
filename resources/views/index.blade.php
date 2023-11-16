<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @include('cdn')

    <style>
        .card img:hover {
            transform: scale(1.008);
            transition: all .2s linear;
        }
    </style>
    <x-home.header :theloai="$theloai" :role="$role" title="Trang Chủ" />
</head>

<body>
    <br>
    <div class="container-fluid">
        <x-home.carousel />
    </div>
    <section style="background-color: #eee;">
        <div class="text-center container py-5">
            <h4 class="mt-4 mb-5"><strong>Bestsellers</strong></h4>
            <div class="row">
                @foreach ($sanphams as $sanpham)
                    <div class="col-lg-4 col-md-12 mb-4">
                        <div class="card">
                            <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light"
                                data-mdb-ripple-color="light">
                                @foreach ($sanpham_image as $hinh)
                                    @if ($sanpham->id == $hinh->sanpham_id)
                                        <img src="{{ asset('images/Sanpham/' . $hinh->image) }}" class="w-100" />
                                    @break
                                @endif
                            @endforeach
                            <a href="#!">
                                <div class="mask">
                                    <div class="d-flex justify-content-start align-items-end h-100">
                                        <h5><span class="badge bg-primary ms-2">New</span></h5>
                                    </div>
                                </div>
                                <div class="hover-overlay">
                                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                </div>
                            </a>
                        </div>
                        <div class="card-body">
                            <a href="" class="text-reset">
                                <h5 class="card-title mb-3">{{ $sanpham['name'] }}</h5>
                            </a>
                            <a href="" class="text-reset">
                                <p>
                                    @foreach ($sanpham->theloai as $theloai)
                                        {{ $theloai->name }}
                                    @endforeach
                                </p>
                            </a>
                            <h6 class="mb-3">{{ $sanpham['gia'] }} VND</h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

</body>
<x-home.footer />

</html>
