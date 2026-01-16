$(function() {

    const adminSigninFormAuthBtn = $('#admin_signin_form_auth_btn');
    const adminSigninFormSpinner = $('#admin_signin_form_spinner');
    const adminSigninFormResponse = $('#admin_signin_form_response');

	adminSigninFormAuthBtn.click(function(e) {
		e.preventDefault();
		adminSigninFormSpinner.show();
		adminSigninFormAuthBtn.prop("disabled", true);
		adminSigninFormResponse.html('');

		let formData = new FormData();
		formData.append('adminLogin', $('input[id=admin_signin_form_login]').val());
		formData.append('adminPass', $('input[id=admin_signin_form_pswd]').val());

        fetch("../admin/auth", {
            method: 'POST',
            headers: {
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                adminSigninFormSpinner.hide();
                adminSigninFormAuthBtn.prop("disabled", false);
                throw new Error(`HTTP Error: ${response.status}, 
                    ${response.statusText}!`);
            }
            return response.json();
        })
        .then(data => {
            adminSigninFormSpinner.hide();
            if(data.success == false) {
                adminSigninFormResponse.css('color', '#f02d1f')
                    .html(data.message);
            } else {
                window.location.replace(data.message);
            }
            adminSigninFormAuthBtn.prop("disabled", false);
        })
        .catch(error => {
            adminSigninFormSpinner.hide();
            adminSigninFormAuthBtn.prop("disabled", false);
            if (error.message === 'Failed to fetch') {
                adminSigninFormResponse.css('color', '#f02d1f')
                    .html("Network Error!")                
            } else {
                adminSigninFormResponse.css('color', '#f02d1f')
                    .html(error.message)
            }       
        });
	});	
});
