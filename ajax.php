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
require_once('config.php');
include_once('locallib.php');

global $CFG, $USER, $DB;
$action = required_param('action', PARAM_TEXT);


switch ($action) {
    case 'getBuildingsSelect':
        $campusId = required_param('campusId', PARAM_INT);
        echo \local_buildings\Helper::printBuildingsSelectBox($campusId);
        break;
    case 'deleteCampus':
        $id = required_param('id', PARAM_INT);
        $CAMPUS = new \local_buildings\Campus($id);
        echo $CAMPUS->delete(true);
        break;
}

