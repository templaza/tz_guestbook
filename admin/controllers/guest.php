<?php
/*------------------------------------------------------------------------

# TZ Guestbook Extension

# ------------------------------------------------------------------------

# author    TuanNATemPlaza

# copyright Copyright (C) 2012 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

defined('_JEXEC') or die;
jimport('joomla.application.component.controllerform');


class Tz_guestbookControllerGuest extends JControllerForm
{
    function display($cachable = false, $urlparams = array())
    {
        $doc = JFactory::getDocument();
        $task = JRequest::getVar('task');
        $type = $doc->getType();
        $view = $this->getView('guestbook', $type);
        $model = $this->getModel('guestbook');
        $view->setModel($model, true);

        switch ($task) {
            case'unpublish':

                $model->unpulich();
                break;
            case'publish':

                $model->publish();
                break;
            default:
                $view->setLayout('default');
                break;
        }
        $view->display();
    }

    public function batch($model = null)
    {
        $model = $this->getModel('Guest', '', array());
        // Preset the redirect
        $this->setRedirect(JRoute::_('index.php?option=com_tz_guestbook&view=guestbook' . $this->getRedirectToListAppend(), false));
        return parent::batch($model);
    }

}