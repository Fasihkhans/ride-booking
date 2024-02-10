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
        // $user = User::find(auth()->user()->id);
        // $method = $user->customerPaymentMethods();
        dd('asd');
        return view('payment-details', [
            'intent' => 'ride charge'
        ]);

    }

    public function store(Request $request)
    {

        // dd(json_decode($request->stripeToken, true));

        //    Auth::user()->id

           $method = $this->iCustomerPaymentMethodsRepository::create([
            'user_id'=>Auth::user()->id,
            'name' => "card",
            'stripe_card_reference' => json_encode(['token'=>json_decode($request->stripeToken)]),
            'is_default'=>false,
            'status' => Constants::ACTIVE
        ]);

        dd($method);

            // Stripe::setApiKey(env('STRIPE_SECRET'));


        // $paymentMethod = PaymentMethod::create([
        //     'type' => 'card',
        //     'card' => [
        //         'token' => $request->stripeToken,
        //     ],
        // ]);
        // dd($paymentMethod);
        // $user = Auth::user();

        // $card = $user->customerPaymentMethods->updateCard($request->stripeToken);

        // dd($card);
        // You can add additional logic here, such as redirecting the user or displaying a success message.
    }
}
