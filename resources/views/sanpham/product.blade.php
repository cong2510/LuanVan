<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('cdn')
    <x-home.header :theloai="$theloai" :role="$role" title="Product" />
</head>
<br>

<body>
    <div class="container">
        <div class="row">
            <!-- sidebar -->
            <div class="col-lg-3">
                <!-- Collapsible wrapper -->
                <div class="accordion" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                aria-controls="panelsStayOpen-collapseOne" style="color: black;font-weight: bold">
                                Thể loại
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                            aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body">
                                <div>
                                    <ol class="list-group list-group ">
                                        <li class="list-group-item d-flex justify-content-between align-items-start"
                                            style="border: none;">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold"><a href="{{ route('sanpham') }}"
                                                        class="theloaiFilter">All</a>
                                                </div>
                                            </div>
                                            <span class="badge bg-primary rounded-pill">{{ $allProduct }}</span>
                                        </li>
                                        <hr>
                                        @foreach ($theloai as $loai)
                                            <li class="list-group-item d-flex justify-content-between align-items-start"
                                                style="border: none;">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold"><a
                                                            href="{{ route('sanphamtheloai', $loai->id) }}"
                                                            class="theloaiFilter">{{ $loai->name }}</a></div>
                                                </div>
                                                @php
                                                    $tam = 0;
                                                    foreach ($loaiSanphams as $sanphamtl) {
                                                        if ($sanphamtl->theloai_id == $loai->id) {
                                                            $tam = $tam + 1;
                                                        }
                                                    }
                                                @endphp
                                                <span class="badge bg-primary rounded-pill">
                                                    {{ $tam }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- sidebar -->
            <!-- content -->
            <div class="col-lg-9">
                <header class="d-sm-flex align-items-center border-bottom mb-4 pb-3">
                    <strong class="d-block py-2">{{ $allProduct }} Items found </strong>
                    <form class="ms-auto" action="{{ route('sanpham') }}" method="GET" id="form">
                        {{-- <div class="ms-auto d-flex">
                        <input class="searchBar form-control me-2" type="search" placeholder="Tìm kiếm"
                            aria-label="Search">
                        <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"
                                style="color: #000000;"></i></button>
                        </div> --}}
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
                        {{-- <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"
                                style="color: #000000;"></i></button> --}}
                    </form>
                </header>
                <x-sanpham.productlist :sanphams="$sanphamsort" :image="$image" />
                <!-- Pagination -->
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
    $("select").change(function() {
        $("form").submit();
    });
</script>
<x-home.footer />

</html>
