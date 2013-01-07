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
        $view =JRequest::getCmd('view','guestbook');
        $controllerName = $view;
        $task  = JRequest::getVar('task');



        $controlletPath=JPATH_COMPONENT.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$controllerName.'.php';

        if(file_exists($controlletPath)){
            require_once($controlletPath);

        }
        else{
            echo"khong ton tia duong dan";
        }

        $controllerClass='Tz_guestbookController'.ucfirst($controllerName); // Ucfirst la ham doi ky tu dau tien thanh chu hoa
        if(class_exists($controllerClass))
                $controller=new $controllerClass;
            else
                echo "khong ton tai class";

        $controller->execute(JRequest::getVar('task')); // chay task
        $controller->redirect(); // chen file controler vao
?>