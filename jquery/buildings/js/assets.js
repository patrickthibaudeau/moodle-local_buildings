function init_assets() {
    $("#confirm_box").hide();
    $("#editassetss").prop('disabled', true);
    $("#assets_table").DataTable({
        "lengthMenu": [[-1, 25, 50], ["All", 25, 50]],
        stateSave: false,
        "order": [[1, "asc"]],
        "aoColumnDefs": [
            {"bSortable": false, "aTargets": [0]}
        ]

    });

    $(".delete-asset").click(function () {
        var id = $(this).attr('data-id');
        var htmlString = 'Are you sure you want to delete this asset?<br>';
        $('#confirm_box').html(htmlString);
        $("#confirm_box").dialog({
            modal: true,
            width: 'auto',
            title: 'Delete asset',
            buttons: [{
                    text: 'Delete',
                    click: function () {
                        var assets = $("#assets").val();

                        $.ajax({
                            type: "POST",
                            url: "ajax.php?action=deleteAsset&id=" + id,
                            dataType: "html",
                            success: function (resultData) {
                                if (resultData == 'ERROR-1451') {
                                    alert('This asset cannot be deleted because it is linked to one or more rooms.');
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

