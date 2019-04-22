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
include_once('../locallib.php');
require_once($CFG->dirroot . '/local/buildings/classes/Assets.php');
require_once($CFG->dirroot . '/local/buildings/classes/Asset.php');
global $CFG, $USER, $DB;
$action = required_param('action', PARAM_TEXT);


switch ($action) {
    case 'deleteCampus':
        $id = required_param('id', PARAM_INT);
        $CAMPUSES = new \local_buildings\Campuses();
        $CAMPUS = new \local_buildings\Campus($id);

        $deleted = $CAMPUS->delete();

        if ($deleted == true) {
            echo $CAMPUSES->getHtmlTable();
        } else {
            //error code 1451 cannot delete
            echo 'ERROR-1451';
        }
        break;
    case 'deleteFaculty':
        $id = required_param('id', PARAM_INT);
        $FACULTIES = new \local_buildings\Faculties();
        $FACULTY = new \local_buildings\Faculty($id);

        $deleted = $FACULTY->delete('');

        if ($deleted == true) {
            echo $FACULTIES->getHtmlTable();
        } else {
            //error code 1451 cannot delete
            echo 'ERROR-1451';
        }
        break;
    case 'deleteBuilding':
        $id = required_param('id', PARAM_INT);
        $deleteFloorsAndRooms = true;
        $BUILDING = new \local_buildings\Building($id);
        $deleted = $BUILDING->delete($deleteFloorsAndRooms);

        if ($deleted == true) {
//            $BUILDINGS = new \local_buildings\Buildings($BUILDING->getCampusId());
//            echo $BUILDINGS->getHtmlTable();
            echo true;
        } else {
            //error code 1451 cannot delete
            echo 'ERROR-1451';
        }
        break;
    case 'deleteFloor':
        $id = required_param('id', PARAM_INT);
        $buildingid = $FLOOR = new \local_buildings\Floor($id);
        $buildingid = $FLOOR->getBuildingId();

        $deleted = $FLOOR->delete(true);

        if ($deleted == true) {
            $FLOORS = new \local_buildings\Floors($buildingid);
            echo $FLOORS->getHtmlTable();
        } else {
            //error code 1451 cannot delete
            echo 'ERROR-1451';
        }
        break;
    case 'deleteRoomType':
        $id = required_param('id', PARAM_INT);
        $ROOMTYPES = new \local_buildings\RoomTypes();
        $ROOMTYPE = new \local_buildings\RoomType();
        $deleted = $ROOMTYPE->delete($id);

        if ($deleted == true) {
            echo $ROOMTYPES->getHtmlTable();
        } else {
            //error code 1451 cannot delete
            echo 'ERROR-1451';
        }
        break;
    case 'deleteRoom':
        $id = required_param('id', PARAM_INT);
        $ROOM = new \local_buildings\Room($id);
        $deleted = $ROOM->delete($id);
        echo true;
        break;
    case 'updateRooms':
        $ids = required_param('ids', PARAM_TEXT);
        $floorid = required_param('floorid', PARAM_INT);
        $seats = optional_param('seats', '', PARAM_TEXT);
        $roomtypeid = optional_param('roomtype', 0, PARAM_INT);
        $guestreservable = optional_param('guestreservable', '', PARAM_TEXT);
        $assets = optional_param_array('assets', null, PARAM_RAW);
        $ids = explode(',', $ids);
        //Setup data
        $data = array();
        if ($seats != '') {
            $data['seats'] = $seats;
        }
        if ($roomtypeid != 0) {
            $data['roomtypeid'] = $roomtypeid;
        }
        if ($guestreservable != '') {
            $data['guestreservable'] = $guestreservable;
        }
        if (isset($assets)) {
            $data['assets'] = $assets;
        }
        $data['timemodified'] = time();

        for ($i = 0; $i < count($ids); $i++) {
            $data['id'] = $ids[$i];
            $ROOM = new Room($data['id']);
            //delete all assets everytime
            $DB->delete_records('buildings_room_assets', array('roomid' => $data['id']));
            //If the assets is set, then add then to the table
            if (isset($data['assets'])) {
                //Add assets to table
                for ($x = 0; $x < count($data['assets']); $x++) {
                    //Add assets as per array
                    $assetData = array();
                    $assetData['roomid'] = $data['id'];
                    $assetData['inventoryid'] = $data['assets'][$x];
                    $assetData['timecreated'] = time();

                    $DB->insert_record('buildings_room_assets', $assetData);
                }
            }
            //Update room
            $ROOM->update($data);
        }
        $ROOMS = new \local_buildings\Rooms($floorid);
        echo $ROOMS->getHtmlTable();
        break;
    case 'deleteAsset':
        $id = required_param('id', PARAM_INT);
        $ASSET = new \local_buildings\Asset($id);
        $ASSETS = new \local_buildings\Assets();
        if ($ASSET->delete() == true) {
            echo $ASSETS->getHtmlTable();
        } else {
            echo 'ERROR-1451';
        }
        break;
}

    