<div class="card-body">
    <div class="table-responsive">
        <table id="pending" class="table table-hover" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">Id</th>
                    <th class="text-center">Mã hóa đơn</th>
                    <th class="text-center">Số điện thoại</th>
                    <th class="text-center">Phương thức thanh toán</th>
                    <th class="text-center">Ngày đặt</th>
                    <th class="text-center">Tổng tiền</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $key => $order)
                    @if ($order->order_status == 'Pending')
                        <tr class="text-center">
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->order_id_ref }} <a data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $order->id }}"><i class="fa-solid fa-circle-info"
                                        style="color: #005eff;"></i></a>
                            </td>
                            <td>{{ $order->phone }}</td>
                            <td>
                                @foreach ($paymentmethod as $payment)
                                    @if ($payment->order_id == $order->id)
                                        {{ $payment->name }}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                            <td>{{ number_format($order->totalprice, 0, ',', '.') }}đ</td>
                            <td><span class="badge bg-primary">{{ $order->order_status }}</span></td>
                            <td class="text-center">
                                @php
                                    $flag = 1;
                                    $ten = [];
                                    $soluong = [];
                                @endphp
                                @foreach ($order->orderdetail as $detail)
                                    @foreach ($sanpham as $sp)
                                        @if ($sp->id == $detail->sanpham_id)
                                            @if ($sp->soluong < $detail->soluong)
                                                @php
                                                    $flag = 0;
                                                    $ten[] = $detail->name;
                                                    $soluong[] = $detail->soluong - $sp->soluong;
                                                @endphp
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                                @php
                                    $sanphamthieu = array_combine($ten, $soluong);
                                @endphp
                                @if ($flag == 0)
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#needModal{{ $order->id }}">
                                        <i class="fa-solid fa-sack-xmark"></i>
                                    </button>
                                    <div class="modal fade" id="needModal{{ $order->id }}" tabindex="-1"
                                        aria-labelledby="needModal{{ $order->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="needModal{{ $order->id }}Label">
                                                        Thiếu sản phẩm
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @foreach ($sanphamthieu as $key => $thieu)
                                                        {{ $key }} x {{ $thieu }} <br>
                                                    @endforeach
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $order->id }}">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                @endif
                                <a href="{{ route('cancel.orderinfo',$order->id) }}" class="btn btn-danger">
                                    <i class="fa-solid fa-ban"></i>
                                </a>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="detailModal{{ $order->id }}" tabindex="-1"
                            aria-labelledby="detailModal{{ $order->id }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailModal{{ $order->id }}Label">Thông tin đơn
                                            hàng
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
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
                                                                                src="{{ asset('images/Sanpham/' . $hinh->image) }}" />
                                                                        @break
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
                                                <p class="fw-bold mb-0">Order Details</p>
                                                <p class="small text-dark mb-0"><span
                                                        class="fw-bold me-4">Tổng</span>
                                                    {{ number_format($order->totalprice, 0, ',', '.') }}đ</p>
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <p class="small text-dark mb-0">Invoice Date :
                                                    {{ date('d-m-Y', strtotime($order->created_at)) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteModal{{ $order->id }}" tabindex="-1"
                        aria-labelledby="deleteModal{{ $order->id }}Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModal{{ $order->id }}Label">Xác nhận
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Xác nhận đơn hàng {{ $order->order_id_ref }} này ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <form action="{{ route('update.orderpending') }}" method="post">
                                        @csrf
                                        @foreach ($order->orderdetail as $detail)
                                            <input type="hidden"
                                                name="orderdetails[{{ $detail->id }}][sanphamid]"
                                                value="{{ $detail->sanpham_id }}">
                                            <input type="hidden"
                                                name="orderdetails[{{ $detail->id }}][soluong]"
                                                value="{{ $detail->soluong }}">
                                        @endforeach
                                        <input type="hidden" name="orderid" value="{{ $order->id }}">
                                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </tbody>
        {{-- <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Mã hóa đơn</th>
                    <th>Phương thức thanh toán</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th class="text-center">Actions</th>
                </tr>
            </tfoot> --}}
    </table>
</div>
</div>
