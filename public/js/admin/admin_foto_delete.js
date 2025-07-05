$(function() {

    $('a[name="item_delete_btn"]').click(function(e) {
        e.preventDefault();
        let itemDeleteId = $(this).siblings('span[name="item_id"]').html();
        let itemDeleteName = $(this).siblings('span[name="item_name"]').html();
        $('#id_delete').html(itemDeleteId);
        $('#name_delete').html(itemDeleteName);
    });

    $('#modal_delete_btn_delete').click(function(e) {
        e.preventDefault();
        $("#modal_delete_btn_cancel").prop("disabled", true);
        $("#modal_delete_btn_delete").prop("disabled", true);
        $('#modal_delete_spinner').show();

        let deleteId = $('#id_delete').html();
        console.log(deleteId);

        $.ajax({
            type: 'DELETE',
			dataType: 'json',
			contentType: false,
			processData: false,
            url: './fotos/' + deleteId
        })
        .done(function(response) {
            $('#modal_delete_spinner').hide();
            if(response.status == 401) {
                $('#modal_delete_response')
                .css('color', '#f02d1f')
                .html("<span class='uk-margin-small-right' uk-icon='icon: warning'></span>" 
                    + response.message);
                setTimeout(function() {
                    window.location.replace(response.url);
                }, 1000);
            } else {
                UIkit.modal('#modal-delete').hide();
                let notification = "";
                if(response.success == false) {
                    notification = "<span style='color: #f02d1f;'>"
                        + "<span class='uk-margin-small-right' uk-icon='icon: warning'></span>" 
                        + response.message +"</span>";
                } else {
                    notification = "<span style='color: #22a131;'>" 
                        + "<span class='uk-margin-small-right' uk-icon='icon: check'></span>" 
                        + response.message +"</span>";   
                }
                UIkit.notification(notification);
                setTimeout(function(){location.reload()}, 2000);
            }   
        })
        .fail (function(e) { 
            $('#modal_delete_spinner').hide();
            $("#modal_delete_btn_cancel").prop("disabled", false);
            $("#modal_delete_btn_delete").prop("disabled", false);
            $("#modal_delete_response").html(e.responseText);
        });
    });
});
