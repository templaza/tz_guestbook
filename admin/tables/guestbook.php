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


class TZ_guestbookTableGuestbook extends JTable
{
    var $id_cm = null;
    var $name = null;
    var $email = null;
    var $catid = null;
    var $title = null;
    var $content = null;
    var $public = null;
    var $date = null;
    var $status = null;
    var $website = null;
    var $id_us = null;

    function __construct($db)
    {
        parent::__construct('#__comment', 'id_cm', $db);
    }

}