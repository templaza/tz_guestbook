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

jimport('joomla.application.component.view');

class TZ_guestbookViewCategories extends JViewLegacy
{
    protected $state = null;
    protected $item = null;
    protected $items = null;


    function display($tpl = null)
    {

        // Initialise variables
        $state = $this->get('State');
        $items = $this->get('Items');
        if (count($errors = $this->get('Errors'))) {
            JError::raiseWarning(500, implode("\n", $errors));
            return false;
        }
        if ($items === false) {
            JError::raiseError(404, JText::_('COM_CONTENT_ERROR_CATEGORY_NOT_FOUND'));
            return false;
        }
        $params = $state->get('params');
        $this->assign('params', $params);
        $this->assign('items', $items);
        parent::display($tpl);

    }


}
