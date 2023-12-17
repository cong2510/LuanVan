@extends('infor')
@section('page_title')
    Lịch sử đơn hàng
@endsection
@section('content')
    <style>
        .error {
            color: red;
            font-size: 16px;
        }

    </style>
    <div class="row">
        <!-- card -->
        <div class="card">
            <!-- card body-->
            <div class="card-header mb-6">
                <h4 class="mb-0">Đơn hàng của bạn</h4>
            </div>
            <hr style="color:black !important;height: 3px;opacity: 0.5;">
            <div class="card-body">
                @if (count($orders) > 0)
                    @foreach ($orders as $key => $order)
                        <div style="margin-bottom: 60px">
                            <!-- text -->
                            <div class="border-bottom mb-3 pb-3 d-lg-flex align-items-center justify-content-between ">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Order #{{ $order->order_id_ref }}</h5>
                                    <span class="ms-2">&nbsp;Đặt hàng ngày:
                                        {{ date('d-m-Y', strtotime($order->created_at)) }}</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <!-- link -->
                                    @if ($order->order_status == $canceled)
                                        <span class="badge bg-danger">{{ $order->order_status }}</span>
                                    @elseif ($order->order_status == $done)
                                        <span class="badge bg-success">{{ $order->order_status }}</span>
                                    @elseif ($order->order_status == $onway)
                                        <span class="badge bg-secondary">{{ $order->order_status }}</span>
                                    @else
                                        <span class="badge bg-primary">{{ $order->order_status }}</span>
                                    @endif
                                </div>
                            </div>
                            <!-- row -->
                            @foreach ($order->orderdetail as $detail)
                                <div class="row justify-content-between align-items-center">
                                    <!-- col -->
                                    <div class="col-lg-8 col-12">
                                        <div class="d-md-flex">
                                            <div>
                                                <!-- img -->
                                                @foreach ($image as $hinh)
                                                    @if ($hinh->sanpham_id == $detail->sanpham_id)
                                                        <img style="max-width: 100%; max-height: 15vh; margin: auto;"
                                                            class="rounded-4 fit"
                                                            src="{{ asset('images/Sanpham/' . $hinh->image) }}" />
                                                    @break
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="ms-md-4 mt-2 mt-lg-0">
                                            <!-- heading -->
                                            <h5 class="mb-1">
                                                <a href="{{ route('detailsanpham', $detail->sanpham_id) }}"
                                                    class="sanphamName" style="font-size: 16px">{{ $detail->name }}</a>
                                            </h5>
                                            <!-- text -->
                                            <span>Số lượng: <span class="text-dark">{{ $detail->soluong }}</span>
                                                <!-- text -->
                                                <div class="mt-3">
                                                    <h4>{{ number_format($detail->gia, 0, ',', '.') }}đ</h4>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- button -->
                                <div class="col-lg-4 col-12 d-grid">
                                    @if ($order->order_status == $done)
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if (!$user->rating()->where('sanpham_id', $detail->sanpham_id)->where('orderdetail_id', $detail->id)->exists())
                                                    <form accept-charset="UTF-8" action="{{ route('rateproduct') }}"
                                                        method="post">
                                                        @csrf
                                                        <input type="hidden" name="orderdetail_id"
                                                            value="{{ $detail->id }}">
                                                        <input type="hidden" name="sanpham_id"
                                                            value="{{ $detail->sanpham_id }}">
                                                        <textarea class="no-resize form-control animated" cols="50" id="new-review" name="content"
                                                            placeholder="Đánh giá sản phẩm tại đây..." rows="5" maxlength="255"></textarea>
                                                        @error('content')
                                                            <div class="invalid-feedback d-block" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                        <div class="text-right">
                                                            <div class="form-group-row therating">
                                                                <label class=" starlabel" for="inputmatch">Đánh
                                                                    giá:</label>
                                                                <div class="rating">
                                                                    <input id="rate5star{{ $detail->id }}"
                                                                        name="rating" type="radio" value="5"
                                                                        class="radio-btn starhide" />
                                                                    <label for="rate5star{{ $detail->id }}">☆</label>
                                                                    <input id="rate4star{{ $detail->id }}"
                                                                        name="rating" type="radio" value="4"
                                                                        class="radio-btn starhide" />
                                                                    <label for="rate4star{{ $detail->id }}">☆</label>
                                                                    <input id="rate3star{{ $detail->id }}"
                                                                        name="rating" type="radio" value="3"
                                                                        class="radio-btn starhide" />
                                                                    <label for="rate3star{{ $detail->id }}">☆</label>
                                                                    <input id="rate2star{{ $detail->id }}"
                                                                        name="rating" type="radio" value="2"
                                                                        class="radio-btn starhide" />
                                                                    <label for="rate2star{{ $detail->id }}">☆</label>
                                                                    <input id="rate1star{{ $detail->id }}"
                                                                        name="rating" type="radio" value="1"
                                                                        class="radio-btn starhide" />
                                                                    <label for="rate1star{{ $detail->id }}">☆</label>
                                                                    <div class="clear"></div>
                                                                </div>
                                                            </div>
                                                            @error('rating')
                                                                <div class="invalid-feedback d-block" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </div>
                                                            @enderror
                                                            <br>
                                                            <button class="btn btn-success" type="submit">Gửi</button>
                                                        </div>
                                                    </form>
                                                @else
                                                    <p>Cảm ơn bạn đã đánh giá sản phẩm.</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <br>
                            <!-- row -->
                        @endforeach
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3 class="h6">Phương thức thanh toán</h3>
                                    <p>
                                        @foreach ($paymentmethod as $paymethod)
                                            @if ($paymethod->order_id == $order->id)
                                                {{ $paymethod->name }}
                                            @endif
                                        @endforeach
                                        <br>
                                        Mã khuyễn mãi:
                                        @foreach ($promos as $promo)
                                            @if ($promo->id == $order->promocode_id)
                                                <strong>{{ $promo->name }}</strong>
                                            @endif
                                        @endforeach
                                        <br>
                                        Total: {{ number_format($order->totalprice, 0, ',', '.') }}đ
                                    </p>
                                </div>
                                <div class="col-lg-6">
                                    <h3 class="h6">Địa chỉ nhận hàng</h3>
                                    <address>
                                        <strong>{{ $order->name }}</strong><br>
                                        {{ $order->diachi }}<br>
                                        @php
                                            $sodienthoai = substr_replace($order->phone, '.', 2, 0);
                                            $sdt = substr_replace($sodienthoai, '.', 7, 0);
                                        @endphp
                                        Số điện thoại: {{ $sdt }}
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="color:black !important;height: 3px;opacity: 0.5;">
                @endforeach
            @else
                <div class="container col-8 pt-4" style="margin-bottom: 100px;margin-top: 70px">
                    <div class="text-center">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <p>
                                <strong>Lịch sử đơn hàng trống</strong>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        {{ $orders->links() }}
    </div>
</div>
@endsection
