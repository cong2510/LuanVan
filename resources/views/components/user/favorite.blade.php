{{-- {{ dd($favorites) }} --}}
<br>

<div class="row">
    @foreach ($favorites as $favorite)
        <div class="col-md-3">
            <div class="card text-center" style="margin-bottom: 20px">
                @foreach ($favorite->sanpham as $sanpham)
                    @foreach ($image as $hinh)
                        @if ($sanpham->id == $hinh->sanpham_id)
                            <a href="{{ route('detailsanpham', $sanpham->id) }}">
                                <img class="card-img-top" src="{{ asset('images/Sanpham/' . $hinh->image) }}"
                                    style="width: 98%;" />
                            </a>
                        @break
                    @endif
                @endforeach
            @endforeach
            <div class="card-body">
                <div class="d-flex justify-content-left">
                    @foreach ($favorite->sanpham as $sanpham)
                        @foreach ($sanpham->theloai as $theloai)
                            <p class="small"><a href="{{ route('sanphamtheloai', $theloai->id) }}"
                                    class="text-muted">{{ $theloai->name }}</a></p>
                            &nbsp;&nbsp;
                        @endforeach
                    @endforeach
                </div>

                @foreach ($favorite->sanpham as $sanpham)
                    <div class="d-flex mb-3">
                        <h5 class="mb-0"><a
                                href="{{ route('detailsanpham', $sanpham->id) }}"
                                class="sanphamName" style="font-size: 18px;">{{ $sanpham->name }}</a></h5>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="text-muted mb-0">Còn: <span
                                class="fw-bold text-danger">{{ $sanpham->soluong }}</span>
                        </h6>
                        <h5 class="text-dark mb-0">{{ number_format($sanpham->gia, 0, ',', '.') }}đ</h5>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endforeach
</div>
