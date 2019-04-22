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

class Campuses {

    private $campuses;
    
    /**
     * Construct Campuses array
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     */
    function __construct() {
        global $CFG, $DB;
        
        $campus = $DB->get_records('buildings_campus', array(), 'name');
        
        foreach ($campus as $c) {
            //Get number of buildings
            $buildings = $DB->get_records('buildings_building', array('campusid' => $c->id));
            
            $this->campuses[$c->id]['id'] = $c->id ;
            $this->campuses[$c->id]['name'] = $c->name ;
            $this->campuses[$c->id]['shortname'] = $c->shortname ;
            $this->campuses[$c->id]['color'] = $c->color ;
            $this->campuses[$c->id]['colorDisplay'] = '<div style="width: 25px; height: 25px; background-color:' . $c->color . ';"></div>' ;
            $this->campuses[$c->id]['numberOfBuildings'] = count($buildings) . ' '
                    . '<a href="'. $CFG->wwwroot . '/local/buildings/admin/buildings.php?campusid=' . $c->id . '" title="' . get_string('view', 'local_buildings') . '" class="btn btn-link">'
                    . '<i class="fa fa-eye"></i> ' .  get_string('view', 'local_buildings') . '</a>';
            $this->campuses[$c->id]['buildings'] = $buildings;
            $this->campuses[$c->id]['timecreated'] = $c->timecreated;
            $this->campuses[$c->id]['timemodified'] = $c->timemodified;
            
        }
    }

    public function getCampuses() {
        return $this->campuses;
    }

    public function setCampuses($campuses) {
        $this->campuses = $campuses;
    }

        
    /**
     * Return HTML table of campuses
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     */
    public function getHtmlTable() {
        global $CFG, $DB;
        
        $headers = array();
        $headers['name'] = get_string('name', 'local_buildings');
        $headers['shortname'] = get_string('abbreviation', 'local_buildings');
        $headers['numberOfBuildings'] = get_string('number_of_buildings', 'local_buildings');
        $headers['colorDisplay'] = get_string('color', 'local_buildings');
        
        $action = array();
        $action[0]['action'] = 'edit_campus';
        $action[0]['url'] = 'campus.php?id=';
        $action[0]['classes'] = 'btn btn-warning';
        $action[0]['key'] = 'id';
        $action[0]['title'] = get_string('edit', 'local_buildings');
        $action[0]['iClasses'] = 'fa fa-pencil';
        $action[1]['action'] = 'delete_campus';
        $action[1]['url'] = '#';
        $action[1]['classes'] = 'btn btn-danger delete-campus';
        $action[1]['key'] = 'id';
        $action[1]['title'] = get_string('delete', 'local_buildings');
        $action[1]['iClasses'] = 'fa fa-trash';
        $html = \local_buildings\Helper::formatAsTable('campuses_table', $this->campuses, $headers, $action);
        
        return $html;
    }
    
    /**
     * returns an array of key = campus id and value = campus name
     * This is used, for example, to create select elements on forms
     * @return array
     */
    public function getCampusesNamesArray() {
        $campuses = array();
        
        foreach ($this->campuses as $cs) {
            $campuses[$cs['id']] = $cs['name'];
        }
        
        return $campuses;
    }
}
