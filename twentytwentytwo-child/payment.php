<?php /* Template Name: PagePayment */ ?>

<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */


get_header();
?>
<link rel="stylesheet" href="//cdn.tutorialjinni.com/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdn.tutorialjinni.com/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
<link rel="stylesheet" href="//g.tutorialjinni.com/mojoaxel/bootstrap-select-country/dist/css/bootstrap-select-country.min.css" />
<style>
 
    .my-input {
        width: 100%;
        height: 100%;
        padding: 0;
        /* margin-left: 15px; */
      
    }
    #payment-box {
        display:none;
    }
    #select-payment {
        display:none;
    }
    table, tr, td, th{

        padding: 10px;

        margin: auto;

        border: none !important;

    }
    tr {
        height: 50px;
    }
    td {
        text-align: center;
    }
    table {
        width: 100%;
    }
    .my-row {
        margin-bottom: 20px;
    }
    
    select {
        width:100%;
        height: 42px;
    }
    input {
        width:100%;
        height: 42px;
    }
    .asp_product_buy_btn_container {
        display: inherit !important;
    }
    .asp_product_buy_btn_container button {
        width: 100%;
    }
    .modal-button {
        width: 100%;  padding: 0 30px; margin-bottom: 10px; float: left;  
    }
    .modal-button button{
        width: 100%;  padding: 0 30px; margin-bottom: 10px; float: left;  
    }
</style>


<div class="container">
        <?php 
            echo do_shortcode('[contact-form-7 id="40" title="Payment Form"]'); 
                      
        ?>
       
        
       <script src="https://www.paypal.com/sdk/js?client-id=ATPp5HRYnygq8EeMOtz5zSMjEcK0C0DTlDvyzlXOxY5me3F4n-07L2493f8oj098HmjzzLcM6JclPdH9&currency=USD&intent=capture" data-sdk-integration-source="integrationbuilder"></script>
        <script src="https://js.stripe.com/v3/"></script>
  
        <div class="row"  id = "payment-box" style="display:none;">        
            <input type="hidden" id="payment_index" name="payment_index" value="-1">
            <input type="hidden" id="payment_amount" name="payment_amount" value="0">
            <div class="my-input">
                <table cellspacing="0" cellpadding="0" id="myTable">
                    <tbody>
                        
                    </tobody>
                </table>                
            </div>
        </div>              
      
</div>
<div id="ex1" class="modal" style="overflow: auto;">   
    <div class="modal-button">
            <div id="paypal-button-container"></div>
    </div>    
    <div class="modal-button">
        <div id="payment-request-button" style="width: 100%; height: 100%; text-align: center;">       
    </div> 
    <div class="modal-button">
        <a href="#" rel="modal:close" style="float: right;">Cancel</a>
    </div>    
</div>
<script async
  src="https://js.stripe.com/v3/buy-button.js">
</script>


<script src="//cdn.tutorialjinni.com/jquery/3.6.1/jquery.min.js"></script>
<script src="//cdn.tutorialjinni.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="//cdn.tutorialjinni.com/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script src="//g.tutorialjinni.com/mojoaxel/bootstrap-select-country/dist/js/bootstrap-select-country.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />



<script>
          const fundingSources = [
            paypal.FUNDING.PAYPAL,
              paypal.FUNDING.CARD
            ]

          for (const fundingSource of fundingSources) {
            const paypalButtonsComponent = paypal.Buttons({
              fundingSource: fundingSource,

              // optional styling for buttons
              // https://developer.paypal.com/docs/checkout/standard/customize/buttons-style-guide/
              style: {
                shape: 'rect',
                height: 40,
              },

              // set up the transaction
              createOrder: (data, actions) => {
                // pass in any options from the v2 orders create call:
                // https://developer.paypal.com/api/orders/v2/#orders-create-request-body
                const createOrderPayload = {
                  purchase_units: [
                    {
                      amount: {
                        value: $('input#payment_amount').val(),
                      },
                    },
                  ],
                }

                return actions.order.create(createOrderPayload)
              },

              // finalize the transaction
              onApprove: (data, actions) => {
                const captureOrderHandler = (details) => {
                  const payerName = details.payer.name.given_name
                  console.log('Transaction completed!');
                  completePay();  
                }

                return actions.order.capture().then(captureOrderHandler)
              },

              // handle unrecoverable errors
              onError: (err) => {
                console.error(
                  'An error prevented the buyer from checking out with PayPal',
                )
              },
            })

            if (paypalButtonsComponent.isEligible()) {
              paypalButtonsComponent
                .render('#paypal-button-container')
                .catch((err) => {
                  console.error('PayPal Buttons failed to render')
                })
            } else {
              console.log('The funding source is ineligible')
            }
          }
</script>

<script>
    function completePay() {
        hidemodal();
        $index = $('input#payment_index').val();    
        console.log("showed nth icon....", $index);   
        $("#myTable tr:nth-child("+(parseInt($index, 10)+1)+") img").css("display", "block"); 
    }
    function hidemodal(){
        
        $('#ex1').hide();
        $('.jquery-modal').hide();
        
    }
    // function clickPaypal() {
    //     console.log("Paypal clicked!");        
    //     $("#ex1").modal("hide");
    //     $('.payment-select').val('pay-paypal').trigger('change');
    //     $(document.forms[0]).trigger( "submit" );          
   
    // }
    // function clickStripe() {
        
    //     console.log("Stripe clicked!"); 
    //     $('#ex1').hide();
    //     $('.payment-select').val('pay-stripe').trigger('change');
    //     $(document.forms[0]).trigger( "submit" );

    // }
    function validateForm() {
        let name = $("#name").val();
        let email = $("#email").val();
        let phone = $("#phone-number").val();

        


        var filter = /^[0-9-+]+$/;
        let regex = /^([_\-\.0-9a-zA-Z]+)@([_\-\.0-9a-zA-Z]+)\.([a-zA-Z]){2,7}$/;
        if (name.length == "") {
            console.log("Name length is 0............");
            return false;
        } else if (!filter.test(phone)){
            console.log("InValid phone............");
            return false;
        } else if (!regex.test(email)) {
            console.log("InValid email............");
            return false;
        } else {
            return true;
        }
        
        
       
        // email.addEventListener("blur", () => {
            
        //     let s = email.value;
        //     if (regex.test(s)) {
        //         console.log("Valid email............");
        //         email.classList.remove("is-invalid");
        //         emailError = true;
        //     } else {
        //         console.log("InValid email............");
        //         email.classList.add("is-invalid");
        //         emailError = false;
        //     }
        // });

    }
  
    function clickPay(amount, index) {    
        $("#payment_index").val(index);
            $("#payment_amount").val(amount);
            $("#ex1").modal("show");   
            stripeload();
        if(validateForm()) {
            
        }
        
        // jQuery.ajax({
        //     type: "post",
        //     dataType: "html",
        //     url:  ajaxurl,
        //     data:  {action: "get_amount", amount: amount},
        //     success: function(msg){
        //         $("#ex1").html(msg);
        //         console.log(msg);                
                
        //         $("#ex1").modal("show");                
        //     }
        // });  

    }

    function stripeload() {
        $amount = $('input#payment_amount').val();

        console.log("Here: ", $amount);

        var stripe = Stripe('pk_test_51MoER3GjmY9scAO6F4fwOvJ2SB6hZLCyl5vF4xnyavkLRRpkljbKryoUXk6YAzxctiH5CNBWiYi8QGjQUHuCylOK00467KaCxO'); 

        const paymentRequest = stripe.paymentRequest({
            country: 'US',
            currency: 'usd',
            total: {
                label: 'Demo total',
                amount: $amount * 100,
            },
            requestPayerName: true,
            requestPayerEmail: true,
        });
        const elements = stripe.elements();
        const prButton = elements.create('paymentRequestButton', {
        paymentRequest,
        });

        (async () => {
        // Check the availability of the Payment Request API first.
        const result = await paymentRequest.canMakePayment();
        if (result) {
            console.log("result: ", result);
            prButton.mount('#payment-request-button');
        } else {
            console.log("result: ", result);
            document.getElementById('payment-request-button').style.display = 'none';
        }
        })();
        paymentRequest.on('paymentmethod', async (ev) => {
        // Confirm the PaymentIntent without handling potential next actions (yet).
            const {paymentIntent, error: confirmError} = await stripe.confirmCardPayment(
                clientSecret,
                {payment_method: ev.paymentMethod.id},
                {handleActions: false}
            );

            if (confirmError) {
                // Report to the browser that the payment failed, prompting it to
                // re-show the payment interface, or show an error message and close
                // the payment interface.
                ev.complete('fail');
            } else {
                // Report to the browser that the confirmation was successful, prompting
                // it to close the browser payment method collection interface.
                ev.complete('success');
                 
                // Check if the PaymentIntent requires any actions and if so let Stripe.js
                // handle the flow. If using an API version older than "2019-02-11"
                // instead check for: `paymentIntent.status === "requires_source_action"`.
                if (paymentIntent.status === "requires_action") {
                // Let Stripe.js handle the rest of the payment flow.
                const {error} = await stripe.confirmCardPayment(clientSecret);
                if (error) {
                    // The payment failed -- ask your customer for a new payment method.
                } else {
                    completePay();  
                    // The payment has succeeded.
                }
                } else {
                    completePay();  
                // The payment has succeeded.
                }
            }
        });
    }
    function showBox(amount) {
        
        const count = Math.floor(amount/1500);
        let height_box;
        if(amount % 1500 != 0){
             height_box = (58)* (count + 1);
        } else {
             height_box = (58)* count;
        }       
        
        console.log("count: " , count);        
        $("#payment-box").css('height', height_box);
        $("#payment-box").show();
        $('#myTable tbody').html("");
        
        let inner_tag = "";
        for (let i = 0; i < count; i++) {
            
            inner_tag = inner_tag + '<tr class="1500-item">' +
                            '<td>1500</td>' +
                            '<td>$USD</td>' +
                            '<td><img style="height: 20px; width: 20px; display: none;" src="http://localhost/newwpsite/wp-content/uploads/2023/03/images.png"></td>' +
                            '<td>' +
                                '<button style="height: 30px; padding: 0 30px;" type="button" onClick="clickPay('+1500+','+ i+ ')">Pay</button>' +
                            '</td>' +
                           
                        '</tr>';
        }
        if(amount % 1500 != 0) {
            inner_tag = inner_tag + '<tr class="1500-item">' +
                            '<td>'+amount % 1500+'</td>' +
                            '<td>$USD</td>' +
                            '<td><img style="height: 20px; width: 20px; display: none;" src="http://localhost/newwpsite/wp-content/uploads/2023/03/images.png"></td>' +
                            '<td>' +
                                '<button style="height: 30px; padding: 0 30px;" type="button" onClick="clickPay('+amount % 1500+','+ 0 +')">Pay</button>' +
                            '</td>' +                           
                        '</tr>';
        }        
        $('#myTable tbody').append(inner_tag);
        
    }
    function hideBox() {
        $("#payment-box").hide();
    }
  
    $( document ).ready(function() {        
        
        $("#amount").keyup(function(event) {
            showBox($(this).val());       
        });        
 
    });    
</script>
<?php
get_footer();
?>