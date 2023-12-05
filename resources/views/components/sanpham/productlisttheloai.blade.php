{{-- @foreach ($sanphams as $sanpham)
    @foreach ($product as $sanphamtheloai)
        @if ($sanphamtheloai->sanpham_id == $sanpham->id)
            <div class="row justify-content-center mb-3">
                <div class="col-md-12">
                    <div class="card shadow-0 border rounded-3">
                        <div class="card-body">
                            <div class="row g-0">
                                <div class="col-xl-3 col-md-4 d-flex justify-content-center">
                                    <div class="bg-image hover-zoom ripple rounded ripple-surface me-md-3 mb-3 mb-md-0">
                                        @foreach ($image as $hinh)
                                            @if ($sanpham->id == $hinh->sanpham_id)
                                                <a href="{{ route('detailsanpham', $sanpham->id) }}"><img
                                                        src="{{ asset('images/Sanpham/' . $hinh->image) }}"
                                                        style="width: 150px;" /></a>
                                            @break
                                        @endif
                                    @endforeach
                                    <a href="#!">
                                        <div class="hover-overlay">
                                            <div class="mask"
                                                style="background-color: rgba(253, 253, 253, 0.15);">
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-5 col-sm-7">
                                <a href="{{ route('detailsanpham', $sanpham->id) }}" class="sanphamName">
                                    <h5>{{ $sanpham['name'] }}</h5>
                                </a>
                                <div class="d-flex flex-row">
                                    <a href="" class="text-reset" style="text-decoration: none;">
                                        <p>
                                            @foreach ($sanpham->theloai as $theloai)
                                                <span class="badge bg-primary">{{ $theloai->name }}</span>
                                            @endforeach
                                        </p>
                                    </a>
                                </div>
                                <p class="text mb-4 mb-md-0">
                                    {{ Str::limit($sanpham->mota, 200) }}...<a
                                        href="{{ route('detailsanpham', $sanpham->id) }}" class="xemThem">xem
                                        thêm</a>
                                </p>
                            </div>
                            <div class="col-xl-3 col-md-3 col-sm-5">
                                <div class="d-flex flex-row align-items-center mb-1">
                                    <h4 class="mb-1 me-1">{{ number_format($sanpham->gia, 0, ',', '.') }}đ</h4>
                                </div>
                                <h6 class="text-success">No free shipping</h6>
                                <div class="mt-4">
                                    <form action="{{ route('addtocart') }}" method="post">
                                        @csrf
                                        @if (Session::has('cart') && !empty(session('cart')))
                                            @foreach ((array) session('cart') as $id => $details)
                                                @if ($details['id'] == $sanpham->id)
                                                    @if ($details['soluong'] >= $sanpham->soluong)
                                                        <button type="submit" class="btn btn-danger" disabled>
                                                            Thêm vào giỏ
                                                        </button>&nbsp;
                                                    @else
                                                        <input type="text" name="id" id="id"
                                                            value="{{ $sanpham->id }}" hidden>
                                                        <button type="submit" class="btn btn-primary">
                                                            Thêm vào giỏ
                                                        </button>&nbsp;
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    </form>
                                    <a href="#!" class="btn btn-light border px-2 pt-2 icon-hover"><i
                                            class="fas fa-heart fa-lg px-1"></i></a>
                                    <a href="#!" class="btn btn-light border px-2 pt-2 icon-hover"><i
                                            class="fa-regular fa-heart fa-lg px-1" style="color: #000000;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
@endforeach --}}

<div class="container">
    <div class="row">
        @foreach ($sanphams as $sanpham)
            @foreach ($product as $sanphamtheloai)
                @if ($sanphamtheloai->sanpham_id == $sanpham->id)
                    <!-- Single Product -->
                    <div class="col-md-3">
                        <div class="card text-center" style="margin-bottom: 20px">
                            @foreach ($image as $hinh)
                                @if ($sanpham->id == $hinh->sanpham_id)
                                    <a href="{{ route('detailsanpham', $sanpham->id) }}"><img class="card-img-top"
                                            src="{{ asset('images/Sanpham/' . $hinh->image) }}" style="width: 98%;" /></a>
                                @break
                            @endif
                        @endforeach
                        <div class="card-body">
                            <div class="d-flex justify-content-left">
                                @foreach ($sanpham->theloai as $theloai)
                                    <p class="small"><a href="{{ route('sanphamtheloai', $theloai->id) }}"
                                            class="text-muted">{{ $theloai->name }}</a></p>
                                    &nbsp;&nbsp;
                                @endforeach
                            </div>

                            <div class="d-flex mb-3">
                                <h5 class="mb-0" style="font-size: 14px"><a href="{{ route('detailsanpham', $sanpham->id) }}"
                                        class="sanphamName">{{ $sanpham->name }}</a></h5>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="text-muted mb-0">Còn: <span
                                        class="fw-bold text-danger">{{ $sanpham->soluong }}</span></h6>
                                <h5 class="text-dark mb-0" style="font-size: 14px">{{ number_format($sanpham->gia, 0, ',', '.') }}đ</h5>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach
    <!-- Single Product -->
</div>
</div>
{{ $sanphams->links() }}
<!-- Pagination -->
