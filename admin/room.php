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
require_once('../config.php');
include("../locallib.php");
include("room_form.php");

/**
 * Display the content of the page
 * @global stdClass $CFG
 * @global moodle_database $DB
 * @global core_renderer $OUTPUT
 * @global moodle_page $PAGE
 * @global stdClass $SESSION
 * @global stdClass $USER
 */
function display_page() {
    // CHECK And PREPARE DATA
    global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $USER;
    $COURSE;

    require_login(1, FALSE);

    $id = optional_param('id', 0, PARAM_INT);
    $floorid = optional_param('floorid', 0, PARAM_INT);

    //Set principal parameters
    $context = CONTEXT_SYSTEM::instance();

    if ((!has_capability('local/buildings:editbuilding', $context)) || (!has_capability('local/buildings:admin', $context))) {
        redirect($CFG->wwwroot, get_string('no_permission', 'local_buildings'), 5);
    }

    if ($id) {
        $ROOM = new \local_buildings\Room($id);
        $formdata = $DB->get_record('buildings_room', array('id' => $id), '*', MUST_EXIST);
        $assets = $ROOM->getAssets();

        //Loading files into filemanger
        $draftitemid = file_get_submitted_draft_itemid('roomfiles');
        file_prepare_draft_area($draftitemid, $context->id, 'local_buildings', 'image', $id, \local_buildings\Base::getFileManagerOptions($context));
        $formdata->roomfiles = $draftitemid;

        //Loading text into editor
        $draftid_editor = file_get_submitted_draft_itemid('description');
        $currenttext = file_prepare_draft_area($draftid_editor, $context->id, 'local_buildings', 'room', $id, \local_buildings\Base::getEditorOptions($context), $formdata->description);
        $formdata->description = array('text' => $currenttext, 'format' => FORMAT_HTML, 'itemid' => $draftid_editor);

        $formdata->assets = $assets;

        $heading = get_string('editing', 'local_buildings') . ' ' . get_string('room', 'local_buildings') . ' - ' . $ROOM->getRoomNumber() . ' - ' . $ROOM->getBuildingName() . ' - ' . $ROOM->getCampusName();
    } else {
        $formdata = new stdClass();
        $formdata->id = 0;
        $formdata->floorid = $floorid;
        $formdata->guestreservable = true;
        $FLOOR = new \local_buildings\Floor($floorid);
        $heading = get_string('create_room', 'local_buildings') . ' - ' . $FLOOR->getName() . ' - ' . $FLOOR->getBuildingName() . ' - ' . $FLOOR->getCampusName();
    }

    echo \local_buildings\Base::buildingsPage($CFG->pluginlocalwww . '/buildings_campus.php', get_string('create_room', 'local_buildings'), $heading, $context);

    $mform = new room_form(null, array('formdata' => $formdata));

// If data submitted, then process and store.
    if ($mform->is_cancelled()) {
        redirect('rooms.php?floorid=' . $formdata->floorid);
    } else if ($data = $mform->get_data()) {
        $ROOM = new \local_buildings\Room($data->id);
        if ($CFG->buildings_use_internal_assets == true) {
            //delete all assets everytime
            $DB->delete_records('buildings_room_assets', array('roomid' => $data->id));
        }
        $data->timemodified = time();
        if ($data->id) {
            //If the assets is set, then add then to the table
            if (isset($data->assets)) {
                //Add assets to table
                for ($i = 0; $i < count($data->assets); $i++) {
                    //Add assets as per array
                    $assetData = array();
                    $assetData['roomid'] = $data->id;
                    $assetData['inventoryid'] = $data->assets[$i];
                    $assetData['timecreated'] = time();

                    $DB->insert_record('buildings_room_assets', $assetData);
                }
            }

            //Update room
            // Saving file from filemanger
            file_save_draft_area_files($data->roomfiles, $context->id, 'local_buildings', 'image', $data->id, \local_buildings\Base::getFileManagerOptions($context));

            //Saving editor text and files
            $draftid_editor = file_get_submitted_draft_itemid('description');
            $messagetext = file_save_draft_area_files($draftid_editor, $context->id, 'local_buildings', 'room', $data->id, \local_buildings\Base::getEditorOptions($context), $data->description['text']);
            $data->description = $messagetext;

            $ROOM->update($data);
        } else {
            $ROOM = new \local_buildings\Room(0);
            unset($roomNumbers);
            //Create room
            if (strstr($data->roomnumber, ',')) {
                $roomNumbers = explode(',', $data->roomnumber);
            }
            if (isset($roomNumbers)) {
                $i = 0;
                while ($i < count($roomNumbers)) {
                    $data->roomnumber = $roomNumbers[$i];
                    $id = $ROOM->create($data);
                    //Add assets to table
                    if (isset($data->assets)) {
                        for ($x = 0; $x < count($data->assets); $x++) {
                            //Add assets as per array
                            $assetData = array();
                            $assetData['roomid'] = $id;
                            $assetData['inventoryid'] = $data->assets[$x];
                            $assetData['timecreated'] = time();

                            $DB->insert_record('buildings_room_assets', $assetData);
                        }
                    }

                    $i++;
                }
            } else {
                $id = $ROOM->create($data);
                //Add assets to table
                if ($CFG->buildings_use_internal_assets == true) {
                    if (isset($data->assets)) {
                        for ($i = 0; $i < count($data->assets); $i++) {
                            //Add assets as per array
                            $assetData = array();
                            $assetData['roomid'] = $id;
                            $assetData['inventoryid'] = $data->assets[$i];
                            $assetData['timecreated'] = time();

                            $DB->insert_record('buildings_room_assets', $assetData);
                        }
                    }
                }
            }
        }

        redirect('rooms.php?floorid=' . $data->floorid);
    }

    //--------------------------------------------------------------------------
    echo $OUTPUT->header();
    //**********************
    //*** DISPLAY HEADER ***
    $initjs = "$(document).ready(function() {
                        init_room();
                    });";
    echo html_writer::script($initjs);

    $mform->display();
    //**********************
    //*** DISPLAY FOOTER ***
    //**********************
    echo $OUTPUT->footer();
}

display_page();
?>