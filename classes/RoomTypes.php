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

class RoomTypes {
    
    private $roomTypes;
    private $classrooms;

    /**
     * Construct Campuses array
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     */
    function __construct() {
        global $CFG, $DB;

        $roomTypes = $DB->get_records('buildings_room_types', array(), 'name');
        $i = 0;
        foreach ($roomTypes as $rt) {
            
            $this->roomTypes[$i]['id'] = $rt->id;
            $this->roomTypes[$i]['name'] = $rt->name;
            $this->roomTypes[$i]['color'] = $rt->color;
            $this->roomTypes[$i]['classroom'] = $rt->classroom;
            $this->roomTypes[$i]['colorDisplay'] = '<div style="width: 25px; height: 25px; background-color:' . $rt->color . ';"></div>';
            $this->roomTypes[$i]['timecreated'] = $rt->timecreated;
            $this->roomTypes[$i]['timemodified'] = $rt->timemodified;
            $i++;
        }
    }

    public function getRoomTypes() {
        return $this->roomTypes;
    }

    public function getRoomTypesBasicArray() {
        $roomtypes = array(0 => get_string('select', 'local_buildings'));
        for ($i = 0; $i < count($this->roomTypes); $i++) {
            $roomtypes[$this->roomTypes[$i]['id']] = $this->roomTypes[$i]['name'];
        }
        
        return $roomtypes;
    }
    /**
     * Return HTML table of Room types
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @return string $HTML
     */
    public function getHtmlTable() {
        global $CFG, $DB;

        $headers = array();
        $headers['name'] = get_string('name', 'local_buildings');
        $headers['classroom'] = get_string('is_classroom', 'local_buildings');
        $headers['colorDisplay'] = get_string('color', 'local_buildings');

        $action = array();
        $action[0]['action'] = 'edit_room_type';
        $action[0]['url'] = 'room_type.php?id=';
        $action[0]['classes'] = 'btn btn-warning';
        $action[0]['key'] = 'id';
        $action[0]['title'] = get_string('edit', 'local_buildings');
        $action[0]['iClasses'] = 'fa fa-pencil';
        $action[1]['action'] = 'delete_roomType';
        $action[1]['url'] = '#';
        $action[1]['classes'] = 'btn btn-danger delete-roomType';
        $action[1]['key'] = 'id';
        $action[1]['title'] = get_string('delete', 'local_buildings');
        $action[1]['iClasses'] = 'fa fa-trash';
        $html = \local_buildings\Helper::formatAsTable('room_types_table', $this->roomTypes, $headers, $action, array('classroom'));

        return $html;
    }
    
    /**
     * 
     * @global \moodle_database $DB
     * @return stdClass $classRooms
     */
    public function getClassrooms() {
        global $DB;
        $classRooms = $DB->get_records('buildings_room_types', array('classroom' => 1));
        return $classRooms;
    }

    public function getRoomsBasedOnType($roomType) {
        global $DB;
        $rooms = $DB->get_records('buildings_room', array('roomtypeid' => $roomType));
        return $rooms;
    }
    
}
