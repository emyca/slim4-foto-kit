document.getElementById('admin_signin_form_auth_btn').addEventListener('click', function(e) {
    e.preventDefault();

    const adminSigninFormSpinner = document.getElementById('admin_signin_form_spinner');
    const adminSigninFormAuthBtn = document.getElementById("admin_signin_form_auth_btn");
    const adminSigninFormResponse = document.getElementById('admin_signin_form_response');

    adminSigninFormSpinner.style.display = "block";
    adminSigninFormAuthBtn.disabled = true;
    adminSigninFormResponse.innerHTML = '';

    const url = "../admin/auth";

    const adminData = {
        adminLogin: document.querySelector('input[id=admin_signin_form_login]').value,
        adminPass: document.querySelector('input[id=admin_signin_form_pswd]').value
     }

    fetch(url, {
        credentials: 'same-origin',
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(adminData)
     })
     .then(response => {
        if (!response.ok) {
            adminSigninFormSpinner.style.display = "none";
            adminSigninFormAuthBtn.disabled = false;
            throw new Error(`HTTP Error: ${response.status}, ${response.statusText}!`);
        }
        return response.json();
     })
     .then(data => {
        adminSigninFormSpinner.style.display = "none";        
        if(data.success == false) {
            adminSigninFormResponse.style.color = "#f02d1f";
            adminSigninFormResponse.innerHTML = data.message;
        } else {
            window.location.replace(data.message);
        }
        adminSigninFormAuthBtn.disabled = false;
     })
     .catch(error => {
        adminSigninFormSpinner.style.display = "none";
        adminSigninFormAuthBtn.disabled = false;
        adminSigninFormResponse.style.color = "#f02d1f";
        if (error.message === 'Failed to fetch') {
            adminSigninFormResponse.innerHTML = "Network Error!";
        } else {
            adminSigninFormResponse.innerHTML = error.message;
        }
        throw error;
     });

})
