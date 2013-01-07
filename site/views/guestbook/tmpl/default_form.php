<?php
	  defined("_JEXEC") or die;
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

        <?PHP
        if(isset($this->hienthistatus) && $this->hienthistatus ==1){
            echo JText::_("COM_TZ_GUESTBOOK_NOTICE");
        }else{
            echo JText::_("COM_TZ_GUESTBOOK_NOTICE_2");
        }
        ?>
    </span>
</div>
<div id="warp-fom">
            <h5 id="tz-guestbook-h5">
                <span> <?php echo JText::_("COM_TZ_GUESTBOOK_SING_GUESTBOOK"); ?></span>
                 <img  id="tz-guestbook-h5-img" src="<?php echo JURI::base(true).'/components/com_tz_guestbook/images/delete2.png' ?>" />
            </h5>
           <form ACTION="" method="POST" >

               <div class="warp-in">
                    <input
                           id="warp-input1" class="conten-input" type="text" name="name" maxlength="<?php echo $this->count_name; ?>"

                           <?php
                               if(isset($this->auth->name) && $this->auth->name !="")
                               {
                                   ?>
                                       value="<?php echo $this->auth->name; ?>"
                                    <?php
                               }
                               else{
                                   ?>
                                   value="<?PHP echo JText::_("COM_TZ_GUESTBOOK_FULL_NAME"); ?>"
                                <?php
                               } ?>
                          />
                   <p class="tz_input_name" ID="pname"></p>
               </div>
               <div class="warp-in">
                    <input id="warp-input2" class="conten-input" type="text" name="email" maxlength="<?php echo $this->count_email; ?>"
                            <?php
                                if(isset($this->auth->email) && $this->auth->email !="")
                                {
                                    ?>
                                        value="<?php echo $this->auth->email; ?>"
                                     <?php
                                }
                                else{
                                    ?>
                                    value="<?PHP echo JText::_("COM_TZ_GUESTBOOK_EMAIL"); ?>"
                                 <?php
                                } ?>
                           />
                   <p class="tz_input_email" id="pemail"></p>
               </div>
			                   <?php
               if($this->tit ==1){
				?>
               <div class="warp-in">
                    <input    id="warp-input3" class="conten-input" type="text" name="title" maxlength="<?php echo $this->count_tit; ?>;" value="<?PHP echo JText::_("COM_TZ_GUESTBOOK_TITLE"); ?>">
                   <p class="tz_input_title" id="ptitle"></p>
               </div>
			  <?php } ?>
			     <?php
                 if(isset($this->fweb) && $this->fweb ==1){
               ?>
               <div class="warp-in">
                   <input     id="warp-input4" class="conten-input" type="text" name="website" maxlength="<?php echo $this->count_web; ?>;" value="<?PHP echo JText::_("COM_TZ_GUESTBOOK_WEBSITE"); ?>">
                   <p  class="tz_input_website" id="p_website"></p>
                </div>
				<?php } ?>
               <div  id="nnt_com1" class="warp-in">
                 <label  id="warp-label"><?php echo JText::_("COM_TZ_GUESTBOOK_SHOW_EMIAL_IN_PUBLIC"); ?> </label>
                  <input id="warp-check" type="checkbox" name="check" value="1">
                   <div class="clre"></div>
               </div>
               <div class="warp-in">
                    <textarea    name="conten"   id="text-ra" maxlength="<?php echo $this->count_comm; ?>;""  ><?PHP echo JText::_("COM_TZ_GUESTBOOK_YOUR_GUESTBOOK"); ?></textarea>
                   <p  class="tz_input_comment" id="p_nntconten"></p>
                   <input type="hidden" ID="checkcapcha" name="checkcapcha" value="<?php  echo $this->capchat;  ?>">


               </div>

               <?php

                    if(isset($this->capchat) and $this->capchat == 1){

               ?>
               <div class="warp-in-capchat">
                   <?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field)
                   { ?>
                   <div id="nnt-comment-label-capchat">
                       <?php echo $field->label; ?>
                   </div>
                   <div id="nnt-comment-input-capchat">
                       <?php echo $field->input; ?>
                   </div>
                   <?php } ?>


                   <div class="clearr">

                   </div>
                   <div id="nnt-comment-input-loi-capchat">
                                       <p id="nnt_p_capchar">

                                       </p>
                     </div>
               </div>
                        
                        <?php
                    }
            ?>

               <div class="warp-in2">
               <input id="warp-input-sub" type="button" name="send" value="<?php echo JText::_("COM_TZ_GUESTBOOK_SEND_GUESTBOOK"); ?>"   >

               </div>

           </form>
       </div>

        <div class="clre"></div>
</div>