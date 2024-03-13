<?php

namespace App\Http\Controllers\Merchants;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MerchantOrderController extends Controller
{
    public function index()
    {
        try {
            $merchant_id = Auth::user()->id;
            $orders = Order::where('merchant_id',$merchant_id)->orderBy('created_at', 'desc')->paginate(6);
            // dd($orders);
            return view('merchant.orders', compact('orders'));
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

            return view('merchant.orders', compact('orders'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function cancelledOrder(Request $request, Order $order)
    {
        try {
            $order->status = '2';
            $order->save();
            if ($request->ajax()) {
                return response()->json(['success' => 'Product Cancelled successfully!']);
            }else{
                return response()->json(['error' => 'Something went Wrong']);
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
