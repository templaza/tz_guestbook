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

require_once(JPATH_SITE . '/components/com_tz_guestbook/libraries/categories.php');


function TZ_GuestbookBuildRoute(&$query)
{

    $segments = array();

    // get a menu item based on Itemid or currently active
    $app = JFactory::getApplication();
    $menu = $app->getMenu();
    $params = JComponentHelper::getParams('com_tz_guestbook');
    $advanced = $params->get('sef_advanced_link', 0);
    // we need a menu item.  Either the one specified in the query, or the current active one if none specified
    if (empty($query['Itemid'])) {
        $menuItem = $menu->getActive();
        $menuItemGiven = false;
    } else {
        $menuItem = $menu->getItem($query['Itemid']);
        $menuItemGiven = true;
    }

    // check again
    if ($menuItemGiven && isset($menuItem) && $menuItem->component != 'com_tz_guestbook') {
        $menuItemGiven = false;
        unset($query['Itemid']);
    }

    if (isset($query['view'])) {
        $view = $query['view'];
    } else {
        // we need to have a view in the query or it is an invalid URL
        return $segments;
    }
    // are we dealing with an article or category that is attached to a menu item?
    if (($menuItem instanceof stdClass) && $menuItem->query['view'] == $query['view'] && isset($query['id']) && $menuItem->query['id'] == (int)$query['id']) {
        unset($query['view']);
        unset($query['id']);
        return $segments;
    }
    if ($view == 'guestbook' || $view == 'categories') {
        if (!$menuItemGiven) {
            $segments[] = $view;
        }
        unset($query['view']);
        if (isset($query['id'])) {
            $catid = $query['id'];
        } else {
            // we should have id set for this view.  If we don't, it is an error
            return $segments;
        }
        if ($menuItemGiven && isset($menuItem->query['id'])) {
            $mCatid = $menuItem->query['id'];
        } else {
            $mCatid = 0;
        }
        $categories = TZCategories::getInstance('TZ_guestbook');
        $category = $categories->get($catid);
        if (!$category) {

            // we couldn't find the category we were given.  Bail.
            return $segments;
        }
        $array = array();

        foreach ($category as $id) {
            $array[] = $id->id;
            $array[] = $id->alias;
            $array = implode('-', $array);
        }
        $segments[] = $array;
        unset($query['id']);
    }
    return $segments;
}


function TZ_GuestbookParseRoute($segments)
{

    $vars = array();

    //Get the active menu item.
    $app = JFactory::getApplication();
    $menu = $app->getMenu();
    $item = $menu->getActive();
    $params = JComponentHelper::getParams('com_tz_guestbook');
    $advanced = $params->get('sef_advanced_link', 0);
    $db = JFactory::getDbo();

    // Count route segments
    $count = count($segments);

    // Standard routing for articles.  If we don't pick up an Itemid then we get the view from the segments
    // the first segment is the view and the last segment is the id of the article or category.
    if (!isset($item)) {

        $vars['view'] = $segments[0];
        $vars['id'] = $segments[$count - 1];

        return $vars;
    }

    // if there is only one segment, then it points to either an article or a category
    // we test it first to see if it is a category.  If the id and alias match a category
    // then we assume it is a category.  If they don't we assume it is an article
    if ($count) {
        // we check to see if an alias is given.  If not, we assume it is an article
        if (strpos($segments[0], '-') === false) {
            $vars['view'] = 'guestbook';
            $vars['id'] = (int)$segments[0];
            return $vars;
        }

        list($id, $alias) = explode('-', $segments[0], 2);
        // first we check if it is a category
        $category = TZCategories::getInstance('TZ_guestbook')->get($id);

        if ($category && $category->alias == $alias) {
            $vars['view'] = 'guestbook';
            $vars['id'] = $id;
            return $vars;
        } else {
            $query = $db->getQuery(true)
                ->select($db->quoteName(array('alias')))
                ->from($db->quoteName('#__categories'))
                ->where($db->quoteName('id') . ' = ' . (int)$id);
            $db->setQuery($query);
            $guestbook = $db->loadObject();
            if ($guestbook) {
                if ($guestbook->alias == $alias) {
                    $vars['view'] = 'guetbook';
                    $vars['id'] = (int)$id;
                    return $vars;
                }

            }
        }
    }

    // if there was more than one segment, then we can determine where the URL points to
    // because the first segment will have the target category id prepended to it.  If the
    // last segment has a number prepended, it is an article, otherwise, it is a category.
    if (!$advanced) {

        $cat_id = (int)$segments[0];
        $vars['view'] = 'guestbook';
        $vars['id'] = $cat_id;
        return $vars;
    }

    // we get the category id from the menu item and search from there

    return $vars;
}