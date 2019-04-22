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

require_once("$CFG->dirroot/local/buildings/classes/Action.php");

class Helper {

    /**
     * 
     * @param string $tableName
     * @param stdClass $data
     * @param array $headers
     * @param array $actions
     * @param array $useTrueFalse, will make result show true or false. Enter field names in array
     * @return string
     */
    public static function formatAsTable($tableName, $data, $headers, $actions, $useTrueFalse = array()) {

        $headerKeys = array_keys($headers);

        $html = '';
        $html .= '<table id="' . $tableName . '" class="table table responsive">' . "\n";
        $html .= '  <thead>' . "\n";
        $html .= '      <tr>' . "\n";
        foreach ($headers as $header) {
            $html .= '              <th>' . $header . '</th>' . "\n";
        }
        if (!empty($actions)) {
            $html .= "<th>" . get_string('actions', 'local_buildings') . "</th>" . "\n";
        }

        $html .= '      </tr>' . "\n";
        $html .= '  </thead>' . "\n";
        $html .= '  <tbody>' . "\n";

        if (isset($data)) {
            foreach ($data as $b) {
                $array = (array) $b;
                $html .= "<tr>" . "\n";

                foreach ($headerKeys as $hk) {
                    if (in_array($hk, $useTrueFalse)) {
                        if ($array[$hk] == 1) {
                            $value = get_string('yes');
                        } else {
                            $value = get_string('no');
                        }
                    } else {
                        $value = $array[$hk];
                    }
                    $html .= '<td>' . $value . '</td>' . "\n";
                }

                if (!empty($actions)) {
                    $html .= "<td>" . "\n";

                    for ($i = 0; $i < count($actions); $i++) {

                        $html .= Action::getLink($actions[$i]['action'], $actions[$i]['url'], $actions[$i]['classes'], $actions[$i]['key'], $b['id'], $actions[$i]['title'], $actions[$i]['iClasses'], $actions[$i]['title']) . "\n";
                    }
                    $html .= "</td>" . "\n";
                }
                $html .= "</tr>" . "\n";
            }
        }



        $html .= '  </tbody>' . "\n";
        $html .= '</table>' . "\n";

        return $html;
    }

    /**
     * Prints link to home
     * @global \stdObject $CFG
     */
    public static function printHomeButton() {
        global $CFG;

        $html = '<a href="' . $CFG->wwwroot . '/local/buildings" title="' . get_string('home', 'local_buildings') . '" class="btn btn-outline-success"><i class="fa fa-home"></i></a>';

        echo $html;
    }

    /**
     * Given a number from 0 to 99, return the string name
     * @param int $number
     * @return string
     */
    public static function getNumberName($number) {
        //Verify that the number is not negative
        //If it is, return error
        if ($number < 0) {
            return 'Error - Cannot use negative numbers.';
        }
        //Get the string length
        $numberLentgh = strlen($number);
        //if the string length is over two (place value tens), return an error
        //For this system, we only need to get to 99
//        if ($numberLentgh > 2) {
//            return 'Error - Cannot use numbers over 99';
//        }
        //Convert number into an array. This will make it easier to figure out the
        //place value (ones, tens, hundreds etc) of each number
        $currentNumber = array();
        for ($i = 0; $i < $numberLentgh; $i++) {
            $numberPostion = $i;
            $currentNumber[$i] = substr($number, $i, 1);
        }
        //Reverse the array so that the place value ones is 0 and the place value tens is 1 and so on
        $currentNumber = array_reverse($currentNumber);
        //Get the string name of the number. We only require place value ones and tens
        if ($numberLentgh == 1) {
            $numberName = self::getPlaceValueOnesNumberName($currentNumber[0]);
        } else {
            //Any other number use the php numberformatter class in order to write out any number
            $f = new NumberFormatter('en', NumberFormatter::SPELLOUT);
            $f->setTextAttribute(NumberFormatter::DEFAULT_RULESET, "%spellout-numbering-verbose");
            $numberName = self::replaceLastNumberNameValue($currentNumber, $f->format($number));
        }

        return $numberName;
    }

    /**
     * Using the Numberformatter class within PHP, convert the last value to the "th" version of the number
     * @param array $numberArray
     * @param string $stringValue
     * @return string
     */
    private static function replaceLastNumberNameValue($numberArray, $stringValue) {
        //don't check for the last number if the number is in tens
        if (count($numberArray) == 2) {
            return self::getPlaceValueTensNumberName($numberArray[0], $numberArray[1]);
        } else {

            $lastNumberOfString = str_replace('-', '', strstr($stringValue, '-', false));

            switch ($lastNumberOfString) {
                case 'one':
                    $numberString = self::getPlaceValueOnesNumberName(1);
                    $numberName = str_replace('-', '', strstr($stringValue, '-', true)) . '-' . $numberString;
                    break;
                case 'two':
                    $numberString = self::getPlaceValueOnesNumberName(2);
                    $numberName = str_replace('-', '', strstr($stringValue, '-', true)) . '-' . $numberString;
                    break;
                case 'three':
                    $numberString = self::getPlaceValueOnesNumberName(3);
                    $numberName = str_replace('-', '', strstr($stringValue, '-', true)) . '-' . $numberString;
                    break;
                case 'four':
                    $numberString = self::getPlaceValueOnesNumberName(4);
                    $numberName = str_replace('-', '', strstr($stringValue, '-', true)) . '-' . $numberString;
                    break;
                case 'five':
                    $numberString = self::getPlaceValueOnesNumberName(5);
                    $numberName = str_replace('-', '', strstr($stringValue, '-', true)) . '-' . $numberString;
                    break;
                case 'six':
                    $numberString = self::getPlaceValueOnesNumberName(6);
                    $numberName = str_replace('-', '', strstr($stringValue, '-', true)) . '-' . $numberString;
                    break;
                case 'seven':
                    $numberString = self::getPlaceValueOnesNumberName(7);
                    $numberName = str_replace('-', '', strstr($stringValue, '-', true)) . '-' . $numberString;
                    break;
                case 'eight':
                    $numberString = self::getPlaceValueOnesNumberName(8);
                    $numberName = str_replace('-', '', strstr($stringValue, '-', true)) . '-' . $numberString;
                    break;
                case 'nine':
                    $numberString = self::getPlaceValueOnesNumberName(9);
                    $numberName = str_replace('-', '', strstr($stringValue, '-', true)) . '-' . $numberString;
                    break;
                default:
                    $numberName = $stringValue;
                    //At this point we must deal with numbers ending with 10,20,30,40 etc
                    $split = explode(' ', $numberName);
                    $splitCount = count($split);
                    $lastNumberOfString = $split[$splitCount - 1];
                    switch ($lastNumberOfString) {
                        case 'ten':
                            $numberString = self::getNumberName(10);
                            $split[$splitCount - 1] = $numberString;
                            $numberName = implode(' ', $split);
                            break;
                        case 'twenty':
                            $numberString = self::getNumberName(20);
                            $split[$splitCount - 1] = $numberString;
                            $numberName = implode(' ', $split);
                            break;
                        case 'twenty':
                            $numberString = self::getNumberName(30);
                            $split[$splitCount - 1] = $numberString;
                            $numberName = implode(' ', $split);
                            break;
                        case 'thirty':
                            $numberString = self::getNumberName(40);
                            $split[$splitCount - 1] = $numberString;
                            $numberName = implode(' ', $split);
                            break;
                        case 'forty':
                            $numberString = self::getNumberName(40);
                            $split[$splitCount - 1] = $numberString;
                            $numberName = implode(' ', $split);
                            break;
                        case 'fifty':
                            $numberString = self::getNumberName(50);
                            $split[$splitCount - 1] = $numberString;
                            $numberName = implode(' ', $split);
                            break;
                        case 'sixty':
                            $numberString = self::getNumberName(60);
                            $split[$splitCount - 1] = $numberString;
                            $numberName = implode(' ', $split);
                            break;
                        case 'seventy':
                            $numberString = self::getNumberName(70);
                            $split[$splitCount - 1] = $numberString;
                            $numberName = implode(' ', $split);
                            break;
                        case 'eighty':
                            $numberString = self::getNumberName(80);
                            $split[$splitCount - 1] = $numberString;
                            $numberName = implode(' ', $split);
                            break;
                        case 'ninety':
                            $numberString = self::getNumberName(90);
                            $split[$splitCount - 1] = $numberString;
                            $numberName = implode(' ', $split);
                            break;
                    }
                    break;
            }

            return $numberName;
        }
    }

    /**
     * return string number name of place value ones
     * @param int $number
     * @return string
     */
    private static function getPlaceValueOnesNumberName($number) {
        switch ($number) {
            case 0:
                $numberName = 'ground';
                break;
            case 1:
                $numberName = 'first';
                break;
            case 2:
                $numberName = 'second';
                break;
            case 3:
                $numberName = 'third';
                break;
            case 4:
                $numberName = 'fourth';
                break;
            case 5:
                $numberName = 'fifth';
                break;
            case 6:
                $numberName = 'sixth';
                break;
            case 7:
                $numberName = 'seventh';
                break;
            case 8:
                $numberName = 'eighth';
                break;
            case 9:
                $numberName = 'nineth';
                break;
        }

        return $numberName;
    }

    /**
     * return string number name of place value tens
     * @param int $number
     * @return string
     */
    private static function getPlaceValueTensNumberName($onesValue, $tenthValue) {
        switch ($tenthValue) {
            case 1:
                $numberName = self::getPlaceValueTensNumberNameStartingWithOne($tenthValue . $onesValue);
                break;
            case 2:
                if ($onesValue == 0) {
                    $numberName = 'twentieth';
                } else {
                    $numberName = 'twenty-' . self::getPlaceValueOnesNumberName($onesValue);
                }
                break;
            case 3:
                if ($onesValue == 0) {
                    $numberName = 'thirtieth';
                } else {
                    $numberName = 'thirty-' . self::getPlaceValueOnesNumberName($onesValue);
                }
                break;
            case 4:
                if ($onesValue == 0) {
                    $numberName = 'fortieth';
                } else {
                    $numberName = 'fourty-' . self::getPlaceValueOnesNumberName($onesValue);
                }
                break;
            case 5:
                if ($onesValue == 0) {
                    $numberName = 'fiftieth';
                } else {
                    $numberName = 'fifty-' . self::getPlaceValueOnesNumberName($onesValue);
                }
                break;
            case 6:
                if ($onesValue == 0) {
                    $numberName = 'sixtieth';
                } else {
                    $numberName = 'sixty-' . self::getPlaceValueOnesNumberName($onesValue);
                }
                break;
            case 7:
                if ($onesValue == 0) {
                    $numberName = 'seventieth';
                } else {
                    $numberName = 'seventy-' . self::getPlaceValueOnesNumberName($onesValue);
                }
                break;
            case 8:
                if ($onesValue == 0) {
                    $numberName = 'eightieth';
                } else {
                    $numberName = 'eighty-' . self::getPlaceValueOnesNumberName($onesValue);
                }
                break;
            case 9:
                if ($onesValue == 0) {
                    $numberName = 'ninetieth';
                } else {
                    $numberName = 'ninety-' . self::getPlaceValueOnesNumberName($onesValue);
                }
                break;
        }

        return $numberName;
    }

    /**
     * return string number name of place value tens when tens begins with 1
     * @param int $number
     * @return string
     */
    private static function getPlaceValueTensNumberNameStartingWithOne($number) {
        switch ($number) {
            case 10:
                $numberName = 'Tenth';
                break;
            case 11:
                $numberName = 'Eleventh';
                break;
            case 12:
                $numberName = 'Twelfth';
                break;
            case 13:
                $numberName = 'Thirteenth';
                break;
            case 14:
                $numberName = 'Fourteenth';
                break;
            case 15:
                $numberName = 'Fifteenth';
                break;
            case 16:
                $numberName = 'Sixteenth';
                break;
            case 17:
                $numberName = 'Seventeenth';
                break;
            case 18:
                $numberName = 'Eighteenth';
                break;
            case 19:
                $numberName = 'Nineteenth';
                break;
        }

        return $numberName;
    }

    /**
     * Returns string HTML select box with all campuses 
     * @param string $divId
     * @param string $class
     * @return string $html
     */
    public static function printCampusesSelectBox($divId = 'campusid', $class = null) {
        $CAMPUSES = new \local_buildings\Campuses();

        $results = array();
        foreach ($CAMPUSES->getCampuses() as $campus) {
            $results[$campus['id']] = $campus['name'];
        }

        asort($results, SORT_STRING);
        $html = '<select id="' . $divId . '" name="' . $divId . '" class="campusid js-example-responsive ' . $class . '" style="width: 100%">' . "\n";
        $html .= '<option value="0" selected>' . get_string('select') . '</option>';
        foreach ($results AS $key => $value) {
            $html .= '<option value="' . $key . '">' . $value . '</option>';
        }
        $html .= '</select>';

        return $html;
    }

    /**
     * Returns string HTML select box with all buildings for a campus 
     * @param int $campusId
     * @param string $divId
     * @param string $class
     * @param boolean $addSelect
     * @param boolean $addMultiple
     * @return string $html
     */
    public static function printBuildingsSelectBox($campusId, $divId = 'buildingid', $class = null, $addSelect = false, $addMultiple = false , $required = false) {
        $BUILDINGS = new \local_buildings\Buildings($campusId);

        $results = array();
        foreach ($BUILDINGS->getBuildings() as $building) {
            $results[$building['id']] = $building['name'];
        }

        $multiple = '';
        $multipleArray = '';
        if ($addMultiple) {
            $multiple = 'multiple="multiple"';
            $multipleArray = '[]';
        }
        
        if ($required == true) {
            $requiredText = 'requried';
        } else {
            $requiredText = '';
        }

        asort($results, SORT_STRING);
        $html = '<select id="' . $divId . '" name="' . $divId . $multipleArray . '" class="buildingid js-example-responsive ' . $class . '" ' . $multiple . ' style="width: 100%" ' . $requiredText . '>' . "\n";
        if ($addSelect) {
            $html .= '<option value="">' . get_string('select', 'local_buildings') . '</option>';
        }
        foreach ($results AS $key => $value) {
            $html .= '<option value="' . $key . '">' . $value . '</option>';
        }
        $html .= '</select>';

        return $html;
    }

    /**
     * Returns string HTML select box with all buildings for a campus 
     * @global \stdClass $CFG
     * @global \moodle_database $$DB
     * @param array $buildingId One or many building ids
     * @param string $divId
     * @param string $class
     * @param boolean $addSelect Adds select option with empty value (default: false)
     * @param boolean $addMultiple Enable multiple select (default: false)
     * @param boolean $guestReservableOnly Only quest reservable rooms will be shown (default: true)
     * @return string $html
     */
    public static function printBuildingRoomsSelectBox($buildingId, $divId = 'roomid', $class = null, $addSelect = false, $addMultiple = false, $guestReservableOnly = true) {
        global $CFG, $DB;
        $buildingWhere = '';
        for ($i = 0; $i < count($buildingId); $i++) {
            $buildingWhere .= '({buildings_building}.id = ' . $buildingId[$i] . ') OR ';
        }
        $buildingWhere = rtrim($buildingWhere, ' OR ');

        $guestReservableWhere = ' AND';
        if ($guestReservableOnly) {
            $guestReservableWhere = ' {buildings_room}.guestreservable = 1 AND ';
        }

        $roomsSQL = ' Select '
                . '   {buildings_room}.id, '
                . '   {buildings_building}.shortname, '
                . '   {buildings_room}.roomnumber, '
                . '   {buildings_room}.name, '
                . '   {buildings_room}.guestreservable, '
                . '   {buildings_room_types}.name As roomtypename '
                . ' From '
                . '   {buildings_room} Inner Join '
                . '   {buildings_floor} '
                . '     On {buildings_room}.floorid = {buildings_floor}.id Inner Join '
                . '   {buildings_building} '
                . '     On {buildings_floor}.buildingid = {buildings_building}.id Inner Join '
                . '   {buildings_room_types} '
                . '     On {buildings_room}.roomtypeid = {buildings_room_types}.id '
                . ' Where '
                . $guestReservableWhere . $buildingWhere
                . ' ORDER BY shortname, roomnumber';

        $rooms = $DB->get_records_sql($roomsSQL);

        $results = array();
        foreach ($rooms as $r) {
            $results[$r->id] = $r->shortname . ' ' . $r->roomnumber . ' (' . $r->name . ' ' . $r->roomtypename . ')';
        }

        $multipleArray = '';
        if ($addMultiple) {
            $multiple = 'multiple="multiple"';
            $multipleArray = '[]';
        }

        asort($results, SORT_STRING);
        $html = '<select id="' . $divId . '" name="' . $divId . $multipleArray . '" class="buildingid js-example-responsive ' . $class . '" ' . $multiple . ' style="width: 100%">' . "\n";
        if ($addSelect) {
            $html .= '<option value="">' . get_string('select', 'local_buildings') . '</option>';
        }
        foreach ($results AS $key => $value) {
            $html .= '<option value="' . $key . '">' . $value . '</option>';
        }
        $html .= '</select>';

        return $html;
    }

    /**
     * Returns string HTML select box with all buildings for a campus 
     * @param int $campusId
     * @param string $divId
     * @param string $class
     * @return string $html
     */
    public static function printFloorsSelectBox($buildingId, $divId = 'floorid', $class = null) {
        $FLOORS = new \local_buildings\Floors($buildingId);

        $results = array();
        foreach ($FLOORS->getFloors() as $floor) {
            $results[$floor['id']] = $floor['number'] . ': ' . $floor['name'];
        }
        asort($results, SORT_NUMERIC);

        $html = '<select id="' . $divId . '" name="' . $divId . '" class="floorid js-example-responsive ' . $class . '" style="width: 100%">' . "\n";

        foreach ($results AS $key => $value) {
            $html .= '<option value="' . $key . '">' . $value . '</option>';
        }
        $html .= '</select>';

        return $html;
    }

    /**
     * returns string HTML of a Bootstrap 3 modal
     * @param string $modalId the div tag id 
     * @param string $modalTitle
     * @param string $modalBody
     * @param string $modalCloseButtonText
     * @param array $modalButtons
     * @param bool $modalClass
     * @return string
     */
    public static function printBootstrapDialog($modalId, $modalTitle, $modalBody, $modalCloseButtonText = '', $modalButtons, $modalClass = '') {

        $html = '<div class="modal fade" id="' . $modalId . '" role="dialog" data-backdrop="false">' . "\n";
        $html .= '  <div class="modal-dialog ' . $modalClass . '" role="document">' . "\n";
        $html .= '    <div class="modal-content">' . "\n";
        $html .= '      <div class="modal-header">' . "\n";
        $html .= '        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . "\n";
        $html .= '        <h4 class="modal-title">' . $modalTitle . '</h4>' . "\n";
        $html .= '      </div>' . "\n";
        $html .= '      <div class="modal-body">' . "\n";
        $html .= '        ' . $modalBody . "\n";
        $html .= '      </div>' . "\n";
        $html .= '      <div class="modal-footer">' . "\n";
        if (!empty($modalCloseButtonText)) {
            $html .= '		<button type="button" class="btn btn-default" data-dismiss="modal">' . $modalCloseButtonText . '</button>' . "\n";
        }
        foreach ($modalButtons as $key => $value) {
            $html .= $value . "\n";
        }
        $html .= '      </div>' . "\n";
        $html .= '    </div>' . "\n";
        $html .= '  </div>' . "\n";
        $html .= '</div>' . "\n";

        return $html;
    }

}
