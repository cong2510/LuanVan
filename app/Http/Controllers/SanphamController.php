<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Brand;
use App\Models\Image;
use App\Models\Sanpham;
use App\Models\Theloai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SanphamController extends Controller
{
    public function index()
    {
        $sanphams = Sanpham::query()->with('theloai')->get();
        $theloai = Theloai::all();
        $role = Role::all();
        $sanpham_image = Image::all();
        return view('index', [
            'sanphams' => $sanphams,
            'theloai' => $theloai,
            'role' => $role,
            'sanpham_image' => $sanpham_image,
        ]);
    }

    public function TrangSanPham(Request $request)
    {
        $sanphams = Sanpham::query()->with('theloai');
        $theloai = Theloai::all();
        $role = Role::all();
        $image = Image::all();

        $loaiSanphams = DB::table('sanpham_theloai')->get(); //Để tính tát cả sản phẩm của mỗi thể loại

        //sort
        $sortBy = $request->get('sortBy');
        // $sanphamQuery = Sanpham::query()->with('theloai');

        if ($sortBy) {
            if ($sortBy == 'highest') {
                $sanphamsort = $sanphams->orderBy('gia', 'desc');
            } elseif ($sortBy == 'lowest') {
                $sanphamsort = $sanphams->orderBy('gia', 'asc');
            } elseif ($sortBy == 'AZ') {
                $sanphamsort = $sanphams->orderBy('name', 'asc');
            } elseif ($sortBy == 'ZA') {
                $sanphamsort = $sanphams->orderBy('name', 'desc');
            }
        } else {
            // If no sort option is selected, get all games with default sorting
            $sanphamsort = $sanphams;
        }
        $sanphamsort = $sanphamsort->paginate(9);
        $sanphamsort->appends($request->except('page'));
        $allProduct = count($sanphamsort);

        return view('sanpham.product', [
            'sanphamsort' => $sanphamsort,
            'theloai' => $theloai,
            'role' => $role,
            'image' => $image,
            'allProduct' => $allProduct,
            'loaiSanphams' => $loaiSanphams,
        ]);
    }


    public function TrangSanPhamTheLoai($id, Request $request)
    {
        $sanphams = Sanpham::query()->with('theloai');
        $image = Image::all();
        $role = Role::all();
        $theloai = Theloai::all();

        $loaiSanphams = DB::table('sanpham_theloai')->get();
        $loaiSanpham = DB::table('theloai')->where('id', $id)->first();
        $product = DB::table('sanpham_theloai')->where('theloai_id', $id)->get();

        //sort
        $sortBy = $request->get('sortBy');
        // $sanphamQuery = Sanpham::query()->with('theloai');

        if ($sortBy) {
            if ($sortBy == 'highest') {
                $sanphamsort = $sanphams->orderBy('gia', 'desc');
            } elseif ($sortBy == 'lowest') {
                $sanphamsort = $sanphams->orderBy('gia', 'asc');
            } elseif ($sortBy == 'AZ') {
                $sanphamsort = $sanphams->orderBy('name', 'asc');
            } elseif ($sortBy == 'ZA') {
                $sanphamsort = $sanphams->orderBy('name', 'desc');
            }
        } else {
            // If no sort option is selected, get all games with default sorting
            $sanphamsort = $sanphams;
        }
        $sanphamsort = $sanphamsort->paginate(9);
        $sanphamsort->appends($request->except('page'));
        $allProduct = count($sanphamsort);

        return view('sanpham.producttheloai', [
            'loaiSanpham' => $loaiSanpham,
            'sanphamsort' => $sanphamsort,
            'image' => $image,
            'role' => $role,
            'theloai' => $theloai,
            'product' => $product,
            'allProduct' => $allProduct,
            'loaiSanphams' => $loaiSanphams,
        ]);
    }

    public function DetailSanpham($id)
    {
        $sanpham = Sanpham::findOrFail($id);
        $brands = Brand::all();
        $image = Image::all();
        $role = Role::all();
        $theloai = Theloai::all();
        $loaiSanphams = DB::table('sanpham_theloai')->get();

        return view('productdetail', [
            'sanpham' => $sanpham,
            'image' => $image,
            'role' => $role,
            'theloai' => $theloai,
            'loaiSanphams' => $loaiSanphams,
            'brands' => $brands,
        ]);
    }

    public function TrangTimKiem(Request $request)
    {
        $sanphams = Sanpham::query()->with('theloai');
        $theloai = Theloai::all();
        $role = Role::all();
        $image = Image::all();

        $loaiSanphams = DB::table('sanpham_theloai')->get();

        $search = $request->get('search');

        if ($search) {
            $sanphamsort = $sanphams->where('name', 'like', '%' . $search . '%');
            $sanphamsort = $sanphamsort->paginate(9);
            $sanphamsort->appends($request->except('page'));
            $allProduct = count($sanphamsort);
        }else{
            return redirect()->back();
        }


        return view('search', [
            'sanphamsort' => $sanphamsort,
            'theloai' => $theloai,
            'role' => $role,
            'image' => $image,
            'loaiSanphams' => $loaiSanphams,
            'allProduct' => $allProduct,
        ]);
    }

}
