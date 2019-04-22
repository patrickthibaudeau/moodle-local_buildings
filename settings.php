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

defined('MOODLE_INTERNAL') || die;
if ($hassiteconfig) {
    $settings = new admin_settingpage('local_buildings', get_string('pluginname', 'local_buildings'));
    $ADMIN->add('localplugins', $settings);
    $settings->add(new admin_setting_heading('buildings_heading', get_string('pluginname', 'local_buildings'), ''));
    $settings->add(new admin_setting_configtext('buildings_number_of_buildings', get_string('number_of_buildings', 'local_buildings'), get_string('number_of_buildings_desc', 'local_buildings'), 3, PARAM_INT));
    $settings->add(new admin_setting_configtext('buildings_number_of_floors', get_string('number_of_floors', 'local_buildings'), get_string('number_of_floors_desc', 'local_buildings'), 3, PARAM_INT));
    $settings->add(new admin_setting_configtext('buildings_number_of_rooms', get_string('number_of_rooms', 'local_buildings'), get_string('number_of_rooms_desc', 'local_buildings'), 3, PARAM_INT));
    $settings->add(new admin_setting_heading('buildings_snipeit', get_string('snipeit', 'local_buildings'), ''));
    $settings->add(new admin_setting_configtext('buildings_snipeit_host', get_string('host', 'local_buildings'), '', '', PARAM_TEXT));
    $settings->add(new admin_setting_configtext('buildings_snipeit_dbname', get_string('dbname', 'local_buildings'), '', '', PARAM_TEXT));
    $settings->add(new admin_setting_configtext('buildings_snipeit_username', get_string('username', 'local_buildings'), '', '', PARAM_TEXT));
    $settings->add(new admin_setting_configpasswordunmask('buildings_snipeit_password', get_string('password', 'local_buildings'), '', '', PARAM_TEXT));
    $settings->add(new admin_setting_heading('buildings_snipeit_urls', get_string('snipeit_url', 'local_buildings'), ''));
    $settings->add(new admin_setting_configtext('buildings_snipeit_url', get_string('snipeit_url_image', 'local_buildings'), get_string('snipeit_url_image_help', 'local_buildings'), '', PARAM_TEXT));
}