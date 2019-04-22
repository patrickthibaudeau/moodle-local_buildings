<?php

require_once('../config.php');
include("../locallib.php");
include("room_type_form.php");

/**
 * Display the content of the page
 * @global stdClass $CFG
 * @global moodle_database $DB
 * @global core_renderer $OUTPUT
 * @global moodle_page $PAGE
 * @global stdClass $SESSION
 * @global stdClass $USER
 */
function display_page() {
    // CHECK And PREPARE DATA
    global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $USER;
    $COURSE;

    require_login(1, FALSE);
    $id = optional_param('id', 0, PARAM_INT);

    //Set principal parameters
    $context = CONTEXT_SYSTEM::instance();

    if ((!has_capability('local/buildings:admin', $context))) {
        redirect($CFG->wwwroot, get_string('no_permission', 'local_buildings'), 5);
    }

    if ($id) {
        $formdata = $DB->get_record('buildings_room_types', array('id' => $id), '*', MUST_EXIST);
    } else {
        $formdata = new stdClass();
    }

    $ROOMTYPE = new \local_buildings\RoomType($id);

    echo \local_buildings\Base::buildingsPage($CFG->pluginlocalwww . '/buildings_room_types.php', get_string('room_types', 'local_buildings'), get_string('room_types', 'local_buildings'), $context);

    $mform = new room_type_form(null, array('formdata' => $formdata));

// If data submitted, then process and store.
    if ($mform->is_cancelled()) {
        redirect($CFG->pluginlocalwww . '/admin/room_types.php');
    } else if ($data = $mform->get_data()) {


        if ($data->id) {

            $data->timemodified = time();
            //update record
            $ROOMTYPE->update($data);
        } else {
            $data->timecreated = time();
            $data->timemodified = time();

            $ROOMTYPE->create($data);
        }
        redirect($CFG->pluginlocalwww . '/admin/room_types.php');
    }

    //--------------------------------------------------------------------------
    echo $OUTPUT->header();
    //**********************
    //*** DISPLAY HEADER ***
    $initjs = "$(document).ready(function() {
                        init_room_type();
                    });";
    echo html_writer::script($initjs);
    echo '<div class="container-fluid">';
    $mform->display();
    echo '</div>';
    //**********************
    //*** DISPLAY FOOTER ***
    //**********************
    echo $OUTPUT->footer();
}

display_page();
?>