$.validator.setDefaults( {
			submitHandler: function () {
				var formData = $( "#changePasswordModal" ).serialize();
			
				$.ajax({
					url: 'models/ChangePassword.php',
					type: 'POST',
					data: formData,
					success: function(response){
						var data = JSON.parse(response);
						if(data.success){
							round_success_noti(data.message);
							setTimeout(function() {
								location.reload();
							}, 1000);
							$('#changePasswordModal').modal('hide');
						}else{
							round_error_noti(data.message);
						}
					}
				});
			}
		} );

		$( document ).ready( function () {

			$( "#changePasswordModal" ).validate( {
				rules: {
					new_password: {
						required: true,
						minlength: 5
					},
					confirm_password: {
						required: true,
						minlength: 5,
						equalTo: "#new_password"
					}
				},
				messages: {
					new_password: {
						required: "Please provide a password",
						minlength: "Your password must be at least 5 characters long"
					},
					confirm_password: {
						required: "Please provide a password",
						minlength: "Your password must be at least 5 characters long",
						equalTo: "Please enter the same password as above"
					},
                    
				},
			
			} );

			

		} );