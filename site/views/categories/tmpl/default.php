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

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('behavior.caption');
JHtml::_('bootstrap.tooltip');
require_once(JPATH_COMPONENT . '/helpers/route.php');

?>

<div class="TzCategories categories-list<?php echo $this->pageclass_sfx; ?>">
    <?php if ($this->params->get('show_page_heading')) : ?>
        <h1>
            <?php echo $this->escape($this->params->get('page_heading')); ?>
        </h1>
    <?php endif; ?>
    <?php if (count($this->items) > 0) : ?>
        <?php foreach ($this->items as $id => $item) : ?>
            <?php
            $a = ($id + 1) % 2;
            $params = new JRegistry($item->params);
            ?>
            <?php if (($id) == 0 or $a == 1): ?>
                <div class="row-fluid">
            <?php endif; ?>

            <div class="span6">
                <h3 class="page-header item-title">
                    <a href="<?php echo JRoute::_(TZ_guestbookHelperRoute::getCategoryRoute($item->id)); ?>">
                        <?php echo $this->escape($item->title); ?>
                    </a>
                </h3>
                <?php if ($this->params->get('show_image_cat') == 1): ?>
                    <?php if ($params->get('image')): ?>
                        <div class="image_cat">
                            <img src="<?php echo $params->get('image'); ?>">
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if ($this->params->get('show_subcat_desc_cat') == 1) : ?>
                    <?php if ($item->description) : ?>
                        <div class="category-desc">
                            <?php echo JHtml::_('content.prepare', $item->description, '', 'com_tz_guestbook.categories'); ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php if (($id + 1) == 0 or  $a == 0): ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

