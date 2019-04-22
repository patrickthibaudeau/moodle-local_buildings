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

class Building implements iCrud {

    private $id;
    private $name;
    private $shortname;
    private $address;
    private $address2;
    private $city;
    private $province;
    private $country;
    private $longitude;
    private $latitude;
    private $color;
    private $colorDisplay;
    private $numberOfFloors;
    private $idNumber;
    private $floors;
    private $timecreated;
    private $timemodified;
    private $campusShortName;
    private $campusName;
    private $campusId;
    private $highestFloor;

    /**
     * Construct Building array
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     */
    public function __construct($id) {
        global $CFG, $DB;
        
        $this->id = $id;
        $this->highestFloor = 0;
        if ($id != 0) {
            $building = $DB->get_record('buildings_building', array('id' => $id));
            //Getcampus
            $campus = $DB->get_record('buildings_campus', array('id' => $building->campusid));
            //Get number of flors
            $floors = $DB->get_records('buildings_floor', array('buildingid' => $id));
            $highestFloorSql = 'SELECT MAX(number) as newvalue FROM {buildings_floor} WHERE buildingid = ' . $id;
            $highestFloor = $DB->get_record_sql($highestFloorSql);

            if ($highestFloor->newvalue == null) {
                $highestFloor->newvalue = 0;
            }

            $this->id = $building->id;
            $this->name = $building->name;
            $this->shortname = $building->shortname;
            $this->address = $building->address;
            $this->address2 = $building->address;
            $this->city = $building->city;
            $this->province = $building->province;
            $this->country = $building->country;
            $this->longitude = $building->longitude;
            $this->latitude = $building->latitude;
            $this->color = $building->color;
            $this->idNumber = $building->idnumber;
            $this->colorDisplay = '<div style="width: 25px; height: 25px; background-color:' . $building->color . ';"></div>';
            $this->numberOfFloors = count($floors);
            $this->floors = $floors;
            $this->campus = $campus;
            $this->timecreated = $building->timecreated;
            $this->campusShortName = $campus->shortname;
            $this->campusName = $campus->name;
            $this->campusId = $campus->id;
            $this->highestFloor = $highestFloor->newvalue;
        }
    }
    
    function getCampusShortName() {
        return $this->campusShortName;
    }
 
    public function getIdNumber() {
        return $this->idNumber;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getShortname() {
        return $this->shortname;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getAddress2() {
        return $this->address2;
    }

    public function getCity() {
        return $this->city;
    }

    public function getProvince() {
        return $this->province;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function getColor() {
        return $this->color;
    }

    public function getColorDisplay() {
        return $this->colorDisplay;
    }

    public function getNumberOfFloors() {
        return $this->numberOfFloors;
    }

    public function getFloors() {
        return $this->floors;
    }

    public function getTimecreated() {
        return $this->timecreated;
    }

    public function getTimemodified() {
        return $this->timemodified;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setShortname($shortname) {
        $this->shortname = $shortname;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setAddress2($address2) {
        $this->address2 = $address2;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setProvince($province) {
        $this->province = $province;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    public function setColor($color) {
        $this->color = $color;
    }

    public function setColorDisplay($colorDisplay) {
        $this->colorDisplay = $colorDisplay;
    }

    public function setNumberOfFloors($numberOfFloors) {
        $this->numberOfFloors = $numberOfFloors;
    }

    public function setFloors($floors) {
        $this->floors = $floors;
    }

    public function setTimecreated($timecreated) {
        $this->timecreated = $timecreated;
    }

    public function setTimemodified($timemodified) {
        $this->timemodified = $timemodified;
    }

    public function getCampusName() {
        return $this->campusName;
    }

    public function getCampusId() {
        return $this->campusId;
    }

    public function setCampusName($campusName) {
        $this->campusName = $campusName;
    }

    public function setCampusId($campusId) {
        $this->campusId = $campusId;
    }

    public function getHighestFloor() {
        return $this->highestFloor;
    }

    public function setHighestFloor($highestFloor) {
        $this->highestFloor = $highestFloor;
    }

    /**
     * Create a building record
     * @global \moodle_database $DB
     * @param array $data
     * @return boolean
     */
    public function create($data) {
        global $DB;

        $numberOfFloors = $data->number_of_floors;
        $numberOfRooms = $data->number_of_rooms;

        if ($newId = $DB->insert_record('buildings_building', $data, TRUE)) {

            if ($numberOfFloors > 0) {
                //Add floors
                $this->createFloors($newId, $numberOfFloors);
            }

            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Update a campus record
     * @global \moodle_database $DB
     * @param array $data
     * @return boolean
     */
    public function update($data) {
        global $DB;

        if ($DB->update_record('buildings_building', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Delete if no buildings in campus
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @param boolean $deleteFloorsAndRooms
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
                $DB->delete_records('buildings_building', array('id' => $this->id));
                return TRUE;
            }
        } else {
            foreach ($this->floors as $f) {
                //Delete rooms
                $DB->delete_records('buildings_room', array('floorid' => $f->id));
            }
            //Delete floors
            $DB->delete_records('buildings_floor', array('buildingid' => $this->id));
            //Delete building
            $DB->delete_records('buildings_building', array('id' => $this->id));
            
            return true;
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

        if ($data = $DB->get_records('buildings_floor', array('buildingid' => $this->id))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * If 
     * @global \moodle_database $DB
     * @param int $buildingId
     * @param int $numberOfFloors
     */
    private function createFloors($buildingId, $numberOfFloors) {
        global $DB;
        //Check to see how many floors this building has.

        $remainingFloors = $numberOfFloors - $this->numberOfFloors;

        if ($remainingFloors > 0) {

            $FLOOR = new Floor(0);
            $i = $this->highestFloor + 1;

            $data = array();
            while ($i < (($remainingFloors + $this->highestFloor) + 1)) {
                $data['buildingid'] = $buildingId;
                $data['number'] = $i;
                $data['name'] = ucfirst(\local_buildings\Helper::getNumberName($i) . ' floor');
                $data['color'] = '#' . dechex(rand(0x000000, 0xFFFFFF));
                $data['timecreated'] = time();

                $FLOOR->create($data);

                $i++;
            }
        }
    }

}
