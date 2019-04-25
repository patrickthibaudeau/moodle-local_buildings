<?php

/**
 * Code run after the local_buildings  database tables have been created.
 * Disables this plugin for new installs
 * @return bool
 */
function xmldb_local_buildings_install() {
    global $CFG, $DB, $OUTPUT;

    //Add faculty settings
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
        'Foyer'
    );

    $data = array();

    for ($i = 0; $i < count($roomtypes); $i++) {
        $data[$i]['name'] = $roomtypes[$i];
        $data[$i]['timecreated'] = time();
        $data[$i]['timemodified'] = time();

        $DB->insert_record('buildings_room_types', $data[$i]);
    }
    return true;
}
