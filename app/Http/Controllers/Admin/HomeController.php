<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Contact; // Assuming you have this from the previous task
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // <--- Import DB Facade


class HomeController extends Controller
{
    //
public function index()
    {
        // 4. Return Vie// 1. STATS (Keep existing logic)
        $today = Carbon::today();
        $todaySalesCount = Order::whereDate('created_at', $today)->where('status', 'completed')->count();
        $totalSalesCount = Order::where('status', 'completed')->count();

        $todayRevenue = Order::whereDate('created_at', $today)->where('status', 'completed')
            ->with('book')->get()->sum(fn($o) => $o->book->sale_price ?? $o->book->price);

        $totalRevenue = Order::where('status', 'completed')
            ->with('book')->get()->sum(fn($o) => $o->book->sale_price ?? $o->book->price);

        // 2. RECENT ORDERS (Keep existing)
        $recentOrders = Order::with(['user', 'book'])->where('status', 'completed')->latest()->take(5)->get();

        // 3. MESSAGES (Keep existing)
        $recentMessages = class_exists(Contact::class) ? Contact::latest()->take(4)->get() : [];

        // --- NEW ADDITIONS ---

        // 4. TOP SELLING BOOKS (Group orders by book_id and count them)
        $topBooks = Order::where('status', 'completed')
            ->select('book_id', DB::raw('count(*) as sales_count'))
            ->groupBy('book_id')
            ->orderByDesc('sales_count')
            ->take(5)
            ->with('book')
            ->get();

        // 5. NEWEST USERS
        $newUsers = User::where('role', 'user')->latest()->take(5)->get();
        return view('screens.admin.index', get_defined_vars());
    }
}
