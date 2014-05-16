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
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
?>

<div id="nnt_comment">
    <a href="#" id="nnt_comment_a1">
        <?php echo JText::_("COM_TZ_GUESTBOOK_SING_GUESTBOOK"); ?>
    </a>

    <div class="clearr"></div>
</div>
<div id="tz-Guestbook-warp">
    <div id="tz-Guestbook">
    </div>
    <div id="tz-Guestbook-seccess">
        <span>
            <?php
            if (isset($this->hstatus) && $this->hstatus == 1) :
                echo JText::_("COM_TZ_GUESTBOOK_NOTICE");
            else :
                echo JText::_("COM_TZ_GUESTBOOK_NOTICE_2");
            endif;
            ?>
        </span>
    </div>

    <div id="warp-fom">
        <h5 id="tz-guestbook-h5">
            <span> <?php echo JText::_("COM_TZ_GUESTBOOK_SING_GUESTBOOK"); ?></span>
            <img id="tz-guestbook-h5-img"
                 src="<?php echo JURI::base(true) . '/components/com_tz_guestbook/images/delete2.png' ?>" alt=""/>
        </h5>

        <form ACTION="" method="POST">
            <div class="warp-in">
                <input
                    id="warp-input1" class="conten-input tz_check_name" type="text" name="name"
                    maxlength="<?php echo $this->count_name; ?>"
                    <?php if (isset($this->auth->name) && $this->auth->name != ""): ?>
                        value="<?php echo $this->auth->name; ?>"
                    <?php else : ?>
                        value="<?php echo JText::_("COM_TZ_GUESTBOOK_FULL_NAME"); ?>"
                    <?php endif; ?>
                    />

                <p class="tz_input_name" id="pname"></p>
            </div>

            <div class="warp-in">
                <input id="warp-input2" class="conten-input tz_check_email" type="text" name="email"
                       maxlength="<?php echo $this->count_email; ?>"
                    <?php if (isset($this->auth->email) && $this->auth->email != "") : ?>
                        value="<?php echo $this->auth->email; ?>"
                    <?php else : ?>
                        value="<?php echo JText::_("COM_TZ_GUESTBOOK_EMAIL"); ?>"
                    <?php endif; ?>
                    />

                <p class="tz_input_email" id="pemail"></p>
            </div>
                <div class="warp-in">
                    <input id="warp-input3" class="conten-input tz_check_title" type="text" name="title"
                           maxlength="<?php echo $this->count_tit; ?>"
                           value="<?php echo JText::_("COM_TZ_GUESTBOOK_TITLE"); ?>"/>

                    <p class="tz_input_title" id="ptitle"></p>
                </div>
            <div class="warp-in">
                 <select class="tz_category" id="jform_mycategory">
                    <option value=""><?php echo JText::_('COM_TZ_GUESTBOOK_CATEGORY_NONE'); ?></option>
                    <?php foreach ($this->listcate as $cate): ?>
                        <option<?php echo ((int)$cate->id == (int)$this->catid) ? ' selected="selected"' : '' ?>
                            value="<?php echo $cate->id; ?>">
                            <?php echo $cate->title; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="tz_input_category" id="s_category"></p>
            </div>
                <div class="warp-in">
                    <input id="warp-input4" class="conten-input tz_check_website" type="text" name="website"
                           maxlength="<?php echo $this->count_web; ?>"
                           value="<?php echo JText::_("COM_TZ_GUESTBOOK_WEBSITE"); ?>"/>

                    <p class="tz_input_website" id="p_website"></p>
                </div>
            <div id="nnt_com1" class="warp-in">
                <label id="warp-label">
                    <?php echo JText::_("COM_TZ_GUESTBOOK_SHOW_EMIAL_IN_PUBLIC"); ?>
                </label>
                <input id="warp-check" type="checkbox" name="check" value="1"/>

                <div class="clre"></div>
            </div>
            <div class="warp-in">
                <textarea name="conten" id="text-ra"
                          maxlength="<?php echo $this->count_comm; ?>"><?php echo JText::_("COM_TZ_GUESTBOOK_YOUR_GUESTBOOK"); ?></textarea>

                <p class="tz_input_comment" id="p_nntconten"></p>
                <input type="hidden" id="checkcapcha" name="checkcapcha" value="<?php echo $this->capchat; ?>"/>
            </div>

            <?php if (isset($this->capchat) and $this->capchat == 1) : ?>
                <div class="warp-in-capchat">
                    <div id="nnt-comment-label-capchat">
                        <?php
                        echo $this->form->getLabel('captcha'); ?>
                    </div>
                    <div id="nnt-comment-input-capchat">
                        <?php
                        echo $this->form->getInput('captcha'); ?>
                    </div>
                    <div class="clearr"></div>
                    <div id="nnt-comment-input-loi-capchat">
                        <p id="nnt_p_capchar"></p>
                    </div>
                </div>
            <?php endif; ?>
            <div class="warp-in2">
                <input id="warp-input-sub" type="button" name="send"
                       value="<?php echo JText::_("COM_TZ_GUESTBOOK_SEND_GUESTBOOK"); ?>"/>
            </div>
        </form>
    </div>
    <div class="clre"></div>
</div>