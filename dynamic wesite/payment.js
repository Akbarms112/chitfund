<><div id="container"></div><script async
    src="https://pay.google.com/gp/p/js/pay.js"
    onload="onGooglePayLoaded()"></script></>



    function addGooglePayButton() {
          const paymentsClient = getGooglePaymentsClient();
          const button =
              paymentsClient.createButton({onClick: onGooglePaymentButtonClicked});
          document.getElementById('container').appendChild(button);
        }
        
        /**
         * Provide Google Pay API with a payment amount, currency, and amount status
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#TransactionInfo|TransactionInfo}
         * @returns {object} transaction info, suitable for use as transactionInfo property of PaymentDataRequest
         */
        function getGoogleTransactionInfo() {
          return {
                displayItems: [
                {
                  label: "Subtotal",
                  type: "SUBTOTAL",
                  price: "11.00",
                },
              {
                  label: "Tax",
                  type: "TAX",
                  price: "1.00",
                }
            ],
            countryCode: 'US',
            currencyCode: "USD",
            totalPriceStatus: "FINAL",
            totalPrice: "12.00",
            totalPriceLabel: "Total"
          };
        }
        
     
        function onGooglePaymentButtonClicked() {
          const paymentDataRequest = getGooglePaymentDataRequest();
          paymentDataRequest.transactionInfo = getGoogleTransactionInfo();
        
          const paymentsClient = getGooglePaymentsClient();
          paymentsClient.loadPaymentData(paymentDataRequest);
        }
        
        let attempts = 0;
        /**
         * Process payment data returned by the Google Pay API
         *
         * @param {object} paymentData response from Google Pay API after user approves payment
         * @see {@link https://developers.google.com/pay/api/web/reference/response-objects#PaymentData|PaymentData object reference}
         */
        function processPayment(paymentData) {
          return new Promise(function(resolve, reject) {
            setTimeout(function() {
              // @todo pass payment token to your gateway to process payment
              paymentToken = paymentData.paymentMethodData.tokenizationData.token;
        
                    if (attempts++ % 2 == 0) {
                  reject(new Error('Every other attempt fails, next one should succeed'));      
              } else {
                  resolve({});      
              }
            }, 500);
          });
        }