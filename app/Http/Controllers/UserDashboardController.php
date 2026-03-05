<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = Order::with(['product', 'vehicle', 'tripSchedule.vehicle', 'rentalSchedule', 'packageRentalSchedule'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(20);

        $stats = [
            'total'     => $orders->count(),
            'completed' => $orders->where('status', 'completed')->count(),
            'pending'   => $orders->where('status', 'pending')->count(),
        ];

        return view('pages.dashboard', compact('orders', 'stats'));
    }
}
