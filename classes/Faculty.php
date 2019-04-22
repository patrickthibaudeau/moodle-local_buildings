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

/**
 * Description of Faculty
 *
 * @author patrick
 */
class Faculty implements iCrud {

    private $id;
    private $name;
    private $shortName;
    private $timeCreated;
    private $timeCreatedHumanReadble;
    private $timeModifiedHumanReadable;

    /**
     * 
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @param int $id
     */
    public function __construct($id) {
        global $CFG, $DB;
        if ($id == 0) {
            $this->id = '';
            $this->name = '';
            $this->shortName = '';
            $this->timeCreated = '';
            $this->timeCreatedHumanReadble = '';
            $this->timeModified = '';
            $this->timeModifiedHumanReadable = '';
        } else {
            $faculty = $DB->get_record('buildings_faculty', array('id' => $id));

            $this->id = $faculty->id;
            $this->name = $faculty->name;
            $this->shortName = $faculty->shortname;
            $this->timeCreated = $faculty->timecreated;
            $this->timeCreatedHumanReadble = strftime('%A %e %B, %Y', $faculty->timecreated);
            $this->timeModified = $faculty->timemodified;
            $this->timeModifiedHumanReadable = strftime('%A %e %B, %Y', $faculty->timemodified);
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getShortName() {
        return $this->shortName;
    }

    public function getTimeCreated() {
        return $this->timeCreated;
    }

    public function getTimeCreatedHumanReadble() {
        return $this->timeCreatedHumanReadble;
    }

    public function getTimeModifiedHumanReadable() {
        return $this->timeModifiedHumanReadable;
    }

    /**
     * Inserts new faculty
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @param array $data
     * @return boolean
     */
    public function create($data) {
        global $CFG, $DB;

        $DB->insert_record('buildings_faculty', $data);
        return true;
    }

    /**
     * Updates faculty
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @param array $data
     */
    public function update($data) {
        global $CFG, $DB;

        $DB->update_record('buildings_faculty', $data);
        return true;
    }

    /**
     * 
     * @global \moodle_database $DB
     * @return boolean
     */
    public function hasChild() {
        global $DB;

        if ($hasChild = $DB->get_records('buildings_room', array('faculty' => $this->id))) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($all) {
        global $DB;

        if ($this->id == 0) {
            return FALSE;
        }
        //Verifiy that the campus is not being used esle where
        if ($this->hasChild()) {
            return FALSE;
        } else {
            $DB->delete_records('buildings_faculty', array('id' => $this->id));
            return TRUE;
        }
    }

}
