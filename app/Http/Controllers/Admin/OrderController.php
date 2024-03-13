<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Helpers\RatingHelper;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $orders = Order::orderBy('created_at', 'desc')->paginate(6);
            return view('admin.orders', compact('orders'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function markCompleted($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->update(['status' => '1']);
            return response()->json(['message' => 'Order marked as completed successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to mark order as completed'], 500);
        }
    }

    public function searchProduct(Request $request)
    {
        try {
            $query = $request->input('query');
            if ($query != '') {
                $users = Product::where('product', 'like', '%' . $query . '%')->get();
            } else {
                $users = Product::where('product', $query)->get();
            }
            return response()->json($users);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function filterOrders(Request $request)
    {
        try {
            // Retrieve the form input values
            $status = $request->input('status');
            $customerName = $request->input('name');
            $productName = $request->input('product');

            $orders = Order::select('orders.*', 'users.status as customer_status', 'products.product as product_name')
                ->join('users', 'orders.customer_id', '=', 'users.id')
                ->leftJoin('products', 'products.id', '=', DB::raw("JSON_UNQUOTE(JSON_EXTRACT(`orders`.`details`, '$.product_id'))"))
                ->when($status !== null, function ($query) use ($status) {
                    return $query->where('orders.status', $status);
                })
                ->when($customerName !== null, function ($query) use ($customerName) {
                    return $query->where('users.name', 'like', '%' . $customerName . '%');
                })
                ->when($productName !== null, function ($query) use ($productName) {
                    return $query->where('products.product', 'like', '%' . $productName . '%');
                })
                ->orderBy('orders.created_at', 'desc') // Order by descending creation date
                ->paginate(10)->appends($request->except('page'));

            $request->flash(); // Retain form input values on page reload

            return view('admin.orders', compact('orders'));
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
