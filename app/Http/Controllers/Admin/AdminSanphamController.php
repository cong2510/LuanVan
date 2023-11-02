<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Sanpham;
use Illuminate\Http\Request;

class AdminSanphamController extends Controller
{
    public function Index()
    {
        $brands = Brand::all();
        $sanphams = Sanpham::query()->with('theloai')->paginate(4);
        return view('admin.sanpham.adminsanpham', [
            'brands' => $brands,
            'sanphams' => $sanphams,
        ]);
    }
}

