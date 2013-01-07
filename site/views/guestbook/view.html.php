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
    defined("_JEXEC") or die;
    jimport('joomla.application.component.view');
    class Tz_guestbookViewGuestbook extends JViewLegacy{
        protected $form;
        function display($tpl=null){
            $state  = $this -> get('State') -> get('params'); // buoc 1 khai bao 1 ham Sate buoc 2 lay ra thuoc tinh params trong ham

            $titl = $state->get('title'); // lay ra gia tri title
            $showcapcha = $state->get('showcaptchat');
            $name = $state->get('name');
            $date = $state->get('date');
            $this->form		= $this->get('Form');
            $nnt_width = $state->get('nnt_coludwidt');

            $configajx = $state->get('congiajax');
            $fweb = $state->get('website');
            $hienthistatus = $state->get('shownow');
            $count_name = $state->get('texename');
            $count_email = $state->get('texemail');
            $count_website = $state->get('texwebsite');
            $count_title = $state->get('textitle');
            $count_commnet=$state->get('textcomment');
            $time_thongbao=$state->get('timethongbao');
            $gust_arrangements = $state->get('sapxeplubut');

            $this->assign('arrganerme_gustbook',$gust_arrangements);
            $this->assign('tim_thongbao',$time_thongbao);
            $this->assign('count_name',$count_name);
            $this->assign('count_email',$count_email);
            $this->assign('count_web',$count_website);
            $this->assign('count_tit',$count_title);
            $this->assign('count_comm',$count_commnet);
            $this->assign('hienthistatus',$hienthistatus);
            $this->assign('fweb',$fweb);
            $this->assign('capchat',$showcapcha);
            $this->assign('conajx',$configajx);
            $this->assign('nnt_width',$nnt_width);
            $this->assign('dat',$date);
            $this->assign('nam',$name);
            $this->assign('tit',$titl);
            $this->assign('hienthi',$this->get('List'));
            $this->assign('auth',$this->get('Author2'));
            $this -> assignRef('pagination',$this -> get('Pagination'));
            parent::display($tpl);
        }
    }
?>