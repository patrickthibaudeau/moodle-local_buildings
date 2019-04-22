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

class Floor implements iCrud {

    private $id;
    private $number;
    private $name;
    private $color;
    private $colorDisplay;
    private $numberOfRooms;
    private $rooms;
    private $timecreated;
    private $timemodified;
    private $buildingShortName;
    private $buildingName;
    private $buildingId;
    private $campusName;
    private $campusId;

    /**
     * Construct Building array
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     */
    public function __construct($id) {
        global $CFG, $DB;


        $this->id = $id;

        if ($id != 0) {
            $floor = $DB->get_record('buildings_floor', array('id' => $id));
            //Get building
            $BUILDING = new Building($floor->buildingid);
            //Get number of rooms
            $rooms = $DB->get_records('buildings_room', array('floorid' => $id));

            $this->id = $floor->id;
            $this->number = $floor->number;
            $this->name = $floor->name;
            $this->color = $floor->color;
            $this->colorDisplay = '<div style="width: 25px; height: 25px; background-color:' . $floor->color . ';"></div>';
            $this->numberOfRooms = count($rooms);
            $this->rooms = $rooms;
            $this->timecreated = $floor->timecreated;
            $this->timemodified = $floor->timemodified;
            $this->buildingShortName = $BUILDING->getShortname();
            $this->buildingName = $BUILDING->getName();
            $this->buildingId = $BUILDING->getId();
            $this->campusName = $BUILDING->getCampusName();
            $this->campusId = $BUILDING->getCampusId();
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getNumber() {
        return $this->number;
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

    public function getNumberOfRoomss() {
        return $this->numberOfRooms;
    }

    public function getRooms() {
        return $this->rooms;
    }

    public function getTimecreated() {
        return $this->timecreated;
    }

    public function getTimemodified() {
        return $this->timemodified;
    }

    public function getBuildingShortName() {
        return $this->buildingShortName;
    }
    
    public function getBuildingName() {
        return $this->buildingName;
    }

    public function getBuildingId() {
        return $this->buildingId;
    }

    public function getCampusName() {
        return $this->campusName;
    }

    public function getCampusId() {
        return $this->campusId;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNumber($number) {
        $this->number = $number;
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

    public function setNumberOfRoomss($numberOfRooms) {
        $this->numberOfRooms = $numberOfRooms;
    }

    public function setRooms($rooms) {
        $this->rooms = $rooms;
    }

    public function setTimecreated($timecreated) {
        $this->timecreated = $timecreated;
    }

    public function setTimemodified($timemodified) {
        $this->timemodified = $timemodified;
    }

    public function setBuildingName($buildingName) {
        $this->buildingName = $buildingName;
    }

    public function setBuildingId($buildingId) {
        $this->buildingId = $buildingId;
    }

    public function setCampusName($campusName) {
        $this->campusName = $campusName;
    }

    public function setCampusId($campusId) {
        $this->campusId = $campusId;
    }

    /**
     * Create a building record
     * @global \moodle_database $DB
     * @param array $data
     * @return boolean
     */
    public function create($data) {
        global $DB;

        if ($DB->insert_record('buildings_floor', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Update a campus record
     * @global moodle_database $DB
     * @param type $data
     * @return boolean
     */
    public function update($data) {
        global $DB;

        if ($DB->update_record('buildings_floor', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Delete if no buildings in campus
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @param int $id
     * @return boolean If false, campus cannot be deleted
     */
    public function delete($all) {
        global $CFG, $DB;

        if ($this->id == 0) {
            return FALSE;
        }
        //Verifiy that the campus is not being used esle where
        if ($all == 0) {
            if ($this->hasChild($this->id)) {
                return FALSE;
            } else {
                $DB->delete_records('buildings_floor', array('id' => $this->id));
                return TRUE;
            }
        } else {
            $DB->delete_records('buildings_room', array('floorid' => $this->id));
            $DB->delete_records('buildings_floor', array('id' => $this->id));
            return TRUE;
        }
    }

    /**
     * Check to see if this campus has buildings
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @param type $id
     * @return boolean
     */
    public function hasChild() {
        global $CFG, $DB;

        if ($this->id == 0) {
            return FALSE;
        }

        if ($data = $DB->get_records('buildings_room', array('floorid' => $this->id))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function getBasicRoomArray() {
        $rooms = array(0 => get_string('select', 'local_buildings'));
        foreach ($this->rooms as $r) {
            $rooms[$r->id] = $this->number .  $r->roomnumber . ' | ' . $r->name;
        }
        
        return $rooms;
    }

}
