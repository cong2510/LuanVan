@extends('admin.indexAdmin')
@section('page_title')
    Thêm role
@endsection
@section('content')
    <style>
        .error {
            color: red;
            font-size: 16px;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('all.roles.permission') }}"
                    style="text-decoration: none;" class="text-gray-700">Danh sách role</a>/</span>Thêm role</h4>
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
                    <h5 class="mb-0">Thêm role mới</h5>
                    {{-- <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <form id="addRole" action="{{ route('store.roles') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Tên role</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Tên role" />
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Thêm role</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#addRole').validate({
                rules: {
                    name: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Thiếu tên role!',
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
