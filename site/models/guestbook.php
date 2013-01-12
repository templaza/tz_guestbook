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
    jimport('joomla.application.component.modelform');
    jimport('joomla.html.pagination'); // phan trang
    class Tz_guestbookModelGuestbook extends JModelForm{
        function populateState(){
            $app    = &JFactory::getApplication('site');
            $params = $app -> getParams();
            $this -> setState('params',$params);
            $hienthi_status = $params->get('shownow'); // lay ve gia tri admin comfig hien thi comment theo gia tri nao
            $showcapcha = $params->get('showcaptchat');
            $congiajax = $params->get('congiajax'); // lay ve xem admin comfig phan trang theo dang nao
            $limit_row = $params -> get('rows_ts'); // lay ve xem nguoi dung comfig bao nhieu ban ghi de phan trang
            $this->setState('conf',$congiajax); // gan gia tri vao bien conf
            $this->setState('showcap',$showcapcha);
            $this->setState('hienthi_stu',$hienthi_status); // gan gia tri vao hien hienthi_stu
            $this->setState('limitt',$limit_row); // gan so luong nguoi dung comfig vao bien limitt
            $limit_start =JRequest::getCmd('limitstart'); // lay gia tri neu dung phan trang binh thuong
            $this->setState('offset',$limit_start); // gan gia tri vao bien offset
        }
        function getForm($data = array(), $loadData = true){
                    $form = $this->loadForm('com_tz_guestbook.guestbook', 'guestbook', array('control' => 'jform', 'load_data' => $loadData));
                    		if (empty($form)) {
                    			return false;
                    		}

                    		return $form;

                }
        public function getCaptcha()
                	{
                    $showcap = $this->getState('showcap');


                        if($showcap == 1){

                        $dispatcher	= JDispatcher::getInstance();
                                JPluginHelper::importPlugin('captcha');
                                $a =$dispatcher->trigger('onCheckAnswer');
                            $b = $a[0];
                        if($b == false){
                            $b = 0;
                        }else{
                            $b =1;
                        }
                        }else{
                            $b =2;
                        }
                        return $b;

            }
        function getInsertcontent(){
		        if (!isset($_SERVER['HTTP_REFERER'])) return null;
             $refer  =   $_SERVER['HTTP_REFERER'];
            $url_arr=   parse_url($refer);

            if ($_SERVER['HTTP_HOST'] != $url_arr['host']) return null;

            $hienthik = $this->getState('hienthi_stu'); // cho admin cogfig co hien thi bai hay k

            $check_name = strip_tags(htmlspecialchars($_POST['name']));
            $name = $check_name;
            $email = $_POST['email'];
            $check_title = strip_tags(htmlspecialchars($_POST['title']));
            $title =  $check_title ;
            $website = $_POST['website'];
            switch($website){
                case'Your website':
                    $website="";
                    break;
                default:
                    $website=$_POST['website'];
                    break;
            }
 
             $check_content = strip_tags(htmlspecialchars($_POST['content']));

            $conten = $check_content;
            $puli = $_POST['check'];
            $datetim = JFactory::getDate();
             $datee = $datetim ->toSql();
            $user   = JFactory::getUser();
            $id =$user->id;
            if(isset($name) && !empty($name) && isset($email) && !empty($email)   && isset($conten) && !empty($conten)) {

            $db = &JFactory::getDbo();
            $sql='INSERT INTO #__comment values(null,"'.$name.'","'.$email.'","'.$title.'","'.$conten.'",
                                                "'.$puli.'","'.$datee.'","'.$hienthik.'","'.$website.'","'.$id.'")';

            $db->setQuery($sql);
            $num_row = $db->query();
            $row = $db->getAffectedRows($num_row);
            return $row;

            }
        }
        function getList(){
            $lay_ou = $this->getState('conf'); // lay gia tri option cofig loai phan trang nao
            $hienthik = $this->getState('hienthi_stu'); // cho admin cogfig co hien thi bai hay k
            $limit = $this->getState('limitt'); // lay gia tri limitt// lay gia tri nguoi dung nhap vao de phan trang

            $limitstart = $this->getState('offset'); /*lay gia tri offset ban dau khi chua chay axjac no se mac dinh
                                                       gia tri bien offset cua ham popus khi chay axjac no se lay gia tri ham loadajxav*/

            $db=&JFactory::getDbo();
           $sql = "SELECT c.name AS cname,  c.email AS cemail,  c.title AS ctitle, c.content AS ccontent,  c.public AS cpublic,
                                   c.date AS cdate, c.status AS cstatus, u.name AS uname, c.website as cwebsite
                     FROM #__users AS u RIGHT JOIN #__comment AS c ON c.id_us  = u.id
                     where c.status =1 order  by c.date desc";
            $sql2 = "SELECT c.name AS cname,  c.email AS cemail,  c.title AS ctitle, c.content AS ccontent,  c.public AS cpublic,
                                               c.date AS cdate, c.status AS cstatus, u.name AS uname, c.website as cwebsite
                                 FROM #__users AS u RIGHT JOIN #__comment AS c ON c.id_us  = u.id
                                 where c.status =1 order  by c.date desc ";

            $db->setQuery($sql);
            $tinh = $db->query();

            $total = $db->getNumRows($tinh);  // ham tra ve so dong bi anh huong boi cau lenh select


            $this -> pagNav         = new JPagination($total,$limitstart,$limit); // tao mot doi tuog moi de phan trang
            if($lay_ou == '0'){ // kiem tra xem nguoi dung chon kieu phan trang nao
                 $db->setQuery($sql2,$this -> pagNav -> limitstart,$this -> pagNav -> limit); //  thuc hien cau lenh select voi dk
            }else{
                $db -> setQuery($sql2,$limitstart,$limit);
            }

           $row = $db->loadObjectList();


            return $row;
        }
        function getList2(){




                    $db=&JFactory::getDbo();

                    $sql = "SELECT c.name AS cname,  c.email AS cemail,  c.title AS ctitle, c.content AS ccontent,  c.public AS cpublic,
                                                       c.date AS cdate, c.status AS cstatus, u.name AS uname, c.website as cwebsite
                                         FROM #__users AS u RIGHT JOIN #__comment AS c ON c.id_us  = u.id
                                         where c.status =1 order  by c.date desc limit 0,1";

                            $db->setQuery($sql);
                    $row = $db->loadObjectList();
                    return $row;
                }
        function getPagination(){ // vi khi view du lieu ra faj la nhung ham get k co tham so vi vay ta faj tao ra ham nay
            if(!$this->pagNav)
               return '';
            return $this->pagNav;
         }

        function ajax(){
            $row = $this -> getInsertcontent();
            require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'guestbook'.DIRECTORY_SEPARATOR.'view.html.php');
            $view   = new Tz_guestbookViewGuestbook();
            $state = $this->getState('params');
            $option =$state->get('title');
            $name = $state->get('name');
            $date = $state->get('date');
            $fweb = $state->get('website');
            $hienthistatus = $state->get('shownow');
            $view->assign('hienthistatus',$hienthistatus);
            $view->assign('fweb',$fweb);
            $view->assign('dat',$date);
            $view->assign('nam',$name);
            $view->assign('tit',$option);
            $view -> assign('hienthi',$this->getList2());
            $view ->assign('num_roww',$row);

            return ($view -> loadTemplate('item'));

        }
        function loadajax(){

            require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'guestbook'.DIRECTORY_SEPARATOR.'view.html.php'); // chen file view.html.php vao
            $view   = new Tz_guestbookViewGuestbook(); // tao mot doi tuong tu class tren
            $page = JRequest::getInt('page'); // lay du lieu page khi ajax chay thong qua bien page
            $limit  = $this ->getState('limitt'); // lay du lieu tu admin cofig xem phan trang bao nhieu ban ghi tu ham populateState
            $limitstart1=   $limit * ($page-1); // thuc hinh tinh limitsrtat
             $offset = (int) $limitstart1; // gan vao offset va chi lay gia tri nguyen
            $this -> setState('offset',$offset); // gan vao bien offset
            $state = $this->getState('params');
            $option =$state->get('title');
            $name = $state->get('name');
            $date = $state->get('date');
            $fweb = $state->get('website');
            $view->assign('fweb',$fweb);
            $view->assign('dat',$date);
            $view->assign('nam',$name);
            $view->assign('tit',$option);
            $view -> assign('hienthi',$this->getList()); // hien thi

          return ($view -> loadTemplate('item')); // loat du ;ieu
        }
        function getAuthor2(){
            $user   = JFactory::getUser();
            $id =$user->id;
            $db=&JFactory::getDbo();
            $sql ="select * from #__users WHERE id=$id";
            $db->setQuery($sql);
            $row = $db->loadObject();

            return $row;
        }
    }
?>