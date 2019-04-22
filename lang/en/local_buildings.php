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
$string["abbreviation"] = "Abbreviation";
$string["actions"] = "Actions";
$string["adding"] = "Adding new";
$string["add_building"] = "Add building";
$string["add_campus"] = "Add campus";
$string["add_floor"] = "Add floor";
$string["add_room"] = "Add room";
$string["address"] = "Address";
$string["address2"] = "Address 2";
$string["all_guests"] = "All guests";
$string["approvers_only"] = "Approvers only";
$string["asset_header"] = "Assets";
$string["asset_type"] = "Asset type";
$string["associated_faculty"] = "Associated faculty/unit";
$string["back"] = "Back";
$string["building"] = "Building";
$string["buildings"] = "Buildings";
$string["buildings_settings"] = "Buildings settings";
$string["campus"] = "Campus";
$string["campuses"] = "Campuses";
$string["cancel"] = "Cancel";
$string["city"] = "City";
$string["close"] = "Close";
$string["color"] = "Color";
$string["country"] = "Country";
$string["create"] = "Create";
$string["create_faculty"] = "Create faculty/unit";
$string["create_room"] = "Create room";
$string["dashboard"] = "Dashboard";
$string["delete"] = "Delete";
$string["delete_building"] = "Are you sure you want to delete this building? "
        . "This will delete all floors and room associated to this building."
        . "This cannot be reversed.";
$string["delete_floor"] = "Are you sure you want to delete this floor? "
        . "This will delete all roomsassociated to this floor."
        . "This cannot be reversed.";
$string["delete_room"] = "Are you sure you want to delete this room? This cannot be undone";
$string["demographics"] = "Demographics";
$string["description"] = "Description";
$string["edit"] = "Edit";
$string["editing"] = "Editing";
$string["edit_rooms"] = "Edit rooms";
$string["extra"] = "Other options";
$string["faculties"] = "Faculties/Units";
$string["faculty"] = "Faculty?Unit";
$string["floor"] = "Floor";
$string["floors"] = "Floors";
$string["general"] = "General";
$string["has_windows"] = "Has windows";
$string["home"] = "Home";
$string["idnumber"] = "ID Number";
$string["is_classroom"] = "Used as a classroom";
$string["is_classroom_help"] = "Select yes if this room is also used as a classroom. Example, an auditorium can also be used a classroom,"
        . "although, the room type is Auditorium.";
$string["latitude"] = "Latitude";
$string["longitude"] = "Longitude";
$string["name"] = "Name";
$string["no"] = "No";
$string["no_permission"] = "You do not have permission to view this page. Please contact your system administrator.";
$string["number"] = "Number";
$string["number_of_rooms_per_floor"] = "Number of rooms per floor";
$string["number_of_seats"] = "Number of seats";
$string["parentroom"] = "Parent room";
$string["parentroom_help"] = "If this new room is inside another room, select the room it is in. For example a multi-office room may have ROOM-100A, 100B and 100C. The actual Parent room would be 100";
$string["pictures"] = "Pictures";
$string["pluginname"] = "Buildings";
$string["province"] = "Province";
$string["read_only"] = "Read only";
$string["required_rule"] = "This field is required";
$string["reservable_by_guests"] = "Reservable by quests";
$string["reservable_by_guests_help"] = "Select yes (default) if you want to make this room available for booking by non-reservation administrators. "
        . "Note that the reservation will still require approval by a reservation administrator";
$string["room"] = "Room";
$string["roomnumber"] = "Room number";
$string["roomnumber_help"] = "Enter the room number. DO NOT enter the Floor number. That will be added automically";
$string["rooms"] = "Rooms";
$string["room_type"] = "Room type";
$string["room_types"] = "Room types";
$string["room_types_desc"] = "Enter a unique number and name seperated by a pipe for each room type. Enter each room type on a sperate line.";
$string["savecontinue"] = "Save and continue";
$string["schedule"] = "Schedule";
$string["select"] = "Select";
$string["shortname"] = "Short name";
$string["timemodified"] = "Time modified";
$string["too_many_floors"] = "Too many floors to display";
$string["unavailable"] = "Unavailable";
$string["view"] = "View";
$string["view_floors"] = "View floors";
$string["view_rooms"] = "View rooms";
$string["viewing"] = "Viewing";
$string["windows"] = "Windows";
$string["yes"] = "Yes";


//Capabilities
$string['buildings:addinstance'] = "Add instance";
$string['buildings:admin'] = "Administrator";
$string['buildings:editbuilding'] = "Building editor";
$string['buildings:editcampus'] = "Campus editor";
$string['buildings:editfloor'] = "Floor editor";
$string['buildings:editroom'] = "Room editor";
$string['buildings:readonly'] = "Read only";
$string['buildings:readonly'] = "Read only";

//Settings
$string["asset_host"] = "Host";
$string["asset_host_desc"] = "Enter the IP or domain of the host server. Only works with MySQL type servers";
$string["asset_dbname"] = "Database name";
$string["asset_dbname_desc"] = "Enter the database or schema being used";
$string["asset_dbtable"] = "Asset table";
$string["asset_dbtable_desc"] = "Enter the table that is storing the assets";
$string["asset_id"] = "Asset Table unique identifier field";
$string["asset_id_desc"] = "Enter the unique identifier for the asset table (ex. id)";
$string["asset_name"] = "Asset name filed";
$string["asset_name_desc"] = "Enter the field name containing the asset name in the table (ex. name)";
$string["asset_name"] = "Asset name field";
$string["asset_name_desc"] = "Enter the field name containing the asset name in the table (ex. name)";
$string["asset_other_field"] = "Other fields";
$string["asset_other_field_desc"] = "Enter any other fields (columns) from the asset table that you would like used in the asset description menu. Seperate each column name with a comma";
$string["asset_password"] = "Password";
$string["asset_password_desc"] = "Password for the database user";
$string["asset_user"] = "Database user";
$string["asset_user_desc"] = "Database user name";
$string["number_of_buildings"] = "Number of buildings";
$string["number_of_buildings_desc"] = "Default number of buildings to display in campus table";
$string["number_of_floors"] = "Number of floors";
$string["number_of_floors_desc"] = "Default number of floors to display in buildings table";
$string["number_of_rooms"] = "Number of rooms";
$string["number_of_rooms_desc"] = "Default number of rooms to display in floors table";
$string['settings_assests_header'] = 'Assests databse connection settings';
$string['settings_assests_header'] = 'Assests databse connection settings';
$string['use_external_assets'] = 'Use external assets database';
$string['use_external_assets_desc'] = 'Check this option if you have an external assets management system you would liek to connect to.';

//Snipe-IT
$string['assigned_assets'] = "Physical equipement";
$string['dbname'] = "Schema name";
$string['host'] = "Host";
$string['image'] = "Image";
$string['manufacturer'] = "Manufacturer";
$string['model'] = "Model";
$string['model_number'] = "Model number";
$string['username'] = "User name";
$string['password'] = "Password";
$string['purchase_date'] = "Purchase date";
$string['snipeit'] = "Snipe-IT MySQL Connection";
$string['snipeit_url'] = "Snipe-IT URL";
$string['snipeit_url_image'] = "Snipe-IT image URL";
$string['snipeit_url_image_help'] = "Add the full path to asset images, include the trailing slash. ex. www.yourdomain.com/uploads/assets/";
$string['user_internal_assets'] = "Use internal assets system?";
$string['user_internal_assets_help'] = "Set this to yes if you prefer using the internal asset manager. Selecting no will force the use of Snipe-It. "
        . "Make sure you enter the Snipe-IT fields below.";
