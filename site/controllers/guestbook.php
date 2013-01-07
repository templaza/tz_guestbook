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
    class  Tz_guestbookControllerGuestbook extends JControllerAdmin{
        function  display(){

            $doc = &JFactory::getDocument();
                        $type = $doc->getType();
                        $view= &$this -> getView('guestbook',$type);
                        $model=&$this->getModel('guestbook');

                        $view-> setModel($model,true);
            $task = JRequest::getVar('task');

            if($task=='add'){
                $ennr = $model->getCaptcha();

                if($ennr ==1){

                        echo $model -> ajax();
                        die();
                }else if($ennr ==0){
                    echo 1;
                        die();
                } else if($ennr ==2){
                    echo $model -> ajax();
                    die();
                }

            }else if ($task=='add.ajax'){
                echo $model->loadajax();
                 die();
            }else{
                $view->setLayout('default');
            }

//            switch($task){
//
//                case'add':
//                echo $model -> ajax();
//                die();
//                    break;
//                case'add.ajax':
//                 echo $model->loadajax();
//                 die();
//                    break;
//                default:
//                    $view->setLayout('default');
//                    break;
//            }


                 $view->display();

        }
    }
?>