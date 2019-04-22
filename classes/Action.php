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

class Action {

    private $url = "";
    private $key = "";

    function __construct(Action $class = null, $url = "", $key = "") {
        $this->url = $url;
        $this->key = $key;
    }

    /**
     * 
     * @param string $action (optional) will be used as element id
     * @param string $url URL of action to be performed. If adding query string elements (?id=), remember to add the = sign
     * @param string $classes (optional) CSS classes for the <a> tag. Example btn btn-success
     * @param string $key (optional) Name of key to be used in query string
     * @param string $keyValue (optional) Value of key to be sent
     * @param string $title (required) Text explaining link AODA compliancy
     * @param string $iClasses (optional) Font class for <i> tag. Example: fa fa-pencil
     * @param string $text (optional) Link text
     * @param string $imageSrc (optional) image source URL
     * @param string $imageText (optional) image alt text
     */
    public static function getLink($action = "", $url = "", $classes = "", $key = "", $keyValue= "",
                                $title, $iClasses = "", $text = "", $imageSrc = "", $imageText = "" ) {
        $class = "";
        $data = "";
        $iClass = "";
        $img = "";
        
        if (strstr($url, '?')) {
            $url = $url . $keyValue;
        }
        
        if (!empty($classes)) {
            $class = 'class="' . $classes . '"';
        }
        
        if (!empty($key) && !empty($keyValue)) {
            $data = 'data-' . $key . '="' . $keyValue . '"';
        }
        
        if (!empty($iClasses)) {
            $iClass = '<i class="' . $iClasses . '"></i> ';
        }
        
        if (!empty($image)) {
            $img = '<img src="' . $image . '" alt="' . $imageText . '" border="0" class="img-responsive"/>';
        }
        
        $link = '<a href="' . $url . '" id="' . $action . '" ' . $class . ' ' . $data .  ' title="' . $title . '">' . $iClass . $img . $text . '</a>' . "\n";
//       print_object($this->url);
        return $link;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

}
