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
jimport('joomla.html.pagination');

class Tz_guestbookModelGuestbook extends JModelForm
{
    protected static $lookup;

    function populateState()
    {
        $app = JFactory::getApplication('site');
        $params = $app->getParams();
        $this->setState('params', $params);
        $h_status = $params->get('shownow');
        $showcapcha = $params->get('showcaptchat');
        $congiajax = $params->get('congiajax');
        $limit_row = $params->get('rows_ts');
        $remove_text = $params->get('removeText');
        $limit_start = JRequest::getCmd('limitstart');
        $id = JRequest::getVar('id');
        $this->setState('conf', $congiajax);
        $this->setState('showcap', $showcapcha);
        $this->setState('c_status', $h_status);
        $this->setState('limitt', $limit_row);
        $this->setState('offset', $limit_start);
        $this->setState('remove_text', $remove_text);
        $this->setState('chooseCate', $id);

    }

    /*
     * method get captcha to forms
     */
    function getForm($data = array(), $loadData = true)
    {
        $form = $this->loadForm('com_tz_guestbook.guestbook', 'guestbook', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form)) {
            return false;
        }
        return $form;
    }


    /*
     * method check captcha
    */
    public function getCaptcha()
    {
        $showcap = $this->getState('showcap');
        if ($showcap == 1) {
            $dispatcher = JDispatcher::getInstance();
            JPluginHelper::importPlugin('captcha');
            $getSave = $dispatcher->trigger('onCheckAnswer', JRequest::getString('recaptcha_response_field'));
            $check = $getSave[0]; // returned results compare captcha
            if ($check == false) {
                $check = 0;
            } else {
                $check = 1;
            }
        } else {
            $check = 2;
        }
        return $check;
    }

    /*
     *  method insert content
    */
    function getInsertcontent()
    {

        JRequest::checkToken() or jexit('Invalid Token');
        if (!isset($_SERVER['HTTP_REFERER'])) return null;
        $refer = $_SERVER['HTTP_REFERER'];
        $url_arr = parse_url($refer);
		if (isset($url_arr['port']) && $url_arr['port'] != '80') {
            $check = $url_arr['host'] . ":" . $url_arr['port'];
        } else {
            $check = $url_arr['host'];
        }
        if ($_SERVER['HTTP_HOST'] != $check) return null;

        $status = $this->getState('c_status');

        $name = strip_tags(htmlspecialchars($_POST['name']));
        $email = strip_tags(htmlspecialchars($_POST['email']));
        $title = strip_tags(htmlspecialchars($_POST['title']));
        $content = strip_tags(htmlspecialchars($_POST['content']));
        $website = $_POST['website'];
        $publich = $_POST['check'];
        $category = $_POST['category'];
        $datetime = JFactory::getDate();
        $date = $datetime->toSql();
        $user = JFactory::getUser();

        $id = $user->id;
        switch ($website) {
            case'Your website':
                $website = "";
                break;

            default:
                $website = strip_tags(htmlspecialchars($_POST['website']));
                break;
        }
        if (isset($name) && !empty($name) && isset($email) && !empty($email) && isset($content) && !empty($content) && $category != 0) {
            $db = JFactory::getDbo();
            $sql = 'INSERT INTO #__comment
			 (`id_cm`, `name`, `email`, `catid`, `title`, `content`, `public`, `date`, `status`, `website`, `id_us`)
			values
			(null,"' . $name . '","' . $email . '","' . $category . '","' . $title . '","' . $content . '",
                        "' . $publich . '","' . $date . '","' . $status . '","' . $website . '","' . $id . '")';

            $db->setQuery($sql);
            $num_row = $db->query();
            $row = $db->getAffectedRows($num_row);

            return $row;
        }
    }

    /*
     *  method paging ajax
    */
    function getList()
    {
        $chooseCate = $this->getState('chooseCate');
        if ($chooseCate == '') {

            $where1 = '';
        } else {
            if (is_numeric($chooseCate)) {
                $cat_tbl = JTable::getInstance('Category', 'JTable');
                $cat_tbl->load($chooseCate);
                $rgt = $cat_tbl->rgt;
                $lft = $cat_tbl->lft;

                $where1 = 'and j.lft >=' . (int)$lft . ' and j.rgt <=' . (int)$rgt;
            } elseif (is_array($chooseCate)) {
                JArrayHelper::toInteger($chooseCate);
                $chooseCate = implode(',', $chooseCate);
                $where1 = ' and a.catid IN (' . $chooseCate . ')';
            }
        }

        $layout = $this->getState('conf');
        $limit = $this->getState('limitt');
        $limitstart = $this->getState('offset');
        $db = JFactory::getDbo();
        $sql = "SELECT c.name AS cname,  c.email AS cemail,  c.title AS ctitle, c.content AS ccontent,  c.public AS cpublic, j.lft as lft,j.rgt as rgt,
                              c.date AS cdate, c.status AS cstatus, u.name AS uname, c.website as cwebsite , j.title as jtitle
                        FROM #__users AS u RIGHT JOIN #__comment AS c ON c.id_us  = u.id LEFT  JOIN #__categories AS j ON c.catid = j.id
                        where c.status =1 $where1  order  by c.date desc";
        $sql2 = "SELECT c.name AS cname,  c.email AS cemail,  c.title AS ctitle, c.content AS ccontent,  c.public AS cpublic, j.lft as lft,j.rgt as rgt,
                              c.date AS cdate, c.status AS cstatus, u.name AS uname, c.website as cwebsite , j.title as jtitle
                        FROM #__users AS u RIGHT JOIN #__comment AS c ON c.id_us  = u.id LEFT  JOIN #__categories AS j ON c.catid = j.id
                        where c.status =1 $where1 order  by c.date desc ";
        $db->setQuery($sql);
        $number = $db->query();
        $total = $db->getNumRows($number);
        $this->pagNav = new JPagination($total, $limitstart, $limit);
        if ($layout == '0') {
            $db->setQuery($sql2, $this->pagNav->limitstart, $this->pagNav->limit);
        } else {
            $db->setQuery($sql2, $limitstart, $limit);
        }

        $row = $db->loadObjectList();

        return $row;
    }

    /*
     * method display comment. when insert comment
     */
    function getList2()
    {

        $db = JFactory::getDbo();

        $sql = "SELECT c.name AS cname,  c.email AS cemail,  c.title AS ctitle, c.content AS ccontent,  c.public AS cpublic, c.catid AS catid,
                            c.date AS cdate, c.status AS cstatus, u.name AS uname, c.website as cwebsite ,j.title as jtitle
                    FROM #__users AS u right JOIN #__comment AS c ON c.id_us  = u.id LEFT  JOIN #__categories AS j ON c.catid = j.id
                    where c.status =1 order  by c.date desc limit 0,1";


        $db->setQuery($sql);
        $row = $db->loadObjectList();

        return $row;
    }

    function getListLatest()
    {
        $db = JFactory::getDbo();
        $sql = "select co.*, c.title  from #__comment as co right  join  #__categories as c on co.catid = c.id  order by co.id_cm desc limit 1";
        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;
    }

    /*
     *  method paging default
    */
    function getPagination()
    {
        if (!$this->pagNav)
            return '';
        return $this->pagNav;
    }

    function getCategory()
    {
        $db = JFactory::getDbo();
        $sql = "select * from #__categories where extension = 'com_tz_guestbook' and published = 1";
        $db->setQuery($sql);
        $row = $db->loadObjectList();
        return $row;
    }

    /*
     * method run ajax. when task = add
    */
    function ajax()
    {

        $check_mail = $this->checkMail();
        if ($check_mail == 'success') {

            $row = $this->getInsertcontent();

            require_once(JPATH_COMPONENT . '/views/guestbook/view.html.php');

            $view = new Tz_guestbookViewGuestbook();

            $state = $this->getState('params');
            $option = $state->get('title');
            $name = $state->get('name');
            $date = $state->get('date');
            $fweb = $state->get('website');
            $cate = $state->get('showCate');
            $tz_status = $state->get('shownow');
            $view->assign('hstatus', $tz_status);
            $view->assign('fweb', $fweb);
            $view->assign('dat', $date);
            $view->assign('nam', $name);
            $view->assign('tit', $option);
            $view->assign('category', $cate);
            $view->assign('display', $this->getList2());
            $view->assign('num_roww', $row);

            return ($view->loadTemplate('item'));
        } else {
            if ($check_mail == 'name') {
                return '2';
            } else
                if ($check_mail == 'email') {
                    return '3';
                } else
                    if ($check_mail == 'title') {
                        return '4';
                    } else
                        if ($check_mail == 'content') {
                            return '5';
                        } else
                            if ($check_mail == 'website') {
                                return '6';
                            }
        }
    }

    /*
     * method paging ajax
    */
    function loadajax()
    {
        require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'guestbook' . DIRECTORY_SEPARATOR . 'view.html.php'); // chen file view.html.php vao
        $view = new Tz_guestbookViewGuestbook();
        $page = JRequest::getInt('page');
        $limit = $this->getState('limitt');
        $limitstart1 = $limit * ($page - 1);
        $offset = (int)$limitstart1;
        $this->setState('offset', $offset);
        $state = $this->getState('params');
        $option = $state->get('title');
        $name = $state->get('name');
        $date = $state->get('date');
        $fweb = $state->get('website');
        $cate = $state->get('showCate');
        $view->assign('fweb', $fweb);
        $view->assign('dat', $date);
        $view->assign('nam', $name);
        $view->assign('tit', $option);
        $view->assign('category', $cate);
		$this->setState('chooseCate', JRequest::getVar('id'));
        $view->assign('display', $this->getList());
        return ($view->loadTemplate('item'));
    }

    /*
     * method get data author
    */
    function getAuthor2()
    {
        $user = JFactory::getUser();
        $id = $user->id;
        $db = JFactory::getDbo();
        $sql = "select * from #__users WHERE id=$id";
        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;
    }

    function checkMail()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];

        $title = $_POST['title'];
        $content = $_POST['content'];
        $website = $_POST['website'];

        $changeText = $this->getState('remove_text');
		strtolower($changeText);
        strtolower($name);
        strtolower($email);
        strtolower($title);
        strtolower($content);
        strtolower($website);
        if ($changeText != '') {
            $array_changeText = array_map('trim', explode(",", $changeText));
            for ($i = 0; $i < count($array_changeText); $i++) {
                $array_changeText[$i] = '/' . $array_changeText[$i] . '/';
                if (preg_match($array_changeText[$i], $name)) {
                    return 'name';
                } elseif (preg_match($array_changeText[$i], $email)) {
                    return 'email';
                } elseif (preg_match($array_changeText[$i], $title)) {
                    return 'title';
                } elseif (preg_match($array_changeText[$i], $content)) {
                    return 'content';
                } elseif (preg_match($array_changeText[$i], $website)) {
                    return 'website';
                }
            }
            return 'success';
        } else {
            return 'success';
        }
    }

    function TzSendEmail()
    {
        $params = $this->getState('params');
        $type_send = $params->get('type_send');
        if ($type_send != 0) {
            $str = $params->get('formatmail');
            $getId = $this->getListLatest();
            $id = $getId->id_cm;
            $title = $getId->title;
            $website = $getId->website;
            $message = $getId->content;
            $email = $getId->email;
            $author = $getId->name;
            $category = $getId->title;
            $value = array();
            $value[0] = $title;
            $value[1] = $message;
            $value[2] = $website;
            $value[3] = $author;
            $value[4] = $email;
            $value[5] = $category;
            $filter_title = '/\{\$title\}/';
            $filter_message = '/\{\$message\}/';
            $filter_website = '/\{\$website\}/';
            $filter_author = '/\{\$author\}/';
            $filter_email = '/\{\$email\}/';
            $filter_category = '/\{\$category\}/';
            $filter = array();
            $filter[0] = $filter_title;
            $filter[1] = $filter_message;
            $filter[2] = $filter_website;
            $filter[3] = $filter_author;
            $filter[4] = $filter_email;
            $filter[5] = $filter_category;

            if (preg_match($filter_title, $str) or preg_match($filter_message, $str) or preg_match($filter_website, $str) or preg_match($filter_author, $str) or preg_match($filter_email, $str) or preg_match($filter_category, $str)) {
                $str = preg_replace($filter, $value, $str);
            }

            $doc = JFactory::getConfig();
            $arr = $doc->toArray();
            $body = $str;
            $contact = $arr['mailfrom'];
            $mail = JFactory::getMailer();
            if ($type_send == 1 or $type_send == 3) {
                $mail->addRecipient($contact, 'Admin');
            } elseif ($type_send == 2) {
                $mail->addRecipient($email, 'User');
            }
            $mail->setSubject($title);
            $mail->setBody($body);
            $mail->IsHTML(true);
            if ($type_send == 3) {
                $mail->addCC($email);
            }
            $sent = $mail->Send();
        }
    }

    public static function getGuestBookDetailRoute($id)
    {
        $needles = array(
            'guestbook' => array((int)$id)
        );
        JUri::base();
        $link = JUri::base() . "index.php?option=com_tz_guestbook&amp;view=guestbook&amp;id_cm=" . $id;
        if ($item = self::_findItem($needles)) {

            $link .= '&amp;Itemid=' . $item;

        } elseif ($item = self::_findItem()) {
            $link .= '&amp;Itemid=' . $item;
        }
        return $link;
    }


    protected static function _findItem($needles = null)
    {
        $app = JFactory::getApplication();
        $menus = $app->getMenu('site');
        $active = $menus->getActive();
        $component = JComponentHelper::getComponent('com_tz_guestbook');
        $items = $menus->getItems('component_id', $component->id);
        // Prepare the reverse lookup array.
        if (self::$lookup === null) {
            self::$lookup = array();
            foreach ($items as $item) {
                if (isset($item->query) && isset($item->query['view'])) {
                    $view = $item->query['view'];

                    if (!isset(self::$lookup[$view])) {
                        self::$lookup[$view] = array();
                    }
                    if ($active && $active->component == 'com_tz_guestbook') {
                        if (isset($active->query) && isset($active->query['view'])) {
                            if (isset($active->query['id'])) {
                                self::$lookup[$active->query['view']][$active->query['id']] = $active->id;
                            }
                        }
                    }
                }
            }
        }
        if ($needles) {
            foreach ($needles as $view => $ids) {
                if (isset(self::$lookup[$view])) {
                    if ($view == 'guestbook') {
                        foreach ($items as $item) {
                            if ($view == $item->query['view']) {
                                $Itemid = $item->id;
                                return $Itemid;
                            }
                        }
                    }
                }
            }
        } else {
            if ($active && $active->component == 'com_tz_guestbook') {
                return $active->id;
            }
        }
        return null;
    }
}

?>