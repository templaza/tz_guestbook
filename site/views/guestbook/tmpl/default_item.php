      <?php
			  defined("_JEXEC") or die;
              foreach($this->hienthi as $rr){
        ?>
        <div class="warp-comment">
            <div  class="nnt-warp-comment-class">
                <ul>
                <?php
                      if(isset($this->nam) && $this->nam == 1){
                 ?>
                    <li class="nnt-warl-comment-li-1">
                        <span>
                            Author
                        </span>
                        <span>
                              <?php     echo $rr->cname; ?>
                        </span>
                    </li>
                 <?php } ?>
                 <?php
                    if(isset($this->dat) && $this->dat == 1){
                 ?>
                    <li class="nnt-warl-comment-li-2">
                         <span>
                             Create Date
                         </span>
                         <span>
                                  <?php    echo $rr->cdate;    ?>
                         </span>
                     </li>
                <?php } ?>
                <?php
                    if(isset($this->fweb) && $this->fweb ==1 && !empty($rr->cwebsite)){
                ?>
                 <li class="nnt-warl-comment-li-3">
                     <span>
                         Website
                     </span>

                     <a  target="_blank" href="<?php echo $rr->cwebsite; ?>" rel="nofollow">
                             <?php
                                  if(!empty($rr->cwebsite)){
                                       echo $rr->cwebsite;
                                   }else{
                                         echo JText::_("COM_TZ_GUESTBOOK_NOT_WEBSITE_SITE");
                                    }
                                ?>
                      </a>
                </li>
                <?php   } ?>
                <?php
                    if( $rr->cpublic ==1){
                  ?>
                    <li class="nnt-warl-comment-li-4">
                        <span>
                            Email
                        </span>
                        <span>
                                <?php
                                     echo $rr->cemail;
                                 ?>
                         </span>
                    </li>
                <?php } ?>

            <?php
                 if(isset($this->tit) && $this->tit == 1){
             ?>
            <li class="nnt-warl-comment-li-title">
                <span>
                    <?php   echo $rr->ctitle; ?>
                </span>
            </li>
            <?php   } ?>
            <li class="nnt-warl-comment-li-comment">
                <p>
                      <?php echo $rr->ccontent; ?>
                </p>
            </li>
                </ul>
            </div>
        </div>
                  <?php
              }
        ?>