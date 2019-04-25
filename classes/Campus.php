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

class Campus implements iCrud {

    private $id;
    private $name;
    private $shortname;
    private $color;
    private $colorDisplay;
    private $numberOfBuildings;
    private $buildings;
    private $timecreated;
    private $timemodified;

    /**
     * Construct Campuses array
     * @global \moodle_database $DB
     */
    public function __construct($id) {
        global $CFG, $DB;


        $this->id = $id;

        if ($id != 0) {
            $campus = $DB->get_record('buildings_campus', array('id' => $id));

            //Get number of buildings
            $buildings = $DB->get_records('buildings_building', array('campusid' => $id));

            $this->id = $campus->id;
            $this->name = $campus->name;
            $this->shortname = $campus->shortname;
            $this->color = $campus->color;
            $this->colorDisplay = '<div style="width: 25px; height: 25px; background-color:' . $campus->color . ';"></div>';
            $this->numberOfBuildings = count($buildings);
            $this->buildings = $buildings;
            $this->timecreated = $campus->timecreated;
            $this->timemodified = $campus->timemodified;
        }
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

    public function getColor() {
        return $this->color;
    }

    public function getColorDisplay() {
        return $this->colorDisplay;
    }

    public function getNumberOfBuildings() {
        return $this->numberOfBuildings;
    }

    public function getBuildings() {
        return $this->buildings;
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

    public function setColor($color) {
        $this->color = $color;
    }

    public function setColorDisplay($colorDisplay) {
        $this->colorDisplay = $colorDisplay;
    }

    public function setNumberOfBuildings($numberOfBuildings) {
        $this->numberOfBuildings = $numberOfBuildings;
    }

    public function setBuildings($buildings) {
        $this->buildings = $buildings;
    }

    public function setTimecreated($timecreated) {
        $this->timecreated = $timecreated;
    }

    public function setTimemodified($timemodified) {
        $this->timemodified = $timemodified;
    }

    /**
     * Create a campus record
     * @global \moodle_database $DB
     * @param array $data
     * @return boolean
     */
    public function create($data) {
        global $DB;

        if ($DB->insert_record('buildings_campus', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Update a campus record
     * @global \moodle_database $DB
     * @param type $data
     * @return boolean
     */
    public function update($data) {
        global $DB;

        if ($DB->update_record('buildings_campus', $data)) {
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

        $buildings = $DB->get_records('buildings_building', ['campusid' => $this->id]);
        foreach ($buildings as $b) {
            $BUILDING = new \local_buildings\Building($b->id);
            $BUILDING->delete(true);
        }
        if ($DB->delete_records('buildings_campus', array('id' => $this->id))) {
            return true;
        } else {
            return false;
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

        if ($data = $DB->get_records('buildings_building', array('campusid' => $this->id))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
