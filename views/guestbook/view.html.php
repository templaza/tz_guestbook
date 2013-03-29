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
require_once(JPATH_COMPONENT. DIRECTORY_SEPARATOR.'helpers'. DIRECTORY_SEPARATOR.'tz_guestbook.php');

class Tz_guestbookViewGuestbook extends JViewLegacy{

    function display($tpl = null){
        $state      = $this -> get('State');
        $status     = $state->get('sata');
        $aut        = $state->get('autho');
        $listOrder  = $state->get('lab1');
        $listDirn   = $state->get('lab2');
        $search     = $state->get('search');
        $this ->assign('tz_search',$search);
        $this ->assign('detail',$this->get('Detail'));
        $this ->assign('state1',$listOrder);
        $this ->assign('state2',$listDirn);
        $this ->assign('author',$aut);
        $this ->assign('star',$status);
        $this ->assign('Hienthi',$this->get('List'));
        $this ->assign('authors',$this->get('Author'));
        $this -> assign('pagination',$this -> get('Pagination'));
        $task = JRequest::getVar('task');
        Tz_guestbookHelper::addSubmenu('guestbook');
        switch($task){
            case'tz.edit':
            case'g.edit':
            case'guestbook.edit':
                $this->adde();
                break;

            default:
                $this->addTookBar();
                $this->sidebar=JHtmlSidebar::render();
                break;
        }

        parent::display($tpl);
    }

    function addTookBar(){
        JToolbarHelper::title(JText::_('COM_TZ_GUESTBOOK_2'),'article.png');
        JToolbarHelper::editList("tz.edit");
        JToolbarHelper::publishList("tz.publish");
        JToolbarHelper::unpublishList("tz.unpublish");
        JToolBarHelper::preferences('com_tz_guestbook');
        JToolbarHelper::deleteList("COM_TZ_GUESTBOOK_DELETE_GUESTBOOK");
        JToolbarHelper::cancel("tz.cancel");
        JHtmlSidebar::addFilter(
            JText::_('JOPTION_SELECT_PUBLISHED'),
            'filter_published',
            JHtml::_('select.options', $this->publicc(), 'value', 'text',  $this -> get('State')->get('sata'), true)
        );

        JHtmlSidebar::addFilter(
            JText::_('JOPTION_SELECT_AUTHOR'),
            'filter_author_id',
            JHtml::_('select.options', $this->authors, 'value', 'text',$this -> get('State')->get('autho'),true)
        );
    }

    function adde(){
        JToolBarHelper::title(JText::_("COM_TZ_GUESTBOOK_CONTENT_GUESTBOOK"),'article-add.png');
        JToolBarHelper::preferences('com_tz_guestbook');
        JToolBarHelper::cancel();
        JToolBarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER_EDIT');
        $input = JFactory::getApplication()->input;
        $input->set('hidemainmenu', true);
    }

    protected function getSortFields()
    {
        return array(
        'tz.state' => JText::_('JSTATUS'),
        'tz.title' => JText::_('JGLOBAL_TITLE'),
        'tz.author' => JText::_('JDATE'),
        'tz.public' =>JText::_("Public"),
        'tz.email' =>JText::_("Email"),
        'tz.id' => JText::_('JGRID_HEADING_ID')
        );
    }

    function publicc(){
        return array(
        '1' => JText::_('Public'),
        '0' => JText::_('unpublish'),
        );
    }
}
?>