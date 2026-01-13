document.addEventListener("DOMContentLoaded", function()  {

    document.getElementById("modal_add_btn_add").addEventListener("click", function(e) {
        e.preventDefault();

        const modalAddBtnAdd = document.getElementById("modal_add_btn_add");
        const modalAddSpinner = document.getElementById("modal_add_spinner");
        const modalAddResponse = document.getElementById("modal_add_response");

        modalAddBtnAdd.disabled = true;
        modalAddSpinner.style.display = "block";    
        modalAddResponse.innerHTML = '';

        let formData = new FormData();
        // formData.append('file', document.querySelector("input[name=file_add]").files[0]);
        formData.append('file', document.getElementById("file_add").files[0]);
        formData.append('name', document.querySelector("input[name=name_add]").value);
        formData.append('description', document.querySelector("textarea[name=description_add]").value);

        const url = "./fotos";

        fetch(url, {
            method: 'POST',
            headers: {'Accept': 'application/json'},
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                modalAddSpinner.style.display = "none";
                modalAddBtnAdd.disabled = false;
                throw new Error(`HTTP Error: ${response.status}, ${response.statusText}!`);
            }
            return response.json();
        })
        .then(data => {
            modalAddSpinner.style.display = "none";
            modalAddBtnAdd.disabled = false;
            if(data.status == 401) {
                modalAddResponse.style.color = "#f02d1f";
                modalAddResponse.innerHTML = data.message;    
                setTimeout(function() {
                    window.location.replace(data.url);
                }, 1000);
            } else {
                if(data.success == false) {
                    modalAddResponse.style.color = "#f02d1f";
                    modalAddResponse.innerHTML = data.message;
                } else {
                    modalAddResponse.style.color = "#22a131";
                    modalAddResponse.innerHTML = data.message;
                }
            }
        })
        .catch(error => {
            modalAddSpinner.style.display = "none";
            modalAddBtnAdd.disabled = false;
            modalAddResponse.style.color = "#f02d1f";
            if (error.message === 'Failed to fetch') {
                modalAddResponse.innerHTML = "Network Error!";
            } else {
                modalAddResponse.innerHTML = error.message;
            }
            throw error;
        });
    });

    document.getElementById("modal_add_btn_close").addEventListener("click", function() {
        document.getElementById("form_add").reset();
        document.getElementById("modal_add_response").value = "";
        location.reload();
    });
});
