<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Cart;
use App\Models\CustWallet;
use App\Models\User;
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
            $customer = Address::where('user_id', $validatedData['userId'])->first();
            if ($customer) {
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
                        $user = auth()->user();
                        $data = [
                            'user_id' => $user->id,
                            'type'  =>  'debit',
                            'amount' => $order->total_amount + 60,
                            'description' => 'Buy Products',
                            'status' => 1,
                        ];
                        $wallet = CustWallet::create($data);
                        $usr = User::findOrFail($user->id);
                        $usr->balence -= $wallet->amount;
                        $usr->save();
                        Cart::where('user_id', $validatedData['userId'])->delete();
                        return redirect()->route('customer.myOrder');
                    }
                } else {
                    return redirect()->route('customer.cart')->with('error', 'Your Cart is empty, Please select atleast one Item');
                }
            } else {
                return redirect()->route('customer.cart')->with('error', 'Please add delivery address');
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
