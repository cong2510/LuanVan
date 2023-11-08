@extends('admin.indexAdmin')
@section('page_title')
    Import
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('all.permission') }}"
                    style="text-decoration: none;" class="text-gray-700">Danh sách quyền</a>/</span>Import</h4>
        <div class="text-center">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <a class="btn btn-danger" href="{{ route('export') }}" role="button">Download Xlsx</a>&nbsp;
                    </div>
                    <div class="card-body">
                        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                @foreach ($errors->all() as $item)
                                    <li class="alert alert-danger">{{ $item }}</li>
                                @endforeach
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Import file xlsx</label>
                                <div class="col-sm-5">
                                    <input type="file" class="form-control" id="importfile" name="importfile"
                                        placeholder="Chọn thư mục" />
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
