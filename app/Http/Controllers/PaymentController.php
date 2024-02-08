<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(){
        // $user = User::find(auth()->user()->id);
        // $method = $user->customerPaymentMethods();
        dd('asd');
        return view('payment-details', [
            'intent' => 'ride charge'
        ]);

    }

    // public function store(Request $request)
    // {
    //     $user = Auth::user();

    //     $card = $user->customerPaymentMethods->updateCard($request->stripeToken);

    //     dd($card);
    //     // You can add additional logic here, such as redirecting the user or displaying a success message.
    // }
}
