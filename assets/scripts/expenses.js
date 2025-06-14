function getExpenseDetails(expenseID){
    $.post('models/expenses/Expenses.php',{expenseID:expenseID,getAction:1},function(response){
        var res = JSON.parse(response);
        if(res.success){
            $('#editExpenseModal').find('#expenseID').val(res.expense.id);
            $('#editExpenseModal').find('#catName').val(res.expense.category_id);
            $('#editExpenseModal').find('#amount').val(res.expense.amount);
            $('#editExpenseModal').find('#description').val(res.expense.description);
            $('#editExpenseModal').find('#expense_date').val(res.expense.expense_date);
            $('#editExpenseModal').find('#payment_method').val(res.expense.payment_method);
            $('#editExpenseModal').modal('show');
        }else{
            round_error_noti(res.message);
        }
    });
}



$(document).ready(function(){


$('#addExpenseModal').validate({
    rules:{
        catName:{
            required:true,
        },
        amount:{
            required:true,
            number:true,
        },
        description:{
            required:true,
        },
        expense_date:{
            required:true,
            date:true,
        },
        payment_method:{
            required:true,
        },
    },
    messages:{
        catName:{
            required:"Please select a category",
        },
        amount:{
            required:"Please enter an amount",
            number:"Please enter a valid amount",
        },
        description:{
            required:"Please enter a description",
        },
        expense_date:{
            required:"Please select an expense date",
            date:"Please select a valid date",
        },
        payment_method:{
            required:"Please select a payment method",
        },
    },
    submitHandler:function(){
        var formData = $('#addExpenseModal').serialize();
        $.post('models/expenses/Expenses.php',formData,function(response){
            var res = JSON.parse(response);
            if(res.success){
                round_success_noti(res.message);
                setTimeout(function(){
                    location.reload();
                }, 1000);
            }else{
                round_error_noti(res.message);
            }
        });
    },
    errorPlacement:function(error,element){
        error.insertAfter(element);
    }
});

/* Edit Expense Modal */

$('#editExpenseModal').validate({
    rules:{
        catName:{
            required:true,
        },
        amount:{
            required:true,
            number:true,
        },
        description:{
            required:true,
        },
        expense_date:{
            required:true,
            date:true,
        },
        payment_method:{
            required:true,
        },
    },
    messages:{
        catName:{
            required:"Please select a category",
        },
        amount:{
            required:"Please enter an amount",
            number:"Please enter a valid amount",
        },
        description:{
            required:"Please enter a description",
        },
        expense_date:{
            required:"Please select an expense date",
            date:"Please select a valid date",
        },
        payment_method:{
            required:"Please select a payment method",
        },
    },
    submitHandler:function(){
        var formData = $('#editExpenseModal').serialize();
        $.post('models/expenses/Expenses.php',formData,function(response){
            console.log(response);
            var res = JSON.parse(response);
            if(res.success){
                round_success_noti(res.message);
                setTimeout(function(){
                    location.reload();
                }, 1000);
            }else{
                round_error_noti(res.message);
            }
        });
    },
    errorPlacement:function(error,element){
        error.insertAfter(element);
    }
});















});