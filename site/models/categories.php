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

defined("_JEXEC") or die;


jimport('joomla.application.component.modellist');
/**
 * This models supports retrieving lists of article categories.
 */
class TZ_guestbookModelCategories extends JModelList
{

    protected function populateState()
    {
        $app = JFactory::getApplication('site');
        $param = $app->getParams();
       // $id = JRequest::getVar('id');
   $id1 = $param->get('id');
        $this->setState('id', $id1);
        $this->setState('params', $param);
    }

    public function getItems()
    {

        $a = $this->getState('id');
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('c.*' );

        $query->from('#__categories as c');

        $query->where("c.extension = 'com_tz_guestbook' and c.published = 1");

        if ($a[0] == null) {
            $where = '';
        } else {
            $id = array_filter($a);
            $arr = implode(",", $id);
            $where = "c.id IN (" . $arr . ")";
            $query->where($where);
        }
        $db->setQuery($query);

        return $db->loadObjectList();

    }


}
