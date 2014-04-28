<?php
/**
 * Created by PhpStorm.
 * User: TuanMap
 * Date: 4/23/14
 * Time: 3:06 PM
 */
defined('_JEXEC') or die;
jimport('joomla.application.component.modeladmin');

class Tz_guestbookModelGuest extends JModelAdmin
{
    public function getForm($data = array(), $loadData = true)
    {
        return;
    }

    public function getTable($type = 'Guestbook', $prefix = 'TZ_guestbookTable', $config = array())
    {
//        var_dump(JTable::getInstance($type, $prefix, $config));
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
        var_dump($table);

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