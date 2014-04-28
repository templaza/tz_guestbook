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

defined('JPATH_PLATFORM') or die;

if (version_compare(JVERSION,'3.0','ge')) {
    require_once(JPATH_SITE . '/libraries/joomla/object/object.php');
} else {
    require_once(JPATH_SITE . '/libraries/joomla/base/object.php');
}


class TZCategories
{

    public static $instances = array();

    protected $_nodes;

    protected $_checkedCategories;

    protected $_extension = null;

    protected $_table = null;

    protected $_field = null;

    protected $_key = null;

    protected $_statefield = null;

    protected $_options = null;

    public function __construct($options)
    {
        $this->_extension = $options['extension'];
        $this->_table = $options['table'];
        $this->_field = (isset($options['field']) && $options['field']) ? $options['field'] : 'catid';
        $this->_key = (isset($options['key']) && $options['key']) ? $options['key'] : 'id_cm';
        $this->_statefield = (isset($options['statefield'])) ? $options['statefield'] : 'status';
        $options['access'] = (isset($options['access'])) ? $options['access'] : 'true';
        $options['published'] = (isset($options['published'])) ? $options['published'] : 1;
        $this->_options = $options;

        return true;
    }

    public static function getInstance($extension, $options = array())
    {
        $hash = md5($extension . serialize($options));

        if (isset(self::$instances[$hash])) {
            return self::$instances[$hash];
        }

        $parts = explode('.', $extension);

        $component = 'com_' . strtolower($parts[0]);

        $section = count($parts) > 1 ? $parts[1] : '';

        $classname = ucfirst(substr($component, 4)) . ucfirst($section) . 'Categories';


        if (!class_exists($classname)) {
            $path = JPATH_SITE . '/components/' . $component . '/helpers/category.php';

            if (is_file($path)) {

                include_once $path;
            } else {

                return false;
            }
        }

        self::$instances[$hash] = new $classname($options);
        return self::$instances[$hash];
    }

    public function get($id = 'root', $forceload = false)
    {
        if ($id !== 'root') {
            $id = (int)$id;

            if ($id == 0) {

                $id = 'root';
            }
        }

        return $this->_load($id);

    }

    protected function _load($id)
    {

        $db = JFactory::getDbo();
        $user = JFactory::getUser();
        $extension = $this->_extension;
        $query = $db->getQuery(true);

        // Right join with c for category
        $query->select('c.id, c.asset_id, c.access, c.alias, c.checked_out, c.checked_out_time,
			c.created_time, c.created_user_id, c.description, c.extension, c.hits, c.language, c.level,
			c.lft, c.metadata, c.metadesc, c.metakey, c.modified_time, c.note, c.params, c.parent_id,
			c.path, c.published, c.rgt, c.title, c.modified_user_id');

        $query->from('#__categories as c')
            ->where('c.extension=' . $db->quote($extension))
            ->where('c.id=' . $id);
        if ($this->_options['access']) {
            $query->where('c.access IN (' . implode(',', $user->getAuthorisedViewLevels()) . ')');
        }

        if ($this->_options['published'] == 1) {
            $query->where('c.published = 1');
        }
        // Get the results
        $db->setQuery($query);

        $results = $db->loadObjectList();
        return $results;
    }
}


class JCategoryNode1 extends JObject
{

    public $id = null;
    public $asset_id = null;
    public $parent_id = null;

    public $lft = null;

    public $rgt = null;

    public $level = null;

    public $extension = null;

    public $title = null;

    public $alias = null;

    public $description = null;

    public $published = null;

    public $checked_out = 0;

    public $checked_out_time = 0;

    public $access = null;

    public $params = null;

    public $metadesc = null;

    public $metakey = null;

    public $metadata = null;

    public $created_user_id = null;

    public $created_time = null;

    public $modified_user_id = null;

    public $modified_time = null;

    public $hits = null;

    public $language = null;

    public $numitems = null;

    public $childrennumitems = null;

    public $slug = null;

    public $assets = null;

    protected $_parent = null;

    protected $_children = array();

    protected $_path = array();

    protected $_leftSibling = null;

    protected $_rightSibling = null;

    protected $_allChildrenloaded = false;

    protected $_constructor = null;

    public function __construct($category = null, $constructor = null)
    {
        if ($category) {
            $this->setProperties($category);
            if ($constructor) {
                $this->_constructor = $constructor;
            }
            return true;
        }
        return false;
    }

    public function setParent($parent)
    {
        if ($parent instanceof JCategoryNode1 || is_null($parent)) {
            if (!is_null($this->_parent)) {
                $key = array_search($this, $this->_parent->_children);
                unset($this->_parent->_children[$key]);
            }
            if (!is_null($parent)) {
                $parent->_children[] = & $this;
            }
            $this->_parent = $parent;

            if ($this->id != 'root') {
                if ($this->parent_id != 1) {
                    $this->_path = $parent->getPath();
                }
                $this->_path[] = $this->id . ':' . $this->alias;
            }

            if (count($parent->_children) > 1) {
                end($parent->_children);
                $this->_leftSibling = prev($parent->_children);
                $this->_leftSibling->_rightsibling = & $this;
            }
        }
    }

    public function addChild($child)
    {
        if ($child instanceof JCategoryNode1) {
            $child->setParent($this);
        }
    }

    public function removeChild($id)
    {
        $key = array_search($this, $this->_parent->_children);
        unset($this->_parent->_children[$key]);
    }

    public function &getChildren($recursive = false)
    {
        if (!$this->_allChildrenloaded) {
            $temp = $this->_constructor->get($this->id, true);
            if ($temp) {
                $this->_children = $temp->getChildren();
                $this->_leftSibling = $temp->getSibling(false);
                $this->_rightSibling = $temp->getSibling(true);
                $this->setAllLoaded();
            }
        }

        if ($recursive) {
            $items = array();
            foreach ($this->_children as $child) {
                $items[] = $child;
                $items = array_merge($items, $child->getChildren(true));
            }
            return $items;
        }

        return $this->_children;
    }

    public function getParent()
    {
        return $this->_parent;
    }

    public function hasChildren()
    {
        return count($this->_children);
    }

    public function hasParent()
    {
        return $this->getParent() != null;
    }

    public function setSibling($sibling, $right = true)
    {
        if ($right) {
            $this->_rightSibling = $sibling;
        } else {
            $this->_leftSibling = $sibling;
        }
    }

    public function getSibling($right = true)
    {
        if (!$this->_allChildrenloaded) {
            $temp = $this->_constructor->get($this->id, true);
            $this->_children = $temp->getChildren();
            $this->_leftSibling = $temp->getSibling(false);
            $this->_rightSibling = $temp->getSibling(true);
            $this->setAllLoaded();
        }

        if ($right) {
            return $this->_rightSibling;
        } else {
            return $this->_leftSibling;
        }
    }

    public function getParams()
    {
        if (!($this->params instanceof JRegistry)) {
            $temp = new JRegistry;
            $temp->loadString($this->params);
            $this->params = $temp;
        }

        return $this->params;
    }

    public function getMetadata()
    {
        if (!($this->metadata instanceof JRegistry)) {
            $temp = new JRegistry;
            $temp->loadString($this->metadata);
            $this->metadata = $temp;
        }

        return $this->metadata;
    }

    public function getPath()
    {

        return $this->_path;
    }

    public function getAuthor($modified_user = false)
    {
        if ($modified_user) {
            return JFactory::getUser($this->modified_user_id);
        }

        return JFactory::getUser($this->created_user_id);
    }

    public function setAllLoaded()
    {
        $this->_allChildrenloaded = true;
        foreach ($this->_children as $child) {
            $child->setAllLoaded();
        }
    }

    public function getNumItems($recursive = false)
    {
        if ($recursive) {
            $count = $this->numitems;

            foreach ($this->getChildren() as $child) {
                $count = $count + $child->getNumItems(true);
            }

            return $count;
        }
        return $this->numitems;
    }
}
