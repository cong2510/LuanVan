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

        ul,
        ul li {
            list-style: none;
            margin: 0px;
        }

        .glyphicon {
            margin-right: 5px;
        }

        .rating .glyphicon {
            font-size: 22px;
        }

        .rating-num {
            margin-top: 0px;
            font-size: 54px;
        }

        .progress {
            margin-bottom: 5px;
        }

        .progress-bar {
            text-align: left;
        }

        .rating-desc .col-md-3 {
            padding-right: 0px;
        }

        .sr-only {
            margin-left: 5px;
            overflow: visible;
            clip: auto;
        }
    </style>
</head>

<body>
    <br>
    <section class="py-5" style="">
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
                            {!! nl2br($sanpham->mota) !!}
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
                <div class="col-lg-8 card">
                    <div id="reviews" class="review-section">
                        <div class="row">
                            <div class="col-xs-12 col-md-12 text-center">
                                <h1 class="rating-num">
                                    {{ number_format($averageRating, 1) }}</h1>
                                <div class="rating-reviews">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $averageRating)
                                            <span class="fa fa-star" style="color: #fbff00;"></span>
                                        @elseif ($i - 0.5 == $averageRating)
                                            <span class="fa fa-star-half" style="color: #fbff00;"></span>
                                        @endif
                                    @endfor
                                </div>
                                <div>
                                    <span class="glyphicon glyphicon-user"></span>{{ $allreviews }} lượt đánh giá
                                </div>
                            </div>
                            {{-- <div class="col-xs-12 col-md-6">
                            </div> --}}
                        </div>
                    </div>

                    <div class="review-list">
                        <ul>
                            @foreach ($reviews as $review)
                                @foreach ($users as $user)
                                    @if ($review->user_id == $user->id)
                                        <li>
                                            <div class="d-flex">
                                                <div class="left">
                                                    <span>
                                                        <img src="{{ asset('images/user.png') }}"
                                                            class="profile-pict-img img-fluid" alt="" />
                                                    </span>
                                                </div>
                                                <div class="right">
                                                    <h4>
                                                        {{ $user->name }}
                                                        <span class="gig-rating text-body-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 1792 1792" width="15"
                                                                height="15">
                                                                <path fill="currentColor"
                                                                    d="M1728 647q0 22-26 48l-363 354 86 500q1 7 1 20 0 21-10.5 35.5t-30.5 14.5q-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z">
                                                                </path>
                                                            </svg>
                                                            {{ $review->rating }}
                                                        </span>
                                                    </h4>
                                                    <div class="review-description">
                                                        <p>{{ $review->content }}</p>
                                                        <br>
                                                    </div>
                                                    @if (Auth::user())
                                                        @if (auth()->user()->id == $review->user_id)
                                                            <div>
                                                                {{-- <a style="font-size: 13px;color:grey;text-decoration: underline">
                                                                    Chỉnh sửa
                                                                </a> --}}
                                                                &nbsp;
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#deleteModal"
                                                                    style="font-size: 13px;color:grey;text-decoration: underline">
                                                                    Xóa
                                                                </a>
                                                                <br>
                                                                <hr>
                                                                <form action="{{ route('editrateproduct') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="ratingid"
                                                                        value="{{ $review->id }}">
                                                                    <input type="hidden" name="userid"
                                                                        value="{{ $review->user_id }}">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            @error('content')
                                                                                <div class="invalid-feedback d-block"
                                                                                    role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </div>
                                                                            @enderror
                                                                            <textarea class="form-control no-resize" rows="4" placeholder="Chỉnh sửa đánh giá..." maxlength="255"
                                                                                name="content"></textarea>
                                                                        </div>
                                                                        @error('rating')
                                                                            <div class="invalid-feedback d-block"
                                                                                role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </div>
                                                                        @enderror
                                                                        <div class="form-group-row ">
                                                                            <div class="rating"
                                                                                style="font-size: 25px !important">
                                                                                <input
                                                                                    id="rate5star{{ $review->id }}"
                                                                                    name="rating" type="radio"
                                                                                    value="5"
                                                                                    class="radio-btn starhide" />
                                                                                <label
                                                                                    for="rate5star{{ $review->id }}">☆</label>
                                                                                <input
                                                                                    id="rate4star{{ $review->id }}"
                                                                                    name="rating" type="radio"
                                                                                    value="4"
                                                                                    class="radio-btn starhide" />
                                                                                <label
                                                                                    for="rate4star{{ $review->id }}">☆</label>
                                                                                <input
                                                                                    id="rate3star{{ $review->id }}"
                                                                                    name="rating" type="radio"
                                                                                    value="3"
                                                                                    class="radio-btn starhide" />
                                                                                <label
                                                                                    for="rate3star{{ $review->id }}">☆</label>
                                                                                <input
                                                                                    id="rate2star{{ $review->id }}"
                                                                                    name="rating" type="radio"
                                                                                    value="2"
                                                                                    class="radio-btn starhide" />
                                                                                <label
                                                                                    for="rate2star{{ $review->id }}">☆</label>
                                                                                <input
                                                                                    id="rate1star{{ $review->id }}"
                                                                                    name="rating" type="radio"
                                                                                    value="1"
                                                                                    class="radio-btn starhide" />
                                                                                <label
                                                                                    for="rate1star{{ $review->id }}">☆</label>
                                                                                <div class="clear"></div>
                                                                            </div>
                                                                        </div>
                                                                        <br><br>
                                                                        <div class="col-12">
                                                                            <button class="btn btn-primary"
                                                                                type="submit">Chỉnh sửa</button>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <hr>
                                                                </form>
                                                                <div class="modal fade" id="deleteModal"
                                                                    tabindex="-1" aria-labelledby="deleteModalLabel"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="deleteModalLabel">Xác nhận xóa
                                                                                </h5>
                                                                                <button type="button"
                                                                                    class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Xóa đánh giá này
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Hủy</button>
                                                                                <form
                                                                                    action="{{ route('deleterateproduct') }}"
                                                                                    method="post">
                                                                                    @csrf
                                                                                    <input type="hidden"
                                                                                        name="deleteratingid"
                                                                                        value="{{ $review->id }}">
                                                                                    <button type="submit"
                                                                                        class="btn btn-danger"
                                                                                        id="confirmDelete">
                                                                                        Xóa
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    <span class="publish py-3 d-inline-block w-100">
                                                        Đăng {{ $review->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            @endforeach
                        </ul>
                        {{ $reviews->links() }}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="px-0 border rounded-2 shadow-0">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Sản phẩm tương tự</h5>
                                <hr>
                                @foreach ($similars as $similar)
                                    <div class="d-flex mb-3">
                                        <a href="{{ route('detailsanpham', $similar->id) }}" class="me-3">
                                            @foreach ($image as $hinh)
                                                @if ($hinh->sanpham_id == $similar->id)
                                                    <img style="min-width: 96px; height: 96px;"
                                                        class="img-md img-thumbnail"
                                                        src="{{ asset('images/Sanpham/' . $hinh->image) }}" />
                                                @break
                                            @endif
                                        @endforeach
                                    </a>
                                    <div class="info">
                                        <a href="{{ route('detailsanpham', $similar->id) }}" class="sanphamName"
                                            style="font-size: 16px">{{ $similar->name }}</a><br>
                                        <strong
                                            class="text-danger">{{ number_format($similar->gia, 0, ',', '.') }}
                                            đ</strong>
                                    </div>
                                </div>
                            @endforeach
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


    document.getElementById('confirmDelete').addEventListener('click', function() {
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.hide();
    });
</script>
<x-home.footer />

</html>
