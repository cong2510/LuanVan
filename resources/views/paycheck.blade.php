<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('cdn')

    <x-home.header :theloai="$theloai" :role="$role" title="Thanh toán" />
    <style>
        .error {
            color: red;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <br><br>
    <div class="container">
        <main>
            <div class="row g-5">
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Giỏ hàng</span>
                        <span class="badge bg-primary rounded-pill">
                            @if (Session::has('cart'))
                                @php
                                    $soluong = 0;
                                @endphp
                                @foreach ((array) session('cart') as $id => $details)
                                    @php
                                        $soluong += $details['soluong'];
                                    @endphp
                                @endforeach
                                {{ $soluong }}
                            @else
                                0
                            @endif
                        </span>
                    </h4>
                    <ul class="list-group mb-3">
                        @if (Session::has('cart') && !empty(session('cart')))
                            @php
                                $tong = 0;
                            @endphp
                            @foreach ((array) session('cart') as $id => $details)
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">{{ $details['name'] }}</h6>
                                        <small class="text-muted">Số lượng: {{ $details['soluong'] }}</small>
                                    </div>
                                    <span class="text-muted">{{ number_format($details['gia'], 0, ',', '.') }} đ</span>
                                </li>
                                @php
                                    $tong += $details['gia'] * $details['soluong'];
                                @endphp
                            @endforeach

                            <li class="list-group-item d-flex justify-content-between bg-light">
                                <div class="text-success">
                                    <h6 class="my-0">Promo code</h6>
                                    <small>EXAMPLECODE</small>
                                </div>
                                <span class="text-success">−$5</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Tổng (VND)</span>
                                <strong>{{ number_format($tong, 0, ',', '.') }} đ</strong>
                            </li>
                        @endif
                    </ul>

                    <form class="card p-2">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Promo code">
                            <button type="submit" class="btn btn-secondary">Redeem</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-7 col-lg-8">
                    <h4 class="mb-3">Thông tin đơn hàng</h4>
                    <form method="POST" action="{{ route('checkoutmethod') }}" id="checkoutForm">
                        @csrf
                        <input type="text" name="total" hidden value="{{ $tong }}">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Họ và tên" value="{{ Auth()->user()->name }}">
                                @error('name')
                                    <div class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Email"
                                    name="email" value="{{ Auth()->user()->email }}" disabled>

                            </div>

                            <div class="col-12">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="phone" class="form-control" id="phone" placeholder="Số điện thoại"
                                    name="phone">
                                @error('phone')
                                    <div class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <select name="address" id="addressSelect" class="form-select" onchange="toggleInput()">
                                    <option value="" disabled="" selected="">Chọn địa chỉ</option>
                                    @foreach ($address as $diachi)
                                        @if ($diachi->user_id == auth()->user()->id)
                                            <option value="{{ $diachi->address }}">{{ $diachi->address }}</option>
                                        @endif
                                    @endforeach
                                    <option value="showInput">Khác</option>
                                </select>
                                @error('address')
                                    <div class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>


                            <div class="form-group" id="inputContainer" style="display: none;">
                                <div class="row">
                                    <div class="col-3">
                                        <input name="anotherAddress" type="text"
                                            class="form-control border-secondary bg-navbar-dark" id="anotherAddress"
                                            placeholder="Nhập địa chỉ" />
                                        @error('anotherAddress')
                                            <div class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="form-select border-secondary" name="thanhpho" id="thanhpho">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <select class="form-select border-secondary" name="quan" id="quan">
                                            <option value="">Chọn quận</option>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <select class="form-select border-secondary" name="phuong" id="phuong">
                                            <option value="">Chọn phường</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="saveAddress"
                                        id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Lưu địa chỉ
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h4 class="mb-3">Phương thức thanh toán</h4>

                        <div class="my-3" id="payment">
                            <div class="form-check">
                                <input id="cod" name="method" type="radio" class="form-check-input"
                                    value="1">
                                <label class="form-check-label" for="credit">COD</label>
                            </div>
                            <div class="form-check">
                                <input id="vnpay" name="method" type="radio" class="form-check-input"
                                    value="2">
                                <label class="form-check-label" for="debit">VN-Pay</label>
                            </div>
                            {{-- <div class="form-check">
                                <input id="paypal" name="paymentMethod" type="radio" class="form-check-input">
                                <label class="form-check-label" for="paypal">PayPal</label>
                            </div> --}}
                        </div>

                        <hr class="my-4">

                        <button name="redirect" class="w-100 btn btn-primary btn-lg" type="submit">Thanh
                            toán</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <br><br>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"
    integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    const host = "https://provinces.open-api.vn/api/";
    var callAPI = (api) => {
        return axios.get(api)
            .then((response) => {
                renderData(response.data, "thanhpho"); // Truyền dữ liệu lấy từ api
            });
    }
    callAPI('https://provinces.open-api.vn/api/?depth=1');
    var callApiDistrict = (api) => {
        return axios.get(api)
            .then((response) => {
                renderData(response.data.districts, "quan");
            });
    }
    var callApiWard = (api) => {
        return axios.get(api)
            .then((response) => {
                renderData(response.data.wards, "phuong");
            });
    }

    var renderData = (array, select) => {
        let row = ' <option disable value="">Chọn</option>'; // tạo thẻ option ban đầu
        array.forEach(element => { //foreach từ màng thành các thẻ option với các name và value
            row += `<option value="${element.name}" id="${element.code}" >${element.name}</option>`
        });
        document.querySelector("#" + select).innerHTML = row //Tìm thẻ select rồi gán dữ liệu vào
    }

    $("#thanhpho").change(() => {
        let selectedValue = $("#thanhpho").val(); // Lấy value của thẻ option
        let selectedId = $("#thanhpho option[value='" + selectedValue + "']").attr(
            "id"); //Lấy dữ liệu từ id theo value
        callApiDistrict(host + "p/" + selectedId + "?depth=2"); // Gọi Api
    });
    $("#quan").change(() => {
        let selectedValue = $("#quan").val();
        let selectedId = $("#quan option[value='" + selectedValue + "']").attr("id");
        callApiWard(host + "d/" + selectedId + "?depth=2");
    });


    function toggleInput() {
        var select = document.getElementById('addressSelect');
        var inputContainer = document.getElementById('inputContainer');

        // Get the selected option value
        var selectedOption = select.options[select.selectedIndex].value;

        // Show or hide the input container based on the selected option
        if (selectedOption === 'showInput') {
            inputContainer.style.display = 'block';
        } else {
            inputContainer.style.display = 'none';
        }
    }

    $(document).ready(function() {
        $('#checkoutForm').validate({
            rules: {
                name: {
                    required: true,
                },
                phone: {
                    required: true,
                },
                address: {
                    required: true,
                },
                anotherAddress: {
                    required: true,
                },
                thanhpho: {
                    required: true,
                },
                quan: {
                    required: true,
                },
                phuong: {
                    required: true,
                },
                method: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: 'Thiếu họ và tên!',
                },
                phone: {
                    required: 'Thiếu số điện thoại!',
                },
                address: {
                    required: 'Thiếu địa chỉ',
                },
                anotherAddress: {
                    required: 'Thiếu địa chỉ',
                },
                thanhpho: {
                    required: 'Thiếu thành phố!',
                },
                quan: {
                    required: 'Thiếu quận',
                },
                phuong: {
                    required: 'Thiếu phường!',
                },
                method: {
                    required: 'Thiếu phương thức thanh toán!'
                },
            },
            errorPlacement: function(error, element) {
                error.appendTo(element.parent());
            }
        });

        $('#name').on('blur', function() {
            $(this).valid(); // Trigger validation on blur event
        });
        $('#phone').on('blur', function() {
            $(this).valid(); // Trigger validation on blur event
        });
        $('#addressSelect').on('blur', function() {
            $(this).valid(); // Trigger validation on blur event
        });
        $('#anotherAddress').on('blur', function() {
            $(this).valid(); // Trigger validation on blur event
        });
        $('#thanhpho').on('blur', function() {
            $(this).valid(); // Trigger validation on blur event
        });
        $('#quan').on('blur', function() {
            $(this).valid();
        });
        $('#phuong').on('blur', function() {
            $(this).valid();
        });
        $('#cod').on('blur', function() {
            $(this).valid();
        });
        $('#vnpay').on('blur', function() {
            $(this).valid();
        });
    });
</script>
<x-home.footer />

</html>
