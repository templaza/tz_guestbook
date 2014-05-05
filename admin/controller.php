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
class TZ_guestbookController extends JControllerLegacy
{

    protected $default_view = 'guestbook';

    /**
     * Method to display a view.
     *
     * @param   boolean            If true, the view output will be cached
     * @param   array  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return  JController        This object to support chaining.
     *
     * @since   1.5
     */
    public function display($cachable = false, $urlparams = false)
    {
//        $view = $this->input->get('view', 'guestbook');
//        $layout = $this->input->get('layout', 'edit');
//        $id = $this->input->getInt('id');
        $view		= JRequest::getCmd('view', 'articles');
        $layout 	= JRequest::getCmd('layout', 'articles');
        $id			= JRequest::getInt('id');
//         Check for edit form.
        if ($view == 'guestbook' && $layout == 'edit' && !$this->checkEditId('com_tz_guestbook.edit.guestbook', $id)) {
            // Somehow the person just went to the form - we don't allow that.
            $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
            $this->setMessage($this->getError(), 'error');
            $this->setRedirect(JRoute::_('index.php?option=com_tz_guestbook&view=guestbook', false));

            return false;
        }

        parent::display();

        return $this;
    }
}