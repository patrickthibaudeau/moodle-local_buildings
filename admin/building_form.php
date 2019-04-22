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
class building_form extends moodleform {

    function definition() {

        global $CFG, $USER, $DB;
        $formdata = $this->_customdata['formdata'];
        $mform = & $this->_form;
        
        $CAMPUSES = new \local_buildings\Campuses();
        $campuses = $CAMPUSES->getCampusesNamesArray();
        

//-------------------------------------------------------------------------------
// Adding the "general" fieldset, where all the common settings are showed
        $mform->addElement('header', 'general', get_string('general', 'local_buildings'));
        $mform->addElement("hidden", "id");
        $mform->setType("id", PARAM_INT);
        $mform->addElement("select", "campusid", get_string('campus', 'local_buildings'), $campuses);
        $mform->setType("campusid", PARAM_INT);
        $mform->addElement("text", "name", get_string("name", "local_buildings"));
        $mform->setType("name", PARAM_TEXT);
        $mform->addRule("name", get_string("required_rule", "local_buildings"), "required");
        $mform->addElement("text", "shortname", get_string("abbreviation", "local_buildings"));
        $mform->setType("shortname", PARAM_TEXT);
        $mform->addRule("shortname", get_string("required_rule", "local_buildings"), "required");
        $mform->addElement("text", "idnumber", get_string("idnumber", "local_buildings"));
        $mform->setType("idnumber", PARAM_TEXT);
        $mform->addElement("text", "address", get_string("address", "local_buildings"));
        $mform->setType("address", PARAM_TEXT);
        $mform->addElement("text", "address2", get_string("address2", "local_buildings"));
        $mform->setType("address2", PARAM_TEXT);
        $mform->addElement("text", "city", get_string("city", "local_buildings"));
        $mform->setType("city", PARAM_TEXT);
        $mform->addElement("text", "province", get_string("province", "local_buildings"));
        $mform->setType("province", PARAM_TEXT);
        $mform->addElement("text", "country", get_string("country", "local_buildings"));
        $mform->setType("country", PARAM_TEXT);
        $mform->addElement('header', 'demographics', get_string('demographics', 'local_buildings'));
        $mform->addElement("text", "longitude", get_string("longitude", "local_buildings"));
        $mform->setType("longitude", PARAM_TEXT);
        $mform->addElement("text", "latitude", get_string("latitude", "local_buildings"));
        $mform->setType("latitude", PARAM_TEXT);
        $mform->addElement("text", "color", get_string("color", "local_buildings"));
        $mform->setType("color", PARAM_TEXT);
        $mform->addElement('header', 'extra', get_string('extra', 'local_buildings'));
        $mform->addElement("text", "number_of_floors", get_string("number_of_floors", "local_buildings"));
        $mform->setType("number_of_floors", PARAM_INT);
        $mform->addElement("text", "number_of_rooms", get_string("number_of_rooms_per_floor", "local_buildings"));
        $mform->setType("number_of_rooms", PARAM_INT);


//-------------------------------------------------------------------------------
// add standard buttons, common to all modules
        $this->add_action_buttons();

// set the defaults
        $this->set_data($formdata);
    }

}
