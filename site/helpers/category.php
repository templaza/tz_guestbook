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
//jimport('joomla.application.categories');
//require_once(JPATH_COMPONENT . '/libra/categories.php');
require_once(JPATH_SITE . '/components/com_tz_guestbook/libra/categories.php');
class Tz_guestbookCategories extends Categories
{
    public function __construct($options = array())
    {
        $options['table'] = '#__comment';
        $options['extension'] = 'com_tz_guestbook';
        parent::__construct($options);
    }
}