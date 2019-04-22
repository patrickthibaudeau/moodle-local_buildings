function init_buildings() {
    $("#confirm_box").hide();
    $("#buildings_table").DataTable();

    $(".delete-building").click(function () {
        var id = $(this).attr('data-id');
        var htmlString = 'Are you sure you want to delete this building?<br>' +
                'Do you also want to delete all rooms and floors ' +
                '<select id="floors">' +
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
                        var floors = $("#floors").val();
                        $.ajax({
                            type: "POST",
                            url: "ajax.php?action=deleteBuilding&id=" + id + '&floors=' + floors,
                            dataType: "html",
                            success: function (resultData) {
                                if (resultData == 'ERROR-1451') {
                                    alert('This building cannot be deleted because a floor is linked to this building.');
                                } else {
                                    $('#buildings_table_container').html(resultData);
                                    init_buildings();
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


function init_building() {
    $("#id_color").spectrum({
        showInput: true,
        allowEmpty: true,
        preferredFormat: "hex"
    });

    $('#id_number_of_floors').change(function () {
        if ($('#id_number_of_floors').val() < 0) {
            alert('You cannot enter a number below zero')
        }
    });

}


function initMap() {
    var map;
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 43.726817, lng: -79.378007},
        zoom: 16
    });

}