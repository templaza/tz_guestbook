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
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_tz_guestbook/css/edit.css');
?>
<form action="index.php?option=com_tz_guestbook" method="post" name="adminForm" id="adminForm">
    <div id="warp-commemt">
        <div id="warp-commemt1">
            <ul>
                <li class="conten-comment">
                    <span>
                        <?php echo JText::_("COM_TZ_GUESTBOOK_GLOBAL_EDIT_NAME"); ?>
                    </span>
                </li>
                <li class="content-comment-right">
                    <span>
                        <?php echo $this->detail->cname; ?>
                    </span>
                </li>
                <li class="cler"></li>
                <li class="conten-comment">
                    <span>
                        <?php echo JText::_("COM_TZ_GUESTBOOK_GLOBAL_EMAIL"); ?>
                    </span>
                </li>
                <li class="content-comment-right">
                    <span>
                        <?php echo $this->detail->cemail; ?>
                    </span>
                </li>
                <li class="cler"></li>
                <?php
                if ($this->detail->jtitle != null):?>
                    <li class="conten-comment">
                        <span>
                            <?php echo JText::_('JCATEGORY'); ?>
                        </span>
                    </li>
                    <li class="content-comment-right">
                        <span>
                            <?php echo $this->detail->jtitle; ?>
                        </span>
                    </li>
                <?php endif; ?>
                <li class="cler"></li>
                <li class="conten-comment">
                    <span>
                        <?php echo JText::_("JSTATUS"); ?>
                    </span>
                </li>
                <li class="content-comment-right">
                    <span>
                    <?php
                    if (isset($this->detail->cstatus) && $this->detail->cstatus == 1) {
                        echo JText::_("JSHOW");
                    } else {
                        echo JText::_("JHIDE");
                    }
                    ?>
                    </span>
                </li>
                <li class="cler"></li>
                <li class="conten-comment">
                    <span>
                        <?php echo JText::_("COM_TZ_GUESTBOOK_GLOBAL_PUBLICH_EMAIL"); ?>
                    </span>
                </li>

                <li class="content-comment-right">
                    <span>
                        <?php
                        if (isset($this->detail->cpublic) && !empty($this->detail->cpublic)) {
                            echo JText::_("JSHOW");
                        } else {
                            echo JText::_("JHIDE");
                        }
                        ?>
                    </span>
                </li>
                <li class="cler"></li>
                <li class="conten-comment">
                    <span>
                        <?php echo JText::_("COM_TZ_GUESTBOOK_GLOBAL_CREATE_DATE"); ?>
                    </span>
                </li>

                <li class="content-comment-right">
                    <span>
                        <?php echo $this->detail->cdate; ?>
                    </span>
                </li>
                <li class="cler"></li>
                <li class="conten-comment">
                    <span>
                        <?php echo JText::_("COM_TZ_GUESTBOOK_GLOBAL_AUTHOR"); ?>
                    </span>
                </li>
                <li class="content-comment-right">
                    <span>
                        <?php
                        if (isset($this->detail->uname) && !empty($this->detail->uname)) {
                            echo $this->detail->uname;
                        } else {
                            echo JText::_("COM_TZ_GUESTBOOK_GUEST");
                        }
                        ?>
                    </span>
                </li>
                <li class="cler"></li>
                <li class="conten-comment">
                    <span>
                        <?php echo JText::_("COM_TZ_GUESTBOOK_YOUR_WEB"); ?>
                    </span>
                </li>
                <li class="content-comment-right">
                    <span>
                        <?php
                        if (isset($this->detail->cwebsite) && !empty($this->detail->cwebsite)) {
                            echo $this->detail->cwebsite;
                        } else {
                            echo JText::_("COM_TZ_GUESTBOOK_EMPTY");
                        }
                        ?>
                    </span>
                </li>
                <li class="cler"></li>
            </ul>
        </div>
        <div class="cler"></div>
        <div id="warp-commemt2">
            <ul>
                <li>
                    <span>
                        <?php echo JText::_("JGLOBAL_TITLE"); ?>
                    </span>

                    <p>
                        <?php echo $this->detail->ctitle; ?>
                    </p>
                </li>
                <li>
                    <span>
                        <?php echo JText::_("COM_TZ_GUESTBOOK_GLOBAL_CONTENT"); ?>
                    </span>

                    <p>
                        <?php echo $this->detail->ccontent; ?>
                    </p>
                </li>
            </ul>
        </div>
    </div>

    <input type="hidden" name="option" value="com_tz_guestbook"/>
    <input type="hidden" name="view" value="guestbook"/>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="0"/>
    <?php echo JHtml::_('form.token'); ?>
</form>