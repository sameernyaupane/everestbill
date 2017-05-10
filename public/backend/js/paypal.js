// Render the PayPal button

paypal.Button.render({

    // Set your environment
    env: 'sandbox', // sandbox | production

    // Wait for the PayPal button to be clicked
    payment: function() {
        // Make a call to the merchant server to set up the payment
        return paypal.request.post(createPaymentUrl, {'_token' : $('meta[name="csrf-token"]').attr('content')}).then(function(res) {
            return res.id;
        });
    },

    // Wait for the payment to be authorized by the customer
    onAuthorize: function(data, actions) {
        // Make a call to the merchant server to execute the payment
        console.log(data);
        console.log(data.id);
        return paypal.request.post(executePaymentUrl, {
            '_token' : $('meta[name="csrf-token"]').attr('content'),
            'payment_id': data.paymentID,
            'payer_id': data.payerID,
        }).then(function (res) {
            document.querySelector('#paypal-button-container').innerText = 'Payment Complete!';
        });
    }

}, '#paypal-button-container');
