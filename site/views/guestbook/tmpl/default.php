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
        $document   =   &JFactory::getDocument();
        $document->addStyleSheet('components/com_tz_guestbook/css/baiviet2.css');
        $document -> addCustomTag('<script type="text/javascript" src="components/com_tz_guestbook/js/jquery.masonry.min.js"></script>');
        $document -> addCustomTag('<script type="text/javascript" src="components/com_tz_guestbook/js/jquery.infinitescroll.min.js"></script>');

    ?>


<style type="text/css">
        .col1 {
            width: <?php echo $this->nnt_width ?>px;
        }
</style>


<script type="text/javascript">
function tz_init(defaultwidth){             // ham tinh chieu rong cua the div voi class = .warp-comment
    var contentWidth    = jQuery('#wrap-baiviet').width();
    var columnWidth     = defaultwidth;
    if(columnWidth >contentWidth ){
        columnWidth = contentWidth;
    }
    var  curColCount = Math.floor(contentWidth / columnWidth);
    var newwidth = columnWidth * curColCount;
    var newwidth2 = contentWidth - newwidth;
    var newwidth3 = newwidth2/curColCount;
    var newColWidth = Math.floor(columnWidth + newwidth3);
    jQuery('.warp-comment').css("width",newColWidth);
    jQuery('#wrap-baiviet').masonry({
    itemSelector: '.warp-comment'
    });
}
    var resizeTimer = null; // code su dung khi co gian man hinh
    jQuery(window).bind('resize', function() {
        if (resizeTimer) clearTimeout(resizeTimer);
        resizeTimer = setTimeout("tz_init("+"<?php echo $this->nnt_width; ?>)", 100);
    });
jQuery.noConflict(); // goi congig voi cac function
jQuery(document).ready(function(){
    tz_init(<?php echo $this->nnt_width ?>);
    jQuery('#nnt_comment_a1').click(function(){
    jQuery('#tz-Guestbook-warp').fadeIn();
    jQuery('#warp-fom').fadeIn();
    jQuery('#tz-guestbook-h5-img').click(function(){
    jQuery('#tz-Guestbook-warp').fadeOut();
          })
     });
// -------------------------------------------------------------
        // kiem tra from
    // kiem tra Full name
    jQuery('#warp-input1').focus(function(){
            var inpName =jQuery('#warp-input1').attr('value');
            if(inpName =="Full name"){
            jQuery('#warp-input1').attr('value','');
            }
            if(inpName !=""){
                jQuery('#warp-input1').keyup(function(){
                        var maxName = <?php echo $this->count_name; ?>;
                        var inpName =jQuery('#warp-input1').attr('value');
                        jQuery(".tz_input_name").css("display","block");
                        var pp = document.getElementById("pname");
                        var countTen =inpName.length;
                        var HieuName = maxName - countTen;
                        if(HieuName > 0){
                             pp.innerHTML="<?php echo JText::_("COM_TZ_GUESTBOOK_COUNT_TEXT_NAME"); ?>"+ HieuName;
                        }else {
                         pp.innerHTML ="<?php echo JText::_("COM_TZ_GUESTBOOK_NOT_COUNT_TEXT") ?>";
                        }
                    });
            }
    });
    jQuery('#warp-input1').blur(function(){
            var inpName =jQuery('#warp-input1').attr('value');
        jQuery(".tz_input_name").css("display","none");
            if(inpName==""){
                document.getElementById("warp-input1").value="Full name";
            }
    }); // ket thuc full name
    // kiem tra Email
    jQuery('#warp-input2').focus(function(){
            var inpEmail =jQuery('#warp-input2').attr('value');
            if(inpEmail =="Email"){
                jQuery('#warp-input2').attr('value','');
            }
            if(inpEmail !=""){
                jQuery('#warp-input2').keyup(function(){
                        var maxEmail = <?php echo $this->count_email; ?>;
                        var inpEmail =jQuery('#warp-input2').attr('value');
                        jQuery(".tz_input_email").css("display","block");
                        var ppemail = document.getElementById("pemail");
                        var countTen =inpEmail.length;
                        var HieuName = maxEmail - countTen;
                        if(HieuName > 0){
                            ppemail.innerHTML="<?php echo JText::_("COM_TZ_GUESTBOOK_COUNT_TEXT_EMAIL"); ?>"+ HieuName;
                        }else {
                            ppemail.innerHTML ="<?php echo JText::_("COM_TZ_GUESTBOOK_NOT_COUNT_TEXT") ?>";
                        }
                    });
            }
    });
    jQuery('#warp-input2').blur(function(){
            var inpName =jQuery('#warp-input2').attr('value');
             jQuery(".tz_input_email").css("display","none");
            if(inpName==""){
                document.getElementById("warp-input2").value="Email";
            }
    }); // ket thuc email
    // kiem tra title
    jQuery('#warp-input3').focus(function(){
            var inpTitle =jQuery('#warp-input3').attr('value');
            if(inpTitle =="Title"){
                jQuery('#warp-input3').attr('value','');
            }
            if(inpTitle !=""){
                jQuery('#warp-input3').keyup(function(){
                        var maxTile = <?php echo $this->count_tit; ?>;
                        var inpTitle =jQuery('#warp-input3').attr('value')
                        jQuery(".tz_input_title").css("display","block");
                        var pptitle = document.getElementById("ptitle");
                        var countTen =inpTitle.length;
                        var HieuName = maxTile - countTen;
                        if(HieuName > 0){
                            pptitle.innerHTML="<?php echo JText::_("COM_TZ_GUESTBOOK_COUNT_TEXT_TITLE"); ?>"+ HieuName;
                        }else {
                            pptitle.innerHTML ="<?php echo JText::_("COM_TZ_GUESTBOOK_NOT_COUNT_TEXT") ?>";
                        }
                    });
            }
    });
    jQuery('#warp-input3').blur(function(){
            var inpTitle =jQuery('#warp-input3').attr('value');
            jQuery(".tz_input_title").css("display","none");
            if(inpTitle==""){
                document.getElementById("warp-input3").value="Title";
            }
    }); // ket thuc title
    // kiem tra website
    jQuery('#warp-input4').focus(function(){
        var inpWeb =jQuery('#warp-input4').attr('value');
        if(inpWeb =="Your website"){
            jQuery('#warp-input4').attr('value','');
        }
        if(inpWeb !=""){
            jQuery('#warp-input4').keyup(function(){
                    var maxWeb = <?php echo $this->count_web; ?>;
                    var inpWeb =jQuery('#warp-input4').attr('value')
                    jQuery(".tz_input_website").css("display","block");
                    var ppweb = document.getElementById("p_website");
                    var countTen =inpWeb.length;
                    var HieuName = maxWeb - countTen;
                    if(HieuName > 0){
                        ppweb.innerHTML="<?php echo JText::_("COM_TZ_GUESTBOOK_COUNT_TEXT_WEBSITE"); ?>"+ HieuName;
                    }else {
                        ppweb.innerHTML ="<?php echo JText::_("COM_TZ_GUESTBOOK_NOT_COUNT_TEXT") ?>";
                    }
                });
        }
    });
    jQuery('#warp-input4').blur(function(){
            var inpWeb =jQuery('#warp-input4').attr('value');
            jQuery(".tz_input_website").css("display","none");
            if(inpWeb==""){
                document.getElementById("warp-input4").value="Your website";
            }
    }); // ket thuc website
    // kiem tra comment
    jQuery('#text-ra').focus(function(){
        var inpWeb =jQuery('#text-ra').attr('value');
        if(inpWeb =="Your guestbook..."){
            jQuery('#text-ra').attr('value','');
        }
        if(inpWeb !=""){
            jQuery('#text-ra').keyup(function(){
                    var maxWeb = <?php echo $this->count_comm; ?>;
                    var inpWeb =jQuery('#text-ra').attr('value')
                    jQuery(".tz_input_comment").css("display","block");
                    var ppweb = document.getElementById("p_nntconten");
                    var countTen =inpWeb.length;
                    var HieuName = maxWeb - countTen;
                    if(HieuName > 0){
                        ppweb.innerHTML="<?php echo JText::_("COM_TZ_GUESTBOOK_COUNT_TEXT_WEBSITE"); ?>"+ HieuName;
                    }else {
                        ppweb.innerHTML ="<?php echo JText::_("COM_TZ_GUESTBOOK_NOT_COUNT_TEXT") ?>";
                    }
                });
        }
    });
    jQuery('#text-ra').blur(function(){
            var inpWeb =jQuery('#text-ra').attr('value');
            jQuery(".tz_input_comment").css("display","none");
            if(inpWeb==""){
                document.getElementById("text-ra").value="Your guestbook...";
            }
    }); // ket thuc comment
// ket thuc kiem tra fom
//-----------------------------------------------------------------------------------------//
    // khi clich vao id la warp-input-sub thi bat dau chay jeax
    jQuery('#warp-input-sub').click(function(){
                    var ten = jQuery('#warp-input1').attr('value');
                    var loiten = jQuery('#warp-input1');
                    var pp = document.getElementById("pname");

                    var emai = jQuery('#warp-input2').attr('value');
                    var loiemi = jQuery('#warp-input2');
                    var ppemail = document.getElementById("pemail");

                    var tit = jQuery('#warp-input3').attr('value');
                    var loitit = jQuery('#warp-input3');
                    var ptitle = document.getElementById("ptitle");

                    var noid = jQuery('#text-ra').attr('value');
                    var loinoid =jQuery('#text-ra');
                    var p_nntconten = document.getElementById("p_nntconten");

                    var websi = jQuery('#warp-input4').attr('value');
                    var loiwebsite = jQuery('#warp-input4');
                    var p_website = document.getElementById("p_website");

                     var str2 = /^([a-zA-Z0-9_\.])+\@([a-zA-Z0-9]{2,4})+\.([a-zA-Z]{2,4})([a-z-A-Z\.]{2,4})?$/;
                    var srt3 =/^http(s)?:\/\/(www\.)?([a-zA-Z0-9\_])+\.([a-zA-Z0-9\/]{1,5})+(\.[A-Za-z0-9\/]{1,4})?([a-zA-Z0-9\/\.&=_\+\#\-\?]*)?$/


                    if( ten ==""){
                                    jQuery(".tz_input_name").css("display","block");
                                     pp.innerHTML="<?PHP echo JText::_("COM_TZ_GUESTBOOK_YOU_NOT_BE_EMPTY"); ?>";
                                    loiten.focus();
                                    return false;
                    }else if(ten == 'Full name'){
                                     jQuery(".tz_input_name").css("display","block");
                                     pp.innerHTML="<?php echo JText::_("COM_TZ_GUESTBOOK_YOU_HAVE_NOT_ENTERED_FULL_NAME"); ?>";
                                        loiten.focus();
                                         return false;
                                    }
                    if( emai ==""){
                                    jQuery(".tz_input_email").css("display","block");
                                     ppemail.innerHTML="<?php echo JText::_("COM_TZ_GUESTBOOK_YOU_NOT_BE_EMPTY"); ?>";
                                     loiemi.focus();
                                     return false;
                    }else if(str2.test(emai) == false){
                                    jQuery(".tz_input_email").css("display","block");
                                    ppemail.innerHTML="<?php echo JText::_("COM_TZ_GUESTBOOK_EMAIL_IS_INVALID"); ?>";
                                     loiemi.focus();
                                    return false;
                    }
					   <?php
            if($this->tit ==1){
        ?>
               if( tit ==""){
                                        jQuery(".tz_input_title").css("display","block");
                                        ptitle.innerHTML="<?php echo JText::_("COM_TZ_GUESTBOOK_YOU_NOT_BE_EMPTY"); ?>";
                                        loitit.focus();
                                        return false;
                    }else if(tit == 'Title'){
                   jQuery(".tz_input_title").css("display","block");
                            ptitle.innerHTML="<?PHP echo JText::_("COM_TZ_GUESTBOOK_YOU_HAVE_NOT_ENTERED_TITLE"); ?>";
                             loitit.focus();
                           return false;
                    }
		<?php } ?>
			 <?php
					  if(isset($this->fweb) && $this->fweb ==1 ){
					?>
                if(websi !="" && websi != "Your website"){
                    if(srt3.test(websi) == false){
                        jQuery(".tz_input_website").css("display","block");
                        p_website.innerHTML="<?php echo JText::_("COM_TZ_GUESTBOOK_WEBSITE_IS_INVALID"); ?>";
                        loiwebsite.focus();
                        return false;
                    }
                }
			<?php } ?>
               if( noid ==""){
                   jQuery(".tz_input_comment").css("display","block");
                                p_nntconten.innerHTML="<?php echo JText::_("COM_TZ_GUESTBOOK_YOU_NOT_BE_EMPTY"); ?>";
                                         loinoid.focus();
                                          return false;
                     }else if(noid == 'Your guestbook...'){
                   jQuery(".tz_input_comment").css("display","block");
                                        p_nntconten.innerHTML="<?PHP echo JText::_("COM_TZ_GUESTBOOK_CONTENT"); ?>";
                                           loinoid.focus();
                                           return false;
                                  }
                    var a = jQuery('#warp-check'); // lay ve input = checkboxx
                    var b = 0; // khoi tao bien ban dau =0
                    if(a.attr('checked')){ // kiem tra xem nguoi dung da check hay chua
                        b = (a.attr('value')); // neu check thj gan = gja tri cua checkbox do con khong gan  b= 0
                    }
                    jQuery.ajax({
                        url: 'index.php?option=com_tz_guestbook&view=guestbook&task=add&Itemid=<?php echo JRequest::getVar('Itemid'); ?>',
                        type: 'post',
                        data:{
                            name: jQuery('#warp-input1').attr('value'),
                            email: jQuery('#warp-input2').attr('value'),
                            title: jQuery('#warp-input3').attr('value'),
                            website: jQuery("#warp-input4").attr('value'),
                            content:jQuery('#text-ra').attr('value'),
                            recaptcha_response_field: jQuery('#recaptcha_response_field').attr('value'),
                            recaptcha_challenge_field: jQuery('#recaptcha_challenge_field').attr('value'),
                            check:b
                        }
                    }).success(function(data){

                                var checkcapta = jQuery('#checkcapcha').attr('value');

                                if(checkcapta == 1){
                                javascript:Recaptcha.reload();
                                }

                                var statuss = <?php echo $this->hienthistatus; ?>;


                               if(statuss ==1){

                                    jQuery('#wrap-baiviet').prepend( jQuery(data) ).masonry( 'reload' );

                                    tz_init(<?php echo $this->nnt_width ?>);
                               }
                                if(data ==1){
                                jQuery("#nnt-comment-input-loi-capchat").slideDown();
                                jQuery("#nnt-comment-input-loi-capchat").animate({
                                                                 "opacity":"hide"
                                                             },3000);
                                document.getElementById("nnt_p_capchar").innerHTML=" <?php echo JText::_("COM_TZ_GUESTBOOK_YOU_ENTER_THE_WRONG_CAPTCHA"); ?>";
                                }
                               if(data != 1){

                                        jQuery('#warp-input3').attr('value','<?php echo JText::_("COM_TZ_GUESTBOOK_TITLE"); ?>');
                                        jQuery('#text-ra').attr('value','<?PHP echo JText::_("COM_TZ_GUESTBOOK_YOUR_GUESTBOOK"); ?>');
                                        jQuery('#warp-fom').hide();
                                        jQuery('#tz-Guestbook-seccess').slideDown(1200);
                                         jQuery("#tz-Guestbook-seccess").animate({
                                                                "opacity":"hide"
                                                               },<?php echo $this->tim_thongbao; ?>,function(){
                                             jQuery('#tz-Guestbook-warp').fadeOut();
                                         });

                                }
                            });
                });
            });
        </script>
        <div id="nguyenngoctu">

<?php
    echo $this -> loadTemplate('form');
?>
<div id="wrap-baiviet" class="transitions-enabled clearfix">
    <?php
        echo  $this -> loadTemplate('item');
     ?>
    <div class="clearr"></div>
</div>
<?php
    if($this->conajx == 0){ // neu nguoi dung chon kieu phan trang =0 thi hien thi phan trang  default cua joomla
    $phantrang_Default = $this -> pagination -> getPagesLinks(); // goi ham phan trang roi gan vao bien

    if(isset($phantrang_Default) && !empty($phantrang_Default)){ // kiem tra xem bien co ton tai hay k neu ton tai thi goi ham phan trang default cua jooomla
  ?>

    <div class="pagination pagination-toolbar ">
        <?php echo $this -> pagination -> getPagesLinks();?>
     </div>

    <?php
        }
      }
       else { // // neu khong chon phan trang de fault, kiem tra xem du lieu co khong neu du lieu > 0 thi hien thi
 ?>
<div id="tz_append">
        <?php
    if($this->conajx == 1){ // neu nguoi dung chon =1 thj phan trang theo buttom
        ?>
    <a class="btn btn-large-tz" id="tz_append-a"  href="#tz_append"><?php echo JText::_("COM_TZ_GUESTBOOK_ADD_ITEMS"); ?></a>
        <p  class="btn btn-large-tz"><?php echo JText::_("COM_TZ_GUESTBOOK_NO_ITEMS"); ?></p>
    <?php
    }
     ?>

</div>
<div id="loadaj" style="display: none;">
    <a href="<?php echo JURI::root().'index.php?option=com_tz_guestbook&view=guestbook&task=add.ajax&page=2&Itemid='.JRequest::getInt('Itemid'); ?>">
    </a>
</div>

<script type="text/javascript">
        var   $container = jQuery('#wrap-baiviet') ;
        $container.infinitescroll({ // bat dau tu dau lay du lieu
                navSelector  : '#loadaj a',    // selector for the paged navigation
                nextSelector : '#loadaj a:first',  // selector for the NEXT link (to page 2)
                itemSelector : '.warp-comment',     // selector for all items you'll retrieve
                errorCallback: function(){
                      <?php if($this->conajx == 1):?> // lua chon kieu chay phan trang ajzca
                        jQuery('#tz_append a').hide();
                        jQuery('#tz_append p').show(1200);
                      <?php endif;?>
                      <?php if($this->conajx == 2):?>
                        jQuery('#tz_append').removeAttr('style').html('<a id="tz_append-a"  class="btn btn-large-tz"><?php echo JText::_('COM_TZ_GUESTBOOK_NO_ITEMS');?></a>');
                      <?php endif;?>

                },
                loading: { // khi load du lieu xuat hien hin
                    msgText: "<em><?php echo JText::_("COM_TZ_GUESTBOOK_LOADING"); ?></em>",
                    finishedMsg: '',
                    img:'<?php echo JURI::root();?>components/com_tz_guestbook/images/ajax-loader.gif',
                    selector: '#tz_append'
                  }
                },
        function( newElements ){ // khi loaod xong du lieu tra ve bien newElemnts
            if(newElements.length){
                var arrganerme_gustbooks = <?php echo $this->arrganerme_gustbook; ?>;
                if(arrganerme_gustbooks == 0){
               // jQuery('#wrap-baiviet').append( jQuery(newElements) ).masonry( 'reload' );// chay msony
                jQuery('#wrap-baiviet').append( jQuery(newElements) ).masonry( 'appended',jQuery(newElements),true );// chay msony
                }else{
                    jQuery('#wrap-baiviet').prepend( jQuery(newElements) ).masonry( 'reload' );
                }
                tz_init(<?php echo $this->nnt_width ?>);

                jQuery('div#tz_append').find('a:first').show();
            }

        });
        <?php if($this->conajx == 1){?> //chon kieu chay ajxac buttom
            jQuery(window).unbind('.infscr');
            jQuery('#tz_append >a').click(function(){
            jQuery(this).stop();
            jQuery('div#tz_append').find('a:first').hide(); // khi click thj cho an dj
            $container.infinitescroll('retrieve');
        })<?php }?>

</script>
    <?php
        }
    ?>
        </div>