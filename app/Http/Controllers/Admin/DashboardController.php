<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Sanpham;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function Index()
    {
        $monthlyEarnings = DB::table('order')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(totalprice) as total_earnings')
            )
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->where('order_status', 'Done')
            ->get();

        $annualEarnings = DB::table('order')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(totalprice) as total_earnings')
            )
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->where('order_status', 'Done')
            ->get();

        $currentDate = Carbon::now();
        $currentMonth = $currentDate->month;
        $currentYear = $currentDate->year;
        $tongThang = 0;
        $tongNam = 0;

        foreach ($monthlyEarnings as $monthEarning) {
            if ($monthEarning->year == $currentYear && $monthEarning->month == $currentMonth) {
                $tongThang = $monthEarning->total_earnings;
            }
        }

        foreach ($annualEarnings as $annualEarning) {
            if ($annualEarning->year == $currentYear) {
                $tongNam = $annualEarning->total_earnings;
            }
        }

        $tongOrder = Order::count();
        $tongUser = User::count();

        $paytype = DB::table('paymentmethods')->get();
        $newlyCreatedOrders = Order::latest()->limit(10)->get();

        $favorites = DB::table('sanpham_favorite')
        ->select('sanpham_id', DB::raw('COUNT(*) as count'))
        ->groupBy('sanpham_id')
        ->orderBy('count', 'desc') // Order by the count in descending order
        ->limit(10)->get();

        $sanphams = Sanpham::all();
        // dd($newlyCreatedOrders);

        return view('admin.dashboard',
            [
                'tongThang' => $tongThang,
                'tongNam' => $tongNam,
                'tongOrder' => $tongOrder,
                'tongUser' => $tongUser,
                'newlyCreatedOrders' => $newlyCreatedOrders,
                'paytype' => $paytype,
                'favorites' => $favorites,
                'sanphams' => $sanphams,
            ]);
    }
}
