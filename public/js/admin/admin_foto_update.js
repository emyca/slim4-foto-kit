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

    $('#modal_update_btn_update').click(function(e) {
        e.preventDefault();
        $("#modal_update_btn_update").prop("disabled", true);
        $('#modal_update_spinner').show();

        let updateId = $('span[id=id_update]').html();

        let formData = new FormData();
        formData.append('file', $('input[name=file_update]')[0].files[0]);
        formData.append('name', $('input[name=name_update]').val());
        formData.append('description', $('textarea[name=description_update]').val());

        $.ajax({
            method: 'POST',
            enctype: 'multipart/form-data',
            url: './fotos/' + updateId,
			dataType: 'json',
			contentType: false,
			processData: false,
			data: formData
        })
        .done(function(response) {
            $('#modal_update_spinner').hide();
            $("#modal_update_btn_update").prop("disabled", false);
            if(response.status == 401) {
                $('#modal_update_response')
                .css('color', '#f02d1f')
                .html("<span class='uk-margin-small-right' uk-icon='icon: warning'></span>" 
                    + response.message);
                setTimeout(function() {
                    window.location.replace(response.url);
                }, 1000);
            } else {
                if(response.success == false) {
                    $('#modal_update_response')
                        .css('color', '#f02d1f')
                        .html("<span class='uk-margin-small-right' uk-icon='icon: warning'></span>" 
                            + response.message);
                } else {
                    $('#modal_update_response')
                        .css('color', '#22a131')
                        .html("<span class='uk-margin-small-right' uk-icon='icon: check'></span>" 
                            + response.message);
                }
            }
        })
        .fail (function(e) { 
            $('#modal_update_spinner').hide();
            $("#modal_update_response").html(e.responseText);
            $("#modal_update_btn_update").prop("disabled", false);
        });
    });

    $('#modal_update_btn_close').click(function() {
        $('#form_update')[0].reset();
        $('#modal_update_response').html('');
        location.reload();
    });
});
