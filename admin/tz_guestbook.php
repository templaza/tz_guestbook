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
$option = JRequest::getCmd('option');
$view = JRequest::getCmd('view', 'guestbook');
$controllerName = $view;
$task = JRequest::getVar('task');
$controlletPath = JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $controllerName . '.php';

if (file_exists($controlletPath)) {
    require_once($controlletPath);

} else {
    echo "not exist path";
}

$controllerClass = 'Tz_guestbookController' . ucfirst($controllerName);
if (class_exists($controllerClass))
    $controller = new $controllerClass;
else
    echo "not exist class";
include_once dirname(__FILE__) . '/libraries/core/defines.php';
include_once dirname(__FILE__) . '/libraries/core/tzguestbook.php';

$controller->execute(JRequest::getVar('task'));
$controller->redirect();
?>