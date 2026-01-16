$(function() {

    $('a[name="item_delete_btn"]').click(function() {
        let itemDeleteId = $(this).siblings('span[name="item_id"]').html();
        let itemDeleteName = $(this).siblings('span[name="item_name"]').html();
        $('#id_delete').html(itemDeleteId);
        $('#name_delete').html(itemDeleteName);
    });

    const modalDeleteBtnDelete = $("#modal_delete_btn_delete");
    const modalDeleteBtnCancel = $("#modal_delete_btn_cancel");
    const modalDeleteSpinner = $('#modal_delete_spinner');
    const modalDeleteResponse = $('#modal_delete_response');

    modalDeleteBtnDelete.click(function(e) {
        e.preventDefault();

        modalDeleteBtnCancel.prop("disabled", true);
        modalDeleteBtnDelete.prop("disabled", true);
        modalDeleteSpinner.show();

        let deleteId = $('#id_delete').html();

        fetch('./fotos/' + deleteId, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                modalDeleteSpinner.hide();
                modalDeleteBtnCancel.prop("disabled", false);
                modalDeleteBtnDelete.prop("disabled", false);
                throw new Error(`HTTP Error: ${response.status}, 
                    ${response.statusText}!`);
            }
            return response.json();
        })
        .then(data => {
            modalDeleteSpinner.hide();
            modalDeleteBtnDelete.prop("disabled", false);
            if(data.status == 401) {
                modalDeleteResponse.css('color', '#f02d1f')
                    .html(data.message);
                setTimeout(function() {
                    window.location.replace(data.url);
                }, 1000);
            } else {
                if(data.success == false) {                 
                    modalDeleteResponse.css('color', '#f02d1f')
                        .html(data.message);
                } else {
                    modalDeleteResponse.css('color', '#22a131')
                        .html(data.message);                    
                }
                modalDeleteBtnCancel.prop("disabled", true);
                modalDeleteBtnDelete.prop("disabled", true);
                setTimeout(function(){location.reload()}, 1000);
            }
        })
        .catch(error => {
            modalDeleteSpinner.hide();
            modalDeleteBtnCancel.prop("disabled", false);
            modalDeleteBtnDelete.prop("disabled", false);
            if (error.message === 'Failed to fetch') {
                modalDeleteResponse.css('color', '#f02d1f')
                    .html("Network Error!")                
            } else {
                modalDeleteResponse.css('color', '#f02d1f')
                    .html(error.message)
            }
        });
    });

    modalDeleteBtnCancel.click(function(e) {
        e.preventDefault();
        modalDeleteResponse.html('');
        location.reload();
    });
});
