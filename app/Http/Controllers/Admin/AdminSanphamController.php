<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Image as ImageModel;
use App\Models\Sanpham;
use App\Models\Theloai;
use Illuminate\Http\Request;
use App\Exports\SanphamExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;


class AdminSanphamController extends Controller
{
    public function AllProduct()
    {
        $sanphams = Sanpham::query()->with('theloai')->get();
        $brandsanphams = Brand::all();
        $image = DB::table('image')->get();
        return view('admin.sanpham.allproduct', [
            'sanphams' => $sanphams,
            'brandsanphams' => $brandsanphams,
            'image' => $image,
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
                'hinh' => [
                    'required',
                ],
                'hinh.*' => [
                    'mimes:jpeg,jpg,png,gif,csv,txt,pdf|max:2048',
                    'image',
                    'max:5048',
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

                'loai.requied' => "Hãy chọn loại",

                'hinh.required' => 'Thiếu hình ảnh!',

                'hinh.*.max' => 'Hình ảnh không quá 5MB!',
                'hinh.*.mimes' => 'Định dạng ảnh không hợp lệ',
                'hinh.*.image' => 'Hình ảnh không hợp lệ',
            ]
        );
        // dd($request);
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

        if ($request->hasFile('hinh')) {
            $hinhs = $request->file('hinh');
            foreach ($hinhs as $hinh) {
                //Tao temp hinh anh
                $image_temp = Image::make($hinh);
                //Lay Extension hinh anh
                $extension = $hinh->getClientOriginalExtension();
                //Tao ten cho hinh
                $image_name = 'sanpham-' . rand(1111, 9999999) . '.' . $extension;
                //Dia chi thu muc
                $image_path = public_path('images/Sanpham/' . $image_name);

                Image::make($image_temp)->resize(600, 700)->save($image_path);

                //Them vao database
                DB::table('image')->insert([
                    'image' => $image_name,
                    'sanpham_id' => $sanpham_id,
                ]);
            }
        }




        toastr()->success("", 'Thêm sản phẩm thành công', ['timeOut' => 1000]);
        return redirect()->route('all.product');
    }


    public function Export()
    {
        return Excel::download(new SanphamExport(), 'product.xlsx');
    }

    public function EditProduct($id)
    {
        $sanpham = Sanpham::findOrFail($id);
        $brands = Brand::all();
        $loais = Theloai::all();
        $sanpham_theloai = DB::table('sanpham_theloai')->get();
        $sanpham_hinh = DB::table('image')->get();

        return view('admin.sanpham.editproduct', [
            'sanpham' => $sanpham,
            'brands' => $brands,
            'loais' => $loais,
            'sanpham_theloai' => $sanpham_theloai,
            'sanpham_hinh' => $sanpham_hinh,
        ]);
    }

    public function UpdateProduct(Request $request, $id)
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'max:300',
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
                'hinh.*' => [
                    'mimes:jpeg,jpg,png,gif,csv,txt,pdf|max:2048',
                    'image',
                    'max:5048',
                ],
            ],
            [

                'name.required' => "Thiếu tên sản phẩm!",
                'name.max' => "Tên sản phẩm tối đa 300 ký tự",

                'mota.required' => "Thiếu mô tả",
                'mota.max' => "Mô tả tối đa 600 ký tự",

                'brand.requied' => "Hãy chọn thương hiệu",

                'soluong.requied' => "Thiếu số lượng",
                'soluong.numeric' => "Số lượng phải là kiểu số",

                'gia.requied' => "Thiếu giá",
                'gia.numeric' => "Giá phải là kiểu số",

                'loai_id.requied' => "Hãy chọn loại",

                'hinh.*.max' => 'Hình ảnh không quá 5MB!',
                'hinh.*.mimes' => 'Định dạng ảnh không hợp lệ',
                'hinh.*.image' => 'Hình ảnh không hợp lệ',
            ]
        );
        DB::beginTransaction();
        try {
            DB::table('sanpham')->where('id', '=', $id)->update([
                'name' => $request->name,
                'mota' => $request->mota,
                'brand_id' => $request->brand,
                'soluong' => $request->soluong,
                'gia' => $request->gia,
            ]);

            $data = array();
            $loais = $request->loai;
            DB::table('sanpham_theloai')
                ->where('sanpham_id', '=', $id)
                ->delete();

            foreach ($loais as $key => $loai) {
                if ($loai == 0) {
                    continue;
                } else {
                    $data['sanpham_id'] = $id;
                    $data['theloai_id'] = $loai;

                    DB::table('sanpham_theloai')->insert($data);
                }
            }

            if ($request->hasFile('hinh')) {
                $hinhs = $request->file('hinh');
                foreach ($hinhs as $hinh) {
                    //Tao temp hinh anh
                    $image_temp = Image::make($hinh);
                    //Lay Extension hinh anh
                    $extension = $hinh->getClientOriginalExtension();
                    //Tao ten cho hinh
                    $image_name = 'sanpham-' . rand(1111, 9999999) . '.' . $extension;
                    //Dia chi thu muc
                    $image_path = public_path('images/Sanpham/' . $image_name);

                    Image::make($image_temp)->resize(600, 700)->save($image_path);

                    //Them vao database
                    DB::table('image')->insert([
                        'image' => $image_name,
                        'sanpham_id' => $id,
                    ]);
                }
            }


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error('', 'Something went wrong');
            return redirect()->back();
        }

        toastr()->success("", 'Cập nhật sản phẩm thành công', ['timeOut' => 1000]);
        return redirect()->route('all.product');
    }

    public function DeleteProduct($id)
    {
        $imageProduct = DB::table('image')->where('sanpham_id', $id)->get();

        foreach ($imageProduct as $imagePro) {
            $image_path = public_path('images/Sanpham/' . $imagePro->image);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        Sanpham::findOrfail($id)->delete();
        DB::table('sanpham_theloai')
            ->where('sanpham_id', '=', $id)
            ->delete();

        DB::table('image')
            ->where('sanpham_id', '=', $id)
            ->delete();



        toastr()->success('', 'Xóa thành công');
        return redirect()->back();
    }

    public function DeleteProductImage($id)
    {
        $imageProduct = DB::table('image')->where('id', $id)->first();
        $image_path = public_path('images/Sanpham/' . $imageProduct->image);

        if (File::exists($image_path)) {
            File::delete($image_path);
        }

        DB::table('image')->where('id', $id)->delete();

        return redirect()->back()->with('success','Xóa hình thành công');
    }
}

