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
if (isset($this->display) && !empty($this->display)) :
    foreach ($this->display as $rr) : ?>
        <div class="warp-comment">
            <div class="nnt-warp-comment-class">
                <ul>
                    <?php
                    if (isset($this->nam) && $this->nam == 1) :?>
                        <li class="nnt-warl-comment-li-1">
                            <span>
                                <?php echo JText::_('COM_TZ_GUESTBOOK_AUTHOR'); ?>
                            </span>
                            <span>
                                <?php echo $rr->cname; ?>
                            </span>
                        </li>
                    <?php endif; ?>
                    <?php
                    if (isset($this->dat) && $this->dat == 1) :?>
                        <li class="nnt-warl-comment-li-2">
                            <span>
                                <?php echo JText::_('COM_TZ_GUESTBOOK_CREATE_DATE'); ?>
                            </span>
                            <span>
                                <?php echo $rr->cdate; ?>
                            </span>
                        </li>
                    <?php endif; ?>

                    <?php if ($this->category == 1 && $rr->jtitle != null): ?>
                        <li class="nnt-warl-comment-li-1">
                            <span>
                                <?php echo JText::_('COM_TZ_GUESTBOOK_CATEGORY'); ?>
                            </span>
                            <span>
                                <?php echo $rr->jtitle; ?>
                            </span>
                        </li>
                    <?php endif; ?>
                    <?php
                    if (isset($this->fweb) && $this->fweb == 1 && !empty($rr->cwebsite)) :?>
                        <li class="nnt-warl-comment-li-3">
                            <span>
                                <?php echo JText::_('COM_TZ_GUESTBOOK_WEBSITE_SITE'); ?>
                            </span>
                            <a target="_blank" href="<?php echo $rr->cwebsite; ?>" rel="nofollow">
                                <?php if (!empty($rr->cwebsite)) :
                                    echo $rr->cwebsite;
                                else :
                                    echo JText::_("COM_TZ_GUESTBOOK_NOT_WEBSITE_SITE");
                                endif;?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($rr->cpublic == 1) : ?>
                        <li class="nnt-warl-comment-li-4">
                            <span>
                                <?php echo JText::_('COM_TZ_GUESTBOOK_EMAIL'); ?>
                            </span>
                            <span>
                                <?php echo $rr->cemail; ?>
                            </span>
                        </li>
                    <?php endif; ?>

                    <?php if (isset($this->tit) && $this->tit == 1) : ?>
                        <li class="nnt-warl-comment-li-title">
                            <span>
                                <?php echo $rr->ctitle; ?>
                            </span>
                        </li>
                    <?php endif; ?>
                    <li class="nnt-warl-comment-li-comment">
                        <p>
                            <?php echo $rr->ccontent; ?>
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    <?php
    endforeach;
endif;
?>