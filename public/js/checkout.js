// This is a public sample test API key.
// Don’t submit any personally identifiable information in requests made with this key.
// Sign in to see your own test API key embedded in code samples.
const stripe = Stripe(
    "pk_test_51MgKcIJLVz02y2Vzk7XdeiTtni1OU5boiI6FKfg6pXrNTna9ema2Yoxdy4BbU9wN4BCnhiOvI9hqtPjgx6NxLJQ500bXEKfNrm"
);

const options = {
    clientSecret: "{!! $intent->client_secret !!}",
    // Fully customizable with appearance API.
    appearance: {
        /*...*/
    },
};

// Set up Stripe.js and Elements to use in checkout form, passing the client secret obtained in step 2
const elements = stripe.elements(options);

// Create and mount the Payment Element
const paymentElement = elements.create("payment");
paymentElement.mount("#payment-element");
