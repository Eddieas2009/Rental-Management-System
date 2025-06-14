
function getCategoryDetails(id){
    $.post('models/expenses/category.php',{id:id},function(response){
        var data = JSON.parse(response);
        if(data.success){
            $('#editCategoryModal #catName').val(data.category.catname);
            $('#editCategoryModal #catID').val(data.category.id);
            $('#editCategoryModal').modal('show');
        }else{
            round_error_noti(data.message);
        }
    });
}

$(document).ready(function(){

$('#addCategoryModal').validate({
    rules:{
        catName:{
            required:true,
            remote:{
                url:'models/expenses/getexistingcategory.php',
                type:'post',
                data:{
                    catName:function(){return $('#catName').val();}
                }
            }
        }
    },
    messages:{
        catName:{
            required:"Category name is required",
            remote:"Category name already exists"
        }
    },
    submitHandler:function(){
        var formData = $('#addCategoryModal').serialize();
        $.post('models/expenses/category.php',formData,function(response){
            var data = JSON.parse(response);
            if(data.success){
                round_success_noti(data.message);
                setTimeout(function(){
                    window.location.reload();
                },1000);
            }else{
                round_error_noti(data.message);
            }
        });
    },
    errorPlacement:function(error,element){
        error.appendTo(element.parent());
    }
});

/* Edit Category */

$('#editCategoryModal').validate({
    rules:{
        catName:{
            required:true,
        },
    },
    messages:{
        catName:{
            required:"Category name is required"
        }
    },
    submitHandler:function(){
        var formData = $('#editCategoryModal').serialize();
        $.post('models/expenses/category.php',formData,function(response){
           
            var data = JSON.parse(response);
            if(data.success){
                round_success_noti(data.message);
                setTimeout(function(){
                    window.location.reload();
                },1000);
            }else{
                round_error_noti(data.message);
            }
        });
    }
})
    
    
});
