<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Sanpham;
use App\Models\Theloai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SanphamController extends Controller
{
    public function index()
    {
        $sanphams = Sanpham::query()->with('theloai')->paginate(6);
        $theloai = Theloai::all();
        $role = Role::all();
        return view('index', [
            'sanphams' => $sanphams,
            'theloai' => $theloai,
            'role' => $role,
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
