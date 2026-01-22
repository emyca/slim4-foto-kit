$(function() {

    $('a[name="item_update_btn"]').click(function(e) {
        e.preventDefault();
        let itemUpdateId = $(this).siblings('span[name="item_id"]').html();
        let itemUpdateName = $(this).siblings('span[name="item_name"]').html();
        let itemUpdateDescription = $(this).siblings('span[name="item_description"]').html();
        $('#id_update').html(itemUpdateId);
        $('#name_update').val(itemUpdateName);
        $('#description_update').val(itemUpdateDescription);
    });

    const modalUpdateBtnUpdate = $('#modal_update_btn_update');
    const modalUpdateSpinner = $('#modal_update_spinner');
    const modalUpdateResponse = $('#modal_update_response');
    const modalUpdateBtnClose = $('#modal_update_btn_close');
    const errorColor = '#f02d1f';
    const successColor = '#22a131';

    modalUpdateBtnUpdate.click(function(e) {
        e.preventDefault();
        modalUpdateBtnUpdate.prop("disabled", true);
        modalUpdateSpinner.show();

        let updateId = $('span[id=id_update]').html();

        let formData = new FormData();
        formData.append('file', $('input[name=file_update]')[0].files[0]);
        formData.append('name', $('input[name=name_update]').val());
        formData.append('description', $('textarea[name=description_update]').val());

        fetch('./fotos/' + updateId, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                // Custom header for JSON response to Fetch API request
                'X-Data-Request': 'data-manipulate'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                modalUpdateSpinner.hide();
                modalUpdateBtnUpdate.prop("disabled", false);
                throw new Error(`HTTP Error: ${response.status}, 
                    ${response.statusText}!`);
            }
            return response.json();
        })
        .then(data => {
            modalUpdateSpinner.hide();
            modalUpdateBtnUpdate.prop("disabled", false);
            if(data.status == 401) {
                modalUpdateResponse.css('color', errorColor)
                    .html(data.message);
                setTimeout(function() {
                    window.location.replace(data.url);
                }, 1000);
            } else {
                if(data.success == false) {
                    modalUpdateResponse.css('color', errorColor)
                        .html(data.message);
                } else {
                    modalUpdateResponse.css('color', successColor)
                        .html(data.message);
                }
            }
        })
        .catch(error => {
            modalUpdateSpinner.hide();
            modalUpdateBtnUpdate.prop("disabled", false);
            modalUpdateResponse.css('color', errorColor);
            if (error.message === 'Failed to fetch') {
                modalUpdateResponse.html("Network Error!");
            } else {
                modalUpdateResponse.html(error.message);
            }
        });    
    });

    modalUpdateBtnClose.click(function() {
        $('#form_update')[0].reset();
        modalUpdateResponse.html('');
        location.reload();
    });
});
