<?php
/*------------------------------------------------------------------------

# TZ Guestbook Extension

# ------------------------------------------------------------------------

# author    DuongTVTemPlaza

# copyright Copyright (C) 2012 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

// no direct access
defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

class JFormFieldTZAuthor extends JFormField{

    protected $type = 'TZAuthor';

    protected function getInput(){
        // Initialize variables.
        $html = array();
        $attr = '';

        // Initialize some field attributes.
        $attr .= $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';

        // To avoid user's confusion, readonly="true" should imply disabled="true".
        if ((string) $this->element['readonly'] == 'true' || (string) $this->element['disabled'] == 'true')
        {
            $attr .= ' disabled="disabled"';
        }

        $attr .= $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
        $attr .= $this->multiple ? ' multiple="multiple"' : '';

        // Initialize JavaScript field attributes.
        $attr .= $this->element['onchange'] ? ' onchange="' . (string) $this->element['onchange'] . '"' : '';

        // Get the field options.
        $options = (array) $this->getOptions();

        // Create a read-only list (no name) with a hidden input to store the value.
        if ((string) $this->element['readonly'] == 'true')
        {
            $html[] = JHtml::_('select.genericlist', $options, '', trim($attr), 'value', 'text', $this->value, $this->id);
            $html[] = '<input type="hidden" name="' . $this->name . '" value="' . $this->value . '"/>';
        }
        // Create a regular list.
        else
        {
            $html[] = JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
        }

        return implode($html);
    }
    protected function getOptions(){
        $options    = array();

        foreach ($this->element->children() as $option)
        {

            // Only add <option /> elements.
            if ($option->getName() != 'option')
            {
                continue;
            }

            // Create a new option object based on the <option /> element.
            $tmp = JHtml::_(
                'select.option', (string) $option['value'],
                JText::alt(trim((string) $option), preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)), 'value', 'text',
                ((string) $option['disabled'] == 'true')
            );

            // Set some option attributes.
            $tmp->class = (string) $option['class'];

            // Set some JavaScript option attributes.
            $tmp->onclick = (string) $option['onclick'];

            // Add the option object to the result set.
            $options[] = $tmp;
        }

        $db     = JFactory::getDbo();
        $query  = $db -> getQuery(true);
        $query -> select('u.*,ug.title AS group_title,ug.id AS group_id');
        $query -> from('#__users AS u');

        $query -> join('LEFT','#__user_usergroup_map AS m ON m.user_id = u.id');
        $query -> join('LEFT','#__usergroups AS ug ON m.group_id = ug.id');
        $query -> join('LEFT','#__comment AS c ON c.id_us = u.id');

        $query -> where('u.block = 0 AND u.activation = 0');
//        if(isser($element['groups']) && !empty($element['groups'])){
//            $query -> where()
//        }

        $query -> order('ug.id ASC');

        $db -> setQuery($query);

        if($items = $db -> loadObjectList()){
            $groupid    = null;

            foreach($items as $item){

                if($groupid != $item -> group_id){
                    $options[]  = JHtml::_('select.optgroup',$item -> group_title);
                    $groupid    = $item -> group_id;
                }

                $options[]  = JHtml::_('select.option', $item -> id,$item -> name);
            }
        }

        return $options;
    }
}