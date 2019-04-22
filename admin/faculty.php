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
include("faculty_form.php");

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

    if ((!has_capability('local/buildings:editbuilding', $context)) || (!has_capability('local/buildings:admin', $context))) {
        redirect($CFG->wwwroot, get_string('no_permission', 'local_buildings'), 5);
    }

    if ($id) {
        $FACULTY = new \local_buildings\Faculty($id);
        $formdata = $DB->get_record('buildings_faculty', array('id' => $id), '*', MUST_EXIST);

        $heading = get_string('editing', 'local_buildings') . ' ' . get_string('faculty', 'local_buildings') . ' - ' . $FACULTY->getName();
    } else {
        $FACULTY = new \local_buildings\Faculty(0);
        $formdata = new stdClass();
        $heading = get_string('create_faculty', 'local_buildings');
    }

    echo \local_buildings\Base::buildingsPage($CFG->wwwroot . '//local/buildings/admin/faculty.php?id=' . $id, get_string('create_faculty', 'local_buildings'), $heading, $context);

    $mform = new faculty_form(null, array('formdata' => $formdata));

// If data submitted, then process and store.
    if ($mform->is_cancelled()) {
        redirect('faculties.php');
    } else if ($data = $mform->get_data()) {

        $data->timemodified = time();
        if ($data->id) {
            $FACULTY->update($data);
            redirect($CFG->wwwroot . '/local/buildings/admin/faculties.php');
        } else {
            $data->timecreated = time();
            $FACULTY->create($data);
            redirect($CFG->wwwroot . '/local/buildings/admin/faculties.php');
        }
    }

    //--------------------------------------------------------------------------
    echo $OUTPUT->header();
    //**********************
    //*** DISPLAY HEADER ***
    $initjs = "$(document).ready(function() {
                        init_faculty();
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