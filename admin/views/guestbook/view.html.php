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
require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'tz_guestbook.php');
if(!COM_TZ_GUESTBOOK_JVERSION_COMPARE){
    require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'libraries/cms/html' . DIRECTORY_SEPARATOR . 'sidebar.php');
    JHtml::addIncludePath(JPATH_COMPONENT . '/libraries/cms/html');    
}

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');

class Tz_guestbookViewGuestbook extends JViewLegacy
{
    protected $pagination   = null;
    protected $sidebar = null;
    protected $hienthi = null;
    protected $detail = null;
    public function display($tpl = null)
    {
        $this->pagination = $this->get('Pagination');
        $this->hienthi = $this->get('List');
        $this->detail = $this->get('Detail');
        $state = $this->get('State');
        $status = $state->get('sata');
        $aut = $state->get('autho');
        $listOrder = $state->get('lab1');
        $listDirn = $state->get('lab2');
        $search = $state->get('search');
        $category = $state->get('cate');
        $author = $this->get('Author');
        $guest = new stdClass();
        $guest->value = 0;
        $guest->text = JText::_('COM_TZ_GUESTBOOK_GUEST');

        array_push($author, $guest);
        $this->assign('tz_search', $search);
//        $this->assign('detail', $this->get('Detail'));
        $this->assign('state1', $listOrder);
        $this->assign('state2', $listDirn);
        $this->assign('author', $aut);
        $this->assign('star', $status);
        $this->assign('authors', $author);
        $this->assign('category', $category);
        $this->assign('state', $state);
        $task = JRequest::getVar('task');
        Tz_guestbookHelper::addSubmenu('guestbook');

		if ($task == 'edit') {
            $this->adde();
        } else {
            $this->addTookBar();
            $this->sidebar = JHtmlSidebar::render();
        }
        parent::display($tpl);
    }

    function addTookBar()
    {
        $user = JFactory::getUser();

        // Get the toolbar object instance
        $bar = JToolBar::getInstance('toolbar');
        JToolbarHelper::title(JText::_('COM_TZ_GUESTBOOK_2'), 'article.png');
        JToolbarHelper::editList("guestbook.edit", JText::_('COM_TZ_GUESTBOOK_VIEW'));
        JToolbarHelper::publishList("guestbook.publish");
        JToolbarHelper::unpublishList("guestbook.unpublish");
        JToolBarHelper::preferences('com_tz_guestbook');
        JToolbarHelper::deleteList("COM_TZ_GUESTBOOK_DELETE_GUESTBOOK", 'guestbook.delete');

        if ($user->authorise('core.edit')) {
            JHtml::_('bootstrap.modal', 'collapseModal');

            $title = JText::_('COM_TZ_GUSETBOOK_BATCH');
			if(!COM_TZ_GUESTBOOK_JVERSION_COMPARE){
			$batchIcon = '<span class="tz-checkbox-partial" title="' . $title . '"></span>';
			$batchClass = ' class="tz-batch"';
			}else{
			$batchIcon = '<i class="icon-checkbox-partial" title="' . $title . '"></i>';
			$batchClass = ' class="btn btn-small"';
			}
            $dhtml = '<a' . $batchClass . ' href="#" data-toggle="modal" data-target="#collapseModal">';
            $dhtml .= $batchIcon . $title . '</a>';

            $bar->appendButton('Custom', $dhtml, 'batch');
        }
        JHtmlSidebar::addFilter(
            JText::_('JOPTION_SELECT_PUBLISHED'),
            'filter_published',
            JHtml::_('select.options', $this->publicc(), 'value', 'text', $this->get('State')->get('sata'))
        );

        JHtmlSidebar::addFilter(
            JText::_('JOPTION_SELECT_AUTHOR'),
            'filter_author_id',
            JHtml::_('select.options', $this->authors, 'value', 'text', $this->get('State')->get('autho'), true)
        );

        JHtmlSidebar::addFilter(
            JText::_('JOPTION_SELECT_CATEGORY'),
            'filter_category_id',
            JHtml::_('select.options', JHtml::_('category.options', 'com_tz_guestbook'), 'value', 'text', $this->get('State')->get('cate'), true)
        );
    }

    function adde()
    {
        JToolbarHelper::title(JText::_('COM_TZ_GUESTBOOK_CONTENT_GUESTBOOK'), 'article-add.png');
        JToolbarHelper::preferences('com_tz_guestbook');
        JToolbarHelper::cancel("guestbook.cancel");
        JToolbarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER_EDIT');
        $input = JFactory::getApplication()->input;
        $input->set('hidemainmenu', true);
    }

    protected function getSortFields()
    {
        return array(
            'tz.state' => JText::_('JSTATUS'),
            'tz.title' => JText::_('JGLOBAL_TITLE'),
            'tz.category' => JText::_('Category'),
            'tz.author' => JText::_('JDATE'),
            'tz.public' => JText::_("Public"),
            'tz.email' => JText::_("Email"),
            'tz.id' => JText::_('JGRID_HEADING_ID')
        );
    }

    function publicc()
    {
        return array(
            '1' => JText::_('JPUBLISHED'),
            '0' => JText::_('JUNPUBLISHED'),
        );
    }
}

?>