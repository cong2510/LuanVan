<?php

namespace App\Http\Controllers;

use App\Models\Sanpham;
use App\Models\Theloai;
use Illuminate\Http\Request;

class SanphamController extends Controller
{
    public function index()
    {
        $sanphams = Sanpham::query()->with('theloai')->paginate(6);
        $theloai = Theloai::all();
        return view('index', [
            'sanphams' => $sanphams,
            'theloai' => $theloai,
        ]);
    }

    public function TrangSanPham()
    {
        $sanphams = Sanpham::query()->with('theloai')->paginate(6);
        $theloai = Theloai::all();
        return view('sanpham', [
            'sanphams' => $sanphams,
            'theloai' => $theloai,
        ]);
    }
}
