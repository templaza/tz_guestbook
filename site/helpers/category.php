<?php
/*------------------------------------------------------------------------

# TZ Guestbook Extension

# ------------------------------------------------------------------------

# author    TuanNguyenTemPlaza

# copyright Copyright (C) 2012 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

defined('_JEXEC') or die;
require_once(JPATH_SITE . '/components/com_tz_guestbook/libraries/categories.php');
/**
 * Content Component Category Tree
 *
 * @package     Joomla.Site
 * @subpackage  com_content
 * @since       1.6
 */
class TZ_guestbookCategories extends TZCategories
{
    public function __construct($options = array())
    {
        $options['table'] = '#__comment';
        $options['extension'] = 'com_tz_guestbook';

        parent::__construct($options);
    }
}
