<?php
/*------------------------------------------------------------------------

# TZ Guestbook Extension

# ------------------------------------------------------------------------

# author    DuongTVTemPlaza

# copyright Copyright (C) 2012 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die;

class modTZ_GuestbookHelper{
    public static function getList($params){
        $db     = JFactory::getDbo();
        $query  = $db -> getQuery(true);
        $query -> select('g.*,u.name AS author');
        $query -> from('#__comment AS g');

        $query -> join('LEFT','#__users AS u ON u.id = g.id_us');

        $query -> where('g.status = 1');

        $author = $params -> get('author',array());

        if(isset($author[0]) && empty($author[0])){
            array_shift($author);
        }
        if(count($author)){
            $query -> where('g.id_us IN('.implode(',',$author).')');
        }

        $order  = $params -> get('order','rid');

        switch ($order){
            default:
                $query -> order('g.date DESC');
                break;
            case 'id':
                $query -> order('g.id_cm ASC');
                break;
            case 'alpha':
                $query -> order('g.title ASC');
                break;
            case 'ralpha':
                $query -> order('g.title DESC');
                break;
            case 's_alpha':
                $query -> order('g.content ASC');
                break;
            case 's_ralpha':
                $query -> order('g.content DESC');
                break;
        }

        $db -> setQuery($query,0,$params -> get('count',5));

        if($rows = $db -> loadObjectList()){
            foreach($rows as $item){
                if($item -> id_us == 0){
                    $item -> author = JText::_('MOD_TZ_GUESTBOOK_GUEST');
                }
            }
            return $rows;
        }

        return false;
    }
}