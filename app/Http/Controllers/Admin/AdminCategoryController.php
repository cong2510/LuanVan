<?php

namespace App\Http\Controllers\Admin;

use App\Models\Theloai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminCategoryController extends Controller
{
    public function AllCategory()
    {
        $loais = Theloai::all();

        return view('admin.theloai.allcategory', [
            'loais' => $loais,
        ]);
    }

    public function AddCategory()
    {
        return view('admin.theloai.addcategory');
    }

    public function StoreCategory(Request $request)
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:50',
                    'unique:theloai,name'

                ],
            ],
            [
                'name.required' => "Thiếu tên thể loại!",
                'name.string' => "Tên thể loại cần phải là 1 chuỗi ký tự chữ",
                'name.max' => "Tên thể loại tối đa 50 ký tự",
                'name.unique' => 'Thể loại đã tồn tại!',
            ]
        );

        Theloai::create([
            'name' => $request->name,
        ]);
        toastr()->success("", 'Thêm thể loại thành công', ['timeOut' => 1000]);
        return redirect()->route('all.category');
    }

    public function EditCategory($id)
    {
        $loai = Theloai::findOrFail($id);

        return view('admin.theloai.editcategory', [
            'loai' => $loai,
        ]);
    }

    public function UpdateCategory(Request $request)
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
                'name.required' => "Thiếu tên thể loại!",
                'name.string' => "Tên thể loại cần phải là 1 chuỗi ký tự chữ",
                'name.max' => "Tên thể loại tối đa 50 ký tự",

            ]
        );

        $loaiid = $request->id;
        Theloai::findOrFail($loaiid)->update([
            'name' => $request->name,
        ]);

        toastr()->success("", 'Cập nhật thể loại thành công', ['timeOut' => 1000]);
        return redirect()->route('all.category');
    }

    public function DeleteCategory($id)
    {
        $existTheloai = DB::table('sanpham_theloai')->where('theloai_id', $id)->exists();

        if ($existTheloai == true) {
            toastr()->warning("", 'Không thể xóa', ['timeOut' => 100]);
            return redirect()->back();
        } else {
            Theloai::findOrFail($id)->delete();
            toastr()->success("", 'Xóa thể loại thành công', ['timeOut' => 100]);
            return redirect()->route('all.category');
        }
    }
}
