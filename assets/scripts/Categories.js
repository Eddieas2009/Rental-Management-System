
function getCategoryDetails(catID){
    $.ajax({
        url: 'models/maintenance/Categories.php',
        type: 'POST',
        data: {getCategoryDetails: catID },
        success: function(response){
            var data = JSON.parse(response);
            if(data.success){
                $('#editCategoryModal #catName').val(data.category.catName);
                $('#editCategoryModal #catID').val(data.category.catID);
                $('#editCategoryModal').modal('show');
            }else{
                round_error_noti(data.message);
            }
        },
        error: function(xhr, status, error) {
            round_error_noti('Error occurred while getting category details');
        }
    });
}



$(document).ready(function() {
    $('#addCategoryModal').validate({
        rules: {
            catName: {
                required: true,
            }
        },
        messages: {
            catName: {
                required: "Category name is required",
            }
        },
        submitHandler: function() {
            var formData = $('#addCategoryModal').serialize();
            $.ajax({
                url: 'models/maintenance/Categories.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    var data = JSON.parse(response);
                    if(data.success) {
                        round_success_noti(data.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }else{
                        round_error_noti(data.message);
                    }
                },
                error: function(xhr, status, error) {
                    round_error_noti('Error occurred while adding category');
                }
            });
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.parent());
        }

    });

    $('#editCategoryModal').validate({
        rules: {
            catName: {
                required: true
            }
        },
        messages: {
            catName: {
                required: "Category name is required"
            }
        },
        submitHandler: function() {
            var formData = $('#editCategoryModal').serialize();
            $.ajax({
                url: 'models/maintenance/Categories.php',
                type: 'POST',
                data: formData,
                success: function(response){
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
                
            });
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.parent());
        }
    });
});

