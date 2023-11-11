<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Sanpham;
use App\Models\Theloai;
use Illuminate\Http\Request;
use App\Exports\SanphamExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AdminSanphamController extends Controller
{
    public function AllProduct()
    {
        $sanphams = Sanpham::query()->with('theloai')->get();
        $brandsanphams = Brand::all();
        return view('admin.sanpham.allproduct', [
            'sanphams' => $sanphams,
            'brandsanphams' => $brandsanphams,
        ]);
    }

    public function AddProduct()
    {
        $brands = Brand::all();
        $loais = Theloai::all();
        return view('admin.sanpham.addproduct', [
            'brands' => $brands,
            'loais' => $loais,
        ]);
    }

    public function StoreProduct(Request $request)
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'max:300',
                    'unique:sanpham,name'
                ],
                'mota' => [
                    'required',
                    'max:600',
                ],
                'brand' => [
                    'required',
                ],
                'soluong' => [
                    'required',
                    'numeric'
                ],
                'gia' => [
                    'required',
                    'numeric'
                ],
                'loai' => [
                    'required',
                ],
            ],
            [

                'name.required' => "Thiếu tên sản phẩm!",
                'name.max' => "Tên sản phẩm tối đa 300 ký tự",
                'name.unique' => 'Sản phẩm đã tồn tại!',

                'mota.required' => "Thiếu mô tả",
                'mota.max' => "Mô tả tối đa 600 ký tự",

                'brand.requied' => "Hãy chọn thương hiệu",

                'soluong.requied' => "Thiếu số lượng",
                'soluong.numeric' => "Số lượng phải là kiểu số",

                'gia.requied' => "Thiếu giá",
                'gia.numeric' => "Giá phải là kiểu số",

                'loai_id.requied' => "Hãy chọn loại",
            ]
        );

        $sanpham_id = DB::table('sanpham')->insertGetId([
            'name' => $request->name,
            'mota' => $request->mota,
            'brand_id' => $request->brand,
            'soluong' => $request->soluong,
            'gia' => $request->gia,
        ]);

        $data = array();
        $loais = $request->loai;
        foreach ($loais as $key => $loai) {
            $data['sanpham_id'] = $sanpham_id;
            $data['theloai_id'] = $loai;

            DB::table('sanpham_theloai')->insert($data);
        }

        toastr()->success("", 'Thêm sản phẩm thành công', ['timeOut' => 5000]);
        return redirect()->route('all.product');
    }


    public function Export()
    {
        return Excel::download(new SanphamExport(), 'product.xlsx');
    }
}

