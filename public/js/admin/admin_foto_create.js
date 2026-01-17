$(function() {

    const modalAddBtnAdd = $('#modal_add_btn_add');
    const modalAddSpinner = $('#modal_add_spinner');
    const modalAddBtnClose = $('#modal_add_btn_close');
    const modalAddResponse = $('#modal_add_response');
    const errorColor = '#f02d1f';
    const successColor = '#22a131';

    modalAddBtnAdd.click(function(e) {
        e.preventDefault();
        modalAddBtnAdd.prop("disabled", true);
        modalAddSpinner.show();

        let formData = new FormData();
        formData.append('file', $('input[name=file_add]')[0].files[0]);
        formData.append('name', $('input[name=name_add]').val());
        formData.append('description', $('textarea[name=description_add]').val());

        fetch('./fotos', {
            method: 'POST',
            headers: {'Accept': 'application/json'},
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                modalAddSpinner.hide();
                modalAddBtnAdd.prop("disabled", false);
                throw new Error(`HTTP Error: ${response.status}, 
                    ${response.statusText}!`);
            }
            return response.json();
        })
        .then(data => {
            modalAddSpinner.hide();
            modalAddBtnAdd.prop("disabled", false);
            if(data.status == 401) {
                modalAddResponse.css('color', errorColor);
                modalAddResponse.html(data.message);
                setTimeout(function() {
                    window.location.replace(data.url);
                }, 1000);
            } else {
                if(data.success == false) {
                    modalAddResponse.css('color', errorColor);
                    modalAddResponse.html(data.message);
                } else {
                    modalAddResponse.css('color', successColor);
                    modalAddResponse.html(data.message);
                }
            }
        })
        .catch(error => {
            modalAddSpinner.hide();
            modalAddBtnAdd.prop("disabled", false);
            modalAddResponse.css('color', errorColor);
            if (error.message === 'Failed to fetch') {
                modalAddResponse.html("Network Error!");
            } else {
                modalAddResponse.html(error.message);
            }
        });
    });

    modalAddBtnClose.click(function() {
        $('#form_add')[0].reset();
        modalAddResponse.html('');
        location.reload();
    });
});
