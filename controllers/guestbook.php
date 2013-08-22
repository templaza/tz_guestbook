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

    class Tz_guestbookControllerGuestbook extends JControllerAdmin {

            function display($cachable=false,$urlparams=array()){
                $doc    = JFactory::getDocument();
                // If the joomla's version is more than or equal to 3.0
                if(!COM_TZ_GUESTBOOK_JVERSION_COMPARE){
                    JHtml::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_tz_guestbook/libraries/cms/html');
                    tzguestbookimport('cms/html/sidebar');

                    //Add Script to the header
                    $doc -> addScript(COM_TZ_GUESTBOOK_ADMIN_HOST_PATH.'/jui/js/jquery.min.js');
                    $doc -> addScript(COM_TZ_GUESTBOOK_ADMIN_HOST_PATH.'/jui/js/jquery-noconflict.js');
                    $doc -> addScript(COM_TZ_GUESTBOOK_ADMIN_HOST_PATH.'/jui/js/bootstrap.min.js');
                    $doc -> addScript(COM_TZ_GUESTBOOK_ADMIN_HOST_PATH.'/jui/js/chosen.jquery.min.js');
                    $doc -> addScript(COM_TZ_GUESTBOOK_ADMIN_HOST_PATH.'/jui/js/jquery.ui.core.min.js');
                    $doc -> addScript(COM_TZ_GUESTBOOK_ADMIN_HOST_PATH.'/jui/js/jquery.ui.sortable.min.js');
                    $doc -> addScript(COM_TZ_GUESTBOOK_ADMIN_HOST_PATH.'/jui/js/sortablelist.js');
                    $doc -> addScript(COM_TZ_GUESTBOOK_ADMIN_HOST_PATH.'/js/template.js');

                    $doc -> addStyleSheet(COM_TZ_GUESTBOOK_ADMIN_HOST_PATH.'/jui/css/chosen.css');
                    $doc -> addCustomTag('<link href="'.COM_TZ_GUESTBOOK_ADMIN_HOST_PATH.'/css/template.css'.
                        '" rel="stylesheet" type="text/css"/>');
                }

                $task   = JRequest::getVar('task');
                $type   = $doc->getType();
                $view   = $this -> getView('guestbook',$type);
                $model  = $this->getModel('guestbook');
                $view   -> setModel($model,true);
                switch($task){
                    case'tz.edit':
                    case'g.edit':
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