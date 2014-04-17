<?php
/*------------------------------------------------------------------------

# TZ Portfolio Extension

# ------------------------------------------------------------------------

# author    DuongTVTemPlaza

# copyright Copyright (C) 2013 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/
defined('_JEXEC') or die;
function tzguestbookimport($package)
{
    $path = COM_TZ_GUESTBOOK_ADMIN_PATH . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR
        . $package. '.php';
    if (file_exists($path)) {
        include_once $path;
    } else {
        trigger_error('TZ Guestbook import not found object: ' . $package, E_USER_ERROR);
    }
}

