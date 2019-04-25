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

        $context = context_system::instance();
        $node = $navigation->find('local_roomsupport',
                navigation_node::TYPE_CUSTOM);
        if (!$node) {
            $node = $navigation->add(get_string('pluginname',
                            'local_buildings'),
                    new moodle_url('/local/buildings/index.php'),
                    navigation_node::TYPE_CUSTOM,
                    get_string('pluginname', 'local_buildings'),
                    'local_buildings');
            $node->showinflatnavigation = true;
        }
    }
}

function local_buildings_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    global $DB;

    if ($context->contextlevel != CONTEXT_SYSTEM) {
        return false;
    }

    require_login();

    if ($filearea !== 'room' && $filearea !== 'image') {
        return false;
    }

    $itemid = (int) array_shift($args);

    $fs = get_file_storage();
    $filename = array_pop($args);

    if (empty($args)) {
        $filepath = '/';
    } else {
        $filepath = '/' . implode('/', $args) . '/';
    }

    $file = $fs->get_file($context->id, 'local_buildings', $filearea, $itemid, $filepath, $filename);
    if (!$file) {
        return false;
    }

    send_stored_file($file, 0, 0, $forcedownload, $options);
}
