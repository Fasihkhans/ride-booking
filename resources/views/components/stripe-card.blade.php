<div>
    <div>
        <form action="{{ route('save-card') }}" method="POST" id="payment-form">
            @csrf
            <div class="mt-4 form-group">
                <div class="m-1 form-group">
                    <label for="card-number-element">Card Number</label>
                    <div id="card-number-element" class="StripeElement"></div>
                    <!-- Error element for card number -->
                    <div id="card-number-errors" role="alert"></div>
                </div>

                <div class="flex justify-between w-full">
                    <div class="w-full m-1 form-group">
                        <label for="card-expiry-element">Expiration Date</label>
                        <div id="card-expiry-element" class="StripeElement"></div>
                        <!-- Error element for expiry -->
                        <div id="card-expiry-errors" role="alert"></div>
                    </div>
                    <div class="w-full m-1 form-group">
                        <label for="card-cvc-element">CVC</label>
                        <div id="card-cvc-element" class="StripeElement"></div>
                        <!-- Error element for CVC -->
                        <div id="card-cvc-errors" role="alert"></div>
                    </div>
                </div>
                <div id="card-errors" role="alert"></div>
            </div>

            <div class="flex items-center justify-center mt-4">

                <x-primary-button  id="submit-button" class="flex items-center justify-center w-full text-white capitalize rounded-[1.8rem] bg-zinc-800 hover:text-black">
                    {{ __('Continue') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    {{-- @head --}}
    <script src="https://js.stripe.com/v3/"></script>
    {{-- @endhead --}}

    @once
    <script>
        // Create a Stripe client.
        var stripe = Stripe('pk_test_51OgvOQEcKRugJstRJRTS0pmKarGtYPqz2mpsIIIOFsCE0FIaSMGwWptolARWg32G5qBQUEAsqVMsIeV3IT7ceU0W004L9potkB');

        // Create an instance of Elements.
        var elements = stripe.elements();
        var cardNumber = elements.create('cardNumber', {
            style: {
                base: {
                    iconColor: '#666EE8',
                    fontWeight: 300,
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSize: '15px',
                    '::placeholder': {
                    },
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a',
                },
            },
            classes: {
                focus: 'is-focused',
                empty: 'is-empty',
                invalid: 'is-invalid',
            },
            hidePostalCode: true,
        });
        var cardExpiry = elements.create('cardExpiry');
        var cardCvc = elements.create('cardCvc');
        cardNumber.mount('#card-number-element');
        cardExpiry.mount('#card-expiry-element');
        cardCvc.mount('#card-cvc-element');

        var form = document.getElementById('payment-form');
        var submitButton = document.getElementById('submit-button');
        var cardErrors = document.getElementById('card-errors');
        var cardNumberComplete = false;
        var cardExpiryComplete = false;
        var cardCvcComplete = false;
        function setButtonState() {
            submitButton.disabled = !(cardNumberComplete && cardExpiryComplete && cardCvcComplete);
        }
        cardNumber.addEventListener('change', function(event) {
            cardNumberComplete = event.complete;
            setButtonState();
            cardErrors.textContent = event.error ? event.error.message : '';
        });

        cardExpiry.addEventListener('change', function(event) {
            cardExpiryComplete = event.complete;
            setButtonState();
            cardErrors.textContent = event.error ? event.error.message : '';
        });

        cardCvc.addEventListener('change', function(event) {
            cardCvcComplete = event.complete;
            setButtonState();
            cardErrors.textContent = event.error ? event.error.message : '';
        });

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(cardNumber).then(function(result) {
                if (result.error) {
                    cardErrors.textContent = result.error.message;
                } else {
                    var token = result.token;
                    var form = document.getElementById('payment-form');

                    var hiddenTokenInput = document.createElement('input');
                    hiddenTokenInput.setAttribute('type', 'hidden');
                    hiddenTokenInput.setAttribute('name', 'stripeToken');
                    hiddenTokenInput.setAttribute('value', token.id);
                    form.appendChild(hiddenTokenInput);

                    var cardDetails = {
                        brand: token.card.brand,
                        last4: token.card.last4,
                        exp_month: token.card.exp_month,
                        exp_year: token.card.exp_year
                    };

                    var hiddenCardInput = document.createElement('input');
                    hiddenCardInput.setAttribute('type', 'hidden');
                    hiddenCardInput.setAttribute('name', 'cardDetails');
                    hiddenCardInput.setAttribute('value', JSON.stringify(cardDetails));
                    form.appendChild(hiddenCardInput);

                    form.submit();
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }

        setButtonState();
    </script>
    @endonce
    <style>
        button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .StripeElement {
            padding: 16px;
            border:1px;
            border-color:#000;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 16px;
            box-shadow:  0 1px 3px 0 rgba(0,0,0,0.8);
        }

        .StripeElement--focus {
            border-color: #80bdff;
        }
        #card-errors {
            color: #fa755a;
            font-size: 14px;
            line-height: 24px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</div>
