<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminBrandController extends Controller
{
    public function AllBrand()
    {
        $brands = Brand::all();

        return view('admin.brand.allbrand',[
            'brands' => $brands,
        ]);
    }

    public function AddBrand()
    {
        return view('admin.brand.addbrand');
    }

    public function StoreBrand(Request $request)
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:50',
                    'unique:brand,name'

                ],
            ],
            [
                'name.required' => "Thiếu tên thương hiệu!",
                'name.string' => "Tên thương hiệu cần phải là 1 chuỗi ký tự chữ",
                'name.max' => "Tên thương hiệu tối đa 50 ký tự",
                'name.unique' => 'Thương hiệu đã tồn tại!',
            ]
        );

        Brand::create([
            'name' => $request->name,
        ]);
        toastr()->success("", 'Thêm thương hiệu thành công', ['timeOut' => 1000]);
        return redirect()->route('all.brand');
    }

    public function EditBrand($id)
    {
        $brand = Brand::findOrFail($id);

        return view('admin.brand.editbrand',[
            'brand' => $brand,
        ]);
    }

    public function UpdateBrand(Request $request)
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:50'
                ],
            ],
            [
                'name.required' => "Thiếu tên thương hiệu!",
                'name.string' => "Tên thương hiệu cần phải là 1 chuỗi ký tự chữ",
                'name.max' => "Tên thương hiệu tối đa 50 ký tự",

            ]
        );

        $brand_id = $request->id;
        Brand::findOrFail($brand_id)->update([
            'name' => $request->name,
        ]);

        toastr()->success("", 'Cập nhật thương hiệu thành công', ['timeOut' => 1000]);
        return redirect()->route('all.brand');
    }

    public function DeleteBrand($id)
    {
        $existBrand = DB::table('sanpham')->where('brand_id', $id)->exists();

        if ($existBrand == true) {
            toastr()->warning("", 'Không thể xóa', ['timeOut' => 100]);
            return redirect()->back();
        } else {
            Brand::findOrFail($id)->delete();
            toastr()->success("", 'Xóa thương hiệu thành công', ['timeOut' => 100]);
            return redirect()->route('all.brand');
        }
    }
}
