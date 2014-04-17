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
jimport('joomla.application.component.controlleradmin');

class  Tz_guestbookControllerCategories extends JControllerAdmin
{

    function  display($cachable = false, $urlparams = array())
    {
        $doc = JFactory::getDocument();
        $type = $doc->getType();
        $view = $this->getView('categories', $type);
        $model = $this->getModel('categories');
        $view->setModel($model, true);
        $view->setLayout('default');
        $view->display();
    }
}

?>