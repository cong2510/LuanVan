<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('cdn')

    <style>
        @media (min-width: 1025px) {
            .h-custom {
                height: 100vh !important;
            }
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }

        .error {
            color: red;
            font-size: 16px;
        }
    </style>
    <x-home.header :theloai="$theloai" :role="$role" :brand="$brand" title="Giỏ hàng" />
</head>

<body>
    <div class="container mt-5">
        <div class="container col-8 pt-3">
            <div class="text-center">
                @if (Session::has('order_success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong class="h4">{{ Session::get('order_success') }}</strong>
                        <hr class="py-0 text-success" />
                        <p>
                            Hóa đơn sẽ được gửi tới email của bạn!
                        </p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
        <h2 class="mb-4">Giỏ hàng</h2>
        <!-- Cart Items -->
        <div class="row">
            <div class="col-md-8">
                @if (Session::has('cart') && !empty(session('cart')))
                    @php
                        $total = 0;
                    @endphp
                    @foreach ((array) session('cart') as $id => $details)
                        <!-- Product 1 -->
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-2">
                                    @foreach ($image as $hinh)
                                        @if ($details['id'] == $hinh->sanpham_id)
                                            <img src="{{ asset('images/Sanpham/' . $hinh->image) }}"
                                                class="img-fluid rounded-3" style="width: 138px;">
                                        @break
                                    @endif
                                @endforeach
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <h5 class="card-title sanphamName">{{ $details['name'] }}</h5>
                                    <p class="card-text">
                                    <h6 class="text-danger">{{ number_format($details['gia'], 0, ',', '.') }} đ</h6>
                                    </p>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            <form action="{{ route('updateitem') }}" method="POST">
                                                @csrf
                                                <div class="d-flex flex-row">
                                                    <input type="hidden" name="id" id="id"
                                                        value="{{ $details['id'] }}">
                                                    <button type="submit" class="btn btn-link px-2" name="down"
                                                        value="true">
                                                        <i class="fas fa-minus"></i>
                                                    </button>

                                                    @foreach ($sanphams as $sanpham)
                                                        @if ($details['id'] == $sanpham->id)
                                                            <input id="form1" min="1" name="soluong"
                                                                value="{{ $details['soluong'] }}" type="number"
                                                                class="form-control form-control-sm"
                                                                style="width: 50px;" onKeyDown="return false"
                                                                max="{{ $sanpham->soluong }}" />
                                                        @endif
                                                    @endforeach

                                                    <button class="btn btn-link px-2" type="submit" name="up"
                                                        value="false">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </small>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-1 text-right">
                                <form action="{{ route('removeitem') }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <input name="id" type="text" value="{{ $details['id'] }}" hidden>
                                    <button type="submit"
                                        style="background: none;border: none;color:red;font-size: 20px">X</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @php
                        $total += $details['gia'] * $details['soluong'];
                    @endphp
                @endforeach
            @else
                <div class="container col-8 pt-4">
                    <div class="text-center">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <p>
                                <strong>Giỏ hàng trống</strong>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Cart Summary -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tổng giỏ hàng</h5>
                    <ul class="list-group">
                        @if (Session::has('cart') && !empty(session('cart')))
                            @php
                                $total = 0;
                                $tam = 0;
                            @endphp
                            @foreach ((array) session('cart') as $id => $details)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $details['name'] }}
                                    @if ($details['soluong'] > 1)
                                        @php
                                            $tam += $details['gia'] * $details['soluong'];
                                        @endphp
                                        <span
                                            class="badge bg-primary rounded-pill">{{ number_format($tam, 0, ',', '.') }}
                                            đ</span>
                                    @else
                                        <span
                                            class="badge bg-primary rounded-pill">{{ number_format($details['gia'], 0, ',', '.') }}
                                            đ</span>
                                    @endif
                                </li>
                                @php
                                    $total += $details['gia'] * $details['soluong'];
                                @endphp
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Tổng
                                <span
                                    class="badge bg-success rounded-pill">{{ number_format($total, 0, ',', '.') }}
                                    đ</span>
                            </li>
                        @else
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Giỏ hàng trống
                                <span class="badge bg-primary rounded-pill">0 đ</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Tổng
                                <span class="badge bg-success rounded-pill">0 đ</span>
                            </li>
                        @endif
                    </ul>
                    @if (Session::has('cart') && !empty(session('cart')))
                        <span>
                            <a href="{{ route('checkout') }}" style="text-decoration: none;color: white"><button
                                    type="button" class="btn btn-primary btn-block btn-lg">
                                    Đặt hàng
                                </button></a>
                        </span>
                    @else
                        <span>
                            <a href="" style="text-decoration: none;color: white"><button type="button"
                                    class="btn btn-primary btn-block btn-lg">
                                    Đặt hàng
                                </button></a>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<br>


{{-- {{ dd(session('cart')) }} --}}
{{-- <div class="container col-8 pt-3">
    <div class="text-center">
        @if (Session::has('order_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong class="h4">{{ Session::get('order_success') }}</strong>
                <hr class="py-0 text-success" />
                <p>
                    Hóa đơn sẽ được gửi tới email của bạn!
                </p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
</div>
<div class="container h-100 py-5">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="h5">Giỏ hàng</th>
                            <th scope="col">Thương hiệu</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Giá</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (Session::has('cart') && !empty(session('cart')))
                            @php
                                $total = 0;
                            @endphp
                            @foreach ((array) session('cart') as $id => $details)
                                <tr>
                                    <th scope="row">
                                        <div class="d-flex align-items-center">
                                            @foreach ($image as $hinh)
                                                @if ($details['id'] == $hinh->sanpham_id)
                                                    <img src="{{ asset('images/Sanpham/' . $hinh->image) }}"
                                                        class="img-fluid rounded-3" style="width: 120px;">
                                                @break
                                            @endif
                                        @endforeach
                                        <div class="flex-column ms-4">
                                            <h5 class="mb-2 sanphamName">{{ $details['name'] }}</h5>
                                            <p class="mb-0">
                                                @foreach ($theloai as $loai)
                                                    @foreach ($sanpham_theloai as $sptl)
                                                        @if ($sptl->sanpham_id == $details['id'] && $sptl->theloai_id == $loai->id)
                                                            <span
                                                                class="badge bg-primary">{{ $loai->name }}</span>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </p>
                                        </div>
                                    </div>
                                </th>
                                <td class="align-middle">
                                    <p class="mb-0" style="font-weight: 500;">
                                        @foreach ($brands as $brand)
                                            @if ($details['brand_id'] == $brand->id)
                                                {{ $brand->name }}
                                            @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="align-middle">
                                    <form action="{{ route('updateitem') }}" method="POST">
                                        @csrf
                                        <div class="d-flex flex-row">
                                            <input type="hidden" name="id" id="id"
                                                value="{{ $details['id'] }}">
                                            <button type="submit" class="btn btn-link px-2" name="down"
                                                value="true">
                                                <i class="fas fa-minus"></i>
                                            </button>

                                            @foreach ($sanphams as $sanpham)
                                                @if ($details['id'] == $sanpham->id)
                                                    <input id="form1" min="1" name="soluong"
                                                        value="{{ $details['soluong'] }}" type="number"
                                                        class="form-control form-control-sm"
                                                        style="width: 50px;" onKeyDown="return false"
                                                        max="{{ $sanpham->soluong }}" />
                                                @endif
                                            @endforeach

                                            <button class="btn btn-link px-2" type="submit" name="up"
                                                value="false">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                                <td class="align-middle">
                                    <p class="mb-0" style="font-weight: 500;">
                                        {{ number_format($details['gia'], 0, ',', '.') }} đ</p>
                                </td>
                                <td>
                                    <form action="{{ route('removeitem') }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <input name="id" type="text" value="{{ $details['id'] }}"
                                            hidden>
                                        <button type="submit"
                                            style="background: none;border: none;color:red;font-size: 18px">X</button>
                                    </form>
                                </td>
                            </tr>
                            @php
                                $total += $details['gia'] * $details['soluong'];
                            @endphp
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="justify-content-end">
                                    <form action="{{ route('removeitem') }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button name="clear_all" type="submit" class="btn btn-danger">Xóa
                                            hết</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @else
                        <tr style="text-align: center; justify-content: center">
                            <td></td>
                            <td style="text-align: center; justify-content: center">
                                <p class="h5 mb-4 mt-4">Giỏ hàng trống!</p>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="card shadow-2-strong mb-5 mb-lg-0" style="border-radius: 16px;">
            <div class="card-body p-4">
                <div class="row flex-row-reverse">
                    <div class="col-lg-4 col-xl-3">
                        <div class="d-flex justify-content-between mb-4" style="font-weight: 500;">
                            <p class="mb-2">Tổng</p>
                            @if (Session::has('cart') && !empty(session('cart')))
                                <p class="mb-2">{{ number_format($total, 0, ',', '.') }} đ</p>
                            @else
                                <p class="mb-2">0đ</p>
                            @endif
                        </div>
                        <hr class="my-4">
                        @if (Session::has('cart') && !empty(session('cart')))
                            <span>
                                <a href="{{ route('checkout') }}"
                                    style="text-decoration: none;color: white"><button type="button"
                                        class="btn btn-primary btn-block btn-lg">
                                        Đặt hàng
                                    </button></a>
                            </span>
                        @else
                            <span>
                                <a href="" style="text-decoration: none;color: white"><button
                                        type="button" class="btn btn-primary btn-block btn-lg">
                                        Đặt hàng
                                    </button></a>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div> --}}
</body>
<x-home.footer />

</html>
