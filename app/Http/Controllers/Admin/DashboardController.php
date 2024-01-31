<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Count total users
            $totalUsers = User::count();

            // Count total orders
            $totalOrders = Order::count();

            // Count total products
            $totalProducts = Product::count();

            // Count pending orders (assuming there's a 'status' column in the orders table)
            $pendingOrders = Order::where('status', 'pending')->count();
            return view('admin.index', compact('totalUsers', 'totalOrders', 'totalProducts', 'pendingOrders'));
        } catch (\Exception $e) {
            // Handle exceptions if needed
            return [
                'error' => $e->getMessage(),
            ];
        }
    }
}
