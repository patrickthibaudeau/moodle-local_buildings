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
class asset_form extends moodleform {

    function definition() {

        global $CFG, $USER, $DB;
        $formdata = $this->_customdata['formdata'];
        $mform = & $this->_form;
//-------------------------------------------------------------------------------
// Adding the "general" fieldset, where all the common settings are showed
        $mform->addElement('header', 'general', get_string('asset_header', 'local_buildings'));
        $mform->addElement("hidden", "id");
        $mform->setType("id", PARAM_INT);
        
        $mform->addElement("text", "name", get_string("name", "local_buildings"));
        $mform->setType("name", PARAM_TEXT);
        


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
