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

namespace local_buildings;

class Rooms {

    private $rooms = array();
    private $floorName;
    private $floorNumber;
    private $buildingId;
    private $buildingName;
    private $campusName;

    /**
     * Construct Floors array
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     */
    function __construct($floorid) {
        global $CFG, $DB;

        $FLOOR = new Floor($floorid);

        $this->floorName = $FLOOR->getName();
        $this->floorNumber = $FLOOR->getNumber();
        $this->buildingId = $FLOOR->getBuildingId();
        $this->buildingName = $FLOOR->getBuildingName();
        $this->campusName = $FLOOR->getCampusName();

        $rooms = $DB->get_records('buildings_room', array('floorid' => $floorid), 'name');
        $numberOfRooms = count($rooms);

        foreach ($rooms as $r) {

            $ROOM = new Room($r->id);
            $RoomType = $DB->get_record('buildings_room_types', array('id' => $ROOM->getRoomTypeId()));

            $this->rooms[$r->id]['id'] = $r->id;
            $this->rooms[$r->id]['idcheckbox'] = '<input type="checkbox" name="id" value= "' . $r->id . '">';
            $this->rooms[$r->id]['floorid'] = $ROOM->getFloorId();
            $this->rooms[$r->id]['parentroomid'] = $ROOM->getParentRoomId();
            $this->rooms[$r->id]['roomnumber'] = $ROOM->getRoomNumber();
            $this->rooms[$r->id]['name'] = $ROOM->getName();
            $this->rooms[$r->id]['roomtypeid'] = $ROOM->getRoomTypeId();
            if (isset($RoomType->name)) {
                $this->rooms[$r->id]['roomtypename'] = $RoomType->name;
            } else {
                $this->rooms[$r->id]['roomtypename'] = '';
            }
            $this->rooms[$r->id]['seats'] = $ROOM->getSeats();
            $this->rooms[$r->id]['notes'] = $ROOM->getNotes();
            $this->rooms[$r->id]['facultyId'] = $ROOM->getFacultyId();
            $this->rooms[$r->id]['facultyName'] = $ROOM->getFacultyName();
            $this->rooms[$r->id]['facultyShortName'] = $ROOM->getFacultyShortName();
            $this->rooms[$r->id]['color'] = $ROOM->getColor();
            if ($ROOM->getHasWindows()) {
                $windows = get_string('yes', 'local_buildings');
            } else {
                $windows = get_string('no', 'local_buildings');
            }
            $this->rooms[$r->id]['window'] = $windows;
            $this->rooms[$r->id]['colordisplay'] = $ROOM->getColorDisplay();
        }
    }

    public function getBuildingId() {
        return $this->buildingId;
    }

    public function getRooms() {
        return $this->rooms;
    }

    public function getFloorName() {
        return $this->floorName;
    }

    public function getFloorNumber() {
        return $this->floorNumber;
    }

    public function getBuildingName() {
        return $this->buildingName;
    }

    public function getCampusName() {
        return $this->campusName;
    }

    /**
     * Return HTML table of floors
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @param string $value Value used for editing, 
     */
    public function getHtmlTable() {
        global $CFG, $DB;

        $headers = array();
        $headers['idcheckbox'] = '<input type="checkbox" id="checkAll"/> Check all';
        $headers['roomnumber'] = get_string('number', 'local_buildings');
        $headers['name'] = get_string('name', 'local_buildings');
        $headers['seats'] = get_string('number_of_seats', 'local_buildings');
        $headers['window'] = get_string('windows', 'local_buildings');
        $headers['roomtypename'] = get_string('roomtype', 'local_buildings');
        $headers['colordisplay'] = get_string('color', 'local_buildings');

        $action = array();
        $action[0]['action'] = 'edit_room';
        $action[0]['url'] = 'room.php?id=';
        $action[0]['classes'] = 'btn btn-warning';
        $action[0]['key'] = 'id';
        $action[0]['title'] = get_string('edit', 'local_buildings');
        $action[0]['iClasses'] = 'fa fa-pencil';
        $action[1]['action'] = 'delete_room';
        $action[1]['url'] = '#';
        $action[1]['classes'] = 'btn btn-danger delete-room';
        $action[1]['key'] = 'id';
        $action[1]['title'] = get_string('delete', 'local_buildings');
        $action[1]['iClasses'] = 'fa fa-trash';
        $html = \local_buildings\Helper::formatAsTable('rooms_table', $this->rooms, $headers, $action);

        return $html;
    }

    /**
     * 
     * @global \moodle_database $DB
     * @param string $building
     * @param string $roomNumber
     */
    public static function getRoomIdByBuildingNumber($building, $roomNumber) {
        global $DB;

        $sql = 'SELECT '
        . '  {buildings_room}.id '
        . 'FROM '
        . '  {buildings_room '
        . '  INNER JOIN {buildings_floor} ON {buildings_floor}.id = {buildings_room}.floorid '
        . '  INNER JOIN {buildings_building} ON {buildings_building}.id = {buildings_floor}.buildingid '
        . 'WHERE '
        . '  {buildings_building}.shortname = ? AND '
        . '  {buildings_room}.roomnumber = ? ';
        
        $room = $DB->get_record_sql($sql);
        
        return $room->id;
    }

}
