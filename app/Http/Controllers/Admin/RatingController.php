<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RatingController extends Controller
{
    public function AllRating()
    {
        $ratings = DB::table('rating')->latest()->get();


        return view('admin.rating.allrating',[
            'ratings' => $ratings,
        ]);
    }

    public function DeleteRating(Request $request)
    {
        $ratingid = $request->ratingid;

        DB::table('rating')->where('id',$ratingid)->delete();

        toastr()->success("", 'Xóa đánh giá thành công', ['timeOut' => 100]);
        return redirect()->back();
    }
}
