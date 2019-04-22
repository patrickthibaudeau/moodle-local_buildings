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

class Floors {

    private $floors = array();

    /**
     * Construct Floors array
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     */
    function __construct($buildingid) {
        global $CFG, $DB;

        $floors = $DB->get_records('buildings_floor', array('buildingid' => $buildingid), 'name');

        $BUILDING = new Building($buildingid);

        foreach ($floors as $f) {
            //Get number of rooms
            $rooms = $DB->get_records('buildings_room', array('floorid' => $f->id));

            $this->floors[$f->id]['id'] = $f->id;
            $this->floors[$f->id]['buildingInfo'] = $BUILDING;
            $this->floors[$f->id]['number'] = $f->number;
            $this->floors[$f->id]['name'] = '<a href="' . $CFG->wwwroot . '/local/buildings/admin/rooms.php?floorid=' . $f->id . '">'. $f->name . '</a>';
            $this->floors[$f->id]['color'] = $f->color;
            $this->floors[$f->id]['colorDisplay'] = '<div style="width: 25px; height: 25px; background-color:' . $f->color . ';"></div>';
            $this->floors[$f->id]['numberOfRooms'] = count($rooms) ;
            $this->floors[$f->id]['rooms'] = $rooms;
            $this->floors[$f->id]['timecreated'] = $f->timecreated;
            $this->floors[$f->id]['timemodified'] = $f->timemodified;
        }
    }

    public function getFloors() {
        return $this->floors;
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
        $headers['number'] = get_string('name', 'local_buildings');
        $headers['name'] = get_string('name', 'local_buildings');
        $headers['numberOfRooms'] = get_string('number_of_rooms', 'local_buildings');
        $headers['colorDisplay'] = get_string('color', 'local_buildings');

        $action = array();
        $action[0]['action'] = 'edit_floor';
        $action[0]['url'] = 'floor.php?id=';
        $action[0]['classes'] = 'btn btn-warning';
        $action[0]['key'] = 'id';
        $action[0]['title'] = get_string('edit', 'local_buildings');
        $action[0]['iClasses'] = 'fa fa-pencil';
        $action[1]['action'] = 'delete_floor';
        $action[1]['url'] = '#';
        $action[1]['classes'] = 'btn btn-danger delete-floor';
        $action[1]['key'] = 'id';
        $action[1]['title'] = get_string('delete', 'local_buildings');
        $action[1]['iClasses'] = 'fa fa-trash';
        $html = \local_buildings\Helper::formatAsTable('floors_table', $this->floors, $headers, $action);

        return $html;
    }

}
