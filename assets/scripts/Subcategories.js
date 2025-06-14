
function getSubCategories(categoryID){
    // Show loading spinner
    $('#subCategoryTable').html('<tr><td colspan="2" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>');
    
    $.ajax({
        url: 'models/maintenance/Subcategories.php',
        type: 'POST',
        data: {getSubCategoriesList: categoryID},
        success: function(response){
            var data = JSON.parse(response);
            var tblData = '';
            if(data.success){
                data.subCategories.forEach(function(subCategory){
                    tblData +=`
                    <tr>
                        <td>${subCategory.subcatName}</td>
                        <td>
                        <a href="javascript:;" onclick="getsubCategoryDetails(${subCategory.subcatID})" ><i class="bx bx-edit"></i>edit</a>
                        </td>
                    </tr>`;
                });

                $('#subCategoryTable').html(tblData);
            }else{
                round_error_noti(data.message);
                $('#subCategoryTable').html('<tr><td colspan="2" class="text-center">No data found</td></tr>');
            }
        },
        error: function(xhr, status, error){
            round_error_noti('Error: ' + error);
            $('#subCategoryTable').html('<tr><td colspan="2" class="text-center">Error loading data</td></tr>');
        }
    });
}


function getsubCategoryDetails(subcatID){
    $.ajax({
        url: 'models/maintenance/Subcategories.php',
        type: 'POST',
        data: {getSubCategoryDetails: subcatID},
        success: function(response){
            var mydata = JSON.parse(response);
            if(mydata.success){
                $('#editSubCategoryModal #subCatName').val(mydata.data.subcatName);
                $('#editSubCategoryModal #subCatId').val(mydata.data.subcatID);
                $('#editSubCategoryModal').modal('show');
            }else{
                round_error_noti(mydata.message);
            }
        },
        error: function(xhr, status, error){
            round_error_noti('Error: ' + error);
        }
    });
}


$(document).ready(function() {

    /* Open Add Sub Category Modal */
$('#addSubCategoryBtn').on('click', function(){

        if($('#categorySelect').val() == ''){
            alert('Please select a category');
            return;
        }
        $('#categoryID').val($('#categorySelect').val());
        $('#addSubCategoryModal').modal('show');


});

/* Get Sub Categories */

    $('#categorySelect').change(function() {
        getSubCategories($(this).val());
    });

    /* Search Sub Categories */
    $('#searchSubCategoryBtn').click(function() {
        if($('#categorySelect').val() == ''){
            alert('Please select a category');
            return;
        }
        var categoryID = $('#categorySelect').val();
        getSubCategories(categoryID);
    });


    /* Add Sub Category */

$('#addSubCategoryModal').validate({
    rules: {
        subCatName: {
            required: true
        }
    },
    messages: {
        subCatName: {
            required: 'Sub Category Name is required'
        }
    },
    submitHandler: function() {
        var formData = $('#addSubCategoryModal').serialize();
        $.ajax({
            url: 'models/maintenance/Subcategories.php',
            type: 'POST',
            data: formData,
            success: function(response){
                var data = JSON.parse(response);
                if(data.success){
                    round_success_noti(data.message);
                    setTimeout(function() {
                        $('#addSubCategoryModal').modal('hide');
                        getSubCategories($('#categorySelect').val());
                    }, 1000);
                }else{
                    round_error_noti(data.message);
                }
            },
            error: function(xhr, status, error){
                round_error_noti('Error: ' + error);
            }
        });
    },
    errorPlacement: function(error, element) {
        error.appendTo(element.parent());
    }

});

/* Edit Sub Category */

$('#editSubCategoryModal').validate({
    rules: {
        subCatName: {
            required: true
        }
    },
    messages: {
        subCatName: {
            required: 'Sub Category Name is required'
        }
    },
    submitHandler: function() {
        var formData = $('#editSubCategoryModal').serialize();
        $.ajax({
            url: 'models/maintenance/Subcategories.php',
            type: 'POST',
            data: formData,
            success: function(response){
                var data = JSON.parse(response);
                if(data.success){
                    round_success_noti(data.message);
                    setTimeout(function() {
                        $('#editSubCategoryModal').modal('hide');
                        getSubCategories($('#categorySelect').val());
                    }, 1000);
                }else{
                    round_error_noti(data.message);
                }
            },
            error: function(xhr, status, error){
                round_error_noti('Error: ' + error);
            }
        });
    },
    errorPlacement: function(error, element) {
        error.appendTo(element.parent());
    }


});

});

