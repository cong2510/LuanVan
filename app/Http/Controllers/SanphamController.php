<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Role;
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

    public function TrangSanPham()
    {
        $sanphams = Sanpham::query()->with('theloai')->paginate(6);
        $theloai = Theloai::all();
        $role = Role::all();
        return view('sanpham', [
            'sanphams' => $sanphams,
            'theloai' => $theloai,
            'role' => $role,
        ]);
    }
}
