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
include("campus_form.php");

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
    global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $USER; $COURSE;

    require_login(1, FALSE);
    $id = optional_param('id', 0, PARAM_INT);

    //Set principal parameters
    $context = CONTEXT_SYSTEM::instance();
    
    if ((!has_capability('local/buildings:editcampus', $context)) || (!has_capability('local/buildings:admin', $context))) {
        redirect($CFG->wwwroot , get_string('no_permission', 'local_buildings'), 5);
    }

    if ($id) {
        $formdata = $DB->get_record('buildings_campus', array('id' => $id), '*', MUST_EXIST);
    }  else {
	$formdata = new stdClass();
    }

    $CAMPUS = new \local_buildings\Campus($id);
    
     echo \local_buildings\Base::buildingsPage($CFG->pluginlocalwww . '/buildings_campus.php', get_string('campus', 'local_buildings'), get_string('campus', 'local_buildings'), $context);

    $mform = new campus_form(null, array('formdata' => $formdata));

// If data submitted, then process and store.
    if ($mform->is_cancelled()) {
        redirect('../index.php');
    } else if ($data = $mform->get_data()) {
        
        if ($data->id) {
            
            $data->timemodified = time();
            //update record
            $CAMPUS->update($data);
            

        } else {
            $data->timecreated = time();
            $data->timemodified = time();
            
            $CAMPUS->create($data);
        }
        redirect('../index.php');
    }

    //--------------------------------------------------------------------------
    echo $OUTPUT->header();
    //**********************
    //*** DISPLAY HEADER ***
    $initjs = "$(document).ready(function() {
                        init_campus();
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