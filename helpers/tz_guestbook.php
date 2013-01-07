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
    		JHtmlSidebar::addEntry(
    			JText::_('guestbook'),
    			'index.php?option=com_tz_guestbook&view=guestbook',
    			$vName == 'guestbook'
    		);

    	}
    }
?>