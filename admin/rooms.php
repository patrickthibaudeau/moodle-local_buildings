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
 * @global \stdClass $CFG
 * @global \moodle_database $DB
 * @global \core_renderer $OUTPUT
 * @global \moodle_page $PAGE
 * @global \stdClass $SESSION
 * @global \stdClass $USER
 */
function display_page() {
    // CHECK And PREPARE DATA
    global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

    require_login(1, false); //Use course 1 because this has nothing to do with an actual course, just like course 1

    $context = context_system::instance();

    if ((!has_capability('local/buildings:editbuilding', $context)) || (!has_capability('local/buildings:admin', $context))) {
        redirect($CFG->wwwroot, get_string('no_permission', 'local_buildings'), 5);
    }

    $floorid = required_param('floorid', PARAM_INT);

    $ROOMS = new \local_buildings\Rooms($floorid);
    $ROOMTYPES = new \local_buildings\RoomTypes();
    $ASSETS = new \local_buildings\Assets();

    $pagetitle = get_string('rooms', 'local_buildings');
    $pageheading = get_string('viewing', 'local_buildings') . ' - ' . get_string('rooms', 'local_buildings') . ' - ' . $ROOMS->getFloorName() . ' - ' . $ROOMS->getBuildingName() . ' - ' . $ROOMS->getCampusName();

    echo \local_buildings\Base::buildingsPage('/rooms.php', $pagetitle, $pageheading, $context);

    $HTMLcontent = '';
    //**********************
    //*** DISPLAY HEADER ***
    //**********************
    echo $OUTPUT->header();
    $initjs = "$(document).ready(function() {
                   init_rooms();
               });";

    echo html_writer::script($initjs);


    //**********************
    //*** DISPLAY CONTENT **
    //**********************

    $output = $PAGE->get_renderer('local_buildings');
    $rooms = new \local_buildings\output\rooms($floorid);

    echo '<div id="roomsContainer">';
    echo $output->render_rooms($rooms);
    echo '</div>';
    //**********************
    //*** DISPLAY FOOTER ***
    //**********************
    echo $OUTPUT->footer();
}

display_page();
?>