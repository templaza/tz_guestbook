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
$task = JRequest::getVar('send');
$controlletPath = JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $controllerName . '.php';
$doc = JFactory::getDocument();
$doc->addStyleSheet(JUri::root().'components/com_tz_guestbook/css/baiviet2.css');
if (file_exists($controlletPath)) {
    require_once($controlletPath);
} else {
    echo JError::raiseError(500, 'Invailid controller');;
}
$controllerClass = 'Tz_guestbookController' . ucfirst($controllerName);
if (class_exists($controllerClass))
    $controller = new $controllerClass;
else
    echo JError::raiseError(500, 'Invailid Class controller!');
$controller->execute(JRequest::getCmd('send'));
$controller->redirect();
?>