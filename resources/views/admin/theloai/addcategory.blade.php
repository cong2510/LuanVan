@extends('admin.indexAdmin')
@section('page_title')
    Thêm thể loại
@endsection
@section('content')
    <style>
        .error {
            color: red;
            font-size: 16px;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('all.category') }}"
                    style="text-decoration: none;" class="text-gray-700">Danh sách thể loại</a>/</span>Thêm thể loại</h4>
        <div class="text-center">
            @if ($errors->any())
                <div class="text-danger h6 text-lg-start fw-bold">
                    Sai nhập liệu...
                </div>
                <ul class="list-group list-unstyled" style="width: 350px">
                    @foreach ($errors->all() as $item)
                        <li class="alert alert-danger">{{ $item }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Thêm thể loại mới</h5>
                    {{-- <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <form id="addCategory" action="{{ route('store.category') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Tên thể loại</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Tên thể loại" />
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Thêm thể loại</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#addCategory').validate({
                rules: {
                    name: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Thiếu tên thể loại!',
                    },
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent());
                }
            });

            $('#name').on('blur', function() {
                $(this).valid(); // Trigger validation on blur event
            });
        });
    </script>
@endsection
