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

    $buildingid = required_param('buildingid', PARAM_INT);

    $FLOORS = new \local_buildings\Floors($buildingid);
    $BUILDING = new \local_buildings\Building($buildingid);
    
    
    $pagetitle = get_string('floors', 'local_buildings');
    $pageheading = $BUILDING->getName() . ' - ' . $BUILDING->getCampusName();

    echo \local_buildings\Base::buildingsPage('/floors.php', $pagetitle, $pageheading, $context);



    $HTMLcontent = '';
    //**********************
    //*** DISPLAY HEADER ***
    //**********************
    echo $OUTPUT->header();
    $initjs = "$(document).ready(function() {
                   init_floors();
               });";

    echo html_writer::script($initjs);


    //**********************
    //*** DISPLAY CONTENT **
    //**********************
    $output = $PAGE->get_renderer('local_buildings');
    $floors = new \local_buildings\output\floors($buildingid);

    echo '<div id="floorsContainer">';
    echo $output->render_floors($floors);
    echo '</div>';
    //**********************
    //*** DISPLAY FOOTER ***
    //**********************
    echo $OUTPUT->footer();
}

display_page();
?>