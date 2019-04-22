function init_campuses() {
    $("#confirm_box").hide();
    $("#campuses_table").DataTable();

    $(".delete-campus").click(function () {
        var id = $(this).attr('data-id');
        $('#confirm_box').html('Are you sure you want to delete this campus?');
        $("#confirm_box").dialog({
            modal: true,
            width: 'auto',
            title: 'Delete campus',
            buttons: [{
                    text: 'Delete',
                    click: function () {
                        $.ajax({
                            type: "POST",
                            url: "ajax.php?action=deleteCampus&id=" + id,
                            dataType: "html",
                            success: function (resultData) {
                                if (resultData == 'ERROR-1451') {
                                    alert('This campus cannot be deleted because a building is linked to this campus.');
                                } else {
                                    location.reload();
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

function init_campus() {
    $("#id_color").spectrum({
        showInput: true,
        allowEmpty: true,
        preferredFormat: "hex"
    });

}