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
defined('MOODLE_INTERNAL') || die();
include_once('config.php');

function local_buildings_cron() {
    global $CFG, $DB;

    return true;
}

/**
 * Update the navigation block with buildings options
 * @global moodle_database $DB
 * @global stdClass $USER
 * @global stdClass $CFG
 * @global moodle_page $PAGE
 * @param global_navigation $navigation The navigation block
 */
function local_buildings_extend_navigation(global_navigation $navigation) {
    global $DB, $USER;

    //Only display if panorama is installed
    $pr_config = $DB->count_records('config_plugins', array('plugin' => 'local_buildings'));
    if ($pr_config > 0) {
        $node = $navigation->find('local_buildings', navigation_node::TYPE_CONTAINER);
        if (!$node) {
            $node = $navigation->add(get_string('pluginname', 'local_buildings'), null, navigation_node::TYPE_CONTAINER, get_string('pluginname', 'local_buildings'), 'local_buildings');
        }

        $context = context_system::instance();
        //The user can see that IF he has rights on at least one category
        //profile 4 is the READ ONLY. we don't use the local_buildings::PROFILE_READONLY because it is not loaded here

        $node->add(get_string('dashboard', 'local_buildings'), new moodle_url('/local/buildings/index.php'));
        $node->showinflatnavigation = true;
    }
}

function local_buildings_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $DB;
    
    if ($context->contextlevel != CONTEXT_SYSTEM) {
        return false;
    }
    
    require_login();
   
    if ($filearea !== 'room' && $filearea !== 'image') {
        return false;
    }
     
    $itemid = (int)array_shift($args);

    $fs = get_file_storage();
    $filename = array_pop($args);
    
    if (empty($args)) {
        $filepath = '/';
    } else {
        $filepath = '/'.implode('/', $args).'/';
    }
    
    $file = $fs->get_file($context->id, 'local_buildings', $filearea, $itemid, $filepath, $filename);
    if (!$file) {
        return false;
    }
    
    send_stored_file($file, 0, 0, $forcedownload, $options);
}