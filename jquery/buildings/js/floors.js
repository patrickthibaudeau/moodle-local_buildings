function init_floors() {
    $("#confirm_box").hide();
    $("#floors_table").DataTable({
        "lengthMenu": [[-1, 10, 25, 50], ["All", 10, 25, 50]],
        stateSave: false
    });

    $(".delete-floor").click(function () {
        var id = $(this).attr('data-id');
        var htmlString = 'Are you sure you want to delete this floor?<br>' +
                   'Do you also want to delete all rooms? ' +
                   '<select id="rooms">' +
                   '    <option value="0">No</option>' +
                   '    <option value="1">Yes</option>' +
                   '</select>';
        $('#confirm_box').html(htmlString);
        $("#confirm_box").dialog({
            modal: true,
            width: 'auto',
            title: 'Delete campus',
            buttons: [{
                    text: 'Delete',
                    click: function () {
                        var rooms = $("#rooms").val();
                        $.ajax({
                            type: "POST",
                            url: "ajax.php?action=deleteFloor&id=" + id + '&rooms=' + rooms,
                            dataType: "html",
                            success: function (resultData) {
                                if (resultData == 'ERROR-1451') {
                                    alert('This floor cannot be deleted because it is linked to other rooms.');
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


function init_floor() {
    $("#id_color").spectrum({
        showInput: true,
        allowEmpty: true,
        preferredFormat: "hex"
    });
}