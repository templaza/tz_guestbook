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


$listDirn = $this->state2;
$listOrder = $this->state1;
$sortFields = $this->getSortFields();
?>
<script type="text/javascript">
    Joomla.orderTable = function () {
        table = document.getElementById("sortTable");
        direction = document.getElementById("directionTable");
        order = table.options[table.selectedIndex].value;
        if (order != '<?php echo $listOrder; ?>') {
            dirn = 'asc';
        } else {
            dirn = direction.options[direction.selectedIndex].value;
        }
        Joomla.tableOrdering(order, dirn, '');
    }
</script>

<form action="index.php?option=com_tz_guestbook&view=guestbook" method="post" name="adminForm" id="adminForm">
    <?php if (!empty($this->sidebar) AND COM_TZ_GUESTBOOK_JVERSION_COMPARE): ?>
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
        <?php else: ?>
        <div id="j-main-container">
            <?php endif; ?>

            <div id="filter-bar" class="btn-toolbar">
                <div class="filter-search btn-group pull-left">
                    <label for="filter_search"
                           class="element-invisible"><?php echo JText::_('COM_TZ_GUESTBOOK_FILTER_SEARCH_DESC'); ?></label>
                    <input type="text" name="filter_search"
                           placeholder="<?php echo JText::_('COM_TZ_GUESTBOOK_SEARCH_TITLE_OR_ID'); ?>"
                           id="filter_search" value="<?php echo $this->tz_search; ?>"
                           title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_TITLE_VALUE'); ?>"/>
                </div>
                <div class="btn-group pull-left hidden-phone">
                    <button class="btn hasTooltip" type="submit"
                            title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i>
                    </button>
                    <button class="btn hasTooltip" type="button"
                            onclick="document.id('filter_search').value='';this.form.submit();"
                            title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"><i class="icon-remove"></i></button>
                </div>

                <?php if (COM_TZ_GUESTBOOK_JVERSION_COMPARE): //If the joomla's version is 3.0 ?>
                    <div class="btn-group pull-right hidden-phone">
                        <label for="limit"
                               class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
                        <?php echo $this->pagination->getLimitBox(); ?>
                    </div>
                    <div class="btn-group pull-right hidden-phone">
                        <label for="directionTable"
                               class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></label>
                        <select name="directionTable" id="directionTable" class="input-medium"
                                onchange="Joomla.orderTable()">
                            <option value=""><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></option>
                            <option
                                value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING'); ?></option>
                            <option
                                value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING'); ?></option>
                        </select>
                    </div>
                    <div class="btn-group pull-right">
                        <label for="sortTable"
                               class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY'); ?></label>
                        <select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
                            <option value=""><?php echo JText::_('JGLOBAL_SORT_BY'); ?></option>
                            <?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder); ?>
                        </select>
                    </div>
                <?php endif; ?>
                <?php // If the joomla's version is more than or equal to 3.0 ?>
                <?php if (!COM_TZ_GUESTBOOK_JVERSION_COMPARE): ?>
                    <div class="filter-select pull-right">
                        <?php echo $this->sidebar; ?>
                    </div>
                <?php endif; ?>

            </div>
            <div class="clearfix"></div>
            <table class="table table-striped" id="articleList">
                <thead>
                <tr>
                    <th width="1%" class="hidden-phone">
                        <input type="checkbox" name="checkall-toggle" value=""
                               title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)"/>
                    </th>
                    <th>
                        <?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'tz.title', $listDirn, $listOrder); ?>
                    </th>
                    <th width="15%" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'Category', 'tz.category', $listDirn, $listOrder); ?>
                    </th>
                    <th width="15%" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'Author', 'tz.author', $listDirn, $listOrder); ?>
                    </th>
                    <th width="20%" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'Email', 'tz.email', $listDirn, $listOrder); ?>
                    </th>
                    <th width="5%" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'Public', 'tz.public', $listDirn, $listOrder); ?>
                    </th>
                    <th width="5%" style="min-width:55px" class="nowrap center">
                        <?php echo JHtml::_('grid.sort', 'JSTATUS', 'tz.state', $listDirn, $listOrder); ?>
                    </th>
                    <th width="5%" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'ID', 'tz.id', $listDirn, $listOrder); ?>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php

                foreach ($this->hienthi as $i => $num) {

                    ?>
                    <tr class="row<?php echo $i % 2; ?>">
                        <td class="small hidden-phone">
                            <?php echo JHtml::_('grid.id', $i, $num->cid); ?>
                        </td>
                        <td class="nowrap has-context">
                            <div class="pull-left">
                                <a href="<?php echo JRoute::_('index.php?option=com_tz_guestbook&task=guestbook.edit&id=' . $num->cid); ?>">
                                    <?php
                                    echo $num->ctitle;
                                    ?>
                                </a>
                            </div>
                            <div class="pull-left">
                                <?php
                                JHtml::_('dropdown.addCustomItem', JText::_('COM_TZ_GUESTBOOK_VIEW'),
                                    'index.php?option=com_tz_guestbook&task=guestbook.edit&id=' . $num->cid);
                                JHtml::_('dropdown.divider');
                                if ($num->cstatus) :
                                    JHtml::_('dropdown.unpublish', 'cb' . $i, 'guestbook.');
                                else :
                                    JHtml::_('dropdown.publish', 'cb' . $i, 'guestbook.');
                                endif;
                                echo JHtml::_('dropdown.render');
                                ?>
                            </div>
                        </td>
                        <td>
                            <div class="pull-left">
                                <?php echo $num->jtitle; ?>
                            </div>
                        </td>
                        <td class="small hidden-phone">
                            <?php
                            if (isset($num->uname) && !empty($num->uname)) {
                                echo $num->uname;
                            } else {
                                echo JText::_("COM_TZ_GUESTBOOK_GUEST");
                            }
                            ?>
                        </td>
                        <td class="small hidden-phone">
                            <?php
                            echo $num->cemail;
                            ?>
                        </td>
                        <td class="small hidden-phone">
                            <?PHP echo $num->cpublic; ?>
                        </td>
                        <td class="center">
                            <?php
                            echo JHtml::_('jgrid.published', $num->cstatus, $i, 'guestbook.', true, 'cb');
                            ?>
                        </td>
                        <td class="small hidden-phone">
                            <?php
                            echo $num->cid;
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="8">
                        <?php echo $this->pagination->getListFooter(); ?>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <?php echo $this->loadTemplate('batch'); ?>
    <input type="hidden" name="option" value="com_tz_guestbook">
    <input type="hidden" name="view" value="guestbook">
    <input type="hidden" name="task" value="">
    <input type="hidden" name="boxchecked" value="0">
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
    <?php echo JHtml::_('form.token'); ?>
</form>