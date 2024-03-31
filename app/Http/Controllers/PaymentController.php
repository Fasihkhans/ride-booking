<?php

namespace App\Http\Controllers;

use App\Constants\Constants;
use App\Interfaces\ICustomerPaymentMethodsRepository;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\PaymentMethod;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function __construct(private ICustomerPaymentMethodsRepository $iCustomerPaymentMethodsRepository){}
    public function index(){
        dd('asd');
        return view('payment-details', [
            'intent' => 'ride charge'
        ]);

    }

    public function store(Request $request)
    {
           $method = $this->iCustomerPaymentMethodsRepository::create([
            'user_id'=>Auth::user()->id,
            'name' => "card",
            'stripe_card_reference' => json_encode(['token'=>['id'=>$request->stripeToken,'card'=>$request->cardDetails]]),
            'is_default'=>false,
            'status' => Constants::ACTIVE
        ]);

        return redirect(route('payment'));
    }
}
