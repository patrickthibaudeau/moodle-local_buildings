function init_rooms() {
    $("#confirm_box").hide();
    $("#editRooms").prop('disabled', true);
    $("#rooms_table").DataTable({
        "lengthMenu": [[-1, 25, 50], ["All", 25, 50]],
        stateSave: false,
        "order": [[1, "asc"]],
        "aoColumnDefs": [
            {"bSortable": false, "aTargets": [0]}
        ]

    });

    $(".delete-room").click(function () {
        var id = $(this).attr('data-id');

        var htmlString = 'Are you sure you want to delete this room?<br>';
        $('#confirm_box').html(htmlString);
        $("#confirm_box").dialog({
            modal: true,
            width: 'auto',
            title: 'Delete rooms',
            buttons: [{
                    text: 'Delete',
                    click: function () {
                        var rooms = $("#rooms").val();

                        $.ajax({
                            type: "POST",
                            url: "ajax.php?action=deleteRoom&id=" + id,
                            dataType: "html",
                            success: function (resultData) {
                                if (resultData == 'ERROR-1451') {
                                    alert('This room cannot be deleted because it is linked to other rooms.');
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

    $("#checkAll").click(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));

        if ($("input[name='id']").is(':checked')) {
            $('#editRooms').removeAttr('disabled');
        } else {
            $('#editRooms').attr('disabled', 'disabled');
        }
    });

    //Show edit button if checkbox checked
    $("input[name='id']").click(function () {
        if ($(this).is(':checked')) {
            $('#editRooms').removeAttr('disabled');
        } else {
            $('#editRooms').attr('disabled', 'disabled');
        }
    });

    $("#editRooms").click(function () {
        var ids = $('input[name="id"]:checked').map(function () {
            return this.value;
        }).get();
        $('#ids').val(ids);
    });

    $('#assets').select2({
        width: 400
    });

    $('#submitRoomEdits').click(function () {
        $.ajax({
            type: "POST",
            url: "ajax.php?action=updateRooms",
            data: $('#editRoomsForm').serialize(),
            dataType: "html",
            success: function (resultData) {
                $('#room_table_container').html(resultData);
                init_rooms();
            }
        });
    });
}


function init_room() {
    $("#id_color").spectrum({
        showInput: true,
        allowEmpty: true,
        preferredFormat: "hex"
    });

    $('#id_roomtypeid').select2();
    $('#id_parentroomid').select2();

    $('#id_assets').select2();
}

function enableEditRooms() {

}
