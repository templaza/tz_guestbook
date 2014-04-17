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
abstract class TZ_guestbookHelperRoute
{
    protected static $lookup = array();

    protected static $lang_lookup = array();

    public static function getCategoryRoute($catid, $language = 0)
    {
        if ($catid instanceof JCategoryNode1) {
            $id = $catid->id;
            $category = $catid;
        } else {
            $id = (int)$catid;
            $category = JCategories::getInstance('TZ_guestbook')->get($id);
        }

        if ($id < 1 || !($category instanceof JCategoryNode1)) {
            $link = '';
        } else {
            $needles = array();

            $link = 'index.php?option=com_tz_guestbook&view=guestbook&id=' . $id;

            $catids = array_reverse($category->getPath());
            $needles['category'] = $catids;
            $needles['categories'] = $catids;

            if ($language && $language != "*" && JLanguageMultilang::isEnabled()) {
                self::buildLanguageLookup();

                if (isset(self::$lang_lookup[$language])) {
                    $link .= '&lang=' . self::$lang_lookup[$language];
                    $needles['language'] = $language;
                }
            }

            if ($item = self::_findItem($needles)) {
                $link .= '&Itemid=' . $item;
            }
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

    protected static function _findItem($needles = null)
    {
        $app = JFactory::getApplication();
        $menus = $app->getMenu('site');
        $language = isset($needles['language']) ? $needles['language'] : '*';

        // Prepare the reverse lookup array.
        if (!isset(self::$lookup[$language])) {
            self::$lookup[$language] = array();

            $component = JComponentHelper::getComponent('com_tz_guestbook');

            $attributes = array('component_id');
            $values = array($component->id);

            if ($language != '*') {
                $attributes[] = 'language';
                $values[] = array($needles['language'], '*');
            }

            $items = $menus->getItems($attributes, $values);

            foreach ($items as $item) {
                if (isset($item->query) && isset($item->query['view'])) {
                    $view = $item->query['view'];
                    if (!isset(self::$lookup[$language][$view])) {
                        self::$lookup[$language][$view] = array();
                    }
                    if (isset($item->query['id'])) {
                        if (!isset(self::$lookup[$language][$view][$item->query['id']]) || $item->language != '*') {
                            self::$lookup[$language][$view][$item->query['id']] = $item->id;
                        }
                    }
                }
            }
        }

        if ($needles) {
            foreach ($needles as $view => $ids) {
                if (isset(self::$lookup[$language][$view])) {
                    foreach ($ids as $id) {
                        if (isset(self::$lookup[$language][$view][(int)$id])) {
                            return self::$lookup[$language][$view][(int)$id];
                        }
                    }
                }
            }
        }

        // Check if the active menuitem matches the requested language
        $active = $menus->getActive();
        if ($active && $active->component == 'com_tz_guestbook' && ($language == '*' || in_array($active->language, array('*', $language)) || !JLanguageMultilang::isEnabled())) {
            return $active->id;
        }

        // If not found, return language specific home link
        $default = $menus->getDefault($language);
        return !empty($default->id) ? $default->id : null;
    }
}