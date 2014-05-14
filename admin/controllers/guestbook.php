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
jimport('joomla.application.component.controlleradmin');
require_once(JPATH_COMPONENT.'/libraries/legacy/controller/admin.php');
class Tz_guestbookControllerGuestbook extends TZControllerAdmin
{

    function display($cachable = false, $urlparams = array())
    {
        parent::display($cachable,$urlparams);
		$doc = JFactory::getDocument();
        $task = JRequest::getVar('task');
        $type = $doc->getType();
        $view = $this->getView('guestbook', $type);
        $model = $this->getModel('guestbook');
        $view->setModel($model, true);

        switch ($task) {
            case'tz.edit':
            case'edit':
            case'guestbook.edit':
                $view->setLayout('edit');
                break;
            default:
                $view->setLayout('default');
                break;
        }
        $view->display();
    }
    public function getModel($name = 'Guestbook', $prefix = 'Tz_guestbookModel', $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);

        return $model;
    }

    public function publish()
    {
        // Check for request forgeries
        JRequest::checkToken() or die(JText::_('JINVALID_TOKEN'));

        // Get items to publish from the request.
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $data = array('publish' => 1, 'unpublish' => 0);
        $task = $this->getTask();
        $value = JArrayHelper::getValue($data, $task, 0, 'int');
        if (empty($cid))
        {
            JError::raiseWarning(500, JText::_($this->text_prefix . '_NO_ITEM_SELECTED'));
        }
        else
        {
            // Get the model.
            $model = $this->getModel();
            // Make sure the item ids are integers
            JArrayHelper::toInteger($cid);
            // Publish the items.
            if (!$model->publish($cid, $value))
            {
                JError::raiseWarning(500, $model->getError());
            }
            else
            {
                if ($value == 1)
                {
                    $ntext = $this->text_prefix . '_ARTICLE_N_ITEMS_PUBLISHED';
                }
                elseif ($value == 0)
                {
                    $ntext = $this->text_prefix . '_ARTICLE_N_ITEMS_UNPUBLISHED';
                }
                $this->setMessage(JText::plural($ntext, count($cid)));
            }
        }
        $extension = JRequest::getCmd('extension');
        $extensionURL = ($extension) ? '&extension=' . JRequest::getCmd('extension') : '';
        $this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list . $extensionURL, false));
    }

    public function delete()
    {

        // Check for request forgeries

        JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));

        // Get items to remove from the request.
        $cid = JFactory::getApplication()->input->get('cid', array(), 'array');

        if (!is_array($cid) || count($cid) < 1)
        {
            JLog::add(JText::_($this->text_prefix . '_NO_ITEM_SELECTED'), JLog::WARNING, 'jerror');
        }
        else
        {
            // Get the model.
            $model = $this->getModel();

            // Make sure the item ids are integers
            jimport('joomla.utilities.arrayhelper');
            JArrayHelper::toInteger($cid);

            // Remove the items.
            if ($model->delete($cid))
            {
                $this->setMessage(JText::plural($this->text_prefix . '_N_ITEMS_DELETED', count($cid)));
            }
            else
            {
                $this->setMessage($model->getError());
            }
        }
        // Invoke the postDelete method to allow for the child class to access the model.

        $this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list, false));
    }

    public function batch()
    {
        $model = $this->getModel();
        // Preset the redirect

        $vars = $this->input->post->get('batch', array(), 'array');
        $cid  = $this->input->post->get('cid', array(), 'array');

        // Build an array of item contexts to check
        $contexts = array();
        foreach ($cid as $id)
        {
            // If we're coming from com_categories, we need to use extension vs. option
            if (isset($this->extension))
            {
                $option = $this->extension;
            }
            else
            {
                $option = $this->option;
            }            
            $contexts[$id] = $option . '.'  . $id;
        }

        // Attempt to run the batch operation.
        if ($model->batch($vars, $cid, $contexts))
        {
            $this->setMessage(JText::_('JLIB_APPLICATION_SUCCESS_BATCH'));
            $this->setRedirect(JRoute::_('index.php?option=com_tz_guestbook&view=guestbook' . $this->getRedirectToListAppend(), false));
            return true;
        }
        else
        {
            $this->setMessage(JText::sprintf('JLIB_APPLICATION_ERROR_BATCH_FAILED', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_tz_guestbook&view=guestbook' . $this->getRedirectToListAppend(), false));
            return false;
        }
    }
    protected function getRedirectToListAppend()
    {
        $tmpl = JFactory::getApplication()->input->get('tmpl');
        $append = '';

        // Setup redirect info.
        if ($tmpl)
        {
            $append .= '&tmpl=' . $tmpl;
        }

        return $append;
    }

}

?>