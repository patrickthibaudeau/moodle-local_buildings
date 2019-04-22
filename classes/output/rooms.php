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
class rooms implements \renderable, \templatable {
    
    /**
     *
     * @var int
     */
    private $floorId;
    
    public function __construct($floorId) {
        $this->floorId = $floorId;
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
        $FLOOR = new \local_buildings\Floor($this->floorId);
        
        $data = [
            'wwwroot' => $CFG->wwwroot,
            'buildingId' => $FLOOR->getBuildingId(),
            'floorId' => $this->floorId,
            'rooms' => $this->getRooms()
        ];
 
        return $data;
    }

    private function getRooms() {
        global $CFG, $DB;
        $ROOMS = new \local_buildings\Rooms($this->floorId);
        $rooms = $ROOMS->getRooms();
        $roomsArray = [];
        $i = 0;
        foreach ($rooms as $r) {
            $ROOM = new \local_buildings\Room($r['id']);
            $roomsArray[$i]['id'] = $ROOM->getId();
            $roomsArray[$i]['floorId'] = $this->floorId;
            $roomsArray[$i]['campusId'] = $ROOM->getCampusId();
            $roomsArray[$i]['buildingId'] = $ROOM->getBuildingId();
            $roomsArray[$i]['number'] = $ROOM->getRoomNumber();
            $roomsArray[$i]['name'] = $ROOM->getName();
            $roomsArray[$i]['numberOfSeats'] = $ROOM->getSeats();
            $roomsArray[$i]['roomType'] = $ROOM->getRoomType();
            $roomsArray[$i]['color'] = $ROOM->getColor();
            $i++;
            unset($ROOM);
        }
        
        return $roomsArray;
    }

}
