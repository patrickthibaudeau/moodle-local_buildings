<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * The main location configuration form
 *
 * It uses the standard core Moodle formslib. For more info about them, please
 * visit: http://docs.moodle.org/en/Development:lib/formslib.php
 *
 * @package    buildings
 * @copyright  2013 Oohoo IT Services Inc.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once("$CFG->dirroot/lib/formslib.php");

/**
 * Module instance settings form
 */
class room_form extends moodleform {

    function definition() {

        global $CFG, $USER, $DB;
        $formdata = $this->_customdata['formdata'];
        $mform = & $this->_form;

        $context = context_system::instance();

        $ROOM = new \local_buildings\Room($formdata->id);

        $ROOMTYPES = new \local_buildings\RoomTypes();
        $roomtypes = $ROOMTYPES->getRoomTypesBasicArray();

        $FLOOR = new \local_buildings\Floor($formdata->floorid);
        $rooms = $FLOOR->getBasicRoomArray();

        $ROOMASSETS = new \local_buildings\RoomAssets($formdata->id);
        $roomAssets = $ROOMASSETS->getAssetsListByCategory();
        
        $FACULTIES = new \local_buildings\Faculties();
        $facultiesArray = $FACULTIES->getSelectArray();

        $reservableByGuests = array(
            \local_buildings\Base::RESERVABLE_NO => get_string('no', 'local_buildings'),
            \local_buildings\Base::RESERVABLE_READONLY => get_string('read_only', 'local_buildings'),
            \local_buildings\Base::RESERVABLE_BY_GUESTS => get_string('all_guests', 'local_buildings'),
            \local_buildings\Base::RESERVABLE_BY_APPROVERS => get_string('approvers_only', 'local_buildings'),
        );

//-------------------------------------------------------------------------------
// Adding the "general" fieldset, where all the common settings are showed
        $mform->addElement('header', 'general', get_string('pluginname', 'local_buildings'));
        $mform->addElement("hidden", "id");
        $mform->setType("id", PARAM_INT);
        $mform->addElement("hidden", "floorid");
        $mform->setType("floorid", PARAM_INT);
        $mform->addElement("select", "roomtypeid", get_string("room_type", "local_buildings"), $roomtypes);
        $mform->setType("roomtypeid", PARAM_INT);
        $mform->addRule("roomtypeid", get_string("required_rule", "local_buildings"), "required");
        $mform->addElement("select", "parentroomid", get_string("parentroom", "local_buildings"), $rooms);
        $mform->addHelpButton("parentroomid", "parentroom", "local_buildings");
        $mform->setType("parentroomid", PARAM_INT);
        $mform->addElement("text", "name", get_string("name", "local_buildings"));
        $mform->setType("name", PARAM_TEXT);
        $mform->addElement("text", "roomnumber", get_string("roomnumber", "local_buildings"));
        $mform->setType("roomnumber", PARAM_TEXT);
        $mform->addRule("roomnumber", get_string("required_rule", "local_buildings"), "required");
        $mform->addHelpButton("roomnumber", "roomnumber", "local_buildings");
        $mform->addElement('editor', 'description', get_string("description", "local_buildings"), null, \local_buildings\Base::getEditorOptions($context));
        $mform->setType('description', PARAM_RAW);
        $mform->addElement('select', 'faculty', get_string("associated_faculty", "local_buildings"), $facultiesArray);
        $mform->setType('faculty', PARAM_INT);
        $mform->addElement('filemanager', 'roomfiles', get_string("pictures", "local_buildings"), null, \local_buildings\Base::getFileManagerOptions($context));
        $mform->setType('roomfiles', PARAM_RAW);
        $mform->addElement("text", "seats", get_string("number_of_seats", "local_buildings"));
        $mform->setType("seats", PARAM_TEXT);
        $mform->addElement("text", "color", get_string("color", "local_buildings"));
        $mform->setType("color", PARAM_TEXT);
        $mform->addElement('selectyesno', 'window', get_string("has_windows", "local_buildings"));
        $mform->setType("window", PARAM_INT);
        $mform->addElement('select', 'guestreservable', get_string("reservable_by_guests", "local_buildings"), $reservableByGuests);
        $mform->setType("guestreservable", PARAM_INT);
        $mform->addHelpButton("guestreservable", "reservable_by_guests", "local_buildings");
        $mform->addElement('header', 'assetheader', get_string('asset_header', 'local_buildings'));
        $mform->addElement('static','snipeit', '<b>' . get_string('assigned_assets', 'local_buildings') . '</b>', $roomAssets);


//-------------------------------------------------------------------------------
// add standard buttons, common to all modules
        $buttonarray = array();
        $buttonarray[] = & $mform->createElement('submit', 'submitbutton', get_string('savechanges'));
        $buttonarray[] = & $mform->createElement('cancel', 'cancel', get_string('cancel'));
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);

// set the defaults
        $this->set_data($formdata);
    }

}
