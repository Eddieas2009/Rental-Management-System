function getPaymentDetails(paymentID){
    $.ajax({
        url: 'models/payments/Payments.php',
        type: 'POST',
        data: {get_payment_details: true, paymentID: paymentID},
        success: function(response){
            var data = JSON.parse(response);
            if(data.success){
                $('#editPaymentModal #amount').val(data.data.amount);
                $('#editPaymentModal #month').val(data.data.month);
                $('#editPaymentModal #year').val(data.data.year);
                $('#editPaymentModal #payment_date').val(data.data.payment_date);
                $('#editPaymentModal #payment_method').val(data.data.payment_method);
                $('#editPaymentModal #status').val(data.data.status);
                $('#editPaymentModal #paymentId').val(data.data.id);
                $('#editPaymentModal').modal('show');
            }else{
                round_error_noti(data.message);
            }
        },
        error: function(xhr, status, error){
            round_error_noti('Error occurred while getting payment details');
        }
    });
}


$(document).ready(function() {


    $('#addPaymentModal').validate({
        rules: {
            amount: {
                required: true,
                number: true
            },
            month: {
                required: true,
                digits: true,
                min: 1,
                max: 12
            },
            year: {
                required: true,
                digits: true,
                minlength: 4,
                maxlength: 4
                // Example for year range:
                // min: new Date().getFullYear() - 10, // Allow years from 10 years ago
                // max: new Date().getFullYear() + 5   // Allow years up to 5 years in the future
            },
            payment_date: {
                required: true,
                date: true // This rule works well with <input type="date">
            },
            payment_method: {
                required: true
            },
            status: {
                required: true
            }
        },
        messages: {
            amount: {
                required: "Please enter the amount.",
                number: "Please enter a valid number."
            },
            month: {
                required: "Please enter the month.",
                digits: "Please enter a valid number for the month (1-12).",
                min: "Month must be between 1 and 12.",
                max: "Month must be between 1 and 12."
            },
            year: {
                required: "Please enter the year.",
                digits: "Please enter a valid year (e.g., 2024).",
                minlength: "Year must be 4 digits.",
                maxlength: "Year must be 4 digits."
            },
            payment_date: {
                required: "Please select the payment date.",
                date: "Please enter a valid date."
            },
            payment_method: {
                required: "Please select a payment method."
            },
            status: {
                required: "Please select a status."
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            // For select2, error placement might need adjustment if default is not good
            // if (element.hasClass('select2-hidden-accessible')) {
            //     error.insertAfter(element.next('.select2-container'));
            // } else {
            //     element.closest('.mb-3').append(error);
            // }
            element.closest('.mb-3').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            // Optionally, add 'is-valid' class for visual feedback on valid fields
            // $(element).addClass('is-valid'); 
        },
        submitHandler: function() {
            var formData = $('#addPaymentModal').serialize();
            alert(formData);
            $.ajax({
                url: 'models/payments/Payments.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    alert(response);
                    var data = JSON.parse(response);
                    if(data.success){
                        round_success_noti(data.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }else{
                        round_error_noti(data.message);
                    }
                },
                error: function(xhr, status, error) {
                    round_error_noti('Error occurred while saving payment');
                }
            });
        
        }
    });


/*  ========================== Edit payment ========================== */

    $('#editPaymentModal').validate({
        rules: {
            amount: {
                required: true,
                number: true
            },
            month: {
                required: true,
                digits: true,
                min: 1,
                max: 12
            },
            year: {
                required: true,
                digits: true,
                minlength: 4,
                maxlength: 4
            },
            payment_date: {
                required: true,
                date: true
            },
            payment_method: {
                required: true
            },
            status: {
                required: true
            }
        },
        messages: {
            amount: {
                required: "Please enter the amount.",
                number: "Please enter a valid number."
            },
            month: {
                required: "Please enter the month.",
                digits: "Please enter a valid number for the month (1-12).",
                min: "Month must be between 1 and 12.",
                max: "Month must be between 1 and 12."
            },
            year: {
                required: "Please enter the year.",
                digits: "Please enter a valid year (e.g., 2024).",
                minlength: "Year must be 4 digits.",
                maxlength: "Year must be 4 digits."
            },
            payment_date: {
                required: "Please select the payment date.",
                date: "Please enter a valid date."
            },
            payment_method: {
                required: "Please select a payment method."
            },
            status: {
                required: "Please select a status."
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.mb-3').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function() {
            var formData = $('#editPaymentModal').serialize();
            $.ajax({
                url: 'models/payments/Payments.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    var data = JSON.parse(response);
                    if(data.success){
                        round_success_noti(data.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }else{
                        round_error_noti(data.message);
                    }
                },
                error: function(xhr, status, error) {
                    round_error_noti('Error occurred while updating payment');
                }
            });
        }
    });



})

/*  ========================== Compose mail ========================== */

function composeMail(paymentID, tenantID){
    $('#composeMailModal #paymentID').val(paymentID);
    $('#composeMailModal #tenantID').val(tenantID);
    $.ajax({
        url: 'models/payments/Payments.php',
        type: 'POST',
        data: {compose_mail: true, paymentID: paymentID, tenantID: tenantID},
        success: function(response){
            var mydata = JSON.parse(response);
            if(mydata.success){
                
                $('#composeMailModal #sendto').val(mydata.data.email);
                $('#composeMailModal #message').val(`Dear ${mydata.data.first_name} ${mydata.data.last_name},

This is a friendly reminder that your rent payment of UGX${parseFloat(mydata.data.amount).toLocaleString()} for ${new Date(2000, mydata.data.month - 1).toLocaleString('default', { month: 'long' })} ${mydata.data.year} is due.
Please ensure your payment is made on time to avoid any late fees.

Best regards,
Property Management Team`);
                $('#composeMailModal').modal('show');
            }
        }
    });
}

/*  ========================== End Compose mail ========================== */

/*  ========================== Send mail ========================== */


$(document).ready(function(){
    $('#composeMailModal').validate({
        rules: {
            sendto: {
                required: true
            },
            subject: {
                required: true
            },
            message: {
                required: true
            }
        },
        messages: {
            sendto: {
                required: "Please enter the email address."
            },
            subject: {
                required: "Please enter the subject."
            },
            message: {
                required: "Please enter the message."
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.mb-3').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function() {
            $('#sendMailButton').prop('disabled', true);
            $('#sendMailButton').html('Sending...');
            var formData = $('#composeMailModal').serialize();
            $.ajax({
                url: 'models/payments/Sendmail.php',
                type: 'POST',
                data: formData,
                success: function(response){
                    var data = JSON.parse(response);
                    if(data.success){
                        round_success_noti(data.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                        $('#sendMailButton').prop('disabled', false);
                        $('#sendMailButton').html('Send Mail');
                    }else{
                        round_error_noti(data.message);
                        $('#sendMailButton').prop('disabled', false);
                        $('#sendMailButton').html('Send Mail');
                    }
                },
                error: function(xhr, status, error){
                    round_error_noti('Error occurred while sending mail');
                    $('#sendMailButton').prop('disabled', false);
                    $('#sendMailButton').html('Send Mail');
                }
            });
        }
        
    });
});



/*  ========================== End Send mail ========================== */

/*  ========================== View partial payment ========================== */

function viewpartialPayment(paymentID){

    $('#viewpartialPaymentModal #paymentID').val(paymentID);
    getPartialPayment(paymentID);
    $('#viewpartialPaymentModal').modal('show');

}

$(document).ready(function(){
    $('#addPartialPaymentModal').validate({
        rules: {
            date: {
                required: true
            },
            amount: {
                required: true
            },
            paymentmethod: {
                required: true
            }
        },
        messages: {
            date: {
                required: "Please select the date."
            },
            amount: {
                required: "Please enter the amount."
            },
            paymentmethod: {
                required: "Please select the payment method."
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.mb-3').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function() {
            var formData = $('#addPartialPaymentModal').serialize();
           $.post('models/payments/Payments.php', formData, function(response){
            alert(response);
            var data = JSON.parse(response);
            if(data.success){
                round_success_noti(data.message);
                getPartialPayment($('#addPartialPaymentModal #paymentID').val());
                $('#addPartialPaymentModal #date').val('');
                $('#addPartialPaymentModal #amount').val('');
                $('#addPartialPaymentModal #paymentmethod').val('');
                $('#addPartialPaymentModal').modal('hide');
                $('#viewpartialPaymentModal').modal('show');
            }else{
                round_error_noti(data.message);
            }
           });
           
        }
    });
})

function getPartialPayment(paymentID){
    $.ajax({
        url: 'models/payments/Payments.php',
        type: 'POST',
        data: {get_partial_payment: true, paymentID: paymentID},
        success: function(response){
            var data = JSON.parse(response);
            if(data.success){
                var html = '';
                var partialtotal = 0;
                data.data.forEach(function(item){
                    partialtotal += parseFloat(item.amount);
                    html += `<tr>
                        <td>${item.datereceived}</td>
                        <td  class="text-end">${parseFloat(item.amount).toLocaleString()}</td>
                        <td>${item.paymentmode}</td>
                        <td>
                            <a href="javascript:;" onclick="editPartialPayment(${item.partialID})"><i class="bx bx-edit"></i> Edit</a>
                        </td>
                    </tr>`;
                });
                $('#partialPaymentTable').html(html);
                $('#totalPartialPayment').html(parseFloat(partialtotal).toLocaleString());
            }else{
                $('#partialPaymentTable').html('');
            }
        }
    })
}


function editPartialPayment(partialPaymentID){

    var data = { partialPaymentID: partialPaymentID };

    $.ajax({
        url: 'models/payments/Payments.php',
        type: 'POST',
        data: data,
        success: function(response){
            var mydata = JSON.parse(response);
            if(mydata.success){
                $('#editPartialPaymentModal #amount').val(mydata.data.amount);
                $('#editPartialPaymentModal #date').val(mydata.data.datereceived);
                $('#editPartialPaymentModal #paymentmethod').val(mydata.data.paymentmode);
                $('#editPartialPaymentModal #partial_ID').val(mydata.data.partialID);
                $('#viewpartialPaymentModal').modal('hide');
                $('#editPartialPaymentModal').modal('show');
            }else{
                round_error_noti(mdata.message);
            }
        }
    });
}

$(document).ready(function(){

    $('#addPartialPayment').click(function(){
        $('#addPartialPaymentModal #paymentID').val($('#viewpartialPaymentModal #paymentID').val());
        $('#viewpartialPaymentModal').modal('hide');
        $('#addPartialPaymentModal').modal('show');
    });



    $('#closeEditPartialPaymentModal').click(function(){
        $('#editPartialPaymentModal').modal('hide');
        $('#viewpartialPaymentModal').modal('show');
    });

    $('#CloseAddPartialPaymentModal').click(function(){
        $('#addPartialPaymentModal').modal('hide');
        $('#viewpartialPaymentModal').modal('show');
    });



/*  ========================== End Edit partial payment ========================== */

    $('#editPartialPaymentModal').validate({
        rules: {
            date: {
                required: true
            },
            amount: {
                required: true
            },
            paymentmethod: {
                required: true
            }
        },
        messages: {
            date: {
                required: "Please select the date."
            },
            amount: {
                required: "Please enter the amount."
            },
            paymentmethod: {
                required: "Please select the payment method."
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.mb-3').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function() {
            var formData = $('#editPartialPaymentModal').serialize();
            $.ajax({
                url: 'models/payments/Payments.php',
                type: 'POST',
                data: formData,
                success: function(response){
                    var data = JSON.parse(response);
                    if(data.success){
                        round_success_noti(data.message);
                        getPartialPayment($('#viewpartialPaymentModal #paymentID').val());
                        $('#editPartialPaymentModal').modal('hide');
                        $('#viewpartialPaymentModal').modal('show');
                    }else{
                        round_error_noti(data.message);
                    }
                }
            }); 
        } 
    });



});










