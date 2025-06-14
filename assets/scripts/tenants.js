

$(document).ready(function(){
    $('#addTenantModal #property').change(function(){
        var propertyId = $(this).val();
        getUnits('#addTenantModal', propertyId);
        $('#addTenantModal #rentamount').val('');
    });


    $('#addTenantModal #unit').change(function(){
        var unitId = $(this).val();
        getRentAmount('#addTenantModal', unitId);
    });
/* ========================== Edit Tenant ========================== */

    $('#editTenantModal #property').change(function(){
        var propertyId = $(this).val();
        getUnits('#editTenantModal', propertyId);
        $('#editTenantModal #rentamount').val($('#editTenantModal #oldrentamount').val());
    });

    $('#editTenantModal #unit').change(function(){
        
        var unitId = $(this).val();
        getRentAmount('#editTenantModal', unitId);
    });



});


function getTenant(tenantId) {
    $.ajax({
        url: 'models/tenants/manageTenant.php',
        type: 'POST',
        data: { tenantById: tenantId },
        success: function(response) {
           
            const data = JSON.parse(response);
            if(data.success){
                $('#editTenantModal #first_name').val(data.tenant.first_name);
                $('#editTenantModal #last_name').val(data.tenant.last_name);
                $('#editTenantModal #email').val(data.tenant.email);
                $('#editTenantModal #phone').val(data.tenant.phone);
                $('#editTenantModal #property').val(data.tenant.propertyID);
                getUnitsinUpdate(data.tenant.propertyID, data.tenant.unitID);
                $('#editTenantModal #move_in_date').val(data.tenant.move_in_date);
                $('#editTenantModal #status').val(data.tenant.status);
                $('#editTenantModal #tenantId').val(data.tenant.tenantID);
                $('#editTenantModal #unit').val(data.tenant.unitID);
                $('#editTenantModal #oldunit').val(data.tenant.unitID);
                $('#editTenantModal').modal('show');
            }else{
                round_error_noti(data.message);
            }
        },
        error: function(xhr, status, error) {
            round_error_noti(xhr.responseText);
        }
    });
}

function getUnitsinUpdate(propertyId, unitId){
    $.ajax({
        url: 'models/tenants/manageTenant.php',
        type: 'POST',
        data: { getUnitsinUpdate: propertyId },
        success: function(response){
            const data = JSON.parse(response);
            if(data.success){
                var html = '<option value="">Select Unit</option>';
                data.units.forEach(function(unit){
                    let selected = '';
                    if(unit.unitID == unitId){
                        selected = 'selected';
                        $('#editTenantModal #rentamount').val(unit.rentamount);
                    }
                    html += '<option value="'+unit.unitID+'" '+selected+'>'+unit.unitname+'</option>';
                });
                $('#editTenantModal #unit').html(html);
            }else{
                round_error_noti(data.error);
            }
        }
    });
}

function getUnits(form, propertyId){
    $.ajax({
        url: 'models/tenants/manageTenant.php',
        type: 'POST',
        data: { getUnits: propertyId },
        success: function(response) {
            const data = JSON.parse(response);
            var html = '<option value="">Select Unit</option>';
            if(data.success){
                data.units.forEach(function(unit){
                    html += '<option value="'+unit.unitID+'">'+unit.unitname+'</option>';
                });
                $(form + ' #unit').html(html);
            }else{
                round_error_noti(data.error);
                $(form + ' #unit').html(html);
            }
        },
        error: function(xhr, status, error) {
            round_error_noti(xhr.responseText);
        }
    });
}

function getRentAmount(form, unitId){
    $.ajax({
        url: 'models/tenants/manageTenant.php',
        type: 'POST',
        data: { getRentAmount: unitId },
        success: function(response){
            const data = JSON.parse(response);
            if(data.success){
                $(form + ' #rentamount').val(data.rentamount);
            }else{
                round_error_noti(data.error);
                $(form + ' #rentamount').val('');
                
            }
        },
        error: function(xhr, status, error) {
            round_error_noti(xhr.responseText);
        }
    });
}





/* ========================== Add Tenant ========================== */
$(document).ready(function(){
$('#addTenantModal').validate({
    rules: {
        first_name: {
            required: true,
        },
        last_name: {    
            required: true,
        },
        email: {
            required: true,
            email: true,
        },
        phone: {
            required: true,
            number: true,
        },
        property: {
            required: true,
        },
        unit: {
            required: true,
        },
        move_in_date: {
            required: true,
        },
        status: {
            required: true,
        },
    },
    messages: {
        first_name: {
            required: 'First name is required',
        },
        last_name: {
            required: 'Last name is required',
        },
        email: {
            required: 'Email is required',
            email: 'Please enter a valid email address',
        },
        phone: {
            required: 'Phone is required',
            number: 'Please enter a valid phone number',
        },
        property: {
            required: 'Property is required',
        },
        unit: {
            required: 'Unit is required',
        },
        move_in_date: {
            required: 'Move in date is required',
        },
        status: {
            required: 'Status is required',
        },
    },
    submitHandler: function() {
        var form = $('#addTenantModal').serialize();

        $.post('models/tenants/manageTenant.php',form,function(response){
           
            const data = JSON.parse(response);
            if(data.success){
                round_success_noti(data.message);
                    $('#addTenantModal').modal('hide');
                    location.reload();
                }else{
                    round_error_noti(data.message);
                }
        });
       
     
    }
});
});


/* ========================== Edit Tenant ========================== */
$(document).ready(function(){
$('#editTenantModal').validate({
    rules: {
        first_name: {
            required: true,
        },
        last_name: {
            required: true,
        },
        email: {
            required: true,
            email: true,
        },
        phone: {
            required: true,
            number: true,
        },
        move_in_date: {
            required: true,
        },
        status: {
            required: true,
        },
    },
    messages: {
        first_name: {
            required: 'First name is required',
        },
        last_name: {
            required: 'Last name is required',
        },
        email: {
            required: 'Email is required',
            email: 'Please enter a valid email address',
        },
        phone: {
            required: 'Phone is required',
            number: 'Please enter a valid phone number',
        },
        move_in_date: {
            required: 'Move in date is required',
        },
        status: {
            required: 'Status is required',
        },
    },
    submitHandler: function() {

        var form = $('#editTenantModal').serialize();

        $.post('models/tenants/manageTenant.php',form,function(response){
          
            const data = JSON.parse(response);
            if(data.success){
                round_success_noti(data.message);
                $('#editTenantModal').modal('hide');
                setTimeout(function(){
                    location.reload();
                }, 800);
            }else{
                round_error_noti(data.message);
            }
        });
        
    }
}); 
});


/* ========================== Tenant Payments ========================== */
function getTenantPayments(tenantId) {
    window.location.href = 'Payments.php?id=' + tenantId;
}


