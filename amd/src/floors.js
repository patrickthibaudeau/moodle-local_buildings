define(['jquery', 'jqueryui', 'local_buildings/datatable', , 'local_buildings/spectrum'], function ($, jqui, DataTable, spectrum) {
    "use strict";

    /**
     * This is the function that is loaded
     * when the page is viewed.
     * @returns {undefined}
     */
    function initFloors() {
        $("#floors_table").DataTable({
            "lengthMenu": [[-1, 10, 25, 50], ["All", 10, 25, 50]]
        });
        initDeleteModal();

    }

    function initDeleteModal() {
        var wwwroot = M.cfg.wwwroot;

        $('.delete_floor').click(function () {
            var id = $(this).data('id');
            console.log(id);
            var content = M.util.get_string('delete_floor', 'local_buildings');
            $('#delete-content').html(content);
            $("#deleteModal").modal({
                show: true,
                focus: true
            });
            $('#deleteBtn').click(function () {
                $.ajax({
                    type: "POST",
                    url: "ajax.php?action=deleteFloor&id=" + id,
                    dataType: "html",
                    success: function (resultData) {
                        if (resultData == 'ERROR-1451') {
                            alert('This building cannot be deleted because a floor is linked to this building.');
                        } else {
                            location.reload();
                        }
                    }
                });
            });
        });
    }

    return {
        init: function () {
            initFloors();
        }
    };
});