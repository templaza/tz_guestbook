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
defined('_JEXEC') or die;


?>
<ul class="tz-guestbook tzguestbook<?php echo $moduleclass_sfx;?>">
    <?php if($list):

        $doc    = JFactory::getDocument();
        $doc -> addStyleSheet(JURI::base(true).'/modules/mod_tz_guestbook/css/style.css');
    ?>
    <?php foreach($list as $item):?>
        <li>
            <?php if($params -> get('show_title',1)):?>
            <h4 class="title"><?php echo $item -> title;?></h4>
            <?php endif;?>

            <?php if($params -> get('show_saying',1)):?>
            <div class="quote"><?php echo $item -> content;?></div>
            <?php endif;?>

            <?php if($params -> get('show_author',1)):?>
            <div class="author"><?php echo JText::sprintf('MOD_TZ_GUESTBOOK_USER',$item -> author);?></div>
            <?php endif;?>

			<?php if($params -> get('show_date',1) OR $params -> get('show_email',1)
                OR $params -> get('show_website',1)):?>
            <div class="addition">
                <?php if($params -> get('show_date',1)):?>
                <span class="date"><?php echo JHtml::_('date',$item ->date,JText::_('DATE_FORMAT_LC2'));?></span>
                <?php endif;?>

				<?php if($params -> get('show_email',1)):?>
				<span class="email"><?php echo $item -> email;?></span>
                <?php endif;?>
				
                <?php if($params -> get('show_website',1) AND !empty($item -> website)):?>
                    <span class="website"><?php echo $item -> website;?></span>
                <?php endif;?>
            </div>
			<?php endif;?>
        </li>
    <?php endforeach;?>
    <?php endif;?>
</ul>
