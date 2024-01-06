<?php

namespace App\Http\Controllers;

use App\Jobs\SendMail;
use App\Mail\HelpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HelpController extends Controller
{
    public function sendMail(Request $request)
    {
        $vaildate = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);
        $adminEmail = "katiestokell@icloud.com";
        SendMail::dispatch($adminEmail,new HelpMail($vaildate));
        return redirect()->route('welcome')
        ->with(['success' => 'Thank you for contact us. we will contact you shortly.']);
    }

}
