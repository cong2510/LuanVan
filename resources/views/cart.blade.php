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
    <x-home.header :theloai="$theloai" :role="$role" title="Giỏ hàng" />
</head>

<body>
    {{-- {{ dd(session('cart')) }} --}}
    <section class="h-100 h-custom">
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
                                                    <input type="hidden" name="id" id="id" value="{{ $details['id'] }}">
                                                    <button type="submit" class="btn btn-link px-2" name="down" value="true">
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

                                                    <button class="btn btn-link px-2" type="submit" name="up" value="false">
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
                            {{-- <div class="col-md-6 col-lg-4 col-xl-3 mb-4 mb-md-0">
                                <form>
                                    <div class="d-flex flex-row pb-3">
                                        <div class="d-flex align-items-center pe-2">
                                            <input class="form-check-input" type="radio" name="radioNoLabel"
                                                id="radioNoLabel1v" value="" aria-label="..." checked />
                                        </div>
                                        <div class="rounded border w-100 p-3">
                                            <p class="d-flex align-items-center mb-0">
                                                <i class="fab fa-cc-mastercard fa-2x text-dark pe-2"></i>Credit
                                                Card
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row pb-3">
                                        <div class="d-flex align-items-center pe-2">
                                            <input class="form-check-input" type="radio" name="radioNoLabel"
                                                id="radioNoLabel2v" value="" aria-label="..." />
                                        </div>
                                        <div class="rounded border w-100 p-3">
                                            <p class="d-flex align-items-center mb-0">
                                                <i class="fab fa-cc-visa fa-2x fa-lg text-dark pe-2"></i>Debit Card
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row">
                                        <div class="d-flex align-items-center pe-2">
                                            <input class="form-check-input" type="radio" name="radioNoLabel"
                                                id="radioNoLabel3v" value="" aria-label="..." />
                                        </div>
                                        <div class="rounded border w-100 p-3">
                                            <p class="d-flex align-items-center mb-0">
                                                <i class="fab fa-cc-paypal fa-2x fa-lg text-dark pe-2"></i>PayPal
                                            </p>
                                        </div>
                                    </div>
                                </form>
                            </div> --}}
                            {{-- <div class="col-md-6 col-lg-4 col-xl-6">
                                <div class="row">
                                    <div class="col-12 col-xl-6">
                                        <div class="form-outline mb-4 mb-xl-5">
                                            <input type="text" id="typeName"
                                                class="form-control form-control-lg" siez="17"
                                                placeholder="John Smith" />
                                            <label class="form-label" for="typeName">Name on card</label>
                                        </div>

                                        <div class="form-outline mb-4 mb-xl-5">
                                            <input type="text" id="typeExp"
                                                class="form-control form-control-lg" placeholder="MM/YY"
                                                size="7" id="exp" minlength="7" maxlength="7" />
                                            <label class="form-label" for="typeExp">Expiration</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-6">
                                        <div class="form-outline mb-4 mb-xl-5">
                                            <input type="text" id="typeText"
                                                class="form-control form-control-lg" siez="17"
                                                placeholder="1111 2222 3333 4444" minlength="19"
                                                maxlength="19" />
                                            <label class="form-label" for="typeText">Card Number</label>
                                        </div>

                                        <div class="form-outline mb-4 mb-xl-5">
                                            <input type="password" id="typeText"
                                                class="form-control form-control-lg"
                                                placeholder="&#9679;&#9679;&#9679;" size="1" minlength="3"
                                                maxlength="3" />
                                            <label class="form-label" for="typeText">Cvv</label>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-lg-4 col-xl-3">
                                <div class="d-flex justify-content-between" style="font-weight: 500;">
                                    <p class="mb-2">Subtotal</p>
                                    @if (Session::has('cart') && !empty(session('cart')))
                                        <p class="mb-2">{{ number_format($total, 0, ',', '.') }} đ</p>
                                    @else
                                        <p class="mb-2">0đ</p>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-between" style="font-weight: 500;">
                                    <p class="mb-0">Shipping</p>
                                    <p class="mb-0">$2.99</p>
                                </div>

                                <hr class="my-4">

                                <div class="d-flex justify-content-between mb-4" style="font-weight: 500;">
                                    <p class="mb-2">Total (tax included)</p>
                                    <p class="mb-2">$26.48</p>
                                </div>

                                <button type="button" class="btn btn-primary btn-block btn-lg">
                                    <div class="d-flex justify-content-between">
                                        <span>Đặt hàng</span>
                                        <span>$26.48</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
<x-home.footer />

</html>
