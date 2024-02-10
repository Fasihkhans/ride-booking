<?php

use App\Livewire\Forms;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{

}; ?>
<div>
    {{-- <x-stripe-card>
    </x-stripe-card> --}}
    <div>
        <form action="{{ route('save-card') }}" method="POST" id="payment-form">
            @csrf
            <div class="form-group">
                <label for="card-element">
                    Credit or debit card
                </label>
                <div id="card-element" class="max-w-xs">
                    <!-- A Stripe Element will be inserted here. -->
                </div>
                <!-- Used to display form errors. -->
                <div id="card-errors" role="alert"></div>
            </div>
            <x-primary-button type="submit">Save Card</x-primary-button>
        </form>

        {{-- @head --}}
        <script src="https://js.stripe.com/v3/"></script>
        {{-- @endhead --}}

        @once
        <script>
            // Create a Stripe client.
            var stripe = Stripe('pk_test_51OgvOQEcKRugJstRJRTS0pmKarGtYPqz2mpsIIIOFsCE0FIaSMGwWptolARWg32G5qBQUEAsqVMsIeV3IT7ceU0W004L9potkB');

            // Create an instance of Elements.
            var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            var card = elements.create('card', {
                hidePostalCode: true,
                style: {
                    base: {
                        iconColor: '#666EE8',
                        color: '#31325F',
                        backgroundColor: '#fff',
                        padding: '16px',
                        lineHeight: '60px',
                        fontWeight: 300,
                        fontFamily: 'roboto',
                        fontSize: '15px',

                        '::placeholder': {
                            color: '#CFD7E0',
                        },
                    },
                }
            });

            // Add an instance of the card Element into the `card-element` div.
            card.mount('#card-element');

            // Handle real-time validation errors from the card Element.
            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // Handle form submission.
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        // Inform the user if there was an error.
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        // Send the token to your server.
                        stripeTokenHandler(result.token);
                    }
                });
            });

            // Submit the form with the token ID.
            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', JSON.stringify(token));
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
        </script>
        @endonce
    </div>

</div>
