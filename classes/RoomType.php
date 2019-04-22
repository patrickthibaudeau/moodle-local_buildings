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

require_once('iCrud.php');

class RoomType implements iCrud {

    private $id;
    private $name;
    private $classroom;
    private $color;
    private $colorDisplay;
    private $timeCreated;
    private $timeModified;

    /**
     * Construct room type
     * @global \moodle_database $DB
     * @param type $id
     */
    public function __construct($id) {
        global $DB;
        $this->id = $id;
        if ($this->id != 0) {
            $roomType = $DB->get_record('buildings_room_types', array('id' => $id));
            
            $this->name = $roomType->name;
            $this->classroom = $roomType->classroom;
            $this->color = $roomType->color;
            $this->colorDisplay = '<div style="width: 25px; height: 25px; background-color:' . $roomType->color . ';"></div>';
            $this->timeCreated = $roomType->timecreated;
            $this->timeModified = $roomType->timemodified;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getColor() {
        return $this->color;
    }

    public function getColorDisplay() {
        return $this->colorDisplay;
    }

    public function getTimeCreated() {
        return $this->timeCreated;
    }

    public function getTimeModified() {
        return $this->timeModified;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setColor($color) {
        $this->color = $color;
    }

    public function setColorDisplay($colorDisplay) {
        $this->colorDisplay = $colorDisplay;
    }

    public function setTimeCreated($timeCreated) {
        $this->timeCreated = $timeCreated;
    }

    public function setTimeModified($timeModified) {
        $this->timeModified = $timeModified;
    }

    public function getClassroom() {
        return $this->classroom;
    }

        /**
     * Create a Room type
     * @global \moodle_database $DB
     * @param array $data
     * @return boolean
     */
    public function create($data) {
        global $DB;

        if ($DB->insert_record('buildings_room_types', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Delete a room type if the room type is not associated to any rooms
     * @global \moodle_database $DB
     * @return boolean
     */
    public function delete($all) {
        global $DB;

        if ($this->id == 0) {
            return FALSE;
        }
        //Verifiy that the campus is not being used esle where
        if ($this->hasChild($this->id)) {
            return FALSE;
        } else {
            $DB->delete_records('buildings_room_types', array('id' => $this->id));
            return TRUE;
        }
    }

    /**
     * Verify if the room type is being used in any room
     * @global \moodle_database $DB
     * @return boolean
     */
    public function hasChild() {
        global $DB;

        if ($this->id == 0) {
            return FALSE;
        }

        if ($data = $DB->get_records('buildings_room', array('roomtypeid' => $this->id))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Update the room type
     * @global \moodle_database $DB
     * @param array $data
     * @return boolean
     */
    public function update($data) {
        global $DB;

        if ($DB->update_record('buildings_room_types', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Retunrs all rooms with type ID
     * @global \moodle_database $DB
     */
    public function getRoomsByType() {
        global $DB;
        
        $rooms = $DB->get_records('buildings_room', array('roomtypeid' => $this->id));
        
        return $rooms;
    }
    
    public function getRoomIdsByType() {
        $rooms = $this->getRoomsByType();
        $roomIds = array();
        foreach($rooms as $r) {
            $roomIds[] = $r->id;
        }
        
        return $roomIds;
        
    }

}
