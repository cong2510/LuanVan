<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Sanpham;
use Illuminate\Http\Request;

class AdminSanphamController extends Controller
{
    public function AllProduct()
    {
        $brands = Brand::all();
        $sanphams = Sanpham::query()->with('theloai')->paginate(4);
        return view('admin.sanpham.allproduct', [
            'brands' => $brands,
            'sanphams' => $sanphams,
        ]);
    }
}

