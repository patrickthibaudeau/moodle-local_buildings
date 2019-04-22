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

class Asset {

    private $id;
    private $name;

    /**
     * 
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @global \moodle_database $DB2
     */
    public function __construct($id = 0) {
        global $CFG, $DB;
        $asset = $DB->get_record('buildings_assets_category', array('id' => $id));

        $this->id = $asset->id ?? 0;
        $this->name = $asset->name ?? '';
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function delete() {
        global $DB;
        //verify that it is not being used
        if ($used = $DB->get_records('buildings_room_assets', array('categoryid' => $this->id))) {
            return false;
        } else {
            $DB->delete_records('buildings_assets_category', array('id' => $this->id));
            return true;
        }
    }

}
