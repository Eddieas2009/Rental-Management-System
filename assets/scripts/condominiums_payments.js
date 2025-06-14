function getCondopayment(paymentID){
    $.ajax({
        url: 'models/condos/getCondopayment.php',
        type: 'POST',
        data: {paymentID: paymentID},
        success: function(response){
            var modalData = JSON.parse(response);
            if(modalData.success){
            $('#editCondoPaymentModal').find('input[name="paymentID"]').val(modalData.data.id);
            $('#editCondoPaymentModal').find('input[name="amount"]').val(modalData.data.amount);
            $('#editCondoPaymentModal').find('input[name="oldAmount"]').val(modalData.data.amount);
            $('#editCondoPaymentModal').find('input[name="paymentDate"]').val(modalData.data.paymentDate);
            $('#editCondoPaymentModal').find('textarea[name="description"]').val(modalData.data.description);
            $('#editCondoPaymentModal').modal('show');
            }else{
                round_error_noti(modalData.message);
            }
        }
    });
}

$(document).ready(function(){
$('#addCondoPaymentModal').validate({
    rules: {
        amount: {
            required: true,
            number: true,
            min: 1
        },
        paymentDate: {
            required: true
        }
    },
    messages: {
        amount: {
            required: 'Please enter amount',
            number: 'Please enter valid amount',
            min: 'Amount must be greater than 0'
        },
        paymentDate: {
            required: 'Please enter date',
            date: 'Please enter valid date'
        }
    },
    errorPlacement: function(error, element){
        error.insertAfter(element);
    },
    submitHandler: function(){
        var formData = $('#addCondoPaymentModal').serialize();
        $.ajax({
            url: 'models/condos/addCondoPayment.php',
            type: 'POST',
            data: formData,
            beforeSend: function(){
                $('#addCondoPaymentModal').find('button[type="submit"]').prop('disabled', true);
                $('#addCondoPaymentModal').find('button[type="submit"]').val('Saving...');
            },
            success: function(response){
                var data = JSON.parse(response);
                if(data.success){
                    round_success_noti(data.message);
                    $('#addCondoPaymentModal').find('button[type="submit"]').prop('disabled', false);
                    $('#addCondoPaymentModal').find('button[type="submit"]').val('Add Payment');
                    setTimeout(function(){
                        window.location.reload();
                    }, 1000);
                }else{
                    round_error_noti(data.message);
                    $('#addCondoPaymentModal').find('button[type="submit"]').prop('disabled', false);
                    $('#addCondoPaymentModal').find('button[type="submit"]').val('Add Payment');
                }
            },
            error: function(xhr, status, error){
                round_error_noti('Something went wrong');
                $('#addCondoPaymentModal').find('button[type="submit"]').prop('disabled', false);
                $('#addCondoPaymentModal').find('button[type="submit"]').val('Add Payment');
            }
        });
    }
});
/* Edit Condo Payment */
$('#editCondoPaymentModal').validate({
    rules: {
        amount: {
            required: true,
            number: true,
            min: 1
            },
        paymentDate: {
            required: true,
            date: true
        }
    },
    messages: {
        amount: {
            required: 'Please enter amount',
            number: 'Please enter valid amount',
            min: 'Amount must be greater than 0'
        },
        paymentDate: {
            required: 'Please enter date',
            date: 'Please enter valid date'
        }
    },
    errorPlacement: function(error, element){
        error.insertAfter(element);
    },
    submitHandler: function(){
        var formData = $('#editCondoPaymentModal').serialize();
        $.ajax({
            url: 'models/condos/updateCondopayment.php',
            type: 'POST',
            data: formData,
            beforeSend: function(){
                $('#editCondoPaymentModal').find('button[type="submit"]').prop('disabled', true);
                $('#editCondoPaymentModal').find('button[type="submit"]').val('Saving...');
            },
            success: function(response){
                var modalData = JSON.parse(response);
                if(modalData.success){
                    round_success_noti(modalData.message);
                    $('#editCondoPaymentModal').find('button[type="submit"]').prop('disabled', false);
                    $('#editCondoPaymentModal').find('button[type="submit"]').val('Edit Payment');
                    setTimeout(function(){
                        window.location.reload();
                    }, 1000);
                }else{
                    round_error_noti(modalData.message);
                    $('#editCondoPaymentModal').find('button[type="submit"]').prop('disabled', false);
                    $('#editCondoPaymentModal').find('button[type="submit"]').val('Edit Payment');
                }
            },
            error: function(xhr, status, error){
                round_error_noti('Something went wrong');
                $('#editCondoPaymentModal').find('button[type="submit"]').prop('disabled', false);
                $('#editCondoPaymentModal').find('button[type="submit"]').val('Edit Payment');
            }
        });
    }
})










})