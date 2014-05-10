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
defined("_JEXEC") or die;
jimport('joomla.application.component.modellist');
jimport('joomla.html.pagination');

class Tz_guestbookModelGuestbook extends JModelList
{

    function populateState($ordering = null, $direction = null)
    {
        parent::populateState('tz.id', 'asc');
        $app = JFactory::getApplication();
        // Adjust the context to support modal layouts.
        if ($layout = $app->input->get('view')) {
            $this->context .= '.' . $layout;
        }
        $filer_public = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
        $filer_auto = $this->getUserStateFromRequest($this->context . '.filter.author.id', 'filter_author_id', '');
        $filert_order = $this->getUserStateFromRequest($this->context . '.filter.order', 'filter_order', '');
        $filert_order_dir = $this->getUserStateFromRequest($this->context . '.filert.order.dir', 'filter_order_Dir', '');
        $filer_search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $category = $this->getUserStateFromRequest($this->context . 'filter.category_id', 'filter_category_id');
        $this->setState('sata', $filer_public);
        $this->setState('autho', $filer_auto);
        $this->setState('lab1', $filert_order);
        $this->setState('lab2', $filert_order_dir);
        $this->setState('search', $filer_search);
        $this->setState('cate', $category);

    }

    protected function getListQuery()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('u.name AS uname, c.id_cm AS cid, c.title AS ctitle, c.email AS cemail, c.status AS cstatus, c.public AS cpublic ,j.title as jtitle');
        $query->from('#__users AS u');
        $query->join('right', '#__comment AS c ON c.id_us  = u.id');
        $query->join('left', ' #__categories AS j ON c.catid = j.id');
        $lisd = $this->getState('lab1');
        $lisd2 = $this->getState('lab2');
        $selectsta = $this->getState('sata');
        $author = $this->getState('autho');
        $search = $this->getState('search');
        $cate = $this->getState('cate');

        switch ($lisd) {
            case'tz.state':
                $ord = "order by c.status $lisd2";
                break;

            case'tz.title':
                $ord = "order by c.title $lisd2";
                break;

            case'tz.email':
                $ord = "order by c.email $lisd2";
                break;

            case'tz.id':
                $ord = "order by c.id_cm $lisd2";
                break;

            case'tz.public':
                $ord = "order by c.public $lisd2";
                break;

            case'tz.author':
                $ord = "order by u.name $lisd2 ";
                break;

            case'tz.category':
                $ord = "order by c.catid $lisd2 ";
                break;

            default:
                $ord = "order by c.date desc";
                break;
        }


        switch ($selectsta) {
            case'1':
                $satrus = '  c.status = 1';
                break;

            case'0':
                $satrus = ' c.status = 0';
                break;

            default:
                $satrus = "c.status in (0,1)";
                break;
        }

        // author
        if (isset($author) && $author > 0) {
            $author = " AND u.id = $author";
        } else {
            $author = '';
        }
        //category
        if (isset($cate) && !empty($cate)) {
            $filter_cate = "AND c.catid = $cate";
        } else {
            $filter_cate = '';
        }

        // search
        if (isset($search) && !empty($search)) {
            if (is_numeric($search) == true) {
                $q_search = "AND c.id_cm = $search";
            } else if (is_numeric($search) == false) {
                $q_search = "AND c.title like '%" . $search . "%'";
            }
        } else {
            $q_search = '';
        }
        $where = $satrus . " " . $author . " " . $q_search . " " . $filter_cate . " " . $ord;
        $query->where($where);

        return $query;
    }

    public function getItems()
    {
        return parent::getItems();
    }

    function getList()
    {
        return $this->getItems();

    }

    protected function getStoreId($id = '')
    {
        // Add the list state to the store id.
        $id .= ':' . $this->getState('list.start');
        $id .= ':' . $this->getState('list.limit');
        $id .= ':' . $this->getState('list.ordering');
        $id .= ':' . $this->getState('list.direction');
        return md5($this->context . ':' . $id);
    }

    /*
     * Method get data author
    */
    function getAuthor()
    {
        $db = JFactory::getDbo();
        $sql = 'SELECT u.id AS value, u.name AS text FROM #__users AS u INNER JOIN #__comment AS c ON c.id_us = u.id group by u.id';
        $db->setQuery($sql);
        $row = $db->loadObjectList();

        return $row;
    }

    /*
     * Method unpublich
    */

    /*
     * Method publish
    */
    function publish($id, $value)
    {
        $idd = $id;
        $string = implode(",", $idd);
        $db = JFactory::getDbo();
        $sql = 'UPDATE #__comment SET status =' . $value . ' WHERE id_cm in(' . $string . ')';

        $db->setQuery($sql);
        return $db->query();

    }

    /*
     * method delete
    */
    function delete($id)
    {
        $idd = $id;
        $string = implode(",", $idd);
        $db = JFactory::getDbo();
        $sql = 'delete from  #__comment  WHERE id_cm in(' . $string . ')';
        $db->setQuery($sql);
        return $db->query();
    }

    /*
     * method view detail comment
    */
    function getDetail()
    {

        $id = JRequest::getInt('id');
        $cid = JRequest::getVar('cid');
        if (isset($id) && $id != "") {
            $where_id = ' where c.id_cm=' . $id;
        } elseif (isset($cid) && $cid != "") {
            $where_id = 'where c.id_cm=' . $cid[0];
        } else
            $where_id = "";
        $db = JFactory::getDbo();

        $sql = 'SELECT c.name AS cname,  c.email AS cemail,  c.title AS ctitle, c.content AS ccontent,  c.public AS cpublic,
                              c.date AS cdate, c. status AS cstatus, u . name AS uname,  c.website as cwebsite  ,j . title as jtitle
                        FROM #__users AS u RIGHT JOIN #__comment AS c ON c.id_us  = u.id LEFT  JOIN #__categories AS j ON c.catid = j.id
                       ' . $where_id;
        $db->setQuery($sql);
        $db->query();
        $row = $db->loadObject();

        return $row;
    }

    function getCate()
    {
        $db = JFactory::getDbo();
        $sql_cate = "SELECT * FROM #__categories where extension ='com_tz_guestbook' and published = 1";
        $db->setQuery($sql_cate);
        $count = $db->getNumRows($db->query());
        return $count;
    }

    public function getTable($type = 'Guestbook', $prefix = 'TZ_guestbookTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    function batch($value, $pks, $contexts)
    {
        $categoryId = (int)$value['category_id'];
        $m_c = $value['move_copy'];
        $table = $this->getTable('Guestbook', 'TZ_guestbookTable');
        $i = 0;
        if ($categoryId) {
            $categoryTable = JTable::getInstance('Category');
            if (!$categoryTable->load($categoryId)) {
                if ($error = $categoryTable->getError()) {
                    // Fatal error
                    $this->setError($error);
                    return false;
                } else {
                    $this->setError(JText::_('JLIB_APPLICATION_ERROR_BATCH_MOVE_CATEGORY_NOT_FOUND'));
                    return false;
                }
            }
        }
        if (empty($categoryId)) {
            $this->setError(JText::_('JLIB_APPLICATION_ERROR_BATCH_MOVE_CATEGORY_NOT_FOUND'));
            return false;
        }

        while (!empty($pks)) {
            $pk = array_shift($pks);
            $table->reset();
            if (!$table->load($pk)) {
                if ($error = $table->getError()) {
                    $this->setError($error);
                    return false;
                } else {
                    $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', $pk));
                    continue;
                }
            }
            if ($m_c == 'c') {
                $table->id_cm = 0;
            } else {
                $table->id_cm = $pk;
            }
            // New category ID
            $table->catid = $categoryId;
            $table->store();
            // Store the row.
            if (!$table->store()) {
                $this->setError($table->getError());
                return false;
            } else
                return true;
        }
        // Clean the cache
        $this->cleanCache();

    }

}

?>