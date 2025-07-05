$(function() {

    $('#modal_add_btn_add').click(function(e) {
        e.preventDefault();
        $("#modal_add_btn_add").prop("disabled", true);
        $('#modal_add_spinner').show();

        let formData = new FormData();
        formData.append('file', $('input[name=file_add]')[0].files[0]);
        formData.append('name', $('input[name=name_add]').val());
        formData.append('description', $('textarea[name=description_add]').val());

        $.ajax({
            type: 'POST',
            enctype: 'multipart/form-data',
            url: './fotos',
			dataType: 'json',
			contentType: false,
			processData: false,            
			data: formData
        })
        .done(function(response) {
            $('#modal_add_spinner').hide();
            $('#modal_add_btn_add').prop("disabled", false);
            if(response.status == 401) {
                $('#modal_add_response')
                .css('color', '#f02d1f')
                .html("<span class='uk-margin-small-right' uk-icon='icon: warning'></span>" 
                    + response.message);
                setTimeout(function() {
                    window.location.replace(response.url);
                }, 1000);
            } else {
                if(response.success == false) {
                    $('#modal_add_response')
                        .css('color', '#f02d1f')
                        .html("<span class='uk-margin-small-right' uk-icon='icon: warning'></span>" 
                            + response.message);
                } else {
                    $('#modal_add_response')
                        .css('color', '#22a131')
                        .html("<span class='uk-margin-small-right' uk-icon='icon: check'></span>" 
                            + response.message);
                }
            }
        })
        .fail (function(e) { 
            $('#modal_add_spinner').hide();
            $('#modal_add_response').html(e.responseText);
            $('#modal_add_btn_add').prop("disabled", false);
        });
    });

    $('#modal_add_btn_close').click(function() {
        $('#form_add')[0].reset();
        $('#modal_add_response').html('');
        location.reload();
    });
});
