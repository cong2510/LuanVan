<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @include('cdn')
    <x-home.header :theloai="$theloai" :role="$role" title="Trang Chủ" />
</head>

<body>
    <br>
    <div class="container-fluid">
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
        <div>

        </div>
    </div>
    <div class="container mt-4">
        <div class="row">
            <!-- Product 1 -->
            <div class="col-md-3">
                <div class="card mb-4">
                    <img src="https://placehold.it/300" class="card-img-top" alt="Product 1">
                    <div class="card-body">
                        <h5 class="card-title">Product 1</h5>
                        <p class="card-text">Description of Product 1. Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit.</p>
                        <a href="#" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="col-md-3">
                <div class="card mb-4">
                    <img src="https://placehold.it/300" class="card-img-top" alt="Product 2">
                    <div class="card-body">
                        <h5 class="card-title">Product 2</h5>
                        <p class="card-text">Description of Product 2. Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit.</p>
                        <a href="#" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="col-md-3">
                <div class="card mb-4">
                    <img src="https://placehold.it/300" class="card-img-top" alt="Product 3">
                    <div class="card-body">
                        <h5 class="card-title">Product 3</h5>
                        <p class="card-text">Description of Product 3. Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit.</p>
                        <a href="#" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="col-md-3">
                <div class="card mb-4">
                    <img src="https://placehold.it/300" class="card-img-top" alt="Product 3">
                    <div class="card-body">
                        <h5 class="card-title">Product 3</h5>
                        <p class="card-text">Description of Product 3. Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit.</p>
                        <a href="#" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="col-md-3">
                <div class="card mb-4">
                    <img src="https://placehold.it/300" class="card-img-top" alt="Product 3">
                    <div class="card-body">
                        <h5 class="card-title">Product 3</h5>
                        <p class="card-text">Description of Product 3. Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit.</p>
                        <a href="#" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<x-home.footer />

</html>
