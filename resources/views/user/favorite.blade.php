{{-- {{ dd($favorites) }} --}}
@extends('infor')
@section('page_title')
    Danh sách yêu thích
@endsection
@section('content')
    <!-- Cart Items -->
    <div class="row">
        <div class="col-md-12" style="margin-bottom: 160px;">
            @if (count($favorites) > 0)
                @foreach ($favorites as $favorite)
                    @foreach ($favorite->sanpham as $sanpham)
                        <!-- Product 1 -->
                        <div class="card">
                            <div class="row g-0">
                                <div class="col-md-2">
                                    @foreach ($image as $hinh)
                                        @if ($sanpham->id == $hinh->sanpham_id)
                                            <a href="{{ route('detailsanpham', $sanpham->id) }}">
                                                <img src="{{ asset('images/Sanpham/' . $hinh->image) }}"
                                                    class="img-fluid rounded-3" style="width: 138px;">
                                            </a>
                                        @break
                                    @endif
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <h3 class="card-title">
                                        <a class="sanphamName" href="{{ route('detailsanpham', $sanpham->id) }}"
                                            style="font-size: 18px">
                                            {{ $sanpham->name }}
                                        </a>
                                    </h3>
                                    <p class="card-text">
                                    <h6 class="text-danger">{{ number_format($sanpham->gia, 0, ',', '.') }} đ</h6>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="card-body">
                                    <h6 class="text-muted mb-0">Còn: <span
                                            class="fw-bold text-danger">{{ $sanpham->soluong }}</span>
                                    </h6>
                                </div>
                            </div>
                            <div class="col-md-3 text-right">
                                <form action="{{ route('deletefavorite') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="sanphamid" value="{{ $sanpham->id }}">
                                    @foreach ($favorites as $favorite)
                                        @foreach ($favorite->sanpham as $sanphamfav)
                                            @if ($sanphamfav->id == $sanpham->id)
                                                <input type="hidden" name="favoriteid" value="{{ $favorite->id }}">
                                            @endif
                                        @endforeach
                                    @endforeach
                                    <button type="submit"
                                        class="btn btn-light border border-dark py-2 icon-hover px-3">
                                        <i class="fa-solid fa-heart fa-lg" style="color: red;"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
            {{ $favorites->links() }}
        @else
            <div class="container col-8 pt-4" style="margin-bottom: 100px;margin-top: 70px">
                <div class="text-center">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <p>
                            <strong>Danh sách yêu thích trống</strong>
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
