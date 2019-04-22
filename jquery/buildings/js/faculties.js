function init_faculties() {
    $("#confirm_box").hide();
    $("#faculties_table").DataTable({
        "pageLength": -1
    });

    $("#faculties_table .delete-faculty").click(function () {
        var id = $(this).attr('data-id');
        $('#confirm_box').html('Are you sure you want to delete this faculty?');
        $("#confirm_box").dialog({
            modal: true,
            width: 'auto',
            title: 'Delete faculty',
            buttons: [{
                    text: 'Delete',
                    click: function () {
                        $.ajax({
                            type: "POST",
                            url: "ajax.php?action=deleteFaculty&id=" + id,
                            dataType: "html",
                            success: function (resultData) {
                                if (resultData == 'ERROR-1451') {
                                    alert('This faculty cannot be deleted because it is associated to one or more rooms.');
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

function init_faculty() {
    $('#id_shortname').prop('maxlength', '2');
}