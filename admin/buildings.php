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
require_once('../locallib.php');

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
    global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

    require_login(1, false); //Use course 1 because this has nothing to do with an actual course, just like course 1

    $context = context_system::instance();

    if ((!has_capability('local/buildings:editbuilding', $context)) || (!has_capability('local/buildings:admin', $context))) {
        redirect($CFG->wwwroot, get_string('no_permission', 'local_buildings'), 5);
    }

    $campusid = required_param('campusid', PARAM_INT);

    $BUILDINGS = new \local_buildings\Buildings($campusid);
    $CAMPUS = new \local_buildings\Campus($campusid);

    $pagetitle = get_string('buildings', 'local_buildings');
    $pageheading = get_string('viewing', 'local_buildings') . ' - ' . get_string('buildings', 'local_buildings') . ' - ' . $CAMPUS->getName();

    echo \local_buildings\Base::buildingsPage('/buildings.php', $pagetitle, $pageheading, $context);




    $HTMLcontent = '';
    //**********************
    //*** DISPLAY HEADER ***
    //**********************
    echo $OUTPUT->header();
//    $initjs = "$(document).ready(function() {
//                   init_buildings();
//               });";
//
//    echo html_writer::script($initjs);



    //**********************
    //*** DISPLAY CONTENT **
    //**********************
    $output = $PAGE->get_renderer('local_buildings');
    $buildings = new \local_buildings\output\buildings($campusid);

    echo '<div id="buildingsContainer">';
    echo $output->render_buildings($buildings);
    echo '</div>';
    //**********************
    //*** DISPLAY FOOTER ***
    //**********************
    echo $OUTPUT->footer();
}

display_page();
?>