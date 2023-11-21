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
    <div class="container" style="--swiper-navigation-color: black;">
        <x-home.carousel />
    </div>

</body>
<x-home.footer />

</html>
