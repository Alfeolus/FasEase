<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\User;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Organization;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $totalUsers = User::count();
        $totalOrganizations = Organization::count();
        $activeUserToday = User::whereDate('login_at', Carbon::today())->count();
        $blockedUsers = User::where('is_active', 0)->count();
        $recentUsers = User::orderBy('created_at', 'desc')->take(10)->get();
        $recentOrganizations = Organization::orderBy('created_at', 'desc')->take(10)->get();

        // User per bulan
        $usersPerDay = User::selectRaw('DATE(created_at) as day, COUNT(*) as count')
            ->whereBetween('created_at', [
                Carbon::now()->subDays(30),
                Carbon::now()
            ])
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('count', 'day')
            ->toArray();

        $userChartLabels = array_map(function ($date) {
            return Carbon::parse($date)->format('d M');
        }, array_keys($usersPerDay));

        $userChartData = array_values($usersPerDay);

        return view('dashboard', compact(
            'totalUsers',
            'totalOrganizations',
            'activeUserToday',
            'blockedUsers',
            'recentUsers',
            'recentOrganizations',
            'userChartLabels',
            'userChartData'
        ));
    }

    public function home_tenant()
    {
        $user = auth()->user();

        if (!$user || !$user->organization) {
            abort(403, 'Organization not found.');
        }

        $orgId = $user->organization_id;
        $pendingBookings = Booking::where('organization_id', $orgId)->where('status', 'pending')->count();
        $activeBookings = Booking::where('organization_id', $orgId)
            ->where('status','approved')
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->count();

        $totalItems = Item::where('organization_id', $orgId)->count();
        $totalCategories = Category::where('organization_id', $orgId)->count();

        $bookingsPerDay = Booking::selectRaw('DATE(created_at) as day, COUNT(*) as count')
            ->where('organization_id', $orgId)
            ->whereBetween('created_at', [
                now()->subDays(30)->startOfDay(),
                now()->endOfDay()
            ])
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('count', 'day')
            ->toArray();

        // Label & data untuk chart
        $bookingChartLabels = array_map(function ($date) {
            return Carbon::parse($date)->format('d M');
        }, array_keys($bookingsPerDay));

        $bookingChartData = array_values($bookingsPerDay);

        $recentRequests = Booking::with(['user', 'item']) 
                            ->where('organization_id', $orgId)
                            ->where('status', 'pending')
                            ->latest()
                            ->take(10)
                            ->get();

        return view('dashboard-admin', [
            'organization' => $user->organization,
            'pendingBookings' => $pendingBookings,
            'activeBookings' => $activeBookings,
            'totalItems' => $totalItems,
            'totalCategories' => $totalCategories,
            'bookingChartLabels' => $bookingChartLabels,
            'bookingChartData' => $bookingChartData,
            'recentRequests' => $recentRequests,
        ]);
    }

    public function home_tenant_user(){
        $user = auth()->user();

        if (!$user || !$user->organization) {
            abort(403, 'Organization not found.');
        }

        $orgId = $user->organization_id;
        $totalBookings = Booking::where('organization_id', $orgId)
            ->where('user_id', $user->id)
            ->count();
        $pendingBookings = Booking::where('organization_id', $orgId)
            ->where('user_id', $user->id)
            ->where('status', 'pending')->count();

        $approvedBookings = Booking::where('organization_id', $orgId)
            ->where('user_id', $user->id)
            ->where('status', 'approved')->count();
        
        $rejectedBookings = Booking::where('organization_id', $orgId)
            ->where('user_id', $user->id)
            ->where('status', 'rejected')->count();
        $categories = Category::where('organization_id', $orgId)->get();
        
        return view('dashboard-user', compact(
            'categories',
            'totalBookings',
            'pendingBookings',
            'approvedBookings',
            'rejectedBookings'
        ));
    }
}
