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
require_once(dirname(__FILE__) . '../../../config.php');

defined('MOODLE_INTERNAL') || die();

global $CFG, $DB;

$CFG->pluginlocal = 'buildings';
$CFG->pluginlocalwww = $CFG->wwwroot . '/local/' . $CFG->pluginlocal;
$CFG->pluginlocalstyle = '/local/' . $CFG->pluginlocal . '/css/';
$CFG->pluginlocalscript = '/local/' . $CFG->pluginlocal . '/js/';

require_once($CFG->dirroot . '/local/buildings/classes/Action.php');
require_once($CFG->dirroot . '/local/buildings/classes/Asset.php');
require_once($CFG->dirroot . '/local/buildings/classes/Assets.php');
require_once($CFG->dirroot . '/local/buildings/classes/Base.php');
require_once($CFG->dirroot . '/local/buildings/classes/Building.php');
require_once($CFG->dirroot . '/local/buildings/classes/Buildings.php');
require_once($CFG->dirroot . '/local/buildings/classes/Campus.php');
require_once($CFG->dirroot . '/local/buildings/classes/Campuses.php');
require_once($CFG->dirroot . '/local/buildings/classes/Faculties.php');
require_once($CFG->dirroot . '/local/buildings/classes/Faculty.php');
require_once($CFG->dirroot . '/local/buildings/classes/Floor.php');
require_once($CFG->dirroot . '/local/buildings/classes/Floors.php');
require_once($CFG->dirroot . '/local/buildings/classes/Helper.php');
require_once($CFG->dirroot . '/local/buildings/classes/Room.php');
require_once($CFG->dirroot . '/local/buildings/classes/RoomAssets.php');
require_once($CFG->dirroot . '/local/buildings/classes/RoomType.php');
require_once($CFG->dirroot . '/local/buildings/classes/RoomTypes.php');
require_once($CFG->dirroot . '/local/buildings/classes/Rooms.php');
require_once($CFG->dirroot . '/local/buildings/classes/SnipeIt.php');
require_once($CFG->dirroot . '/local/buildings/classes/PDO.class.php');



?>