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

JHtml::addIncludePath(JPATH_COMPONENT . '/libraries');
abstract class TZ_guestbookHelperRoute
{
    protected static $lookup = null;

    protected static $lang_lookup = array();

    public static function getCategoryRoute($catid, $language = 0)
    {
        $id = $catid;
        $needles = array();
        $link = 'index.php?option=com_tz_guestbook&view=guestbook&id=' . $id;
        if ($language && $language != "*" && JLanguageMultilang::isEnabled()) {
            self::buildLanguageLookup();

            if (isset(self::$lang_lookup[$language])) {
                $link .= '&lang=' . self::$lang_lookup[$language];
                $needles['language'] = $language;
            }
        }

        if ($item = self::_findItem($catid)) {

            $link .= '&Itemid=' . $item;
        }

        return $link;
    }

    protected static function buildLanguageLookup()
    {
        if (count(self::$lang_lookup) == 0) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true)
                ->select('a.sef AS sef')
                ->select('a.lang_code AS lang_code')
                ->from('#__languages AS a');

            $db->setQuery($query);
            $langs = $db->loadObjectList();

            foreach ($langs as $lang) {
                self::$lang_lookup[$lang->lang_code] = $lang->sef;
            }
        }
    }

    protected static function _findItem($catid = null)
    {
        $app = JFactory::getApplication();
        $menus = $app->getMenu('site');
            $component = JComponentHelper::getComponent('com_tz_guestbook');
            $attributes = array('component_id');
            $values = array($component->id);
            $items = $menus->getItems($attributes, $values);
            if(count($items)){
                foreach ($items as $item) {
                    if (isset($item->query) && isset($item->query['view'])) {
                        if (isset($item->query['id'])) {
                                if($catid == $item -> query['id']){
                                    return $item->id;
                                }
                        }
                    }
                }
            }

        // Check if the active menuitem matches the requested language
        $active = $menus->getActive();
        if ($active && $active->component == 'com_tz_guestbook') {

            return $active->id;
        }
        // If not found, return language specific home link
        return null;
    }
}