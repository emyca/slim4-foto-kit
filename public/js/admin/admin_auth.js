$(function() {

	$('#admin_signin_form_auth_btn').click(function(e) {
		e.preventDefault();
		$('#admin_signin_form_spinner').show();
		$("#admin_signin_form_auth_btn").prop("disabled", true);
		$('#admin_signin_form_response').html('');

		let formData = new FormData();
		formData.append('adminLogin', $('input[id=admin_signin_form_login]').val());
		formData.append('adminPass', $('input[id=admin_signin_form_pswd]').val());

		$.ajax({
			type: 'POST',
			url: '../admin/auth',            
			dataType:'json',
			contentType: false,
			processData: false,
			data: formData,
        })
        .done(function(response) {
            $('#admin_signin_form_spinner').hide();
            $('#admin_signin_form_auth_btn').prop("disabled", false);
            if(response.success == false) {                
                $('#admin_signin_form_response')
                .css('color', '#f02d1f')
                .html("<span class='uk-margin-small-right' uk-icon='icon: warning'></span>" 
                    + response.message);                
            } else {
                window.location.replace(response.message);               
            }
        })
        .fail (function(e) { 
            $('#admin_signin_form_spinner').hide();
            $('#admin_signin_form_response').html(e.responseText);
            $('#admin_signin_form_auth_btn').prop("disabled", false);
        });	
	});	
});
