<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace local_buildings\output;

/**
 * 
 * @global \stdClass $USER
 * @param \renderer_base $output
 * @return array
 */
class buildings implements \renderable, \templatable {
    
    /**
     *
     * @var int
     */
    private $campusId;
    
    public function __construct($campusId) {
        $this->campusId = $campusId;
    }

    /**
     * 
     * @global \stdClass $USER
     * @global \moodle_database $DB
     * @param \renderer_base $output
     * @return array
     */
    public function export_for_template(\renderer_base $output) {
        global $CFG, $USER, $DB;

        $data = [
            'wwwroot' => $CFG->wwwroot,
            'buildings' => $this->getBuildings()
        ];
 
        return $data;
    }

    private function getBuildings() {
        global $CFG, $DB;
        $BUILDINGS = new \local_buildings\Buildings($this->campusId);
        $buildings = $BUILDINGS->getBuildings();
        $buildingsArray = [];
        $i = 0;
        foreach ($buildings as $b) {
            $BUILDING = new \local_buildings\Building($b['id']);
            $buildingsArray[$i]['id'] = $BUILDING->getId();
            $buildingsArray[$i]['campusId'] = $this->campusId;
            $buildingsArray[$i]['name'] = $BUILDING->getName();
            $buildingsArray[$i]['shortName'] = $BUILDING->getShortname();
            $buildingsArray[$i]['idNumber'] = $BUILDING->getIdNumber();
            $buildingsArray[$i]['numberOfFloors'] = $BUILDING->getNumberOfFloors();
            $buildingsArray[$i]['color'] = $BUILDING->getColor();
            $i++;
            unset($BUILDING);
        }
        
        return $buildingsArray;
    }

}
