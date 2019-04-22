<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace local_buildings;

require(dirname(__FILE__) . "/PDO.class.php");

/**
 * This class is used to get assets from SnipeIt
 *
 * @author patrick
 */
class SnipeIt {

    private $DB;

    /**
     * 
     * @global \stdClass $CFG
     */
    public function __construct() {
        global $CFG;

        $dbHost = $CFG->buildings_snipeit_host;
        $dbName = $CFG->buildings_snipeit_dbname;
        $dbUserName = $CFG->buildings_snipeit_username;
        $dbPassword = $CFG->buildings_snipeit_password;

        $this->DB = new \local_buildings\DB($dbHost, $dbName, $dbUserName, $dbPassword);
    }

    private function defaultSql() {
        $sql = "Select "
                . "  a.id, "
                . "  u.first_name As room_name, "
                . "  a.name As asset_name, "
                . "  a.asset_tag, "
                . "  c.name As category, "
                . "  a.purchase_date, "
                . "  a.image, "
                . "  m.name As model_name, "
                . "  m.model_number, "
                . "  man.name As manufacturer "
                . "From "
                . "  assets a Inner Join "
                . "  models m "
                . "    On a.model_id = m.id Inner Join "
                . "  users u "
                . "    On a.assigned_to = u.id Inner Join "
                . "  manufacturers man "
                . "    On m.manufacturer_id = man.id  Inner Join"
                . "  categories c"
                . "    On m.category_id = c.id "
                . "Where ";

        return $sql;
    }

    /**
     * 
     * @param string $building
     * @param string $room
     */
    public function getAssetsByFirstName($building, $room) {

        $SDB = $this->DB;

        $sql = $this->defaultSql();
        $sql .= "  u.first_name = ? ";

        $results = $SDB->query($sql, array("$building $room"));

        return $results;
    }

    /**
     * 
     * @param string $building
     * @param string $room
     */
    public function getAssetsById($id) {

        $SDB = $this->DB;

        $sql = $this->defaultSql();
        $sql .= "  a.id = ? ";

        $results = $SDB->query($sql, array("$id"));

        return $results;
    }

    /**
     * 
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @param int $building
     * @param int $room
     */
    public function addToRoomAssets($roomId, $building, $room) {
        global $CFG, $DB;
        $assets = $this->getAssetsByFirstName($building, $room);

        for ($i = 0; $i < count($assets); $i++) {
            $data = array();
            //Get category id
            switch ($assets[$i]['category']) {
                case 'Desktops':
                case 'Laptops':
                    $data['categoryid'] = $this->getBuildingAssetCategoryId('Computers');
                    break;
                default:
                    $data['categoryid'] = $this->getBuildingAssetCategoryId($assets[$i]['category']);
                    break;
            }
            $data['roomid'] = $roomId;
            $data['externalid'] = $assets[$i]['id'];
            $data['external_location'] = 'snipeit';

            //Add to room if does not exist
            if (!$asset = $DB->get_record('buildings_room_assets', $data)) {
                $DB->insert_record('buildings_room_assets', $data);
            }
        }
    }

    /**
     * This  method can be used for automated tasks
     * @global \moodle_database $DB
     */
    public function addAssetsToRooms() {
        global $DB;

        $rooms = $DB->get_records('buildings_room', array());

        foreach ($rooms as $r) {
            $ROOM = new Room($r->id);
            $this->addToRoomAssets($r->id, $ROOM->getBuildingShortName(), $ROOM->getRoomNumber());
        }
    }

    /**
     * 
     * @global \moodle_database $DB
     * @param type $name
     */
    private function getBuildingAssetCategoryId($name) {
        global $DB;

        $category = $DB->get_record('buildings_assets_category', array('name' => $name));

        return $category->id;
    }

    /**
     * 
     * @global \stdClass $CFG
     * @param string $building
     * @param string $room
     */
    public function getAssetsList($id) {
        global $CFG;
        
        $asset = $this->getAssetsById($id);
        if (empty($asset[0]['asset_name'])) {
            $name = $asset[0]['model_name'];
        } else {
            $name = $asset[0]['asset_name'];
        }
        
        $html = '<div>';
        $html .= '  <table class="table table-stripped">';
        $html .= '     <tbody>';
        $html .= '     <tr>';
        $html .= '         <td>';
        $html .= '            ' . get_string('model', 'local_buildings');
        $html .= '         </td>';
        $html .= '         <td>';
        $html .= '            ' . $asset[0]['model_name'];
        $html .= '         </td>';
        $html .= '     </tr>';
        $html .= '     <tr>';
        $html .= '         <td>';
        $html .= '            ' . get_string('model_number', 'local_buildings');
        $html .= '         </td>';
        $html .= '         <td>';
        $html .= '            ' . $asset[0]['model_number'];
        $html .= '         </td>';
        $html .= '     </tr>';
        $html .= '     <tr>';
        $html .= '         <td>';
        $html .= '            ' . get_string('manufacturer', 'local_buildings');
        $html .= '         </td>';
        $html .= '         <td>';
        $html .= '            ' . $asset[0]['manufacturer'];
        $html .= '         </td>';
        $html .= '     </tr>';
        $html .= '     <tr>';
        $html .= '         <td>';
        $html .= '            ' . get_string('purchase_date', 'local_buildings');
        $html .= '         </td>';
        $html .= '         <td>';
        $html .= '            ' . $asset[0]['purchase_date'];
        $html .= '         </td>';
        $html .= '     </tr>';
        $html .= '     <tr>';
        $html .= '         <td>';
        $html .= '            ' . get_string('image', 'local_buildings');
        $html .= '         </td>';
        $html .= '         <td>';
        if (!empty($asset[0]['image'])) {
            $html .= '<img src="' . $CFG->buildings_snipeit_url . $asset[0]['image'] . '" class="img img-responsive">';
        }
        $html .= '         </td>';
        $html .= '     </tr>';
        $html .= '   </tbody>';
        $html .= ' </table>';
        $html .= '</div>';
        
        return $html;
    }

}
