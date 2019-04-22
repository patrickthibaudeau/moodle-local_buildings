define(['jquery', 'jqueryui', 'local_buildings/spectrum'], function ($, jqui, spectrum) {
    "use strict";

    /**
     * This is the function that is loaded
     * when the page is viewed.
     * @returns {undefined}
     */
    function initEdit() {
        $("#id_color").spectrum({
            showInput: true,
            allowEmpty: true,
            preferredFormat: "hex"
        });

    }


    return {
        init: function () {
            initEdit();
        }
    };
});