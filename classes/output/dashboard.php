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
class dashboard implements \renderable, \templatable {

    public function __construct() {
        
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
            'campuses' => $this->getCampuses()
        ];
 
        return $data;
    }

    private function getCampuses() {
        global $CFG, $DB;
        $CAMPUSES = new \local_buildings\Campuses();
        $campuses = $CAMPUSES->getCampuses();
        $campusArray = [];
        $i = 0;
        foreach ($campuses as $c) {
            $CAMPUS = new \local_buildings\Campus($c['id']);
            $campusArray[$i]['id'] = $CAMPUS->getId();
            $campusArray[$i]['name'] = $CAMPUS->getName();
            $campusArray[$i]['numberOfBuildings'] = $CAMPUS->getNumberOfBuildings();
            $i++;
            unset($CAMPUS);
        }
        
        return $campusArray;
    }

}
