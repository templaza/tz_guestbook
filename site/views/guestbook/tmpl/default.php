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
$document->addStyleSheet('components/com_tz_guestbook/css/baiviet2.css');
$p  = $this->params;
if($p->get('loadjQuery',1)){
    $document->addScript('components/com_tz_guestbook/js/jquery-1.8.2.min.js');
}
$document->addCustomTag('<script type="text/javascript" src="components/com_tz_guestbook/js/jquery.masonry.min.js"></script>');
$document->addCustomTag('<script type="text/javascript" src="components/com_tz_guestbook/js/jquery.infinitescroll.min.js"></script>');
?>


<style type="text/css">
    .col1 {
        width: <?php echo $this->nnt_width ?>px;
    }
</style>


<script type="text/javascript">
function tz_init(defaultwidth) {
    var contentWidth = jQuery('#wrap-baiviet').width();
    var columnWidth = defaultwidth;
    if (columnWidth > contentWidth) {
        columnWidth = contentWidth;
    }
    var curColCount = Math.floor(contentWidth / columnWidth);
    var newwidth = columnWidth * curColCount;
    var newwidth2 = contentWidth - newwidth;
    var newwidth3 = newwidth2 / curColCount;
    var newColWidth = Math.floor(columnWidth + newwidth3);
    jQuery('.warp-comment').css("width", newColWidth);
    jQuery('#wrap-baiviet').masonry({
        itemSelector: '.warp-comment'
    });
}
var resizeTimer = null;
jQuery(window).bind('resize', function () {
    if (resizeTimer) clearTimeout(resizeTimer);
    resizeTimer = setTimeout("tz_init(" + "<?php echo $this->nnt_width; ?>)", 100);
});
jQuery.noConflict();

jQuery(document).ready(function () {
    tz_init(<?php echo $this->nnt_width ?>);
    jQuery('#nnt_comment_a1').click(function () {
        jQuery('#tz-Guestbook-warp').fadeIn();
        jQuery('#warp-fom').fadeIn();
        jQuery('#tz-guestbook-h5-img').click(function () {
            jQuery('#tz-Guestbook-warp').fadeOut();
        });
    });
    // -------------------------------------------------------------
    // check full name
    jQuery('#warp-input1').focus(function () {

        var inpName = jQuery('#warp-input1').val();

        if (inpName == "Full name" || inpName == "") {
            jQuery('#warp-input1').val('');
        }
        if (inpName != "") {
            jQuery('#warp-input1').keyup(function () {
                var maxName = <?php echo $this->count_name; ?>;
                var inpName = jQuery('#warp-input1').attr('value');
                jQuery(".tz_input_name").css("display", "block");
                var pp = document.getElementById("pname");
                var countTen = inpName.length;
                var HieuName = maxName - countTen;
                if (HieuName > 0) {
                    pp.innerHTML = "<?php echo JText::_("COM_TZ_GUESTBOOK_COUNT_TEXT_NAME"); ?>" + HieuName;
                } else {
                    pp.innerHTML = "<?php echo JText::_("COM_TZ_GUESTBOOK_NOT_COUNT_TEXT") ?>";
                }
            });
        }
    });

    jQuery('#warp-input1').blur(function () {
        var inpName = jQuery('#warp-input1').val();
        jQuery(".tz_input_name").css("display", "none");
        if (inpName == "") {
            document.getElementById("warp-input1").value = "Full name";
        }
    }); // end full name

    // check email
    jQuery('#warp-input2').focus(function () {
        var inpEmail = jQuery('#warp-input2').val();
        if (inpEmail == "Email" || inpEmail == "") {
            jQuery('#warp-input2').val('');
        }
        if (inpEmail != "") {
            jQuery('#warp-input2').keyup(function () {
                var maxEmail = <?php echo $this->count_email; ?>;
                var inpEmail = jQuery('#warp-input2').attr('value');
                jQuery(".tz_input_email").css("display", "block");
                var ppemail = document.getElementById("pemail");
                var countTen = inpEmail.length;
                var HieuName = maxEmail - countTen;
                if (HieuName > 0) {
                    ppemail.innerHTML = "<?php echo JText::_("COM_TZ_GUESTBOOK_COUNT_TEXT_EMAIL"); ?>" + HieuName;
                } else {
                    ppemail.innerHTML = "<?php echo JText::_("COM_TZ_GUESTBOOK_NOT_COUNT_TEXT") ?>";
                }
            });
        }
    });

    jQuery('#warp-input2').blur(function () {

        var inpName = jQuery('#warp-input2').val();

        jQuery(".tz_input_email").css("display", "none");
        if (inpName == "") {
            document.getElementById("warp-input2").value = "Email";
        }
    }); // end email

    // check title
    jQuery('#warp-input3').focus(function () {
        var inpTitle = jQuery('#warp-input3').val();
        if (inpTitle == "Title" || inpTitle == "") {
            jQuery('#warp-input3').val('');
        }
        if (inpTitle != "") {
            jQuery('#warp-input3').keyup(function () {
                var maxTile =  <?php echo $this->count_tit; ?>;
                var inpTitle = jQuery('#warp-input3').attr('value')
                jQuery(".tz_input_title").css("display", "block");
                var pptitle = document.getElementById("ptitle");
                var countTen = inpTitle.length;
                var HieuName = maxTile - countTen;
                if (HieuName > 0) {
                    pptitle.innerHTML = "<?php echo JText::_("COM_TZ_GUESTBOOK_COUNT_TEXT_TITLE"); ?>" + HieuName;
                } else {
                    pptitle.innerHTML = "<?php echo JText::_("COM_TZ_GUESTBOOK_NOT_COUNT_TEXT") ?>";
                }
            });
        }
    });

    jQuery('#warp-input3').blur(function () {
        var inpTitle = jQuery('#warp-input3').val();
        jQuery(".tz_input_title").css("display", "none");
        if (inpTitle == "") {
            document.getElementById("warp-input3").value = "Title";
        }
    }); // end title

    // end website
    jQuery('#warp-input4').focus(function () {
        var inpWeb = jQuery('#warp-input4').val();
        if (inpWeb == "Your website" || inpWeb == "") {
            jQuery('#warp-input4').val('');
        }
        if (inpWeb != "") {
            jQuery('#warp-input4').keyup(function () {
                var maxWeb = <?php echo $this->count_web; ?>;
                var inpWeb = jQuery('#warp-input4').attr('value')
                jQuery(".tz_input_website").css("display", "block");
                var ppweb = document.getElementById("p_website");
                var countTen = inpWeb.length;
                var HieuName = maxWeb - countTen;
                if (HieuName > 0) {
                    ppweb.innerHTML = "<?php echo JText::_("COM_TZ_GUESTBOOK_COUNT_TEXT_WEBSITE"); ?>" + HieuName;
                } else {
                    ppweb.innerHTML = "<?php echo JText::_("COM_TZ_GUESTBOOK_NOT_COUNT_TEXT") ?>";
                }
            });
        }
    });
    jQuery('#warp-input4').blur(function () {
        var inpWeb = jQuery('#warp-input4').val();
        jQuery(".tz_input_website").css("display", "none");
        if (inpWeb == "") {
            document.getElementById("warp-input4").value = "Your website";
        }
    }); // end website

    // check comment
    jQuery('#text-ra').focus(function () {
        var inpWeb = jQuery('#text-ra').val();
        if (inpWeb == "Your guestbook..." || inpWeb == "") {
            jQuery('#text-ra').val('');
        }
        if (inpWeb != "") {
            jQuery('#text-ra').keyup(function () {
                var maxWeb = <?php echo $this->count_comm; ?>;
                var inpWeb = jQuery('#text-ra').val();
                jQuery(".tz_input_comment").css("display", "block");
                var ppweb = document.getElementById("p_nntconten");
                var countTen = inpWeb.length;
                var HieuName = maxWeb - countTen;
                if (HieuName > 0) {
                    ppweb.innerHTML = "<?php echo JText::_("COM_TZ_GUESTBOOK_COUNT_TEXT_WEBSITE"); ?>" + HieuName;
                } else {
                    ppweb.innerHTML = "<?php echo JText::_("COM_TZ_GUESTBOOK_NOT_COUNT_TEXT") ?>";
                }
            });
        }
    });

    jQuery('#text-ra').blur(function () {
        var inpWeb = jQuery('#text-ra').val();
        jQuery(".tz_input_comment").css("display", "none");
        if (inpWeb == "") {
            document.getElementById("text-ra").value = "Your guestbook...";
        }
    }); // end comment
    // end fom
    jQuery('#jform_mycategory').blur(function () {
        var scate = jQuery('#jform_mycategory').val();
        if (scate != 0) {
            jQuery('#s_category').hide();
        }

    });
    //-----------------------------------------------------------------------------------------//

    jQuery('#warp-input-sub').click(function () {
        var subname = jQuery('#warp-input1').val();
        var erroname = jQuery('#warp-input1');
        var pp = document.getElementById("pname");

        var subemail = jQuery('#warp-input2').val();
        var erroemail = jQuery('#warp-input2');
        var ppemail = document.getElementById("pemail");

        var subtitle = jQuery('#warp-input3').val();
        var errotitle = jQuery('#warp-input3');
        var ptitle = document.getElementById("ptitle");

        var subcontent = jQuery('#text-ra').val();
        var errocontent = jQuery('#text-ra');
        var p_nntconten = document.getElementById("p_nntconten");

        var websi = jQuery('#warp-input4').val();
        var loiwebsite = jQuery('#warp-input4');
        var p_website = document.getElementById("p_website");

        var scate = jQuery('#jform_mycategory').val();
        var l_cate = jQuery('#jform_mycategory');
        var p_cate = document.getElementById("s_category");

        var str2 = /^([a-zA-Z0-9_\.\-])+\@([a-zA-Z0-9_\-])+\.([a-zA-Z]{2,4})([a-z-A-Z\.]{2,4})?$/;
        var srt3 = /^http(s)?:\/\/(www\.)?([a-zA-Z0-9_\_\-])+\.([a-zA-Z0-9\/]{1,5})+(\.[A-Za-z0-9\/]{1,4})?([a-zA-Z0-9\/\.&=_\+\#\-\?]*)?$/

        if (scate == 0) {
            jQuery('.tz_input_category').css("display", "block");
            p_cate.innerHTML = "<?php echo JText::_('COM_TZ_GUESTBOOK_MUST_BE_CHOOSE_CATEGORY');?>";
            l_cate.focus();
            return false;
        }
        if (subname == "") {
            jQuery(".tz_input_name").css("display", "block");
            pp.innerHTML = "<?PHP echo JText::_("COM_TZ_GUESTBOOK_YOU_NOT_BE_EMPTY"); ?>";
            erroname.focus();
            return false;
        } else if (subname == 'Full name') {
            jQuery(".tz_input_name").css("display", "block");
            pp.innerHTML = "<?php echo JText::_("COM_TZ_GUESTBOOK_YOU_HAVE_NOT_ENTERED_FULL_NAME"); ?>";
            erroname.focus();
            return false;
        }
        if (subemail == "") {
            jQuery(".tz_input_email").css("display", "block");
            ppemail.innerHTML = "<?php echo JText::_("COM_TZ_GUESTBOOK_YOU_NOT_BE_EMPTY"); ?>";
            erroemail.focus();
            return false;
        } else if (str2.test(subemail) == false) {
            jQuery(".tz_input_email").css("display", "block");
            ppemail.innerHTML = "<?php echo JText::_("COM_TZ_GUESTBOOK_EMAIL_IS_INVALID"); ?>";
            erroemail.focus();
            return false;
        }
        <?php if($this->tit ==1):?>
        if (subtitle == "") {
            jQuery(".tz_input_title").css("display", "block");
            ptitle.innerHTML = "<?php echo JText::_("COM_TZ_GUESTBOOK_YOU_NOT_BE_EMPTY"); ?>";
            errotitle.focus();
            return false;
        } else if (subtitle == 'Title') {
            jQuery(".tz_input_title").css("display", "block");
            ptitle.innerHTML = "<?PHP echo JText::_("COM_TZ_GUESTBOOK_YOU_HAVE_NOT_ENTERED_TITLE"); ?>";
            errotitle.focus();
            return false;
        }
        <?php endif; ?>
        <?php if(isset($this->fweb) && $this->fweb ==1 ):?>
        if (websi != "" && websi != "Your website") {
            if (srt3.test(websi) == false) {
                jQuery(".tz_input_website").css("display", "block");
                p_website.innerHTML = "<?php echo JText::_("COM_TZ_GUESTBOOK_WEBSITE_IS_INVALID"); ?>";
                loiwebsite.focus();
                return false;
            }
        }
        <?php endif; ?>
        if (subcontent == "") {
            jQuery(".tz_input_comment").css("display", "block");
            p_nntconten.innerHTML = "<?php echo JText::_("COM_TZ_GUESTBOOK_YOU_NOT_BE_EMPTY"); ?>";
            errocontent.focus();
            return false;
        } else if (subcontent == 'Your guestbook...') {
            jQuery(".tz_input_comment").css("display", "block");
            p_nntconten.innerHTML = "<?PHP echo JText::_("COM_TZ_GUESTBOOK_CONTENT"); ?>";
            errocontent.focus();
            return false;
        }
        var data_input = jQuery('#warp-check');
        var inp = 0;
        if (data_input.attr('checked')) {
            inp = (data_input.attr('value'));
        }
        var $tzname = jQuery('#warp-input1').val();
        var $email = jQuery('#warp-input2').val();
        var $title = jQuery('#warp-input3').val();
        var $website = jQuery('#warp-input4').val();
        var $content = jQuery('#text-ra').val();
        var $category = jQuery('#jform_mycategory').val();
        var $response = jQuery('#recaptcha_response_field').val();
        var $challenge = jQuery('#recaptcha_challenge_field').val();

        jQuery.ajax({
            url: 'index.php?option=com_tz_guestbook&view=guestbook&task=add&Itemid=<?php echo JRequest::getVar('Itemid'); ?>',
            type: 'post',
            data: {
                name: $tzname,
                email: $email,
                title: $title,
                website: $website,
                content: $content,
                category: $category,
                "<?php echo JSession::getFormToken(); ?>": 1,
                recaptcha_response_field: $response,
                recaptcha_challenge_field: $challenge,
                check: inp
            }
        }).success(function (data) {
                if (!jQuery.isNumeric(data)) {
                    data = jQuery.parseHTML(data);
                }
                var checkcapta = jQuery('#checkcapcha').attr('value');
                if (checkcapta == 1) {
                }
                var statuss = <?php echo $this->hstatus; ?>;
                if (statuss == 1) {
                    jQuery('#wrap-baiviet').prepend(jQuery(data)).masonry('reload');
                    tz_init(<?php echo $this->nnt_width ?>);
                }
                if (data == 1) {
                    jQuery("#nnt-comment-input-loi-capchat").slideDown();
                    jQuery("#nnt-comment-input-loi-capchat").animate({
                        "opacity": "hide"
                    }, 3000);
                    document.getElementById("nnt_p_capchar").innerHTML = " <?php echo JText::_("COM_TZ_GUESTBOOK_YOU_ENTER_THE_WRONG_CAPTCHA"); ?>";
                }
                if (!jQuery.isNumeric(data)) {

                    jQuery('#warp-input3').attr('value', '<?php echo JText::_("COM_TZ_GUESTBOOK_TITLE"); ?>');
                    jQuery('#text-ra').attr('value', '<?PHP echo JText::_("COM_TZ_GUESTBOOK_YOUR_GUESTBOOK"); ?>');
                    jQuery('#warp-fom').hide();
                    jQuery('#tz-Guestbook-seccess').slideDown(1200);
                    jQuery("#tz-Guestbook-seccess").animate({
                        "opacity": "hide"
                    }, <?php echo $this->time_notice; ?>, function () {
                        jQuery('#tz-Guestbook-warp').fadeOut();
                    });
                }
                else {
                    if (data == '2') {
                        var nameHTML = jQuery('.tz_input_name');
                        var name_focus = jQuery('.tz_check_name');
                        nameHTML.css("display", "block");
                        pp.innerHTML = '<?php echo JText::_('COM_TZ_GUESTBOOK_ERROR_NAME');?>';
                        name_focus.focus();
                    }
                    if (data == '3') {
                        var emailHTML = jQuery('.tz_input_email');
                        var email_focus = jQuery('.tz_check_email');
                        emailHTML.css("display", "block");
                        ppemail.innerHTML = '<?php echo JText::_('COM_TZ_GUESTBOOK_ERROR_EMAIL');?>';
                        email_focus.focus();
                    }
                    if (data == '4') {
                        var titleHTML = jQuery('.tz_input_title');
                        var title_focus  = jQuery('.tz_check_title');
                        titleHTML.css("display", "block");
                        ptitle.innerHTML = '<?php echo JText::_('COM_TZ_GUESTBOOK_ERROR_TITLE');?>';
                        title_focus.focus();
                    }
                    if (data == '5') {
                        var messageHTML = jQuery('.tz_input_comment');
                        messageHTML.css("display", "block");
                        p_nntconten.innerHTML = '<?php echo JText::_('COM_TZ_GUESTBOOK_ERROR_COMMENT');?>';
                        messageHTML.focus();
                    }
                    if (data == '6') {
                        var websiteHTML = jQuery('.tz_input_website');
                        var website_focus = jQuery('.tz_check_website');
                        websiteHTML.css("display", "block");
                        p_website.innerHTML = '<?php echo JText::_('COM_TZ_GUESTBOOK_ERROR_WEBSITE');?>';
                        website_focus.focus();
                    }
                }
            });
    });
});
</script>

<div id="TZGuestBook">
    <?php

    echo $this->loadTemplate('form'); ?>
    <div id="wrap-baiviet" class="transitions-enabled clearfix">
        <?php echo $this->loadTemplate('item'); ?>
        <div class="clearr"></div>
    </div>
    <?php
    if ($this->conajx == 0) :
        $paging_Default = $this->pagination->getPagesLinks();
    if (isset($paging_Default) && !empty($paging_Default)) : ?>
        <div class="pagination pagination-toolbar ">
            <?php echo $this->pagination->getPagesLinks(); ?>
        </div>
    <?php  endif;
    else : ?>

        <div id="tz_append">
            <?php if ($this->conajx == 1) : ?>
                <a class="btn btn-large-tz" id="tz_append-a"
                   href="#tz_append"><?php echo JText::_("COM_TZ_GUESTBOOK_ADD_ITEMS"); ?></a>

                <p class="btn btn-large-tz"><?php echo JText::_("COM_TZ_GUESTBOOK_NO_ITEMS"); ?></p>
            <?php endif; ?>
        </div>

        <div id="loadaj" style="display: none;">
            <a href="<?php echo JURI::root() . 'index.php?option=com_tz_guestbook&view=guestbook&task=add.ajax&page=2&id=' . JRequest::getVar('id') . '&Itemid=' . JRequest::getInt('Itemid'); ?>">
            </a>
        </div>

        <script type="text/javascript">
            var $container = jQuery('#wrap-baiviet');
            $container.infinitescroll({
                    navSelector: '#loadaj a',
                    nextSelector: '#loadaj a:first',
                    itemSelector: '.warp-comment',
                    errorCallback: function () {
                        <?php if($this->conajx == 1):?>
                        jQuery('#tz_append a').hide();
                        jQuery('#tz_append p').show(1200);
                        <?php endif;?>
                        <?php if($this->conajx == 2):?>
                        jQuery('#tz_append').removeAttr('style').html('<a id="tz_append-a"  class="btn btn-large-tz"><?php echo JText::_('COM_TZ_GUESTBOOK_NO_ITEMS');?></a>');

                        <?php endif;?>
                    },
                    loading: {
                        msgText: "<em><?php echo JText::_("COM_TZ_GUESTBOOK_LOADING"); ?></em>",
                        finishedMsg: '',
                        img: '<?php echo JURI::root();?>components/com_tz_guestbook/images/ajax-loader.gif',
                        selector: '#tz_append'
                    }
                },
                function (newElements) {

                    if (newElements.length) {
                        var arrganerme_gustbooks = <?php echo $this->arrganerme_gustbook; ?>;
                        if (arrganerme_gustbooks == 0) {
                            jQuery('#wrap-baiviet').append(jQuery(newElements)).masonry('appended', jQuery(newElements), true);
                        } else {
                            jQuery('#wrap-baiviet').prepend(jQuery(newElements)).masonry('reload');
                        }
                        tz_init(<?php echo $this->nnt_width ?>);
                        jQuery('div#tz_append').find('a:first').show();
                    }
                });

            <?php if($this->conajx == 1):?>

            jQuery(window).unbind('.infscr');
            jQuery('#tz_append >a').click(function () {
                jQuery(this).stop();
                jQuery('div#tz_append').find('a:first').hide();
                $container.infinitescroll('retrieve');
            });
            <?php endif; ?>
        </script>
    <?php endif; ?>
</div>