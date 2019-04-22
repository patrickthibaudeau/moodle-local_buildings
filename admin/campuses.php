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

    if ((!has_capability('local/buildings:editcampus', $context)) || (!has_capability('local/buildings:admin', $context))) {
        redirect($CFG->wwwroot , get_string('no_permission', 'local_buildings'), 5);
    }
    
    $pagetitle = get_string('campus', 'local_buildings');
    $pageheading = get_string('viewing', 'local_buildings') . ' - ' . get_string('campuses', 'local_buildings');

    echo \local_buildings\Base::buildingsPage('/campuses.php', $pagetitle, $pageheading, $context);
    
    $CAMPUSES = new \local_buildings\Campuses();

    $HTMLcontent = '';
    //**********************
    //*** DISPLAY HEADER ***
    //**********************
    echo $OUTPUT->header();
    $initjs = "$(document).ready(function() {
                   init_campuses();
               });";

    echo html_writer::script($initjs);


    //**********************
    //*** DISPLAY CONTENT **
    //**********************
    ?>
    <div id="campuses_wrapper">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <div id="nav_buttons">
                            <?php
                            \local_buildings\Helper::printHomeButton();
                            echo ' ' . \local_buildings\Action::getLink('create_campus', 'campus.php', 'btn btn-success', null, null, get_string('create', 'local_buildings'), 'fa fa-plus');
                            ?>
                        </div>
                    <div id="campus_table_container">
                       <?php echo $CAMPUSES->getHtmlTable();?>
                    </div>
                </div>
            </div>
            <?php if (is_siteadmin($USER->id)) {?>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='panel panel-default'>
                        <div class="panel-heading"><h3><i class='fa fa-magic'></i> Developer</h3></div>
                        <div class="panel-body">
                            <i class='fa  fa-user'></i> <a href='<?php echo $CFG->wwwroot; ?>/user/editadvanced.php?id=-1'><?php echo get_string('addnewuser'); ?></a><br>
                            <i class='fa  fa-upload'></i> <a href='<?php echo $CFG->wwwroot; ?>/admin/tool/uploaduser/index.php'><?php echo get_string('uploadusers', 'tool_uploaduser'); ?></a><br>
                            <i class='fa  fa-gear'></i> <a href='<?php echo $CFG->wwwroot; ?>/admin/roles/assign.php?contextid=1'><?php echo get_string('assignglobalroles','role'); ?></a><br>
                            <i class='fa  fa-gear'></i> <a href='<?php echo $CFG->wwwroot; ?>/admin/roles/manage.php'><?php echo get_string('manageroles','role'); ?></a><br>
                            <i class='fa  fa-bug'></i> <a href='<?php echo $CFG->wwwroot; ?>/admin/settings.php?section=debugging'><?php echo get_string('debugging', 'admin'); ?></a><br>
                            <i class='fa  fa-home'></i> <a href='<?php echo $CFG->wwwroot; ?>/admin/settings.php?section=frontpagesettings'><?php echo get_string('frontpagesettings', 'admin'); ?></a><br>
                            <i class='fa  fa-gear'></i> <a href='<?php echo $CFG->wwwroot; ?>/admin/tool/xmldb/'>XMLDB Editor</a><br>
                            <i class='fa  fa-gear'></i> <a href='<?php echo $CFG->wwwroot; ?>/admin/index.php'>Notifications</a><br>
                            <i class='fa  fa-gear'></i> <a href='<?php echo $CFG->wwwroot; ?>/admin/search.php?query=cache'>Cache settings</a><br>
                            <i class='fa  fa-gear'></i> <a href='<?php echo $CFG->wwwroot; ?>/admin/purgecaches.php?confirm=1&sesskey=<?php echo sesskey();?>&returnurl=/local/buildings/index.php'>Purge cache</a><br>
                            <i class='fa  fa-list'></i> <a href='<?php echo $CFG->wwwroot; ?>/local/panorama_reports/index.php'>Panorama Reports</a><br>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
        <div id="confirm_box"></div>
    </div>

    <?php
    //**********************
    //*** DISPLAY FOOTER ***
    //**********************
    echo $OUTPUT->footer();
}

display_page();
?>