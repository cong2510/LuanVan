@extends('admin.indexAdmin')
@section('page_title')
    Danh sách đơn hàng
@endsection
@section('content')
    <ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="ex3-tab-1" data-bs-toggle="tab" href="#ex3-tabs-1" role="tab"
                aria-controls="ex3-tabs-1" aria-selected="true" style="font-weight: bold;">Pending</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="ex3-tab-2" data-bs-toggle="tab" href="#ex3-tabs-2" role="tab"
                aria-controls="ex3-tabs-2" aria-selected="false" style="font-weight: bold;">On The Way</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="ex3-tab-3" data-bs-toggle="tab" href="#ex3-tabs-3" role="tab"
                aria-controls="ex3-tabs-3" aria-selected="false" style="font-weight: bold;">Done</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="ex3-tab-4" data-bs-toggle="tab" href="#ex3-tabs-4" role="tab"
                aria-controls="ex3-tabs-4" aria-selected="false" style="font-weight: bold;">Canceled</a>
        </li>
    </ul>

    <div class="tab-content" id="ex2-content">
        <div class="tab-pane fade show active" id="ex3-tabs-1" role="tabpanel" aria-labelledby="ex3-tab-1">
            <x-admin.order.pending :orders="$orders" :paymentmethod="$paymentmethod" :image="$image" :sanpham="$sanpham" />
        </div>
        <div class="tab-pane fade" id="ex3-tabs-2" role="tabpanel" aria-labelledby="ex3-tab-2">
            <x-admin.order.ontheway :orders="$orders" :paymentmethod="$paymentmethod" :image="$image" />
        </div>
        <div class="tab-pane fade" id="ex3-tabs-3" role="tabpanel" aria-labelledby="ex3-tab-3">
            <x-admin.order.done :orders="$orders" :paymentmethod="$paymentmethod" :image="$image" />
        </div>
        <div class="tab-pane fade" id="ex3-tabs-4" role="tabpanel" aria-labelledby="ex3-tab-4">
            <x-admin.order.canceled :orders="$orders" :paymentmethod="$paymentmethod" :image="$image" />
        </div>
    </div>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#pending').DataTable();
            $('#ontheway').DataTable();
            $('#done').DataTable();
            $('#canceled').DataTable();
        });
    </script>
@endsection
