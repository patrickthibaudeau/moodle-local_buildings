<?php
require_once('../config.php');
include("../locallib.php");
include("floor_form.php");

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
    $buildingid = optional_param('buildingid', 0, PARAM_INT);
    
    //Set principal parameters
    $context = CONTEXT_SYSTEM::instance();
    
    if ((!has_capability('local/buildings:editbuilding', $context)) || (!has_capability('local/buildings:admin', $context))) {
        redirect($CFG->wwwroot , get_string('no_permission', 'local_buildings'), 5);
    }
    
    $FLOOR = new \local_buildings\Floor($id);
    
    if ($buildingid == 0) {
        $url = optional_param('url', 'floors.php?buildingid=' . $FLOOR->getBuildingId() , PARAM_TEXT);
    } else {
        $url = optional_param('url', 'floors.php?buildingid=' . $buildingid , PARAM_TEXT);
    }

    if ($id) {
        $formdata = $DB->get_record('buildings_floor', array('id' => $id), '*', MUST_EXIST);
        $formdata->url = $url;
    }  else {
	$formdata = new stdClass();
        $formdata->buildingid = $buildingid;
        $formdata->url = $url;
    }

    if ($id == 0) {
        $BUILDING = new \local_buildings\Building($buildingid);
        $pageHeading = get_string('adding', 'local_buildings') . ' - ' . get_string('floor', 'local_buildings') . ' - ' . $BUILDING->getName() . ' - ' . $BUILDING->getCampusName();
    } else {
        $pageHeading = get_string('editing', 'local_buildings') . ' - ' . get_string('floor', 'local_buildings') . ' - ' . $FLOOR->getBuildingName() . ' - ' . $FLOOR->getCampusName();
    }

   echo \local_buildings\Base::buildingsPage($CFG->pluginlocalwww . '/buildings_floor.php', get_string('floor', 'local_buildings'), $pageHeading, $context);
    
    $mform = new floor_form(null, array('formdata' => $formdata));

// If data submitted, then process and store.
    if ($mform->is_cancelled()) {
        redirect($formdata->url);
    } else if ($data = $mform->get_data()) {


        if ($data->id) {
            
            $data->timemodified = time();
            //update record
            $FLOOR->update($data);
            

        } else {
            $data->timecreated = time();
            $data->timemodified = time();
            
            $FLOOR->create($data);
        }
        redirect($data->url);
    }

    //--------------------------------------------------------------------------
    echo $OUTPUT->header();
    //**********************
    //*** DISPLAY HEADER ***
    $initjs = "$(document).ready(function() {
                        init_floor();
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