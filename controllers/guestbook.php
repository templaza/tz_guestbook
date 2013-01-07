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
    jimport('joomla.application.component.controller');

    class Tz_guestbookControllerGuestbook extends JControllerAdmin {
        function display(){
            $task = JRequest::getVar('task');
            $doc = &JFactory::getDocument();
            $type = $doc->getType();

            $view= &$this -> getView('guestbook',$type);

            $model=&$this->getModel('guestbook');
            $view-> setModel($model,true);

            switch($task){
                case'tz.edit':
                case'chitiet':
                case'guestbook.edit':
                    $view->setLayout('edit');
                      break;
                case'tz.unpublish':
                case'guestbook.unpublish':

                    $model-> unpulich();
                    break;

                case'tz.publish':
                case'guestbook.publish':
                     $model-> publish();
                      break;
                case'remove':
                    $model->delete();
                    break;
                default:
                    $view->setLayout('default');
                    break;
            }

            $view->display();
        }
    }
?>