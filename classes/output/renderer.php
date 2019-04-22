<?php
/**
 * *************************************************************************
 * *                     Norquest Curriculum Settings                     **
 * *************************************************************************
 * @package     local                                                     **
 * @subpackage  selfservehd                                               **
 * @link                                                                  **
 * @author      Patrick Thibaudeau                                        **
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later  **
 * *************************************************************************
 * ************************************************************************ */

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace local_buildings\output;
/**
 * Description of renderer
 *
 * @author patrick
 */
class renderer extends \plugin_renderer_base {
    
    public function render_dashboard(\templatable $dashboard) {
        $data = $dashboard->export_for_template($this);
        return $this->render_from_template('local_buildings/dashboard', $data);
    }
    
    public function render_buildings(\templatable $buildings) {
        $data = $buildings->export_for_template($this);
        return $this->render_from_template('local_buildings/buildings', $data);
    }
    
    public function render_floors(\templatable $floors) {
        $data = $floors->export_for_template($this);
        return $this->render_from_template('local_buildings/floors', $data);
    }
    
    public function render_rooms(\templatable $rooms) {
        $data = $rooms->export_for_template($this);
        return $this->render_from_template('local_buildings/rooms', $data);
    }
}

