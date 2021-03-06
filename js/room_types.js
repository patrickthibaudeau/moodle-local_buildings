function init_room_types() {
    $("#confirm_box").hide();
    $("#room_types_table").DataTable();

    $(".delete_room_type").click(function () {
        var id = $(this).attr('data-room_type');
        $('#confirm_box').html('Are you sure you want to delete this room type?');
        $("#confirm_box").dialog({
            modal: true,
            width: 'auto',
            title: 'Delete campus',
            buttons: [{
                    text: 'Delete',
                    click: function () {
                        $.ajax({
                            type: "POST",
                            url: "ajax.php?action=delete_room_type&id=" + id,
                            dataType: "html",
                            success: function (resultData) {
                                if (resultData == 'ERROR-1451') {
                                    alert('This room type cannot be deleted because it is currently associated.');
                                } else {
                                    $('#room_types_table_container').html(resultData);
                                    init_room_types();
                                }
                            }
                        });
                        $(this).dialog("close");
                    },
                },
                {
                    text: 'cancel',
                    click: function () {
                        $(this).dialog("close");
                    }
                }]
        })
    });
}

function init_room_type() {
    $("#id_color").spectrum({
        showInput: true,
        allowEmpty: true,
        preferredFormat: "hex"
    });
}