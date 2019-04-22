function init_frontpage() {
    $('#campusid').select2();
    $('#campusid').change(function () {
        var campusId = $(this).val();
        if (campusId != 0) {
            $.ajax({
                type: "POST",
                url: "ajax.php?action=getBuildingsSelect&campusId=" + campusId,
                dataType: "html",
                success: function (resultData) {
                    $('#buildingsSelect').html(resultData);
                    $('#buildingid').select2();
                }
            });
        }
    });



    $('#getFloors').click(function () {
        var wwwroot = M.cfg.wwwroot;
        var buildingId = $('#buildingid').val();
        window.location = wwwroot + '/local/buildings/admin/floors.php?buildingid=' + buildingId;
    });
}




