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

class Tz_guestbookViewGuestbook extends JViewLegacy
{
    protected $form;

    function display($tpl = null)
    {
        JHtml::_('behavior.framework');
        $state = $this->get('State')->get('params');
        $titl = $state->get('title');
        $showcapcha = $state->get('showcaptchat');
        $name = $state->get('name');
        $date = $state->get('date');
        $this->form = $this->get('Form');
        $nnt_width = $state->get('nnt_coludwidt');
        $configajx = $state->get('congiajax');
        $fweb = $state->get('website');
        $tz_status = $state->get('shownow');
        $count_name = $state->get('texename');
        $count_email = $state->get('texemail');
        $count_website = $state->get('texwebsite');
        $count_title = $state->get('textitle');
        $count_commnet = $state->get('textcomment');
        $time_notice = $state->get('timethongbao');
        $gust_arrangements = $state->get('sapxeplubut');
        $this->assign('params',$state);
        $this->assign('arrganerme_gustbook', $gust_arrangements);
        $this->assign('time_notice', $time_notice);
        $this->assign('count_name', $count_name);
        $this->assign('count_email', $count_email);
        $this->assign('count_web', $count_website);
        $this->assign('count_tit', $count_title);
        $this->assign('count_comm', $count_commnet);
        $this->assign('hstatus', $tz_status);
        $this->assign('fweb', $fweb);
        $this->assign('capchat', $showcapcha);
        $this->assign('conajx', $configajx);
        $this->assign('nnt_width', $nnt_width);
        $this->assign('dat', $date);
        $this->assign('nam', $name);
        $this->assign('tit', $titl);
        $this->assign('category',$state->get('showCate'));
        $this->assign('display', $this->get('List'));
        $this->assign('auth', $this->get('Author2'));
        $this->assign('pagination', $this->get('Pagination'));
        $this->assign('listcate', $this->get('Category'));
        $this->assign('catid',JRequest::getVar('id'));
        parent::display($tpl);
    }
}

?>