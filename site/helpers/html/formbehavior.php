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

/**
 * Utility class for form related behaviors
 *
 * @package     Joomla.Libraries
 * @subpackage  HTML
 * @since       3.0
 */
abstract class JHtmlFormbehavior
{
	/**
	 * @var    array  Array containing information for loaded files
	 * @since  3.0
	 */
	protected static $loaded = array();

	/**
	 * Method to load the Chosen JavaScript framework and supporting CSS into the document head
	 *
	 * If debugging mode is on an uncompressed version of Chosen is included for easier debugging.
	 *
	 * @param   string  $selector  Class for Chosen elements.
	 * @param   mixed   $debug     Is debugging mode on? [optional]
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public static function chosen($selector = '.advandedSelect', $debug = null)
	{
		if (isset(self::$loaded[__METHOD__][$selector]))
		{
			return;
		}

        if(!COM_TZ_PORTFOLIO_JVERSION_COMPARE){
            JFactory::getLanguage() ->load('com_tz_portfolio');
        }

		// Include jQuery
		JHtml::_('jquery.framework');

		// Add chosen.jquery.js language strings
        JText::script('JGLOBAL_SELECT_SOME_OPTIONS');
		JText::script('JGLOBAL_SELECT_AN_OPTION');
		JText::script('JGLOBAL_SELECT_NO_RESULTS_MATCH');

		// If no debugging value is set, use the configuration setting
		if ($debug === null)
		{
			$config = JFactory::getConfig();
			$debug  = (boolean) $config->get('debug');
		}

		JHtml::_('script', 'jui/chosen.jquery.min.js', false, true, false, false, $debug);
		JHtml::_('stylesheet', 'jui/chosen.css', false, true);
		JFactory::getDocument()->addScriptDeclaration("
				jQuery(document).ready(function (){
					jQuery('" . $selector . "').chosen({
						disable_search_threshold : 10,
						allow_single_deselect : true
					});
				});
			"
		);

		self::$loaded[__METHOD__][$selector] = true;

		return;
	}
}
