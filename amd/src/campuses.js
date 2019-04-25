define(['jquery', 'jqueryui', ], function ($, jqui) {
    "use strict";

    /**
     * This is the function that is loaded
     * when the page is viewed.
     * @returns {undefined}
     */
    function initCampuses() {
        initDeleteModal();

    }

    function initDeleteModal() {
        var wwwroot = M.cfg.wwwroot;

        $('.deleteCampus ').click(function () {
            var id = $(this).data('id');
            console.log(id);
            var content = M.util.get_string('delete_campus', 'local_buildings');
            $('#delete-content').html(content);
            $("#deleteModal").modal({
                show: true,
                focus: true
            });
            $('#deleteBtn').click(function () {
                $.ajax({
                    type: "POST",
                    url: "ajax.php?action=deleteCampus&id=" + id,
                    dataType: "html",
                    success: function (resultData) {                        
                            location.reload();
                    }
                });
            });
        });
    }

    return {
        init: function () {
            initCampuses();
        }
    };
});