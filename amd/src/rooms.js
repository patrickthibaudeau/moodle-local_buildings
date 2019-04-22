define(['jquery', 'jqueryui', 'local_buildings/datatable', , 'local_buildings/spectrum'], function ($, jqui, DataTable, spectrum) {
    "use strict";

    /**
     * This is the function that is loaded
     * when the page is viewed.
     * @returns {undefined}
     */
    function initRooms() {
        $("#rooms_table").DataTable();
        initDeleteModal();

    }

    function initDeleteModal() {
        var wwwroot = M.cfg.wwwroot;

        $('.delete_room').click(function () {
            var id = $(this).data('id');
            console.log(id);
            var content = M.util.get_string('delete_room', 'local_buildings');
            $('#delete-content').html(content);
            $("#deleteModal").modal({
                show: true,
                focus: true
            });
            $('#deleteBtn').click(function () {
                $.ajax({
                    type: "POST",
                    url: "ajax.php?action=deleteRoom&id=" + id,
                    dataType: "text",
                    success: function (resultData) {
                        console.log(resultData);
                        location.reload();

                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            });
        });
    }

    return {
        init: function () {
            initRooms();
        }
    };
});