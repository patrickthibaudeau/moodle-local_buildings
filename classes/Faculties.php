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
 * *************************************************************************
 */

namespace local_buildings;

class Faculties {

    private $faculties = array();
    private $facultiesStdClass = array();

    /**
     * 
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     */
    public function __construct() {
        global $CFG, $DB;

        $faculties = $DB->get_records('buildings_faculty');

        $this->facultiesStdClass = $faculties;

        foreach ($faculties as $f) {
            $this->faculties[$f->id]['id'] = $f->id;
            $this->faculties[$f->id]['name'] = $f->name;
            $this->faculties[$f->id]['shortname'] = $f->shortname;
            $this->faculties[$f->id]['timecreated'] = $f->timecreated;
            $this->faculties[$f->id]['timemodified'] = $f->timemodified;
            $this->faculties[$f->id]['timeModifiedHumanReadable'] = strftime('%A %e %B, %Y', $f->timemodified);
        }
    }

    public function getFaculties() {
        return $this->faculties;
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
        $headers['name'] = get_string('name', 'local_buildings');
        $headers['shortname'] = get_string('shortname', 'local_buildings');
        $headers['timeModifiedHumanReadable'] = get_string('timemodified', 'local_buildings');

        $action = array();
        $action[0]['action'] = 'edit_faculty';
        $action[0]['url'] = 'faculty.php?id=';
        $action[0]['classes'] = 'btn btn-warning';
        $action[0]['key'] = 'id';
        $action[0]['title'] = get_string('edit', 'local_buildings');
        $action[0]['iClasses'] = 'fa fa-pencil';
        $action[1]['action'] = 'delete_faculty';
        $action[1]['url'] = '#';
        $action[1]['classes'] = 'btn btn-danger delete-faculty';
        $action[1]['key'] = 'id';
        $action[1]['title'] = get_string('delete', 'local_buildings');
        $action[1]['iClasses'] = 'fa fa-trash';
        $html = \local_buildings\Helper::formatAsTable('faculties_table', $this->faculties, $headers, $action);

        return $html;
    }

    /**
     * 
     * @global \moodle_database $DB
     * @return string
     */
    public function getSelectArray() {
        global $DB;
        $facultiesStdClass = $this->facultiesStdClass;

        foreach ($facultiesStdClass as $fsc) {
            //Only show faculties that are associated
            if ($DB->get_records('buildings_room', array('faculty' => $fsc->id))) {
                $faculties[$fsc->id] = $fsc->name . ' - (' . $fsc->shortname . ')';
            }
        }

        return $faculties;
    }

}
