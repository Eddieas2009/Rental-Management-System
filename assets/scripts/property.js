
$(document).ready(function() {
    $('#addPropertyModal').validate({
        rules: {
            propName: {
                required: true,
                minlength: 3,
                remote: {
                    url: 'models/property/getexisting_property.php',
                    type: 'POST',
                    data: {
                        propName: function() {
                            return $('#propName').val();
                        }
                    }
                }
            },

            type: {
                required: true
            },
            status: {
                required: true
            },
            location: {
                required: true
            },
            description: {
                required: true,
                minlength: 10
            }
            
        },
        messages: {
            propName: {
                required: "Please enter property name",
                minlength: "Property name must be at least 3 characters long",
                remote: "Property name already exists"
            },
            type: {
                required: "Please select property type"
            },
            status: {
                required: "Please select property status"
            },
            location: {
                required: "Please enter property location"
            },
            description: {
                required: "Please enter property description",
                minlength: "Description must be at least 10 characters long"
            }
        },
        submitHandler: function() {
            var formData = $('#addPropertyModal').serialize();
            
            $.ajax({
                url: 'models/property/manage_property.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    alert(response);
                    var data = JSON.parse(response);
                    if(data.success) {
                        round_success_noti(data.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        round_error_noti(data.message);
                    }
                },
                error: function() {
                    round_error_noti('Error occurred while saving property');
                }
            });
            return false;
        }
    });
});

/* ========================== Get Property ========================== */
function getProperty(propID){
    $.ajax({
        url: 'models/property/manage_property.php',
        type: 'POST',
        data: {propID: propID},
            success: function(response){
                var data = JSON.parse(response);
            if(data.success){
                $('#editPropertyModal #propertyId').val(data.property.propertyID);
                $('#editPropertyModal #propName').val(data.property.propName);
                $('#editPropertyModal #location').val(data.property.location);
                $('#editPropertyModal #type').val(data.property.type);
                $('#editPropertyModal #status').val(data.property.status);
                $('#editPropertyModal #description').val(data.property.description);

                $('#editPropertyModal').modal('show');
            }else{
                round_error_noti(data.message);
            }
        }
    });
}


/* ========================== Update Property ========================== */

$('#editPropertyModal').validate({
    rules: {
        propName: {
            required: true,
            minlength: 3
        },
        location: {
            required: true
        },
        type: {
            required: true
        },
        status: {
            required: true
        },
        description: {
            required: true,
            minlength: 10
        }
    },
    messages: {
        propName: {
            required: "Please enter property name",
            minlength: "Property name must be at least 3 characters long"
        },
        location: {
            required: "Please enter property location"
        },
        type: {
            required: "Please select property type"
        },
        status: {
            required: "Please select property status"
        },
        description: {
            required: "Please enter property description",
            minlength: "Description must be at least 10 characters long"
        }
    },
    submitHandler: function() {
        var formData = $('#editPropertyModal').serialize();
        $.ajax({
            url: 'models/property/manage_property.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                var data = JSON.parse(response);
                if(data.success) {
                    round_success_noti(data.message);
                    $('#editPropertyModal').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    round_error_noti(data.message);
                }
            },
            error: function() {
                round_error_noti('Error occurred while updating property');
            }
        });
        return false;
    }
});


