<?php

require_once('../config.php');
include("../locallib.php");
include("building_form.php");

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
    
    //Set principal parameters
    $context = CONTEXT_SYSTEM::instance();
    
    if ((!has_capability('local/buildings:editbuilding', $context)) || (!has_capability('local/buildings:admin', $context))) {
        redirect($CFG->wwwroot , get_string('no_permission', 'local_buildings'), 5);
    }
    
    $id = optional_param('id', 0, PARAM_INT);
    
    $campusid = optional_param('campusid', 0,PARAM_INT);
    
    $BUILDING = new \local_buildings\Building($id);
    
    if ($id) {
        $formdata = $DB->get_record('buildings_building', array('id' => $id), '*', MUST_EXIST);
        $formdata->number_of_floors = $BUILDING->getNumberOfFloors();
    } else {
        $formdata = new stdClass();
        $formdata->campusid = $campusid;
        $formdata->number_of_floors = 0;
        $formdata->number_of_rooms = 0;
    }

    if ($id == 0) {
        $CAMPUS = new \local_buildings\Campus($campusid);
        $pageHeader = get_string('adding', 'local_buildings') . ' - ' . get_string('building', 'local_buildings') . ' - ' . $CAMPUS->getName();
    } else {
         $pageHeader = get_string('editing', 'local_buildings') . ' - ' . $BUILDING->getName() . ' - ' . $BUILDING->getCampusName();
    }
 
    echo \local_buildings\Base::buildingsPage($CFG->pluginlocalwww . '/admin/buildings_building.php', get_string('pluginname', 'local_buildings'), $pageHeader, $context);

    $mform = new building_form(null, array('formdata' => $formdata));

// If data submitted, then process and store.
    if ($mform->is_cancelled()) {
        redirect($CFG->pluginlocalwww . '/admin/buildings.php?campusid=' . $formdata->campusid);
    } else if ($data = $mform->get_data()) {


        if ($data->id) {

            $data->timemodified = time();
            //update record
            $BUILDING->update($data);
        } else {
            $data->timecreated = time();
            $data->timemodified = time();

            $BUILDING->create($data);
        }
        redirect($CFG->pluginlocalwww . '/admin/buildings.php?campusid=' . $data->campusid);
    }
    //--------------------------------------------------------------------------
    echo $OUTPUT->header();
    //**********************
    //*** DISPLAY HEADER ***
    $initjs = "$(document).ready(function() {
                        init_building();
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