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
class floors implements \renderable, \templatable {
    
    /**
     *
     * @var int
     */
    private $buildingId;
    
    public function __construct($buildingId) {
        $this->buildingId = $buildingId;
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
            'buildingId' => $this->buildingId,
            'floors' => $this->getFloors()
        ];
 
        return $data;
    }

    private function getFloors() {
        global $CFG, $DB;
        $FLOORS = new \local_buildings\Floors($this->buildingId);
        $floors = $FLOORS->getFloors();
        $floorsArray = [];
        $i = 0;
        foreach ($floors as $f) {
            $FLOOR = new \local_buildings\Floor($f['id']);
            $floorsArray[$i]['id'] = $FLOOR->getId();
            $floorsArray[$i]['buildingId'] = $this->buildingId;
            $floorsArray[$i]['campusId'] = $FLOOR->getCampusId();
            $floorsArray[$i]['number'] = $FLOOR->getNumber();
            $floorsArray[$i]['name'] = $FLOOR->getName();
            $floorsArray[$i]['numberOfRooms'] = $FLOOR->getNumberOfRoomss();
            $floorsArray[$i]['color'] = $FLOOR->getColor();
            $i++;
            unset($FLOOR);
        }
        
        return $floorsArray;
    }

}
