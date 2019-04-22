<?php

/**
 * ************************************************************************
 * *                         OOHOO - Panorama                            **
 * ************************************************************************
 * @package     local                                                    **
 * @subpackage  Panorama                                                 **
 * @name        Panorama                                                 **
 * @copyright   oohoo.biz                                                **
 * @link        http://oohoo.biz                                         **
 * @author      Nicolas Bretin                                           **
 * @license     Copyright                                                **
 * ************************************************************************
 * ********************************************************************** */
require_once(dirname(__FILE__) . '/../../config.php');

$lang_strings = new stdClass();
$lang_strings->sEmptyTable = local_panorama_get_string('datatable_sEmptyTable');
$lang_strings->sInfo = local_panorama_get_string('datatable_sInfo');
$lang_strings->sInfoEmpty = local_panorama_get_string('datatable_sInfoEmpty');
$lang_strings->sInfoFiltered = local_panorama_get_string('datatable_sInfoFiltered');
$lang_strings->sInfoPostFix = local_panorama_get_string('datatable_sInfoPostFix');
$lang_strings->sInfoThousands = local_panorama_get_string('datatable_sInfoThousands');
$lang_strings->sLengthMenu = local_panorama_get_string('datatable_sLengthMenu');
$lang_strings->sLoadingRecords = local_panorama_get_string('datatable_sLoadingRecords');
$lang_strings->sProcessing = local_panorama_get_string('datatable_sProcessing');
$lang_strings->sSearch = local_panorama_get_string('datatable_sSearch');
$lang_strings->sZeroRecords = local_panorama_get_string('datatable_sZeroRecords');
$lang_strings->oPaginate = new stdClass();
$lang_strings->oPaginate->sFirst = local_panorama_get_string('datatable_sFirst');
$lang_strings->oPaginate->sLast = local_panorama_get_string('datatable_sLast');
$lang_strings->oPaginate->sNext = local_panorama_get_string('datatable_sNext');
$lang_strings->oPaginate->sPrevious = local_panorama_get_string('datatable_sPrevious');
$lang_strings->oAria = new stdClass();
$lang_strings->oAria->sSortAscending = local_panorama_get_string('datatable_sSortAscending');
$lang_strings->oAria->sSortDescending = local_panorama_get_string('datatable_sSortDescending');


echo json_encode($lang_strings);