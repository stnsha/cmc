<!DOCTYPE html>
<html>

<head>
  <title>Checkout</title>
  <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
  <script src="https://js.stripe.com/v3/"></script>
</head>

<body>
  <section>
    <form id="payment-form" data-secret="{{ $intent->client_secret }}">
      <div id="payment-element">
        <!-- Elements will create form elements here -->
      </div>

      <button id="submit">Submit</button>
    </form>
  </section>


  <!-- <script src="{{ asset('js/checkout.js') }}"></script> -->
  <script>
    // This is a public sample test API key.
    // Don’t submit any personally identifiable information in requests made with this key.
    // Sign in to see your own test API key embedded in code samples.
    //const stripe = Stripe("{!! env('STRIPE_KEY') !!}");
    const stripe = Stripe("pk_test_51MgKcIJLVz02y2Vzk7XdeiTtni1OU5boiI6FKfg6pXrNTna9ema2Yoxdy4BbU9wN4BCnhiOvI9hqtPjgx6NxLJQ500bXEKfNrm");

    const options = {
        clientSecret:
            "{!! $intent->client_secret !!}",
        // Fully customizable with appearance API.
        appearance: {
            /*...*/
        },
    };


    // Set up Stripe.js and Elements to use in checkout form, passing the client secret obtained in step 2
    const elements = stripe.elements(options);

    // Create and mount the Payment Element
    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');


    const form = document.getElementById('payment-form');

    form.addEventListener('submit', async (event) => {
      event.preventDefault();

      const {error} = await stripe.confirmPayment({
        //`Elements` instance that was used to create the Payment Element
        elements,
        confirmParams: {
           //return_url: 'https://example.com/order/123/complete',//redirect ke page yg intented
          return_url: "{{ route('confirm_payment') }}"
        },
      });

      if (error) {
        // This point will only be reached if there is an immediate error when
        // confirming the payment. Show error to your customer (for example, payment
        // details incomplete)
        const messageContainer = document.querySelector('#error-message');
        messageContainer.textContent = error.message;

      } else {
        // Your customer will be redirected to your `return_url`. For some payment
        // methods like iDEAL, your customer will be redirected to an intermediate
        // site first to authorize the payment, then redirected to the `return_url`.
      }
    });
  </script>
</body>

</html>