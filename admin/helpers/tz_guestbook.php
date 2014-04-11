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

class Tz_guestbookHelper
{
    public static function addSubmenu($vName)
    {
        $class = 'JHtmlSidebar';
        if (!version_compare(JVERSION, '3.0', 'ge')) {
            $class = 'JSubMenuHelper';
        }
        call_user_func_array($class . '::addEntry', array(JText::_('COM_TZ_GUESTBOOK_SUBMENU_CATEGORIES'),
                'index.php?option=com_categories&extension=com_tz_guestbook',
                $vName == 'categories'));
        call_user_func_array($class . '::addEntry', array(JText::_('COM_TZ_GUESTBOOK_SUBMENU_GUEST_BOOK'),
                'index.php?option=com_tz_guestbook&view=guestbook',
                $vName == 'guestbook'));

    }
}

?>