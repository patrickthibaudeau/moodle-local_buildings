<?php

/**
 * *************************************************************************
 * *                               buildings                              **
 * *************************************************************************
 * @package     local                                                     **
 * @subpackage  buildings                                                 **
 * @name        buildings                                                 **
 * @copyright   oohoo.biz                                                 **
 * @link        http://www.glendon.yorku.ca                               **
 * @author      Glendon ITS                                               **
 * @author      Patrick Thibaudeau                                        **
 * @author      Aladin Alaily                                             **
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later  **
 * *************************************************************************
 * ************************************************************************ */
require_once('../config.php');
include("../locallib.php");
include("asset_form.php");

/**
 * Display the content of the page
 * @global stdobject $CFG
 * @global moodle_database $DB
 * @global core_renderer $OUTPUT
 * @global moodle_page $PAGE
 * @global stdobject $SESSION
 * @global stdobject $USER
 */
function display_page() {
    // CHECK And PREPARE DATA
    global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $USER;
    $COURSE;

    require_login(1, FALSE);

    $id = optional_param('id', 0, PARAM_INT);

    //Set principal parameters
    $context = CONTEXT_SYSTEM::instance();

    if ((!has_capability('local/buildings:editbuilding', $context)) || (!has_capability('local/buildings:admin', $context))) {
        redirect($CFG->wwwroot, get_string('no_permission', 'local_buildings'), 5);
    }

    if ($id) {
        $formdata = $DB->get_record('buildings_assets_category', array('id' => $id), '*', MUST_EXIST);
    } else {
        $formdata = new stdClass();
    }
    $heading = get_string('asset_header', 'local_buildings');
    echo \local_buildings\Base::buildingsPage('/admin/asset.php?id=' . $id, get_string('create_room', 'local_buildings'), $heading, $context);

    $mform = new asset_form(null, array('formdata' => $formdata));

// If data submitted, then process and store.
    if ($mform->is_cancelled()) {
        redirect('assets.php');
    } else if ($data = $mform->get_data()) {
        if ($data->id) {
            $DB->update_record('buildings_assets_category', $data);
        } else {
           $DB->insert_record('buildings_assets_category', $data); 
        }

        redirect('assets.php');
    }

    //--------------------------------------------------------------------------
    echo $OUTPUT->header();
    //**********************
    //*** DISPLAY HEADER ***
    $initjs = "$(document).ready(function() {
                        init_room();
                    });";
    echo html_writer::script($initjs);

    $mform->display();
    //**********************
    //*** DISPLAY FOOTER ***
    //**********************
    echo $OUTPUT->footer();
}

display_page();
?>