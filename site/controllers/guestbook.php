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

class  Tz_guestbookControllerGuestbook extends JControllerAdmin
{

    function  display($cachable = false, $urlparams = array())
    {
        $doc = JFactory::getDocument();
        $type = $doc->getType();
        $view = $this->getView('guestbook', $type);
        $model = $this->getModel('guestbook');
        $view->setModel($model, true);
        $task = JRequest::getVar('task');

        if ($task == 'add') { // task = add
            $check = $model->getCaptcha(); // call getCaptcha
            if ($check == 1) {
                echo $model->ajax();
                $model->TzSendEmail();
                die();
            } else if ($check == 0) {
                echo 1;
                die();
            } else if ($check == 2) {
                echo $model->ajax();
                $model->TzSendEmail();
                die();
            }
        } else if ($task == 'add.ajax') {
            echo $model->loadajax();
            die();
        } else {
            $view->setLayout('default');
        }
        $view->display();
    }
}

?>