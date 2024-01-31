<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'userId' => 'required',
                'totalPrice' => 'required|numeric',
                'items' => 'required',
            ]);

            $items = json_decode($request->items, true);
            if (!empty($items)) {
                foreach ($items as $item) {
                    $data =  [
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity']
                    ];
                    $orderDetails = json_encode($data);
                    $order = Order::create([
                        'customer_id' => $validatedData['userId'],
                        'total_amount' => $validatedData['totalPrice'],
                        'status' => '0',
                        'details' => $orderDetails,
                    ]);
                }
                if ($order) {
                    Cart::where('user_id', $validatedData['userId'])->delete();
                    return redirect()->route('customer.cart')->with('success', 'Thank You for your Order');
                }
            }
            else{
                return redirect()->route('customer.cart')->with('error', 'Your Cart is empty, Please select atleast one Item');
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
