<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Brand;
use App\Models\Image;
use App\Models\Rating;
use App\Models\Sanpham;
use App\Models\Theloai;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SanphamController extends Controller
{
    public function index()
    {
        $sanphams = Sanpham::query()->with('theloai')->get();
        $theloai = Theloai::all();
        $role = Role::all();
        $image = Image::all();
        $brand = Brand::all();

        $loaidochoi = DB::table('theloai')->where('id',3)->value('id');
        $dochoitheloai = Sanpham::whereHas('theloai', function ($query) use ($loaidochoi) {
            $query->where('theloai_id', $loaidochoi);
        })->get();

        $favorites = DB::table('sanpham_favorite')
        ->select('sanpham_id', DB::raw('COUNT(*) as count'))
        ->groupBy('sanpham_id')
        ->orderBy('count', 'desc') // Order by the count in descending order
        ->get();


        return view('index', [
            'sanphams' => $sanphams,
            'theloai' => $theloai,
            'role' => $role,
            'brand' => $brand,
            'image' => $image,
            'dochoitheloai' => $dochoitheloai,
            'favorites' => $favorites,
            'loaidochoi' => $loaidochoi
        ]);
    }

    public function TrangSanPham(Request $request)
    {
        $allsanphams = Sanpham::query()->with('theloai')->get();
        $sanphams = Sanpham::query()->with('theloai');
        $theloai = Theloai::all();
        $role = Role::all();
        $image = Image::all();
        $brand = Brand::all();

        $allProduct = count($allsanphams);
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
        $sanphamsort = $sanphamsort->paginate(12);
        // $sanphamsort->appends($request->except('page'));

        return view('product', [
            'sanphamsort' => $sanphamsort,
            'theloai' => $theloai,
            'role' => $role,
            'image' => $image,
            'allProduct' => $allProduct,
            'loaiSanphams' => $loaiSanphams,
            'brand' => $brand,
        ]);
    }

    public function TrangSanPhamTheLoai($id, Request $request)
    {
        $theloai = Theloai::all();
        $role = Role::all();
        $image = Image::all();
        $brand = Brand::all();
        $loaisp = DB::table('theloai')->where('id', $id)->first();
        $loaiSanphams = DB::table('sanpham_theloai')->where('theloai_id', $id)->get();

        $sanphams = Sanpham::whereHas('theloai', function ($query) use ($id) {
            $query->where('theloai_id', $id);
        });

        //sort
        $sortBy = $request->get('sortBy');

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
        $sanphamsort = $sanphamsort->paginate(12);
        // $sanphamsort->appends($request->except('page'));
        $allProduct = count($sanphamsort);

        // dd($sanphamsort);

        return view('producttheloai', [
            'allProduct' => $allProduct,
            'sanphamsort' => $sanphamsort,
            'theloai' => $theloai,
            'role' => $role,
            'image' => $image,
            'loaiSanphams' => $loaiSanphams,
            'brand' => $brand,
            'loaisp' => $loaisp,
        ]);
    }

    public function TrangSanPhamBrand($id, Request $request)
    {
        $theloai = Theloai::all();
        $role = Role::all();
        $image = Image::all();
        $brand = Brand::all();
        $loaibrand = DB::table('brand')->where('id', $id)->first();
        $loaiSanphams = DB::table('sanpham_theloai')->where('theloai_id', $id)->get();

        $sanphams = Sanpham::query()->where('brand_id',$id);

        //sort
        $sortBy = $request->get('sortBy');

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
        $sanphamsort = $sanphamsort->paginate(12);
        // $sanphamsort->appends($request->except('page'));
        $allProduct = count($sanphamsort);

        // dd($sanphamsort);

        return view('productbrand', [
            'allProduct' => $allProduct,
            'sanphamsort' => $sanphamsort,
            'theloai' => $theloai,
            'role' => $role,
            'image' => $image,
            'loaiSanphams' => $loaiSanphams,
            'brand' => $brand,
            'loaibrand' => $loaibrand,
        ]);
    }

    public function DetailSanpham($id)
    {
        $user = Auth::user();
        Carbon::setLocale('vi');

        $sanpham = Sanpham::findOrFail($id);
        $brand = Brand::all();
        $image = Image::all();
        $role = Role::all();
        $theloai = Theloai::all();
        $loaiSanphams = DB::table('sanpham_theloai')->get();

        // $favorites = Favorite::with('sanpham')->where('user_id', $user->id)->get();
        $favorites = Favorite::with('sanpham')->get();

        $sanphamfavorite = DB::table('sanpham_favorite')->where('sanpham_id',$id)->get();
        $allfavorite = count($sanphamfavorite);

        // $reviews = DB::table('rating')->where('sanpham_id',$id)->get();
        $reviews = Rating::query()->where('sanpham_id',$id)->paginate(5);
        $users = DB::table('users')->get();

        $averageRating = DB::table('rating')
        ->where('sanpham_id', $id)
        ->avg('rating');

        // $averageRating =3.25;
        // dd($averageRating);
        $theloaisanpham = DB::table('sanpham_theloai')->where('sanpham_id',$id)->value('theloai_id');
        $similars = Sanpham::whereHas('theloai', function ($query) use ($theloaisanpham) {
            $query->where('theloai_id',$theloaisanpham);
        })->take(4)->inRandomOrder()->get();

        $allreviews = Rating::query()->where('sanpham_id',$id)->count();

        return view('productdetail', [
            'sanpham' => $sanpham,
            'image' => $image,
            'role' => $role,
            'theloai' => $theloai,
            'loaiSanphams' => $loaiSanphams,
            'brand' => $brand,
            'favorites' => $favorites,
            'allfavorite' => $allfavorite,
            'reviews' =>$reviews,
            'users' => $users,
            'allreviews' => $allreviews,
            'averageRating' => $averageRating,
            'similars' => $similars,
        ]);
    }

    public function TrangTimKiem(Request $request)
    {
        $sanphams = Sanpham::query()->with('theloai');
        $theloai = Theloai::all();
        $brand = Brand::all();
        $role = Role::all();
        $image = Image::all();

        $loaiSanphams = DB::table('sanpham_theloai')->get();

        $search = $request->get('search');

        if ($search) {
            $sanphamsort = $sanphams->where('name', 'like', '%' . $search . '%');
            $sanphamsort = $sanphamsort->paginate(12);
            $sanphamsort->appends($request->except('page'));
            $allProduct = count($sanphamsort);
        } else {
            return redirect()->back();
        }


        return view('search', [
            'sanphamsort' => $sanphamsort,
            'theloai' => $theloai,
            'role' => $role,
            'image' => $image,
            'loaiSanphams' => $loaiSanphams,
            'allProduct' => $allProduct,
            'brand' => $brand,
        ]);
    }

}
