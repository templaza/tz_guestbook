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
        $limit_start = JRequest::getCmd('limitstart');
        $this->setState('conf', $congiajax);
        $this->setState('showcap', $showcapcha);
        $this->setState('c_status', $h_status);
        $this->setState('limitt', $limit_row);
        $this->setState('offset', $limit_start);
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
        if ($_SERVER['HTTP_HOST'] != $url_arr['host']) return null;

        $status = $this->getState('c_status');
        $name = strip_tags(htmlspecialchars($_POST['name']));
        $email = strip_tags(htmlspecialchars($_POST['email']));
        $title = strip_tags(htmlspecialchars($_POST['title']));
        $content = strip_tags(htmlspecialchars($_POST['content']));
        $website = $_POST['website'];
        $publich = $_POST['check'];
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
        if (isset($name) && !empty($name) && isset($email) && !empty($email) && isset($content) && !empty($content)) {
            $db = JFactory::getDbo();
            $sql = 'INSERT INTO #__comment values(null,"' . $name . '","' . $email . '","' . $title . '","' . $content . '",
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
        $layout = $this->getState('conf');
        $limit = $this->getState('limitt');
        $limitstart = $this->getState('offset');
        $db = JFactory::getDbo();
        $sql = "SELECT c.name AS cname,  c.email AS cemail,  c.title AS ctitle, c.content AS ccontent,  c.public AS cpublic,
                              c.date AS cdate, c.status AS cstatus, u.name AS uname, c.website as cwebsite
                        FROM #__users AS u RIGHT JOIN #__comment AS c ON c.id_us  = u.id
                        where c.status =1 order  by c.date desc";
        $sql2 = "SELECT c.name AS cname,  c.email AS cemail,  c.title AS ctitle, c.content AS ccontent,  c.public AS cpublic,
                              c.date AS cdate, c.status AS cstatus, u.name AS uname, c.website as cwebsite
                        FROM #__users AS u RIGHT JOIN #__comment AS c ON c.id_us  = u.id
                        where c.status =1 order  by c.date desc ";
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
        $sql = "SELECT c.name AS cname,  c.email AS cemail,  c.title AS ctitle, c.content AS ccontent,  c.public AS cpublic,
                            c.date AS cdate, c.status AS cstatus, u.name AS uname, c.website as cwebsite
                    FROM #__users AS u RIGHT JOIN #__comment AS c ON c.id_us  = u.id
                    where c.status =1 order  by c.date desc limit 0,1";
        $db->setQuery($sql);
        $row = $db->loadObjectList();
        return $row;
    }

    function getListLatest()
    {
        $db = JFactory::getDbo();
        $sql = "select * from #__comment order by id_cm desc limit 1 ";
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

    /*
     * method run ajax. when task = add
    */
    function ajax()
    {
        $row = $this->getInsertcontent();
        require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'guestbook' . DIRECTORY_SEPARATOR . 'view.html.php');
        $view = new Tz_guestbookViewGuestbook();
        $state = $this->getState('params');
        $option = $state->get('title');
        $name = $state->get('name');
        $date = $state->get('date');
        $fweb = $state->get('website');
        $tz_status = $state->get('shownow');
        $view->assign('hstatus', $tz_status);
        $view->assign('fweb', $fweb);
        $view->assign('dat', $date);
        $view->assign('nam', $name);
        $view->assign('tit', $option);
        $view->assign('display', $this->getList2());
        $view->assign('num_roww', $row);
        return ($view->loadTemplate('item'));

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
        $view->assign('fweb', $fweb);
        $view->assign('dat', $date);
        $view->assign('nam', $name);
        $view->assign('tit', $option);
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
            $link = $this->getGuestBookDetailRoute($id);
            $value = array();
            $value[0] = $title;
            $value[1] = $message;
            $value[2] = $website;
            $value[3] = $author;
            $value[4] = $email;
            $value[5] = $link;
            $filter_title = '/\{\$title\}/';
            $filter_message = '/\{\$message\}/';
            $filter_website = '/\{\$website\}/';
            $filter_author = '/\{\$author\}/';
            $filter_email = '/\{\$email\}/';
            $filter_link = '/\{\$link\}/';
            $filter = array();
            $filter[0] = $filter_title;
            $filter[1] = $filter_message;
            $filter[2] = $filter_website;
            $filter[3] = $filter_author;
            $filter[4] = $filter_email;
            $filter[5] = $filter_link;

            if (preg_match($filter_title, $str) or preg_match($filter_message, $str) or preg_match($filter_website, $str) or preg_match($filter_author, $str) or preg_match($filter_email, $str)) {
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
                $mail->addRecipient($filter_email, 'User');
            }
            $mail->setSubject($title);
            $mail->setBody($body);
            $mail->IsHTML(true);
            if ($type_send == 3) {
                $mail->addCC($filter_email);
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