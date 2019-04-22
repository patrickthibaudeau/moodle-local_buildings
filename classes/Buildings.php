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

class Buildings {

    private $buildings;

    /**
     * Construct Campuses array
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     */
    function __construct($campusid) {
        global $CFG, $DB;

        if ($campusid == 0) {
            $buildings = $DB->get_records('buildings_building');
        } else {
            $buildings = $DB->get_records('buildings_building', array('campusid' => $campusid), 'name');
        }
        foreach ($buildings as $b) {
            //Get number of buildings
            $floors = $DB->get_records('buildings_floor', array('buildingid' => $b->id));
            //Print out floor
            if (count($floors) > $CFG->buildings_number_of_floors) {
                $floorDisplay = '<a href="floors.php?buildingid=' . $b->id . '" class="btn btn-link" title="' . get_string('too_many_floors', 'local_buildings') . '">' . get_string('too_many_floors', 'local_buildings') . ' (' . count($floors) . ')</a><br>' . "\n";
                $floorDisplay .= '<a href="floor.php?buildingid=' . $b->id . '" title="add floor" class="btn btn-link">[ <i class="fa fa-plus"></i> ]</a><br>' . "\n";
            } else {
                $floorDisplay = '<a href="floor.php?buildingid=' . $b->id . '&url=buildings.php?campusid=' . $b->campusid . '" title="add floor" style="margin-bottom: 5px;" class="btn btn-link">[ <i class="fa fa-plus"></i> ]</a><br>' . "\n";
                $floorDisplay .= '<ul style="list-style-type: none;">' . "\n";
                foreach ($floors as $f) {
                    $floorDisplay .= '<li><a href="floor.php?id=' . $f->id . '&url=buildings.php?campusid=' . $b->campusid . '" title="' . $f->number . ' ' . $f->name . '" class="btn btn-link">[ <i class="fa fa-pencil"></i> ]</a> '
                            . '<a href="rooms.php?floorid=' . $f->id . '" title="' . $f->number . ' ' . $f->name . '" class="btn btn-link"> ' . $f->number . ' ' . $f->name . '</a></li>' . "\n";
                }
                $floorDisplay .= '</ul>' . "\n";
            }

            $this->buildings[$b->id]['id'] = $b->id;
            $this->buildings[$b->id]['name'] = $b->name;
            $this->buildings[$b->id]['shortname'] = $b->shortname;
            $this->buildings[$b->id]['address'] = $b->address;
            $this->buildings[$b->id]['address2'] = $b->address2;
            $this->buildings[$b->id]['city'] = $b->city;
            $this->buildings[$b->id]['province'] = $b->province;
            $this->buildings[$b->id]['country'] = $b->country;
            $this->buildings[$b->id]['longitude'] = $b->longitude;
            $this->buildings[$b->id]['latitude'] = $b->latitude;
            $this->buildings[$b->id]['color'] = $b->color;
            $this->buildings[$b->id]['idNumber'] = $b->idnumber;
            $this->buildings[$b->id]['colorDisplay'] = '<div style="width: 25px; height: 25px; background-color:' . $b->color . ';"></div>';
            $this->buildings[$b->id]['numberOfFloors'] = count($buildings);
            $this->buildings[$b->id]['floors'] = $floors;
            $this->buildings[$b->id]['floorDisplay'] = $floorDisplay;
            $this->buildings[$b->id]['timecreated'] = $b->timecreated;
            $this->buildings[$b->id]['timemodified'] = $b->timemodified;
        }
    }

    public function getBuildings() {
        return $this->buildings;
    }

    public function setBuildings($buildings) {
        $this->buildings = $buildings;
    }

    /**
     * Return HTML table of buildings
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @param string $value Value used for editing, 
     */
    public function getHtmlTable() {
        global $CFG, $DB;

        $headers = array();
        $headers['name'] = get_string('name', 'local_buildings');
        $headers['shortname'] = get_string('abbreviation', 'local_buildings');
        $headers['idNumber'] = get_string('idnumber', 'local_buildings');
        $headers['floorDisplay'] = get_string('number_of_floors', 'local_buildings');
        $headers['colorDisplay'] = get_string('color', 'local_buildings');

        $action = array();
        $action[0]['action'] = 'edit_building';
        $action[0]['url'] = 'building.php?id=';
        $action[0]['classes'] = 'btn btn-warning';
        $action[0]['key'] = 'id';
        $action[0]['title'] = get_string('edit', 'local_buildings');
        $action[0]['iClasses'] = 'fa fa-pencil';
        $action[1]['action'] = 'delete_building';
        $action[1]['url'] = '#';
        $action[1]['classes'] = 'btn btn-danger delete-building';
        $action[1]['key'] = 'id';
        $action[1]['title'] = get_string('delete', 'local_buildings');
        $action[1]['iClasses'] = 'fa fa-trash';
        $html = \local_buildings\Helper::formatAsTable('buildings_table', $this->buildings, $headers, $action);

        return $html;
    }

}
