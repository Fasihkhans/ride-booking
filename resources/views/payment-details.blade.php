@push('head')

<script src="https://js.stripe.com/v3/"></script>
@endpush
{{-- <head> --}}
    <!-- Add this to the <head> tag -->
{{-- </head> --}}

<form action="{{ route('save-card') }}" method="post" id="payment-form">
    @csrf
    <div class="form-group">
        <label for="card-element">
            Credit or debit card
        </label>
        <div id="card-element">
            <!-- A Stripe Element will be inserted here. -->
        </div>

        <!-- Used to display form errors. -->
        <div id="card-errors" role="alert"></div>
    </div>

    <button type="submit">Save Card</button>
</form>

{{-- <script src="https://js.stripe.com/v3/"></script> --}}
@push('script')

<script>
    // Create a Stripe client.
     var stripe = Stripe(env('STRIPE_KEY'));

     // Create an instance of Elements.
     var elements = stripe.elements();

     // Custom styling can be passed to options when creating an Element.
     var style = {
    base: {
        fontSize: '16px',
        color: '#32325d',
    }
};

// Create an instance of the card Element.
var card = elements.create('card', { style: style });

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
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
}
</script>
@endpush
