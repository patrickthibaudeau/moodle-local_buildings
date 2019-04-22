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

class Room implements iCrud {

    private $id;
    private $floorId;
    private $parentRoomId;
    private $roomNumber;
    private $name;
    private $description;
    private $roomTypeId;
    private $seats;
    private $notes;
    private $color;
    private $colorDisplay;
    private $floorName;
    private $floorNumber;
    private $buildingName;
    private $buildingShortName;
    private $buildingId;
    private $campusName;
    private $campusId;
    private $timecreated;
    private $timemodified;
    private $roomType;
    private $roomTypeColor;
    private $assets;
    private $guestReservable;
    private $hasWindows;
    private $pictures;
    private $facultyId;
    private $facultyName;
    private $facultyShortName;

    /**
     * Construct Building array
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     */
    public function __construct($id) {
        global $CFG, $DB;

        $this->id = $id;

        if ($id != 0) {
            $context = \context_system::instance();
            $room = $DB->get_record('buildings_room', array('id' => $id));
            $roomType = $DB->get_record('buildings_room_types', array('id' => $room->roomtypeid));
            $roomAssets = $DB->get_records('buildings_room_assets', array('roomid' => $id));
            $assets = array();
            $i = 0;
            foreach ($roomAssets as $ra) {
                $asset = new Asset($ra->categoryid);
                $assets[$i] = $asset->getId();
                $i++;
            }
            //Get Faculty
            $FACULTY = new Faculty($room->faculty);
            //Get FLOOR
            $FLOOR = new Floor($room->floorid);
            $this->id = $room->id;
            $this->floorId = $room->floorid;
            $this->parentRoomId = $room->parentroomid;
            $this->roomNumber = $room->roomnumber;
            $this->name = $room->name;
            $this->roomTypeId = $room->roomtypeid;
            if (isset($roomType->name)) {
                $this->roomType = $roomType->name;
            } else {
                $this->roomType = '';
            }
            if (isset($roomType->color)) {
                $this->roomTypeColor = $roomType->color;
            } else {
                $this->roomTypeColor = '';
            }
            $this->description = $room->description;
            $this->seats = $room->seats;
            $this->notes = $room->notes;
            $this->facultyId = $room->faculty;
            $this->facultyName = $FACULTY->getName();
            $this->facultyShortName = $FACULTY->getShortName();
            $this->color = $room->color;
            $this->guestReservable = $room->guestreservable;
            $this->timecreated = $room->timecreated;
            $this->timemodified = $room->timemodified;
            $this->hasWindows = $room->window;
            $this->assets = $assets;
            $this->colorDisplay = '<div style="width: 25px; height: 25px; background-color:' . $room->color . ';"></div>';
            $this->floorName = $FLOOR->getName();
            $this->floorNumber = $FLOOR->getNumber();
            $this->buildingShortName = $FLOOR->getBuildingShortName();
            $this->buildingName = $FLOOR->getBuildingName();
            $this->buildingId = $FLOOR->getBuildingId();
            $this->campusName = $FLOOR->getCampusName();
            $this->campusId = $FLOOR->getCampusId();

            //Get pictures
            $out = array();

            $fs = get_file_storage();
            $files = $fs->get_area_files($context->id, 'local_buildings', 'image', $id);
            $urls = array();
            foreach ($files as $file) {
                $filename = $file->get_filename();
                if ($filename != '.') {
                    $url = \moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), $file->get_itemid(), $file->get_filepath(), $file->get_filename());
                    $urls[] = $url->out();
                    }
            }


            $this->pictures = $urls;
        }
    }

    public function getGuestReservable() {
        return $this->guestReservable;
    }

    public function getId() {
        return $this->id;
    }

    public function getFloorId() {
        return $this->floorId;
    }

    public function getParentRoomId() {
        return $this->parentRoomId;
    }

    public function getRoomNumber() {
        return $this->roomNumber;
    }

    public function getName() {
        return $this->name;
    }

    public function getRoomTypeId() {
        return $this->roomTypeId;
    }

    public function getSeats() {
        return $this->seats;
    }

    public function getNotes() {
        return $this->notes;
    }

    public function getColor() {
        return $this->color;
    }

    public function getColorDisplay() {
        return $this->colorDisplay;
    }

    public function getFloorName() {
        return $this->floorName;
    }

    public function getFloorNumber() {
        return $this->floorNumber;
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

    public function getTimecreated() {
        return $this->timecreated;
    }

    public function getTimemodified() {
        return $this->timemodified;
    }

    public function getRoomType() {
        return $this->roomType;
    }

    public function getRoomTypeColor() {
        return $this->roomTypeColor;
    }

    public function getAssets() {
        return $this->assets;
    }

    public function getHasWindows() {
        return $this->hasWindows;
    }

    public function getPictures() {
        return $this->pictures;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getFacultyId() {
        return $this->facultyId;
    }

    public function getFacultyName() {
        return $this->facultyName;
    }

    public function getFacultyShortName() {
        return $this->facultyShortName;
    }

        /**
     * Create a building record
     * @global \moodle_database $DB
     * @param array $data
     * @return boolean
     */
    public function create($data) {
        global $DB;

        $context = \context_system::instance();
        $data->timecreated = time();
        $data->timemodified = time();

        if ($id = $DB->insert_record('buildings_room', $data, true)) {
            // Saving file from filemanger
            file_save_draft_area_files($data->roomfiles, $context->id, 'local_buildings', 'image', $id, \local_buildings\Base::getFileManagerOptions($context));

            //Saving editor text and files
            $draftid_editor = file_get_submitted_draft_itemid('description');
            $messagetext = file_save_draft_area_files($draftid_editor, $context->id, 'local_buildings', 'room', $id, \local_buildings\Base::getEditorOptions($context), $data->description['text']);
            $DB->update_record('buildings_room', array('id' => $id, 'description' => $messagetext));
            return $id;
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

        $context = \context_system::instance();
        if ($DB->update_record('buildings_room', $data)) {
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
    public function delete($id) {
        global $CFG, $DB;


        if ($DB->delete_records('buildings_room', array('id' => $this->id))) {
            //Delete assets
            $DB->delete_records('buildings_room_assets', array('roomid' => $this->id));
            return TRUE;
        } else {
            return FALSE;
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

        //Not used fro room
    }

}
