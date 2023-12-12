<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('cdn')
    <x-home.header :theloai="$theloai" :role="$role" title="{{ $sanpham->name }}" :brand="$brand" />
    <style>
        .icon-hover:hover {
            border-color: #3b71ca !important;
            background-color: white !important;
            color: #3b71ca !important;
        }

        .icon-hover:hover i {
            color: #3b71ca !important;
        }
    </style>
</head>

<body>
    <br>
    <section class="py-5">
        <div class="container">
            <div class="row gx-5">
                <aside class="col-lg-6">
                    <div style="--swiper-navigation-color: black; --swiper-pagination-color: #fff; --swiper-navigation-size: 32px"
                        class="swiper mySwiper2">
                        <div class="swiper-wrapper">
                            @foreach ($image as $hinh)
                                @if ($hinh->sanpham_id == $sanpham->id)
                                    <div class="swiper-slide" style="text-align: center;">
                                        <img style="max-width: 100%; max-height: 50vh; margin: auto;"
                                            class="rounded-4 fit" src="{{ asset('images/Sanpham/' . $hinh->image) }}" />
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                    <hr>
                    <div thumbsSlider="" class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @foreach ($image as $hinh)
                                @if ($hinh->sanpham_id == $sanpham->id)
                                    <div class="swiper-slide">
                                        <img style="max-width: 100%; max-height: 100vh; margin: auto;"
                                            class="rounded-4 fit" src="{{ asset('images/Sanpham/' . $hinh->image) }}" />
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </aside>
                <main class="col-lg-6">
                    <div class="ps-lg-3">
                        <h4 class="title text-dark">
                            {{ $sanpham->name }} <br />
                            @if ($sanpham->soluong <= 0)
                                <h6><i class="fa-solid fa-box"></i> Hết hàng</h6>
                            @else
                                <h6><i class="fa-solid fa-box"></i> Còn hàng: {{ $sanpham->soluong }}</h6>
                            @endif
                        </h4>

                        <br>
                        <div class="mb-3">
                            <span class="h5">{{ number_format($sanpham->gia, 0, ',', '.') }} đ</span>
                        </div>

                        <p>
                            {{ $sanpham->mota }}
                        </p>

                        <div class="row">
                            <dt class="col-3">Loại:</dt>
                            <dd class="col-9">
                                @foreach ($sanpham->theloai as $loai)
                                    <span class="badge bg-primary"><a href="{{ route('sanphamtheloai', $loai->id) }}"
                                            style="text-decoration: none;color: white">{{ $loai->name }}</a></span>
                                @endforeach
                            </dd>

                            {{-- <dt class="col-3">Color</dt>
                            <dd class="col-9">Brown</dd>

                            <dt class="col-3">Material</dt>
                            <dd class="col-9">Cotton, Jeans</dd> --}}

                            <dt class="col-3">Thương hiệu</dt>
                            <dd class="col-9">
                                @foreach ($brand as $brand)
                                    @if ($brand->id == $sanpham->brand_id)
                                        <a href="{{ route('sanphambrand', $brand->id) }}">{{ $brand->name }}</a>
                                    @endif
                                @endforeach
                            </dd>
                            <dd class="col-12">
                                @if (Auth::user())
                                    @php
                                        $flag = 0;
                                    @endphp
                                    @foreach ($favorites as $favorite)
                                        @foreach ($favorite->sanpham as $sanphamfav)
                                            @if ($sanphamfav->id == $sanpham->id && $favorite->user_id == auth()->user()->id)
                                                @php
                                                    $flag = 1;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endforeach

                                    @if ($flag == 1)
                                        <form action="{{ route('deletefavorite') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="sanphamid" value="{{ $sanpham->id }}">
                                            @foreach ($favorites as $favorite)
                                                @foreach ($favorite->sanpham as $sanphamfav)
                                                    @if ($sanphamfav->id == $sanpham->id)
                                                        <input type="hidden" name="favoriteid"
                                                            value="{{ $favorite->id }}">
                                                    @endif
                                                @endforeach
                                            @endforeach
                                            <button type="submit"
                                                class="btn btn-light border border-dark py-2 icon-hover px-3">
                                                <i class="fa-solid fa-heart fa-lg"
                                                    style="color: red;"></i>&nbsp;&nbsp;{{ $allfavorite }}
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('addfavorite') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="sanphamid" value="{{ $sanpham->id }}">
                                            <button type="submit"
                                                class="btn btn-light border border-dark py-2 icon-hover px-3">
                                                <i class="fa-regular fa-heart fa-lg"
                                                    style="color: red;"></i>&nbsp;&nbsp;{{ $allfavorite }}
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <button type="submit"
                                        class="btn btn-light border border-dark py-2 icon-hover px-3">
                                        <i class="fa-solid fa-heart fa-lg"
                                            style="color: red;"></i>&nbsp;&nbsp;{{ $allfavorite }}
                                    </button>
                                @endif
                            </dd>
                        </div>

                        <hr />
                        <form action="{{ route('addtocart') }}" method="POST">
                            @csrf
                            <div class="row mb-4">
                                <!-- col.// -->
                                <div class="col-md-4 col-6 mb-3">
                                    <label class="mb-2 d-block">Số lượng</label>
                                    <div class="input-group mb-3" style="width: 60px;">
                                        <input type="number" class="form-control text-center border border-secondary"
                                            placeholder="" aria-label="Example text with button addon"
                                            aria-describedby="button-addon1" min="1"
                                            max="{{ $sanpham->soluong }}" name="soluong" id="soluong"
                                            value="1" />
                                    </div>
                                </div>
                            </div>
                            <input type="text" name="id" id="id" value="{{ $sanpham->id }}" hidden>
                            <button type="submit" class="btn btn-primary">
                                Thêm vào giỏ
                            </button>&nbsp;
                        </form>
                        <br>
                    </div>
                </main>
            </div>
        </div>
    </section>
    <!-- content -->

    <section class="bg-light border-top py-4">
        <div class="container">
            <div class="row gx-4">
                <div class="col-lg-8 mb-4">
                    <div class="border rounded-2 px-3 py-2 bg-white">
                        <!-- Pills navs -->
                        <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                            <li class="nav-item d-flex" role="presentation">
                                <a class="nav-link d-flex align-items-center justify-content-center w-100 active"
                                    id="ex1-tab-1" data-mdb-toggle="pill" href="#ex1-pills-1" role="tab"
                                    aria-controls="ex1-pills-1" aria-selected="true">Specification</a>
                            </li>
                            <li class="nav-item d-flex" role="presentation">
                                <a class="nav-link d-flex align-items-center justify-content-center w-100"
                                    id="ex1-tab-2" data-mdb-toggle="pill" href="#ex1-pills-2" role="tab"
                                    aria-controls="ex1-pills-2" aria-selected="false">Warranty info</a>
                            </li>
                            <li class="nav-item d-flex" role="presentation">
                                <a class="nav-link d-flex align-items-center justify-content-center w-100"
                                    id="ex1-tab-3" data-mdb-toggle="pill" href="#ex1-pills-3" role="tab"
                                    aria-controls="ex1-pills-3" aria-selected="false">Shipping info</a>
                            </li>
                            <li class="nav-item d-flex" role="presentation">
                                <a class="nav-link d-flex align-items-center justify-content-center w-100"
                                    id="ex1-tab-4" data-mdb-toggle="pill" href="#ex1-pills-4" role="tab"
                                    aria-controls="ex1-pills-4" aria-selected="false">Seller profile</a>
                            </li>
                        </ul>
                        <!-- Pills navs -->

                        <!-- Pills content -->
                        <div class="tab-content" id="ex1-content">
                            <div class="tab-pane fade show active" id="ex1-pills-1" role="tabpanel"
                                aria-labelledby="ex1-tab-1">
                                <p>
                                    With supporting text below as a natural lead-in to additional content. Lorem ipsum
                                    dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                                    labore et dolore magna aliqua. Ut
                                    enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
                                    ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                    cillum dolore eu fugiat nulla
                                    pariatur.
                                </p>
                                <div class="row mb-2">
                                    <div class="col-12 col-md-6">
                                        <ul class="list-unstyled mb-0">
                                            <li><i class="fas fa-check text-success me-2"></i>Some great feature name
                                                here</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Lorem ipsum dolor sit
                                                amet, consectetur</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Duis aute irure dolor in
                                                reprehenderit</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Optical heart sensor</li>
                                        </ul>
                                    </div>
                                    <div class="col-12 col-md-6 mb-0">
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-check text-success me-2"></i>Easy fast and ver good
                                            </li>
                                            <li><i class="fas fa-check text-success me-2"></i>Some great feature name
                                                here</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Modern style and design
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <table class="table border mt-3 mb-2">
                                    <tr>
                                        <th class="py-2">Display:</th>
                                        <td class="py-2">13.3-inch LED-backlit display with IPS</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2">Processor capacity:</th>
                                        <td class="py-2">2.3GHz dual-core Intel Core i5</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2">Camera quality:</th>
                                        <td class="py-2">720p FaceTime HD camera</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2">Memory</th>
                                        <td class="py-2">8 GB RAM or 16 GB RAM</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2">Graphics</th>
                                        <td class="py-2">Intel Iris Plus Graphics 640</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane fade mb-2" id="ex1-pills-2" role="tabpanel"
                                aria-labelledby="ex1-tab-2">
                                Tab content or sample information now <br />
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut
                                aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                proident, sunt in culpa qui
                                officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur
                                adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                                enim ad minim veniam, quis
                                nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            </div>
                            <div class="tab-pane fade mb-2" id="ex1-pills-3" role="tabpanel"
                                aria-labelledby="ex1-tab-3">
                                Another tab content or sample information now <br />
                                Dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                                et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                laboris nisi ut aliquip ex ea
                                commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                                dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                                culpa qui officia deserunt
                                mollit anim id est laborum.
                            </div>
                            <div class="tab-pane fade mb-2" id="ex1-pills-4" role="tabpanel"
                                aria-labelledby="ex1-tab-4">
                                Some other tab content or sample information now <br />
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut
                                aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                proident, sunt in culpa qui
                                officia deserunt mollit anim id est laborum.
                            </div>
                        </div>
                        <!-- Pills content -->
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="px-0 border rounded-2 shadow-0">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Similar items</h5>
                                <div class="d-flex mb-3">
                                    <a href="#" class="me-3">
                                        <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/8.webp"
                                            style="min-width: 96px; height: 96px;" class="img-md img-thumbnail" />
                                    </a>
                                    <div class="info">
                                        <a href="#" class="nav-link mb-1">
                                            Rucksack Backpack Large <br />
                                            Line Mounts
                                        </a>
                                        <strong class="text-dark"> $38.90</strong>
                                    </div>
                                </div>

                                <div class="d-flex mb-3">
                                    <a href="#" class="me-3">
                                        <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/9.webp"
                                            style="min-width: 96px; height: 96px;" class="img-md img-thumbnail" />
                                    </a>
                                    <div class="info">
                                        <a href="#" class="nav-link mb-1">
                                            Summer New Men's Denim <br />
                                            Jeans Shorts
                                        </a>
                                        <strong class="text-dark"> $29.50</strong>
                                    </div>
                                </div>

                                <div class="d-flex mb-3">
                                    <a href="#" class="me-3">
                                        <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/10.webp"
                                            style="min-width: 96px; height: 96px;" class="img-md img-thumbnail" />
                                    </a>
                                    <div class="info">
                                        <a href="#" class="nav-link mb-1"> T-shirts with multiple colors, for
                                            men and lady </a>
                                        <strong class="text-dark"> $120.00</strong>
                                    </div>
                                </div>

                                <div class="d-flex">
                                    <a href="#" class="me-3">
                                        <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/11.webp"
                                            style="min-width: 96px; height: 96px;" class="img-md img-thumbnail" />
                                    </a>
                                    <div class="info">
                                        <a href="#" class="nav-link mb-1"> Blazer Suit Dress Jacket for Men,
                                            Blue color </a>
                                        <strong class="text-dark"> $339.90</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper(".mySwiper", {
        loop: true,
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".mySwiper2", {
        loop: true,
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiper,
        },
    });
</script>
<x-home.footer />

</html>
