<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('cdn')

    <x-home.header :theloai="$theloai" :role="$role" title="Product" />
</head>

<body>
    <br>
    <section class="">
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
                                    aria-controls="panelsStayOpen-collapseOne">
                                    Thể loại
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <div>
                                        <!-- Checked checkbox -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckChecked1" checked />
                                            <label class="form-check-label" for="flexCheckChecked1">Mercedes</label>
                                            <span class="badge badge-secondary float-end">120</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseTwo">
                                    Giá
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body">
                                    <div class="range">
                                        <input type="range" class="form-range" id="customRange1" />
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <p class="mb-0">
                                                Min
                                            </p>
                                            <div class="form-outline">
                                                <input type="number" id="typeNumber" class="form-control" />
                                                <label class="form-label" for="typeNumber">$0</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p class="mb-0">
                                                Max
                                            </p>
                                            <div class="form-outline">
                                                <input type="number" id="typeNumber" class="form-control" />
                                                <label class="form-label" for="typeNumber">$1,0000</label>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button"
                                        class="btn btn-white w-100 border border-secondary">apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- sidebar -->
                <!-- content -->
                <div class="col-lg-9">
                    <header class="d-sm-flex align-items-center border-bottom mb-4 pb-3">
                        <strong class="d-block py-2">32 Items found </strong>
                        <div class="ms-auto">
                            <select class="form-select d-inline-block w-auto border pt-1">
                                <option value="0">Best match</option>
                                <option value="1">Recommended</option>
                                <option value="2">High rated</option>
                                <option value="3">Randomly</option>
                            </select>
                            <div class="btn-group shadow-0 border">
                                <a href="#" class="btn btn-light" title="List view">
                                    <i class="fa fa-bars fa-lg"></i>
                                </a>
                                <a href="#" class="btn btn-light active" title="Grid view">
                                    <i class="fa fa-th fa-lg"></i>
                                </a>
                            </div>
                        </div>
                    </header>
                    @foreach ($sanphams as $sanpham)
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-12">
                                <div class="card shadow-0 border rounded-3">
                                    <div class="card-body">
                                        <div class="row g-0">
                                            <div class="col-xl-3 col-md-4 d-flex justify-content-center">
                                                <div
                                                    class="bg-image hover-zoom ripple rounded ripple-surface me-md-3 mb-3 mb-md-0">
                                                    <img src="images/sanpham/{{ $sanpham['image'] }}" class="w-100" />
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
                                                <h5>{{ $sanpham['name'] }}</h5>
                                                <div class="d-flex flex-row">
                                                    <a href="" class="text-reset"
                                                        style="text-decoration: none;">
                                                        <p>
                                                            @foreach ($sanpham->theloai as $theloai)
                                                                {{ $theloai->name }}
                                                            @endforeach
                                                        </p>
                                                    </a>
                                                </div>
                                                <p class="text mb-4 mb-md-0">
                                                    {{ $sanpham['mota'] }}
                                                </p>
                                            </div>
                                            <div class="col-xl-3 col-md-3 col-sm-5">
                                                <div class="d-flex flex-row align-items-center mb-1">
                                                    <h4 class="mb-1 me-1">{{ $sanpham['gia'] }} vnđ</h4>
                                                    {{-- <span class="text-danger"><s>$49.99</s></span> --}}
                                                </div>
                                                <h6 class="text-success">Free shipping</h6>
                                                <div class="mt-4">
                                                    <button class="btn btn-primary shadow-0" type="button">Thêm vào
                                                        giỏ</button>
                                                    {{-- <a href="#!"
                                                        class="btn btn-light border px-2 pt-2 icon-hover"><i
                                                            class="fas fa-heart fa-lg px-1"></i></a> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{ $sanphams->links() }}
                    <!-- Pagination -->
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
</body>
<x-home.footer />

</html>
