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

class RoomAssets {

    private $roomId;

    /**
     * 
     * @global \moodle_database $DB
     * @param int $roomId
     */
    public function __construct($roomId) {
        global $DB;

        $this->roomId = $roomId;
    }

    public function getAssetsListByCategory() {
        global $DB;

        $categories = $DB->get_records('buildings_assets_category', array());
        $html = '<div class="panel-group" id="assetsAccordion" role="tablist" aria-multiselectable="true">';
        foreach ($categories as $c) {
            if ($assets = $DB->get_records('buildings_room_assets', array('categoryid' => $c->id, 'roomid' => $this->roomId))) {
                $html .= '<div class="panel panel-default">';
                $html .= '    <div class="panel-heading" role="tab" id="assetsHeading' . $c->id . '">';
                $html .= '        <h3 class="panel-title" style="color: #000">';
                $html .= '            <a role="button" data-toggle="collapse" data-parent="#assetsAccordion" href="#assetsCollapse' . $c->id . '" aria-expanded="true" aria-controls="assetsCollapse' . $c->id . '">';
                $html .= '                ' . $c->name;
                $html .= '            </a>';
                $html .= '        </h3>';
                $html .= '    </div>';
                $html .= '    <div id="assetsCollapse' . $c->id . '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="assetsHeading' . $c->id . '">';
                $html .= '        <div class="panel-body">';

                foreach ($assets as $a) {
                    $html .= $this->getRoomAssetDetails($a);
                }
                $html .= '        </div>';
                $html .= '    </div>';
                $html .= '</div>';
            }
        }
        $html .= '</div>';

        return $html;
    }

    /**
     * 
     * @param \stdClass $assetObject
     */
    public function getRoomAssetDetails($assetObject) {
        if ($assetObject->external_location == Assets::ASSET_TYPE_SNIPEIT) {
            $SNIPEIT = new SnipeIt();
            $html = $SNIPEIT->getAssetsList($assetObject->externalid);
        } else {
            $html .= '<div>';
            $html .= '  <table class="table table-stripped">';
            $html .= '     <tbody>';
            $html .= '     <tr>';
            $html .= '         <td>';
            $html .= '            ' . get_string('name', 'local_buildings');
            $html .= '         </td>';
            $html .= '         <td>';
            $html .= '            ' . $assetObject->name;
            $html .= '         </td>';
            $html .= '     </tr>';
            $html .= '     <tr>';
            $html .= '         <td>';
            $html .= '            ' . get_string('quantity', 'local_buildings');
            $html .= '         </td>';
            $html .= '         <td>';
            $html .= '            ' . $assetObject->quantity;
            $html .= '         </td>';
            $html .= '     </tr>';
            $html .= '     <tr>';
            $html .= '         <td>';
            $html .= '            ' . get_string('notes', 'local_buildings');
            $html .= '         </td>';
            $html .= '         <td>';
            $html .= '            ' . $assetObject->notes;
            $html .= '         </td>';
            $html .= '     </tr>';
            $html .= '   </tbody>';
            $html .= ' </table>';
            $html .= '</div>';
        }

        RETURN $html;
    }

}
