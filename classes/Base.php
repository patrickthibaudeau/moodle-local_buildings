<?php

namespace local_buildings;

class Base {

    const NO_VALUE = '-99999999';
    const RESERVABLE_BY_APPROVERS = 2;
    const RESERVABLE_BY_GUESTS = 1;
    const RESERVABLE_NO = 0;
    const RESERVABLE_READONLY = 3;

    /**
     * Creates the Moodle page header
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @global \moodle_page $PAGE
     * @global \stdClass $SITE
     * @param string $url Current page url
     * @param string $pagetitle  Page title
     * @param string $pageheading Page heading (Note hard coded to site fullname)
     * @param array $context The page context (SYSTEM, COURSE, MODULE etc)
     * @return HTML Contains page information and loads all Javascript and CSS
     */
    public static function buildingsPage($url, $pagetitle, $pageheading, $context, $pagelayout = 'standard') {
        global $CFG, $PAGE, $SITE;
        
        $stringman = get_string_manager();
        $strings = $stringman->load_component_strings('local_buildings', current_language());

        $PAGE->set_url($url);
        $PAGE->set_title($pagetitle);
        $PAGE->set_heading($pageheading);
        $PAGE->set_pagelayout($pagelayout);
        $PAGE->set_context($context);
        $PAGE->requires->jquery_plugin('ui-css');
        $PAGE->requires->css($CFG->pluginlocalstyle . "buildings.css");
        $PAGE->requires->css('/local/buildings/js/datatable/DataTables-1.10.18/css/jquery.dataTables.min.css');
        $PAGE->requires->css('/local/buildings/js/bgrins-spectrum/spectrum.css');
        $PAGE->requires->js_call_amd('local_buildings/edit', 'init');
        $PAGE->requires->strings_for_js(array_keys($strings), 'local_buildings');
    }

    /**
     * get all buildings for select2
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @global \session $USER
     * @param int $campusid
     * @return array $user JSON encoded array to be used with javascript
     */
    public static function getAllBuildings() {
        global $CFG, $DB, $USER;

        $term = optional_param('q', '', PARAM_RAW);
        $campuses = $DB->get_records('buildings_campus');

        $buildings[get_string('select', 'local_buildings')][0] = get_string('all', 'local_room_reservations');
        foreach ($campuses as $c) {
            $buildings[$c->name] = array();
            $sql = "SELECT id, name, shortname FROM {buildings_building} WHERE campusid = $c->id ORDER BY name";
            $results = $DB->get_records_sql($sql);
            foreach ($results as $result) {
                $buildings[$c->name][$result->id] = $result->name . ' (' . $result->shortname . ')';
            }
        }

        return $buildings;
    }

    /**
     * get all buildings for select2
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @global \session $USER
     * @param int $campusid
     * @return array $user JSON encoded array to be used with javascript
     */
    public static function getAllCampusBuildings($campusid) {
        global $CFG, $DB, $USER;

        $term = optional_param('q', '', PARAM_RAW);
        $sql = "SELECT id, name, shortname FROM {buildings_building} WHERE campusid=$campusid ORDER BY name";
        $buildings = array(0 => get_string('all', 'local_room_reservations'));
        $results = $DB->get_records_sql($sql);
        foreach ($results as $result) {
            $buildings[$result->id] = $result->name . ' (' . $result->shortname . ')';
        }

        return $buildings;
    }

    /**
     * Get all rooms for select2
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @global \session $USER
     * @param int $campusid
     * @return array $user JSON encoded array to be used with javascript
     */
    public static function getAllRooms() {
        global $CFG, $DB, $USER;

        $campuses = $DB->get_records('buildings_campus');

        $rooms[get_string('select', 'local_buildings')] = array(0 => get_string('all', 'local_room_reservations'));

        foreach ($campuses as $c) {
            $rooms[$c->name] = array();
            $sql = 'Select' .
                    '  {buildings_room}.id as id,' .
                    '  {buildings_room}.roomnumber as roomnumber,' .
                    '  {buildings_room}.name as name,' .
                    '  {buildings_room}.seats as seats,' .
                    '  {buildings_room}.color as color,' .
                    '  {buildings_room}.guestreservable as guestreservable,' .
                    '  {buildings_building}.name As building,' .
                    '  {buildings_building}.shortname as buildingsn,' .
                    '  {buildings_room}.roomtypeid as roomtypeid,' .
                    '  {buildings_room}_types.name As roomtype' .
                    ' From' .
                    '  {buildings_campus} Inner Join' .
                    '  {buildings_building}' .
                    '    On {buildings_building}.campusid =' .
                    '    {buildings_campus}.id Inner Join' .
                    '  {buildings_floor}' .
                    '    On {buildings_floor}.buildingid =' .
                    '    {buildings_building}.id Inner Join' .
                    '  {buildings_room}' .
                    '    On {buildings_room}.floorid =' .
                    '    {buildings_floor}.id Inner Join' .
                    '  {buildings_room}_types' .
                    '    On {buildings_room}.roomtypeid =' .
                    '    {buildings_room}_types.id' .
                    ' Where' .
                    '  {buildings_campus}.id = ' . $c->id . ' ORDER BY {buildings_room}.roomnumber';
            '  ORDER BY {buildings_room}.roomnumber';

            $results = $DB->get_records_sql($sql);

            foreach ($results as $result) {
                $rooms[$c->name][$result->id] = $result->buildingsn . ' ' . $result->roomnumber . ' (' . $result->roomtype . ' | ' . $result->seats . ')';
            }
        }

        return $rooms;
    }

    /**
     * Get all roomtypes for select2
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @global \session $USER
     * @param int $campusid
     * @return array $user JSON encoded array to be used with javascript
     */
    public static function getRoomTypes() {
        global $CFG, $DB, $USER;


        $sql = 'Select id, name FROM {buildings_room_types} ORDER BY name';
        $roomtypes = array(0 => get_string('all', 'local_room_reservations'));
        $results = $DB->get_records_sql($sql);
        foreach ($results as $result) {
            $roomtypes[$result->id] = $result->name;
        }

        return $roomtypes;
    }

    public static function getEditorOptions($context) {
        global $CFG;
        return array('subdirs' => 1, 'maxbytes' => $CFG->maxbytes, 'maxfiles' => 50, 'changeformat' => 1, 'context' => $context, 'noclean' => 1, 'trusttext' => 0);
    }

    public static function getFileManagerOptions($context) {
        global $CFG;
        return array('subdirs' => 0, 'maxbytes' => $CFG->maxbytes, 'maxfiles' => 50);
    }

}
