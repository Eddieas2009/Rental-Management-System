
function paymentsfilterTable() {
    $('#filterModal').modal('show');
}

$(document).ready(function() {
    $('#filterForm').submit(function(e) {
        e.preventDefault();
        var month = $('#month').val();
        var year = $('#year').val();
        $.ajax({
            url: 'models/reports/MonthlyPayments.php',
            type: 'POST',
            data: { month: month, year: year },
            success: function(response) {
                var data = JSON.parse(response);
                var table = '';
                var total = 0;
                if(data.success){
                    data.payments.forEach(function(payment){
                        total += parseFloat(payment.amount);
                        table += '<tr><td>' + payment.first_name + ' ' + payment.last_name + '</td><td>' + payment.propName + '</td><td>' + payment.unitname + '</td><td class="text-end">' + payment.month + ' ' + payment.year + '</td><td class="text-end">' + payment.payment_date + '</td><td class="text-end">' + parseFloat((payment.status=='Paid')?payment.amount:payment.partial_pay).toLocaleString() + '</td></tr>';
                    });
                    $('#paymentsTable').html(table);
                    $('#total').html(total.toLocaleString());
                }else{
                    $('#paymentsTable').html('<tr><td colspan="7" class="text-center">No payments found</td></tr>');
                }
            }
        });
    });
});
