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
    
    $assets = array(
            'Blackboard',
            'Chairs',
            'Desks',
            'Table',
            'Computer PC',
            'Computer MAC',
            'Computer LINUX',
            'Projector',
            'Television',
            'Laser pointer',
            'Whiteboard',
            'Podium',
            'Screen',
            'Interactive monitor',
            'Interactive board',
            'Interactive projector',
            'DVD Player',
            'VCR Player',
            'Microphone',
            'Sound system',
            'Blu-ray player',
            'Neck Mic (Camtashia-Integrated)',
            'Neck Mic',
            'Document camera',
        );
        
        sort($assets);

        $data = array();

        for ($i = 0; $i < count($assets); $i++) {
            $data[$i]['name'] = $assets[$i];
            if (!$DB->get_record('buildings_assets_config', array('name' => $assets[$i]))) {
                $DB->insert_record('buildings_assets_config', $data[$i]);
            }
        }
    
    return true;
}
