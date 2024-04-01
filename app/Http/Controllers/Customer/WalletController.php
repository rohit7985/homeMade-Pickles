<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustWallet;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function myWallet()
    {
        try {
            $customer = Auth::user();
            $data = CustWallet::where('user_id', $customer->id)->orderBy('created_at', 'desc')->paginate(10);
            return view('customer.wallet', compact('data'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function filter(Request $request)
    {
        try {
            $query = CustWallet::query();
            // Check if type is selected and filter accordingly
            if ($request->has('type') && $request->type !== '') {
                // dd($request->type);
                $query->where('type', $request->type);
            }
            // // Check if status is selected and filter accordingly
            // if ($request->has('status') && $request->status !== '') {
            //     $query->where('status', $request->status);
            // }
            // Apply orderBy('desc') to sort data in descending order by default
            $query->orderBy('created_at', 'desc');
            // Fetch paginated and filtered data
            $data = $query->paginate(10); // Adjust the number of items per page as needed
            // Return view with filtered and paginated data
            return view('customer.wallet', compact('data'));
        } catch (\Exception $e) {
            // Handle exception
            dd($e);
        }
    }

    public function addMoney(Request $request)
    {
        try {
            $user = auth()->user();
            $data = [
                'user_id' => $user->id,
                'type'  =>  'credit',
                'amount' => $request->amount,
                'description' =>  $request->description ?? '',
                'status' => 1,
            ];
            $wallet = CustWallet::create($data);
            if (($wallet->status == 1) && ($wallet->type == 'credit')) {
                $usr = User::findOrFail($user->id);
                $usr->balence += $wallet->amount;
                $usr->save();
            }
            return redirect()->route('customer.wallet');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    // store credit/debit transaction
    public function store(Request $request)
    {
        $user = auth()->user();
        $data = [
            'type'  =>  'credit',
            'amount' => $request->amount,
            'description' =>  $request->description,
            'status' => 1,
        ];
        $wallet = $user->transactions()
            ->create($data);
        return $wallet;
    }
}
