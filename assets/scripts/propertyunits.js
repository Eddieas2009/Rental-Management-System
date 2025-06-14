
$(document).ready(function() {
    $('#addUnitModal').validate({
        rules: {
            unitname: {
                required: true,
                minlength: 3,
                remote: {
                    url: 'models/property/getexisting_unitname.php',
                    type: 'POST',
                    data: {
                        unitname: function() {
                            return $('#unitname').val();
                        }
                    }
                }
            },

            bathrooms: {
                required: true
            },
            bedrooms: {
                required: true
            },
            rentamount: {
                required: true
            },
            unitstatus: {
                required: true
            }
        },
        messages: {
            unitname: {
                required: "Please enter unit name",
                minlength: "Unit name must be at least 3 characters long",
                remote: "Unit name already exists"
            },
            bathrooms: {
                required: "Please enter number of bathrooms"
            },
            bedrooms: {
                required: "Please enter number of bedrooms"
            },
            rentamount: {
                required: "Please enter rent amount"
            },
            unitstatus: {
                required: "Please select unit status"
            }
        },
        submitHandler: function() {
            var formData = $('#addUnitModal').serialize();
            
            $.ajax({
                url: 'models/property/manage_unit.php',
                type: 'POST',
                data: formData,
                success: function(response) {
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
function getUnit(unitID){
    $.ajax({
        url: 'models/property/manage_unit.php',
        type: 'POST',
        data: {unitID: unitID},
            success: function(response){
                console.log(response);
                var data = JSON.parse(response);
            if(data.success){
                $('#editUnitModal #unitId').val(data.unit.unitID);
                $('#editUnitModal #unitname').val(data.unit.unitname);
                $('#editUnitModal #bathrooms').val(data.unit.bathrooms);
                $('#editUnitModal #bedrooms').val(data.unit.bedrooms);
                $('#editUnitModal #rentamount').val(data.unit.rentamount);
                $('#editUnitModal #unitstatus').val(data.unit.unitstatus);
                $('#editUnitModal #description').val(data.unit.description);

                $('#editUnitModal').modal('show');
            }else{
                round_error_noti(data.message);
            }
        }
    });
}


/* ========================== Update Unit ========================== */

$('#editUnitModal').validate({
    rules: {
        unitname: {
            required: true,
            minlength: 3
        },
        bathrooms: {
            required: true
        },
        bedrooms: {
            required: true
        },
        rentamount: {
            required: true
        },
        unitstatus: {
            required: true
        }
    },
    messages: {
        unitname: {
            required: "Please enter unit name",
            minlength: "Unit name must be at least 3 characters long"
        },
        bathrooms: {
            required: "Please enter number of bathrooms"
        },
        bedrooms: {
            required: "Please enter number of bedrooms"
        },
        rentamount: {
            required: "Please enter rent amount"
        },
        unitstatus: {
            required: "Please select unit status"
        }
    },
    submitHandler: function() {
        var formData = $('#editUnitModal').serialize();
        $.ajax({
            url: 'models/property/manage_unit.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                var data = JSON.parse(response);
                if(data.success) {
                    round_success_noti(data.message);
                    $('#editUnitModal').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    round_error_noti(data.message);
                }
            },
            error: function() {
                round_error_noti('Error occurred while updating unit');
            }
        });
        return false;
    }
});


