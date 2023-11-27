<div class="container shadow min-vh-100 py-2">
    <div class="table-responsive">
        <table class="table accordion table-hover">
            <thead>
                <tr class="text-center">
                    <th scope="col">Mã hóa đơn</th>
                    <th scope="col">Phương thức thanh toán</th>
                    <th scope="col">Ngày đặt</th>
                    <th scope="col">Tổng tiền</th>
                    <th scope="col">Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $item)
                    <tr class="text-center" data-bs-toggle="collapse" data-bs-target="#{{ $item->order_id_ref }}">
                        <th scope="row" style="color:red">{{ $item->order_id_ref }}<i class="bi bi-chevron-down"></i></th>
                        <td>
                            @foreach ($paymentmethod as $payment)
                                @if ($payment->order_id == $item->id)
                                    {{ $payment->name }}
                                @endif
                            @endforeach
                        </td>
                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                        <td>{{ number_format($item->totalprice, 0, ',', '.') }}đ</td>
                        <td><span class="badge bg-primary">{{ $item->order_status }}</span></td>
                    </tr>
                    <tr class="collapse accordion-collapse" id="{{ $item->order_id_ref }}" data-bs-parent=".table">
                        <td colspan="5">
                            <div class="row d-flex justify-content-center align-items-center h-100">
                                <div class="col-lg-10 col-xl-8">
                                    <div class="card" style="border-radius: 10px;">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <p class="lead fw-normal mb-0" style="color: black;">Hóa đơn</p>
                                                <p class="small text-dark mb-0">Mã hóa đơn : {{ $item->order_id_ref }}
                                                </p>
                                            </div>
                                            <div class="card shadow-0 border mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        @foreach ($item->orderdetail as $detail)
                                                            <div class="col-md-3">
                                                                @foreach ($image as $hinh)
                                                                    @if ($hinh->sanpham_id == $detail->sanpham_id)
                                                                        <img style="max-width: 100%; max-height: 15vh; margin: auto;"
                                                                            class="rounded-4 fit"
                                                                            src="{{ asset('images/Sanpham/' . $hinh->image) }}" />
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <div
                                                            class="col-md-5 text-center d-flex justify-content-center align-items-center">
                                                            <p class="text-dark mb-0" style="font-size: 16px">{{ $detail->name }}</p>
                                                        </div>
                                                        <div
                                                            class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                            <p class="small text-dark mb-0 small">Số lượng:
                                                                {{ $detail->soluong }}</p>
                                                        </div>
                                                        <div
                                                            class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                            <p class="small text-dark mb-0 small">
                                                                {{ number_format($detail->gia, 0, ',', '.') }}đ</p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">
                                        <div class="d-flex justify-content-between pt-2">
                                            <p class="fw-bold mb-0">Order Details</p>
                                            <p class="small text-dark mb-0"><span class="fw-bold me-4">Tổng</span>
                                                {{ number_format($item->totalprice, 0, ',', '.') }}đ</p>
                                        </div>

                                        {{-- <div class="d-flex justify-content-between pt-2">
                                            <p class="small text-dark mb-0">Invoice Number : 788152</p>
                                            <p class="small text-dark mb-0"><span class="fw-bold me-4">Discount</span>
                                                $19.00</p>
                                        </div> --}}

                                        <div class="d-flex justify-content-between">
                                            <p class="small text-dark mb-0">Invoice Date : {{ date('d-m-Y', strtotime($item->created_at)) }}</p>
                                        </div>

                                        {{-- <div class="d-flex justify-content-between mb-5">
                                            <p class="small text-dark mb-0">Recepits Voucher : 18KU-62IIK</p>
                                            <p class="small text-dark mb-0"><span class="fw-bold me-4">Delivery
                                                    Charges</span> Free</p>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

