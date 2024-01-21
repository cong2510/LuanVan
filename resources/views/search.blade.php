<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @include('cdn')

    <x-home.header :theloai="$theloai" :role="$role" :brand="$brand" title="Tìm kiếm" />
</head>

<body>
    <br>
    <div class="container">
        <header class="d-sm-flex align-items-center border-bottom mb-4 pb-3">
            <strong class="d-block py-2">{{ $allProduct }} Items found </strong>
        </header>
        @if (count($sanphamsort) > 0)
            <div>
                <div class="row">
                    @foreach ($sanphamsort as $sanpham)
                        <div class="col-md-3">
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
                                    @foreach ($sanpham->theloai as $loai)
                                        <p class="small"><a href="{{ route('sanphamtheloai', $loai->id) }}"
                                                class="text-muted">{{ $loai->name }}</a>
                                        </p>
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
    @else
        <div class="container col-8 pt-4" style="margin-top: 90px;margin-bottom: 100px">
            <div class="text-center">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <p>
                        <strong>Không tìm thấy sản phẩm</strong>
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
</body>
<script type="text/javascript">
    $("select").change(function() {
        $(form).submit();
    });
</script>
<x-home.footer />

</html>
