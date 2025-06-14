function getRequestDetails(id){
    $.ajax({
        url: 'models/requests/getRequestDetails.php',
        type: 'POST',
        data: {requestId: id},
        success: function(response){
            
            var data = JSON.parse(response);
            if(data.success){
                $('#getRequestDetailsModal #requestId').val(data.request.id);
                $('.ticketNo').html('Ticket No: '+data.request.id);
                $('.dateCreated').html('Date Created: '+data.request.created_at);
                $('#getRequestDetailsModal #categoryName').val(data.request.catName);
                $('#getRequestDetailsModal #subcatName').val(data.request.subcatName);
                $('#getRequestDetailsModal #tenantName').val(data.tenant.first_name + ' ' + data.tenant.last_name);
                $('#getRequestDetailsModal #propName').val(data.tenant.propName);
                $('#getRequestDetailsModal #unitName').val(data.tenant.unitname);
               
                $('#getRequestDetailsModal #status').val(data.request.status);

                if(data.request.priority == 'Low'){
                    $('#getRequestDetailsModal #priority').html('<span class="badge bg-success">Low</span>');
                }else if(data.request.priority == 'Medium'){
                    $('#getRequestDetailsModal #priority').html('<span class="badge bg-warning">Medium</span>');
                }else if(data.request.priority == 'High'){
                    $('#getRequestDetailsModal #priority').html('<span class="badge bg-danger">High</span>');
                }
                $('#getRequestDetailsModal #requestDetails').val(data.request.description);
                $('#getRequestDetailsModal #replynotice').val(data.request.replynotice);
                $('#getRequestDetailsModal').modal('show');
            }else{
                round_error_noti(data.message);
            }
        },
        error: function(){
            round_error_noti('Error fetching request details');
        }
    });
}



$(document).ready(function(){

    $('#AddRequestDetailsModal #maintenanceCatID').change(function(){
        var maintenanceCatID = $(this).val();
        $.ajax({
            url: 'models/requests/getRequestDetails.php',
            type: 'POST',
            data: {maintenanceCatID: maintenanceCatID},
            success: function(response){
                var data = JSON.parse(response);
                var html = '<option value="">Select Service Request</option>';
                if(data.success){
                    data.sub.forEach(function(item){
                        html += '<option value="'+item.subcatID+'">'+item.subcatName+'</option>';
                    });
                    $('#AddRequestDetailsModal #maintenanceSubCatID').html(html);
                }else{
                    round_error_noti(data.message);
                }
            },
            error: function(){
                round_error_noti('Error fetching maintenance sub category');
            }
        });
    });
    

    $('#AddRequestDetailsModal #tenantNamelist').change(function(){
        var tenantID = $(this).val();
        $.ajax({
            url: 'models/requests/updateRequestStatus.php',
            type: 'POST',
            data: {GetPropertyUnitByID: tenantID},
            success: function(response){
                
                var data = JSON.parse(response);
                if(data.success){
                    $('#property').val(data.property.propName);
                    $('#unit').val(data.property.unitname);
                    $('#propertyID').val(data.property.propertyID);
                    $('#unitID').val(data.property.unitID);
                }else{
                    round_error_noti(data.message);
                }
            },
            error: function(){
                round_error_noti('Error fetching property details');
            }
        });
    });
    

/* ========================== Add Request Details ========================== */
$('#AddRequestDetailsModal').validate({
    rules: {
        tenantNamelist: {
            required: true
        },
        property: {
            required: true
        },
        unitID: {
            required: true
        },
        maintenanceCatID: {
            required: true
        },
        maintenanceSubCatID: {
            required: true
        },
        priority: {
            required: true
        },
        requestDetails: {
            required: true
        },
        messages: {
            tenantNamelist: {
                required: "Please select tenant"
            },
            property: {
                required: "Please select property"
            },
            unitID: {
                required: "Please select unit"
            },
            maintenanceCatID: {
                required: "Please select service category"
            },
            maintenanceSubCatID: {
                required: "Please select service request"
            },
            priority: {
                required: "Please select priority"
            },
            requestDetails: {
                required: "Please enter request details"
            }
        }
    },
    submitHandler: function() {
        var formData = $('#AddRequestDetailsModal').serialize();
        $.ajax({
            url: 'models/requests/updateRequestStatus.php',
            type: 'POST',
            data: formData,
            success: function(response){
                console.log(response);
                var data = JSON.parse(response);
                if(data.success){
                    round_success_noti(data.message);
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }else{
                    round_error_noti(data.message);
                }
            },
            error: function(){
                round_error_noti('Error adding request details');
            }
        });
    }
});


/* ========================== Update Request Details ========================== */
$('#getRequestDetailsModal').validate({
    rules: {
        status: {
            required: true
        },
        replynotice: {
            required: true,
            minlength: 5
        },
        messages: {
            status: {
                required: "Please select status",
            },
            replynotice: {
                required: "Please enter reply",
                minlength: "Reply must be at least 5 characters long"
            }
        }
    },
    submitHandler: function() {
        var formData = $('#getRequestDetailsModal').serialize();
        $.ajax({
            url: 'models/requests/updateRequestStatus.php',
            type: 'POST',
            data: formData,
            success: function(response){
                var data = JSON.parse(response);
                if(data.success){
                    round_success_noti(data.message);
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }else{
                    round_error_noti(data.message);
                }
            },
            error: function(){
                round_error_noti('Error updating request status');
            }
        });
    }

    
});



});
