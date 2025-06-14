
$(document).ready(function() {
    $('#addUserModal').validate({
        rules: {
            names: {
                required: true,
            },
            username: {
                required: true,
            remote: {
                url: 'models/admin/check_username.php',
                type: 'post',
                data: {
                    username: function() {
                        return $('#username').val();
                    }
                }
            }
            },
            password: {
                required: true,
            },
            confirm_password: {
                required: true,
                equalTo: "#password"
            },
            role: {
                required: true,
            },
        },
        messages: {
            names: {
                required: "Please enter a name",
            },
            username: {
                required: "Please enter a username",
                remote: "Username already exists",
            },
            password: {
                required: "Please enter a password",
            },
            confirm_password: {
                required: "Please enter a confirm password",
                equalTo: "Please enter the same password as above",
            },
            role: {
                required: "Please select a role",
            },
        },
        submitHandler: function() {
            var form = $('#addUserModal');
            var formData = new FormData(form[0]);
            formData.append('action', 'add_user');
            
            $.ajax({
                url: 'models/admin/manage_user.php',
                type: 'POST',
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Let the browser set the content type
                success: function(response) {
                    var response = JSON.parse(response);
                if(response.success) {
                    round_success_noti(response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    round_error_noti(response.message);
                }
            },
            error: function() {
                round_error_noti('Error occurred while adding user');
            }
        });
        return false;
    }
    });
});
/* =============================== END OF ADD USER =============================== */

/* =============================== START GET USER =============================== */

function GetUserDetails(id){
    $.ajax({
        url: 'models/admin/manage_user.php',
        type: 'POST',
        data: {action: 'get_user', id: id},
        success: function(response) {
            
            var data = JSON.parse(response);
            $('#editUserModal #userId').val(data.user.userID);
            $('#editUserModal #names').val(data.user.names);
            $('#editUserModal #username').val(data.user.username);
            $('#editUserModal #role').val(data.user.role);
            (data.user.canview == 1) ? $('#editUserModal #canview').prop('checked', true) : $('#editUserModal #canview').prop('checked', false);
            (data.user.canedit == 1) ? $('#editUserModal #canedit').prop('checked', true) : $('#editUserModal #canedit').prop('checked', false);
            (data.user.cancreate == 1) ? $('#editUserModal #cancreate').prop('checked', true) : $('#editUserModal #cancreate').prop('checked', false);
            (data.user.canaprove == 1) ? $('#editUserModal #canaprove').prop('checked', true) : $('#editUserModal #canaprove').prop('checked', false);
            $('#editUserModal').modal('show');
        },
        error: function() {
            round_error_noti('Error occurred while getting users');
        }
    });
}

/* =============================== END OF GET USER =============================== */

/* =============================== START OF EDIT USER =============================== */

$(document).ready(function() {
    $('#editUserModal').validate({
        rules: {
            names: {
                required: true,
            },  
            username: {
                required: true,
            },
            role: {
                required: true,
            },
        },  
        messages: {
            names: {
                required: "Please enter a name",
            },
            username: {
                required: "Please enter a username",
            },
            role: {
                required: "Please select a role",
            },
        },
        submitHandler: function() {
            var form = $('#editUserModal').serialize();

            $.ajax({
                url: 'models/admin/manage_user.php',
                type: 'POST',
                data: form,
                processData: false,
                success: function(response) {
                    var response = JSON.parse(response);
                    if(response.success) {
                        round_success_noti(response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        round_error_noti(response.message);
                    }
                },
                error: function() {
                    round_error_noti('Error occurred while editing user');
                }
            });
            return false;
        }
    });
});
/* =============================== END OF EDIT USER =============================== */

/* =============================== START OF CHANGE STATUS =============================== */

function changeStatus(id, status){
    if(confirm('Are you sure you want to change the status of this account?')){
        $.ajax({
            url: 'models/admin/manage_user.php',
            type: 'POST',
            data: {action: 'change_status', id: id, acc_status: status},
            success: function(response){
                var response = JSON.parse(response);
                if(response.success){
                    round_success_noti(response.message);
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                } else {
                    round_error_noti(response.message);
                }
            },
            error: function(){
                round_error_noti('Error occurred while changing status');
            }

        });
    }
}
/* =============================== END OF CHANGE STATUS =============================== */


/* =============================== START OF CHANGE PASSWORD =============================== */

function ChangeUserPassword(id){
    $('#ChangeUserPasswordModal #userId').val(id);
    $('#ChangeUserPasswordModal').modal('show');
}

$('#ChangeUserPasswordModal').validate({
    rules: {
        new_password: {
            required: true,
        },
        confirm_password: {
            required: true,
            equalTo: "#new_password"
        },
    },
    messages: {
        new_password: {
            required: "Please enter a new password",
        },
        confirm_password: {
            required: "Please enter a confirm password",
            equalTo: "Please enter the same password as above",
        },
    },
    submitHandler: function() { 
        var form = $('#ChangeUserPasswordModal').serialize();
        $.ajax({
            url: 'models/admin/manage_user.php',
            type: 'POST',
            data: form,
            success: function(response){
                var response = JSON.parse(response);
                if(response.success){
                    round_success_noti(response.message);
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }else{
                    round_error_noti(response.message);
                }
            },
            error: function(){
                round_error_noti('Error occurred while changing password');
            }
        });
        return false;
    }
});



/* =============================== END OF CHANGE PASSWORD =============================== */

