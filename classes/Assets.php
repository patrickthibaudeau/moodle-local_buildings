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

class Assets {

    private $assets;
    private $assetRecords;
    
    const ASSET_TYPE_MANUAL = 'manual';
    const ASSET_TYPE_SNIPEIT = 'snipeit';
   

    /**
     * 
     * @global \stdclass $CFG
     * @global \moodle_database $DB
     * @global \moodle_database $DB2
     */
    public function __construct() {
        global $CFG, $DB;
        
        $assets = $DB->get_records('buildings_assets_category', array(), 'name');
        
        foreach ($assets as $a) {
        $this->assets[$a->id] = $a->name;
        }
        
        $this->assetRecords = $assets;
    }


    function getAssets() {
        return $this->assets;
    }
    
    public function getAssetRecords() {
        return $this->assetRecords;
    }

        
    /**
     * Return HTML table of floors
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @param string $value Value used for editing, 
     */
    public function getHtmlTable() {
        global $CFG, $DB;

        $assets = convert_to_array($this->assetRecords);
        
        $headers = array();
        $headers['name'] = get_string('name', 'local_buildings');

        $action = array();
        $action[0]['action'] = 'edit_asset';
        $action[0]['url'] = 'asset.php?id=';
        $action[0]['classes'] = 'btn btn-warning';
        $action[0]['key'] = 'id';
        $action[0]['title'] = get_string('edit', 'local_buildings');
        $action[0]['iClasses'] = 'fa fa-pencil';
        $action[1]['action'] = 'delete_asset';
        $action[1]['url'] = '#';
        $action[1]['classes'] = 'btn btn-danger delete-asset';
        $action[1]['key'] = 'id';
        $action[1]['title'] = get_string('delete', 'local_buildings');
        $action[1]['iClasses'] = 'fa fa-trash';
        $html = \local_buildings\Helper::formatAsTable('assets_table', $assets, $headers, $action);

        return $html;
    }
}
