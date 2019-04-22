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
defined('MOODLE_INTERNAL') || die();

function xmldb_local_buildings_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2016031400) {

        //Added capabilities
        // Course_request savepoint reached.
        upgrade_plugin_savepoint(true, 2016031400, 'local', 'buildings');
    }

    if ($oldversion < 2016031401) {

        // Rename field shotrname on table buildings_campus to NEWNAMEGOESHERE.
        $table = new xmldb_table('buildings_campus');
        $field = new xmldb_field('shotrname', XMLDB_TYPE_CHAR, '100', null, null, null, null, 'name');

        // Launch rename field shotrname.
        $dbman->rename_field($table, $field, 'shortname');

        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2016031401, 'local', 'buildings');
    }

    if ($oldversion < 2016031500) {

        // Define field color to be added to buildings_building.
        $table = new xmldb_table('buildings_building');
        $field = new xmldb_field('color', XMLDB_TYPE_CHAR, '8', null, null, null, null, 'latitude');

        // Conditionally launch add field color.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2016031500, 'local', 'buildings');
    }

    if ($oldversion < 2016031600) {

        // Added settings
        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2016031600, 'local', 'buildings');
    }

    if ($oldversion < 2016031601) {

        // Define key pk_building_0 (unique) to be dropped form buildings_building.
        $table = new xmldb_table('buildings_building');
        $key = new xmldb_key('pk_building_0', XMLDB_KEY_UNIQUE, array('campusid'));

        // Launch drop key pk_building_0.
        $dbman->drop_key($table, $key);

        // Define key pk_floor_0 (unique) to be dropped form buildings_floor.
        $table = new xmldb_table('buildings_floor');
        $key = new xmldb_key('pk_floor_0', XMLDB_KEY_UNIQUE, array('buildingid'));

        // Launch drop key pk_floor_0.
        $dbman->drop_key($table, $key);

        // Define key pk_room_0 (unique) to be dropped form buildings_room.
        $table = new xmldb_table('buildings_room');
        $key = new xmldb_key('pk_room_0', XMLDB_KEY_UNIQUE, array('floorid'));

        // Launch drop key pk_room_0.
        $dbman->drop_key($table, $key);

        // Define key pk_room_assets_0 (unique) to be dropped form buildings_room_assets.
        $table = new xmldb_table('buildings_room_assets');
        $key = new xmldb_key('pk_room_assets_0', XMLDB_KEY_UNIQUE, array('roomid'));

        // Launch drop key pk_room_assets_0.
        $dbman->drop_key($table, $key);

        // Define index idx_room_assets (not unique) to be dropped form buildings_room_assets.
        $table = new xmldb_table('buildings_room_assets');
        $index = new xmldb_index('idx_room_assets', XMLDB_INDEX_NOTUNIQUE, array('inventoryid'));

        // Conditionally launch drop index idx_room_assets.
        if ($dbman->index_exists($table, $index)) {
            $dbman->drop_index($table, $index);
        }


        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2016031601, 'local', 'buildings');
    }

    if ($oldversion < 2016031602) {

        // Added settings
        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2016031602, 'local', 'buildings');
    }

    if ($oldversion < 2016031700) {

        // Removed settings
        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2016031700, 'local', 'buildings');
    }

    if ($oldversion < 2016031701) {

        // Define table buildings_room_types to be created.
        $table = new xmldb_table('buildings_room_types');

        // Adding fields to table buildings_room_types.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('color', XMLDB_TYPE_CHAR, '8', null, null, null, null);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '20', null, null, null, null);

        // Adding keys to table buildings_room_types.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for buildings_room_types.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2016031701, 'local', 'buildings');
    }

    if ($oldversion < 2016031702) {

        // Define field roomtype to be dropped from buildings_room.
        $table = new xmldb_table('buildings_room');
        $field = new xmldb_field('roomtype');

        // Conditionally launch drop field roomtype.
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        // Define field roomtypeid to be added to buildings_room.
        $table = new xmldb_table('buildings_room');
        $field = new xmldb_field('roomtypeid', XMLDB_TYPE_INTEGER, '20', null, null, null, null, 'name');

        // Conditionally launch add field roomtypeid.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }


        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2016031702, 'local', 'buildings');
    }


    if ($oldversion < 2016031800) {

        // Rename field timemodifiled on table buildings_campus to NEWNAMEGOESHERE.
        $table = new xmldb_table('buildings_campus');
        $field = new xmldb_field('timemodifiled', XMLDB_TYPE_INTEGER, '20', null, null, null, null, 'timecreated');

        // Launch rename field timemodifiled.
        $dbman->rename_field($table, $field, 'timemodified');

        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2016031800, 'local', 'buildings');
    }

    if ($oldversion < 2016032100) {

        //Added settings
        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2016032100, 'local', 'buildings');
    }

    if ($oldversion < 2016050800) {

        // Define field test to be added to buildings_campus.
        $table = new xmldb_table('buildings_campus');
        $field = new xmldb_field('test', XMLDB_TYPE_INTEGER, '1', null, null, null, '0', 'timemodified');

        // Conditionally launch add field test.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2016050800, 'local', 'buildings');
    }
    if ($oldversion < 2016061400) {

        // Define field test to be added to buildings_campus.
        $table = new xmldb_table('buildings_campus');
        $field = new xmldb_field('test', XMLDB_TYPE_INTEGER, '1', null, null, null, '0', 'timemodified');

        // Conditionally launch add field test.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2016061400, 'local', 'buildings');
    }

    if ($oldversion < 2016062100) {

        // Define field parentroomid to be added to buildings_room.
        $table = new xmldb_table('buildings_room');
        $field = new xmldb_field('parentroomid', XMLDB_TYPE_INTEGER, '20', null, null, null, '0', 'floorid');

        // Conditionally launch add field parentroomid.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2016062100, 'local', 'buildings');
    }

    if ($oldversion < 2016062702) {

        // Define field idnumber to be added to buildings_building.
        $table = new xmldb_table('buildings_building');
        $field = new xmldb_field('idnumber', XMLDB_TYPE_CHAR, '255', null, null, null, null, 'color');

        // Conditionally launch add field idnumber.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }


        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2016062702, 'local', 'buildings');
    }

    if ($oldversion < 2016062704) {
        global $DB;

        $roomtypes = array(
            'Classroom',
            'Office',
            'Stair way',
            'Media closet',
            'Corridor',
            'Dining hall',
            'Cafeteria',
            'Workshop',
            'Seminar',
            'Laboratory',
            'Lecture Hall',
            'Washroom',
            'Lobby',
            'Additorium',
            'Amphitheater',
            'Library',
            'Meeting',
            'Machine',
            'Gymnasium',
            'Weight',
            'Court',
            'Training',
            'Conference',
            'Storage',
            'Foyer',
            'Computer Lab'
        );

        $data = array();

        for ($i = 0; $i < count($roomtypes); $i++) {
            $data[$i]['name'] = $roomtypes[$i];
            $data[$i]['timecreated'] = time();
            $data[$i]['timemodified'] = time();
            if (!$DB->get_record('buildings_room_types', array('name' => $roomtypes[$i]))) {
                $DB->insert_record('buildings_room_types', $data[$i]);
            }
        }

        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2016062704, 'local', 'buildings');
    }

    if ($oldversion < 2016062900) {

        // Define field guestreservable to be added to buildings_room.
        $table = new xmldb_table('buildings_room');
        $field = new xmldb_field('guestreservable', XMLDB_TYPE_INTEGER, '1', null, null, null, '1', 'color');

        // Conditionally launch add field guestreservable.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2016062900, 'local', 'buildings');
    }

    if ($oldversion < 2016070601) {



        $assets = array(
            'Black board',
            'Chairs',
            'Desks',
            'Table',
            'Computer',
            'Projector',
            'Television',
            'Laser pointer',
            'White board',
            'Podium',
            'Screen',
            'Interactive monitor',
            'Interactive board',
            'Interactive projector',
            'DVD Player',
            'VCR',
            'Microphone',
            'Sound system',
        );

        sort($assets);

        $data = array();

        for ($i = 0; $i < count($assets); $i++) {
            $data[$i]['name'] = $assets[$i];
            if (!$DB->get_record('buildings_assets_config', array('name' => $assets[$i]))) {
                $DB->insert_record('buildings_assets_config', $data[$i]);
            }
        }
        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2016070601, 'local', 'buildings');
    }

    if ($oldversion < 2016122100) {

        // Define field window to be added to buildings_room.
        $table = new xmldb_table('buildings_room');
        $field = new xmldb_field('window', XMLDB_TYPE_INTEGER, '1', null, null, null, '1', 'timemodified');

        // Conditionally launch add field window.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2016122100, 'local', 'buildings');
    }

    if ($oldversion < 2017020300) {

        // Define field description to be added to buildings_room.
        $table = new xmldb_table('buildings_room');
        $field = new xmldb_field('description', XMLDB_TYPE_TEXT, null, null, null, null, null, 'name');

        // Conditionally launch add field description.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2017020300, 'local', 'buildings');
    }

    if ($oldversion < 2017020700) {

        // Define field classroom to be added to buildings_room_types.
        $table = new xmldb_table('buildings_room_types');
        $field = new xmldb_field('classroom', XMLDB_TYPE_INTEGER, '1', null, null, null, '0', 'name');

        // Conditionally launch add field classroom.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2017020700, 'local', 'buildings');
    }

    if ($oldversion < 2017021401) {

        // Define field faculty to be added to buildings_room.
        $table = new xmldb_table('buildings_room');
        $field = new xmldb_field('faculty', XMLDB_TYPE_INTEGER, '4', null, null, null, '7', 'window');

        // Conditionally launch add field faculty.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field longitude to be added to buildings_room.
        $table = new xmldb_table('buildings_room');
        $field = new xmldb_field('longitude', XMLDB_TYPE_CHAR, '1333', null, null, null, '0', 'faculty');

        // Conditionally launch add field longitude.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field latitude to be added to buildings_room.
        $table = new xmldb_table('buildings_room');
        $field = new xmldb_field('latitude', XMLDB_TYPE_CHAR, '1333', null, null, null, '0', 'longitude');

        // Conditionally launch add field latitude.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field altitude to be added to buildings_room.
        $table = new xmldb_table('buildings_room');
        $field = new xmldb_field('altitude', XMLDB_TYPE_CHAR, '1333', null, null, null, '0', 'latitude');

        // Conditionally launch add field altitude.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define table buildings_faculty to be created.
        $table = new xmldb_table('buildings_faculty');

        // Adding fields to table buildings_faculty.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('name', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('shortname', XMLDB_TYPE_CHAR, '2', null, null, null, null);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '20', null, null, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '20', null, null, null, '0');

        // Adding keys to table buildings_faculty.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for buildings_faculty.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2017021401, 'local', 'buildings');
    }

    if ($oldversion < 2017030800) {

        // Define field value to be dropped from buildings_assets_config.
        $table = new xmldb_table('buildings_assets_config');
        $field = new xmldb_field('value');

        // Conditionally launch drop field value.
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        // Define table buildings_assets_config to be renamed to NEWNAMEGOESHERE.
        $table = new xmldb_table('buildings_assets_config');

        // Launch rename table for buildings_assets_config.
        $dbman->rename_table($table, 'buildings_assets_category');

        // Define table buildings_room_assets to be dropped.
        $table = new xmldb_table('buildings_room_assets');

        // Conditionally launch drop table for buildings_room_assets.
        if ($dbman->table_exists($table)) {
            $dbman->drop_table($table);
        }

        // Define table buildings_room_assets to be created.
        $table = new xmldb_table('buildings_room_assets');

        // Adding fields to table buildings_room_assets.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('roomid', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('categoryid', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('externalid', XMLDB_TYPE_INTEGER, '20', null, null, null, '0');
        $table->add_field('name', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('notes', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('quantity', XMLDB_TYPE_INTEGER, '10', null, null, null, '1');
        $table->add_field('external_location', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '20', null, null, null, null);

        // Adding keys to table buildings_room_assets.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for buildings_room_assets.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2017030800, 'local', 'buildings');
    }

    if ($oldversion < 2017031000) {

        // Changing type of field external_location on table buildings_room_assets to char.
        $table = new xmldb_table('buildings_room_assets');
        $field = new xmldb_field('external_location', XMLDB_TYPE_CHAR, '255', null, null, null, 'manual', 'quantity');

        // Launch change of type for field external_location.
        $dbman->change_field_type($table, $field);

        // Buildings savepoint reached.
        upgrade_plugin_savepoint(true, 2017031000, 'local', 'buildings');
    }


    return true;
}
