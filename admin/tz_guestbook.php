<?php
/*------------------------------------------------------------------------

# TZ Guestbook Extension

# ------------------------------------------------------------------------

# author    TuNguyenTemPlaza

# copyright Copyright (C) 2012 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/
defined('_JEXEC') or die;
$doc = JFactory::getDocument();
//Add Script to the header
if (!version_compare(JVERSION, '3.0', 'ge')) {
    $doc->addScript(JURI::base() . 'components/com_tz_guestbook/jui/js/jquery.min.js');
    $doc->addScript(JURI::base() . 'components/com_tz_guestbook/jui/js/jquery-noconflict.js');
    $doc->addScript(JURI::base() . 'components/com_tz_guestbook/jui/js/bootstrap.min.js');
    $doc->addScript(JURI::base() . 'components/com_tz_guestbook/jui/js/chosen.jquery.min.js');
}

$doc->addCustomTag('<script src="'.JURI::base() . 'components/com_tz_guestbook/jui/js/jquery.ui.core.min.js'.'" type="text/javascript"></script>');
$doc->addCustomTag('<script src="'.JURI::base() . 'components/com_tz_guestbook/jui/js/jquery.ui.sortable.min.js'.'" type="text/javascript"></script>');
$doc->addCustomTag('<script src="'.JURI::base() . 'components/com_tz_guestbook/jui/js/sortablelist.js'.'" type="text/javascript"></script>');
$doc->addCustomTag('<script src="'.JURI::base() . 'components/com_tz_guestbook/js/template.js'.'" type="text/javascript"></script>');
$doc->addStyleSheet(JURI::base() . 'components/com_tz_guestbook/jui/css/chosen.css');
$doc->addCustomTag('<link href="' . JURI::base() . 'components/com_tz_guestbook/css/template.css' .
    '" rel="stylesheet" type="text/css"/>');

if (!JFactory::getUser()->authorise('core.manage', 'com_content')) {
    return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

include_once dirname(__FILE__) . '/libraries/core/defines.php';
include_once dirname(__FILE__) . '/libraries/core/tzguestbook.php';


$controller = JControllerLegacy::getInstance('TZ_Guestbook');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();



?>