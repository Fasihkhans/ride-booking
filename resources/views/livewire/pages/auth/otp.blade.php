<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Repositories\UserRepository;
use App\Repositories\VerificationCodeRepository;
use App\Http\Requests\AccountVerificationRequest;
use App\Helpers\Configuration;

// #[Layout('layouts.guest')]
// class VerifyOtp extends Component
new #[Layout('layouts.guest')] class extends Component
{

    public string $email = '';
    public  $otp = [];
    public function mount(): void
    {
        $this->email = request()->string('email');
    }

    /**
     * Handle the OTP verification request.
     */
    public function verify()
    {
        // dd($this->otp);
        // Validate input
        $this->validate([
            'otp' => 'required|array|min:4|max:4',
        ]);

        $this->otp = implode('', $this->otp);
        $email = Crypt::decrypt($this->email);

        $userRepository = new UserRepository();
        $user = $userRepository->getWhere('email', $email);
        if ($userRepository->isVerified($user))
            $this->addError('otp', 'Account already verified.');
        $verificationCodeRepository = new verificationCodeRepository();
        $verificationCode = $verificationCodeRepository->exists($user->id, $this->otp, Configuration::VerificationPurpose('Account Verification'));
        if (!$verificationCode)
            return $this->addError('otp', 'Invalid verification code.');
        if ($verificationCodeRepository->expired($verificationCode))
            return $this->addError('otp', 'Invalid verification code.');
        if (!$verificationCodeRepository->verify($verificationCode))
            return $this->addError('otp', 'Could not verify code.');
        $userRepository->updateStatus($user->id,'active');
        $verificationCodeRepository->use($verificationCode);

        Session::flash('status', 'Account verified successfully!');
        $this->redirect(
            session('url.intended', RouteServiceProvider::HOME),
            navigate: true
        );
    }
}?>
<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit.prevent="verify">

        <h1 class="text-lg font-bold leading-loose text-center text-zinc-950 ">OTP verification</h1>
        <p class="my-2 font-normal text-center text-black text-base/6 sm:text-sm/6 ">We have sent the OTP on your email</p>


        <div class="flex justify-center space-x-4">
            <input type="text" wire:model="otp.0" pattern="[0-9]{1}" maxlength="1" class="w-12 h-12 text-4xl text-center bg-white border border-gray-300 rounded-md shadow-md focus:outline-none focus:border-blue-500" oninput="moveToNextInput(this)">
            <input type="text" wire:model="otp.1" pattern="[0-9]{1}" maxlength="1" class="w-12 h-12 text-4xl text-center bg-white border border-gray-300 rounded-md shadow-md focus:outline-none focus:border-blue-500" oninput="moveToNextInput(this)">
            <input type="text" wire:model="otp.2" pattern="[0-9]{1}" maxlength="1" class="w-12 h-12 text-4xl text-center bg-white border border-gray-300 rounded-md shadow-md focus:outline-none focus:border-blue-500" oninput="moveToNextInput(this)">
            <input type="text" wire:model="otp.3" pattern="[0-9]{1}" maxlength="1" class="w-12 h-12 text-4xl text-center bg-white border border-gray-300 rounded-md shadow-md focus:outline-none focus:border-blue-500" oninput="moveToNextInput(this)">
        </div>

        <x-input-error :messages="$errors->get('otp')" class="mt-2" />

        <div class="flex items-center justify-center mt-4">
            <x-primary-button onclick="getOTP()" class="flex items-center justify-center w-full text-white capitalize rounded-[1.8rem] bg-zinc-800 hover:text-black">
                {{ __('Verify') }}
            </x-primary-button>
        </div>
    </form>
<script>
    function moveToNextInput(input) {
        if (input.value.length === parseInt(input.maxLength)) {
            const nextInput = input.nextElementSibling;
            if (nextInput !== null) {
                nextInput.focus();
            }
        }
    }

    function getOTP() {
        var inputs = document.querySelectorAll('input[type="text"]');
        let otp = "";

        inputs.forEach(function(input) {
                otp += input.value;
        });
        // alert("OTP: " + otp);
        //  window.Livewire.find('otp').set('otp', otp);

    }
</script>

</div>
