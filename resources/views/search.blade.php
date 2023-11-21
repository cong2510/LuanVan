<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @include('cdn')

    <x-home.header :theloai="$theloai" :role="$role" title="Tìm kiếm" />
</head>

<body>
    <br>
    <div class="container">
        <header class="d-sm-flex align-items-center border-bottom mb-4 pb-3">
            <strong class="d-block py-2">{{ $allProduct }} Items found </strong>
            {{-- <form class="ms-auto" action="{{ route('search') }}" method="GET" id="form">
                <div class="">
                    <select class="form-select d-inline-block w-auto border pt-1" name="sortBy" id="sortBy">
                        <option value="">Mặc định</option>
                        <option value="lowest" {{ Request::get('sortBy') === 'lowest' ? 'selected' : '' }}>
                            Giá thấp nhất
                        </option>
                        <option value="highest" {{ Request::get('sortBy') === 'highest' ? 'selected' : '' }}>
                            Giá cao nhất
                        </option>
                        <option value="AZ" {{ Request::get('sortBy') === 'AZ' ? 'selected' : '' }}>
                            Theo tên A => Z
                        </option>
                        <option value="ZA" {{ Request::get('sortBy') === 'ZA' ? 'selected' : '' }}>
                            Theo tên Z => A
                        </option>
                    </select>
                </div>
            </form> --}}
        </header>
        <div>
            <div class="row">
                @foreach ($sanphamsort as $sanpham)
                    <div class="col-md-12 col-lg-3 mb-4 mb-lg-0">
                        <div class="card text-center" style="margin-bottom: 20px">
                            @foreach ($image as $hinh)
                                @if ($sanpham->id == $hinh->sanpham_id)
                                    <a href="{{ route('detailsanpham', $sanpham->id) }}"><img class="card-img-top"
                                            src="{{ asset('images/Sanpham/' . $hinh->image) }}"
                                            style="width: 98%;" /></a>
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
                                <h5 class="mb-0" style="font-size: 18px"><a
                                        href="{{ route('detailsanpham', $sanpham->id) }}"
                                        class="sanphamName">{{ $sanpham->name }}</a></h5>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="text-muted mb-0">Còn: <span
                                        class="fw-bold text-danger">{{ $sanpham->soluong }}</span></h6>
                                <h5 class="text-dark mb-0">{{ number_format($sanpham->gia, 0, ',', '.') }}đ</h5>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{ $sanphamsort->links() }}
</div>
</body>
<script type="text/javascript">
    $("select").change(function() {
        $(form).submit();
    });
</script>
<x-home.footer />

</html>
