<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Session;
use Exception;

class RazorpayPaymentController extends Controller
{
    public function index()
    {        
        return view('razorpayView');
    }

    public function store(Request $request)
    {
        $input = $request->all();
  
        $api = new Api("rzp_test_wv1pAZWWF0nhYy", "AMR1qZjKgaMDv8TXZ5YIyTDK");
  
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
  
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
  
            } catch (Exception $e) {
                return  $e->getMessage();
                Session::put('error',$e->getMessage());
                return redirect()->back();
            }
        }
          
        Session::put('success', 'Payment successful');
        return redirect()->back();
    }
}
