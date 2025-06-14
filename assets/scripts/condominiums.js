function getCondo(condoID){
    $.ajax({
        url: 'models/condos/getCondoDetails.php',
        type: 'POST',
        data: {condoID: condoID},
        beforeSend: function(){
            $('#editCondoModal').find('button[type="submit"]').prop('disabled', true);
        },
        success: function(response){
            var modalData = JSON.parse(response);
            if(modalData.success){
                $('#editCondoModal').find('button[type="submit"]').prop('disabled', false);
                $('#editCondoModal').modal('show');
                $('#editCondoModal #condoID').val(modalData.data.condoID);
                $('#editCondoModal #property').val(modalData.data.propertyID).trigger('change');
                $.post('models/condos/getUnits.php', {triggeredpropertyID: modalData.data.propertyID}, function(response){
                    $('#editCondoModal #unit').html(response);
                    $('#editCondoModal #unit').val(modalData.data.unitID).trigger('change');
                });
                $('#editCondoModal #oldunit').val(modalData.data.unitID);
                $('#editCondoModal #clientnames').val(modalData.data.cleintnames);
                $('#editCondoModal #email').val(modalData.data.email);
                $('#editCondoModal #phone').val(modalData.data.phoneNo);
                $('#editCondoModal #sellamount').val(modalData.data.sellAmount);
                $('#editCondoModal #startdate').val(modalData.data.startDate);
            }else{
                round_error_noti(modalData.message);
                $('#editCondoModal').find('button[type="submit"]').prop('disabled', false);
            }
        },
        error: function(xhr, status, error){
            round_error_noti('Error occurred while getting condo details');
            $('#editCondoModal').find('button[type="submit"]').prop('disabled', false);
        }
    });
}


$(document).ready(function(){

    $('#property').change(function(){
        var propertyID = $(this).val();
        $.ajax({
            url: 'models/condos/getUnits.php',
            type: 'POST',
            data: {propertyID: propertyID},
            success: function(response){
                $('#unit').html(response);
            }
        });
    });

/*  ========================== Add Condo ========================== */
    
$('#addCondoModal').validate({
    rules: {
        property: {
            required: true
        },
        unit: {
            required: true
        },
        clientnames: {
            required: true
        },
        email: {
            email: true
        },
        phone: {
            required: true,
            minlength: 10,
        },
        sellamount: {   
            required: true,
            number: true,
            min: 1
        },
        downpayment: {
            required: true,
            number: true,
            min: 1
        },
        startdate: {
            required: true,
            date: true,

        }
    },
    messages: {
        property: {
            required: 'Please select a property'
        },
        unit: {
            required: 'Please select a unit'
        },
        clientnames: {
            required: 'Please enter client names'
        },
        email: {
            email: 'Please enter a valid email address'
        },
        phone: {
            required: 'Please enter a phone number',
            minlength: 'minimum is 10 digits'
        },
        sellamount: {
            required: 'Please enter sell amount',
            number: 'Please enter valid amount',
            min: 'Amount must be greater than 0'
        },
        downpayment: {
            required: 'Please enter down payment',
            number: 'Please enter valid amount',
            min: 'Amount must be greater than 0'
        },
        startdate: { 
            required: 'Please enter a start date'
        }
    },
    errorPlacement: function(error, element){
        error.insertAfter(element);
    }/* ,
    highlight: function(element, errorClass, validClass){
        $(element).addClass('is-invalid').removeClass('is-valid');
    },
    unhighlight: function(element, errorClass, validClass){
        $(element).removeClass('is-invalid').addClass('is-valid');
    } */,
    submitHandler: function(){
        var formData = $('#addCondoModal').serialize();
        $.ajax({
            url: 'models/condos/addCondo.php',
            type: 'POST',
            data: formData,
            beforeSend: function(){
                $('#addCondoModal').find('button[type="submit"]').prop('disabled', true);
                $('#addCondoModal').find('button[type="submit"]').val('Saving...');
            },
            success: function(response){
                var data = JSON.parse(response);
                if(data.success){
                    round_success_noti(data.message);
                    $('#addCondoModal').find('button[type="submit"]').prop('disabled', false);
                    $('#addCondoModal').find('button[type="submit"]').val('Add Condo');
                    setTimeout(function(){
                        window.location.reload();
                    }, 1000);
                }else{
                    round_error_noti(data.message);
                    $('#addCondoModal').find('button[type="submit"]').prop('disabled', false);
                    $('#addCondoModal').find('button[type="submit"]').val('Add Condo');
                }
            },
            error: function(xhr, status, error){
                round_error_noti('Error occurred while saving condo');
            }
        });
    }
});

/*  ========================== Edit Condo ========================== */

$('#editCondoModal').validate({
    rules: {
        property: {
            required: true
        },
        unit: {
            required: true
        },
        clientnames: {
            required: true
        },
        email: {
            email: true
        },
        phone: {
            required: true,
            minlength: 10,
        },
        sellamount: {   
            required: true,
            number: true,
            min: 1
        },
        startdate: {
            required: true,
            date: true,

        }
    },
    messages: {
        property: {
            required: 'Please select a property'
        },
        unit: {
            required: 'Please select a unit'
        },
        clientnames: {
            required: 'Please enter client names'
        },
        email: {
            email: 'Please enter a valid email address'
        },
        phone: {
            required: 'Please enter a phone number',
            minlength: 'minimum is 10 digits'
        },
        sellamount: {
            required: 'Please enter sell amount',
            number: 'Please enter valid amount',
            min: 'Amount must be greater than 0'
        },
        startdate: {
            required: 'Please enter a start date'
        }
    },
    errorPlacement: function(error, element){
        error.insertAfter(element);
    }/* ,
    highlight: function(element, errorClass, validClass){
        $(element).addClass('is-invalid').removeClass('is-valid');
    },
    unhighlight: function(element, errorClass, validClass){
        $(element).removeClass('is-invalid').addClass('is-valid');
    } */,
    submitHandler: function(){
        var formData = $('#editCondoModal').serialize();
        $.ajax({
            url: 'models/condos/updateCondo.php',
            type: 'POST',
            data: formData,
            beforeSend: function(){
                $('#editCondoModal').find('button[type="submit"]').prop('disabled', true);
                $('#editCondoModal').find('button[type="submit"]').val('Saving...');

            },
            success: function(response){
                var data = JSON.parse(response);
                if(data.success){
                    round_success_noti(data.message);
                    $('#editCondoModal').find('button[type="submit"]').prop('disabled', false);
                    $('#editCondoModal').find('button[type="submit"]').val('Save');
                    setTimeout(function(){
                        window.location.reload();
                    }, 1000);
                }else{
                    round_error_noti(data.message);
                    $('#editCondoModal').find('button[type="submit"]').prop('disabled', false);
                    $('#editCondoModal').find('button[type="submit"]').val('Save');
                }
            },
            error: function(xhr, status, error){
                round_error_noti('Error occurred while saving condo');
                $('#editCondoModal').find('button[type="submit"]').prop('disabled', false);
                $('#editCondoModal').find('button[type="submit"]').val('Save');
            }
        });
    }
});






});