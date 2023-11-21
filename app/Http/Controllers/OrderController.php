<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Brand;
use App\Models\Image;
use App\Models\Sanpham;
use App\Models\Theloai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function Cart()
    {
        $sanphams = Sanpham::query()->with('theloai')->get();
        $theloai = Theloai::all();
        $role = Role::all();
        $image = Image::all();
        $brands = Brand::all();
        $sanpham_theloai = DB::table('sanpham_theloai')->get();

        return view('cart', [
            'sanphams' => $sanphams,
            'theloai' => $theloai,
            'role' => $role,
            'image' => $image,
            'brands' => $brands,
            'sanpham_theloai' => $sanpham_theloai,
        ]);
    }

    public function AddToCart(Request $request)
    {
        // dd($request);
        $id = $request->get('id');
        $sanpham = Sanpham::findOrFail($id);
        $hinh = DB::table('image')->where('sanpham_id', $id)->first();

        $soluong = $request->soluong;


        // session()->put('cart', null);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['soluong'] + $soluong > $sanpham->soluong) {
                toastr()->warning('', 'Đã đạt tối đa sản phẩm!');
                return redirect()->back();
            }
        }

        // If the game already in the cart, increase the amount
        if (isset($cart[$id])) {
            if (isset($soluong)) {
                $cart[$id]['soluong'] = $cart[$id]['soluong'] + $soluong;
            } else {
                $cart[$id]['soluong'] = $cart[$id]['soluong'] + 1;
            }
        } else {
            if ($soluong != null) {
                $cart[$id] = [
                    'id' => $sanpham->id,
                    'name' => $sanpham->name,
                    'gia' => $sanpham->gia,
                    'image' => $hinh,
                    'soluong' => $soluong,
                    'brand_id' => $sanpham->brand_id,
                ];
            } else {
                $cart[$id] = [
                    'id' => $sanpham->id,
                    'name' => $sanpham->name,
                    'gia' => $sanpham->gia,
                    'image' => $hinh,
                    'soluong' => 1,
                    'brand_id' => $sanpham->brand_id,
                ];
            }
        }

        session()->put('cart', $cart);
        toastr()->success('', 'Thêm vào giỏ hàng thành công');
        return redirect()->back();
    }

    public function RemoveItem(Request $request)
    {
        // If has the id, remove it
        $cart = session()->get('cart');
        if ($request->id) {
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            toastr()->success('', 'Xóa sản phẩm thành công');
            return redirect()->back();
        }
        // If the request has 'clear_all', remove the entire cart
        if ($request->has('clear_all')) {
            session()->put('cart', null);

            toastr()->success('', 'Xóa giỏ hàng thành công');
            return redirect()->back();
        }
        return redirect()->back()->with('unknow_error', "Something went wrong");
    }

    public function UpdateItem(Request $request)
    {
        $sanpham = Sanpham::findOrFail($request->id);
        $id = $request->id;
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            if ($request->down == "true") {
                if ($cart[$id]['soluong'] == 1) {
                    return redirect()->back();
                } else {
                    $cart[$id]['soluong'] = $cart[$id]['soluong'] - 1;
                    session()->put('cart', $cart);
                    return redirect()->back();
                }
            } elseif ($request->up == "false") {
                if ($cart[$id]['soluong'] == $sanpham->soluong) {
                    return redirect()->back();
                } else {
                    $cart[$id]['soluong'] = $cart[$id]['soluong'] + 1;
                    session()->put('cart', $cart);
                    return redirect()->back();
                }
            }
        } else {
            toastr()->warning('', 'Loi');
            return redirect()->back();
        }
    }
}
