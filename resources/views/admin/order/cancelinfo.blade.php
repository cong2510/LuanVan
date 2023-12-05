@extends('admin.indexAdmin')
@section('page_title')
    Đơn hàng {{ $order->order_id_ref }}
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Thông tin</h5>
                    {{-- <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Họ và tên</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $user->name }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Email</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $user->email }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Số điện thoại</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $order->phone }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Địa chỉ</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $order->diachi }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="card" style="border-radius: 10px;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <p class="lead fw-normal mb-0" style="color: black;">Hóa đơn</p>
                                <p class="small text-dark mb-0">Mã hóa đơn :
                                    {{ $order->order_id_ref }}
                                </p>
                            </div>
                            <div class="card shadow-0 border mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($order->orderdetail as $detail)
                                            <div class="col-md-3">
                                                @foreach ($image as $hinh)
                                                    @if ($hinh->sanpham_id == $detail->sanpham_id)
                                                        <img style="max-width: 100%; max-height: 15vh; margin: auto;"
                                                            class="rounded-4 fit"
                                                            src="{{ asset('images/Sanpham/' . $hinh->image) }}" /> @break
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div
                                                class="col-md-5 text-center d-flex justify-content-center align-items-center">
                                                <p class="text-dark mb-0" style="font-size: 16px">
                                                    {{ $detail->name }}</p>
                                            </div>
                                            <div
                                                class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                <p class="small text-dark mb-0 small">Số lượng:
                                                    {{ $detail->soluong }}</p>
                                            </div>
                                            <div
                                                class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                <p class="small text-dark mb-0 small">
                                                    {{ number_format($detail->gia, 0, ',', '.') }}đ
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">
                            <div class="d-flex justify-content-between pt-2">
                                <p class="fw-bold mb-0">Thông tin đơn hàng</p>
                                <p class="small text-dark mb-0"><span class="fw-bold me-4">Tổng</span>
                                    {{ number_format($order->totalprice, 0, ',', '.') }}đ</p>
                            </div>

                            <div class="d-flex justify-content-between">
                                <p class="small text-dark mb-0">Ngày lập hóa đơn :
                                    {{ date('d-m-Y', strtotime($order->created_at)) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cancel.order') }}" method="POST">
                            @csrf
                            <input type="hidden" name="orderid" value="{{ $order->id }}">
                            <button type="submit" class="btn btn-danger" style="float: right">
                                Hủy đơn
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
