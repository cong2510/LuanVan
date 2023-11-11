@extends('admin.indexAdmin')
@section('page_title')
    Sửa role cho user
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1 class="h3 mb-2 text-gray-800">Sửa role cho user</h1>
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
                    <h5 class="mb-0">Sửa role user</h5>
                    {{-- <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.update.user',$user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Email:</label>
                            <div class="col-sm-10">
                                <h3>{{ $user->email }}</h3>
                            </div>
                        </div>
                        <br>
                        <div class="col-9">
                            @foreach ($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $role->name }}"
                                        id="flexCheckDefault{{ $role->id }}" name="role[]" {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexCheckDefault{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                            <br>
                        </div>
                        <br>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#CheckDefaultAll').click(function() {
            if ($(this).is(':checked')) {
                $('input[ type= checkbox]').prop('checked', true);
            } else {
                $('input[ type= checkbox]').prop('checked', false);
            }
        });
    </script>
@endsection