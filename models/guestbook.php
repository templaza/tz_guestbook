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
    jimport('joomla.application.component.modellist');
    jimport('joomla.html.pagination'); 

    class Tz_guestbookModelGuestbook extends JModelList{

        function populateState($ordering = null, $direction = null){
            $app = JFactory::getApplication();
            // Adjust the context to support modal layouts.
            if ($layout = $app->input->get('layout'))
            {
                $this->context .= '.'.$layout;
            }

            $filer_public       =   $this->getUserStateFromRequest($this->context.'.filter.published','filter_published','');
            $filer_auto         =   $this->getUserStateFromRequest($this->context.'.filter.author.id','filter_author_id','');
            $filert_order       =   $this->getUserStateFromRequest($this->context.'.filter.order','filter_order','');
            $filert_order_dir   =   $this->getUserStateFromRequest($this->context.'.filert.order.dir','filter_order_Dir','');
            $filer_search       =   $this->getUserStateFromRequest($this->context.'.filter.search','filter_search','');
            $limit              =   $this->getUserStateFromRequest($this->context.'limit','limit','');
            $limitstartt        =   $this->getUserStateFromRequest($this->context.'limitstart','limitstart','');
            $this->setState('sata',$filer_public);
            $this->setState('autho',$filer_auto);
            $this->setState('lab1',$filert_order);
            $this->setState('lab2',$filert_order_dir);
            $this->setState('search',$filer_search);
            $this->setState('id_input',JRequest::getVar('cid'));
            $this->setState('detail2',JRequest::getInt('id'));
            $this->setState('limi',$limit);
            $this->setState('limitstar',$limitstartt);
        }

        function getList(){
            $lisd       = $this->getState('lab1');
            $lisd2      = $this->getState('lab2');
            $limit      =  $this->getState('limi',5);
            $limitstart = $this->getState('limitstar',0);
            $selectsta  = $this->getState('sata');
            $author     = $this->getState('autho');
            $search     = $this->getState('search');

            switch($lisd){
                case'tz.state':
                    $ord = "order by c.status $lisd2";
                    break;

                case'tz.title':
                    $ord ="order by c.title $lisd2";
                    break;

                case'tz.email':
                    $ord="order by c.email $lisd2";
                    break;

                case'tz.id':
                    $ord= "order by c.id_cm $lisd2";
                    break;

                case'tz.public':
                    $ord= "order by c.public $lisd2";
                    break;

                case'tz.author':
                    $ord="order by u.name $lisd2 ";
                    break;

                default:
                    $ord="order by c.date desc";
                    break;
            }


            switch($selectsta){
                case'1':
                    $satrus = '  c.status = 1';
                    break;

                case'0':
                    $satrus = ' c.status = 0';
                    break;

                default:
                    $satrus="c.status in (0,1)";
                    break;
            }

           // author
            if(isset($author) && $author >0){
                $author =" AND u.id = $author";
            }else{
                $author = '';
            }

            // search
            if(isset($search) && !empty($search)){
                if(is_numeric($search) == true){
                    $q_search = "AND c.id_cm = $search";
                }else if(is_numeric($search) == false){
                    $q_search = "AND c.title like '%".$search."%'";
                }
            }else{
                $q_search=  '';
            }

            $where  =   "where ".$satrus." ". $author." ". $q_search." ". $ord;


            $db     =   JFactory::getDbo();
            $sql    =   "SELECT u.name AS uname, c.id_cm AS cid, c.title AS ctitle, c.email AS cemail, c.status AS cstatus, c.public AS cpublic
                        FROM #__users AS u RIGHT JOIN #__comment AS c ON c.id_us  = u.id
                        $where";
            $sql2   =   "SELECT u.name AS uname, c.id_cm AS cid, c.title AS ctitle, c.email AS cemail, c.status AS cstatus, c.public AS cpublic
                        FROM #__users AS u RIGHT JOIN #__comment AS c ON c.id_us  = u.id
                        $where";

            $db->setQuery($sql);
            $num    =  $db->query();
            $total  =  $db->getNumRows($num);
            $this   -> pagNav  = new JPagination($total,$limitstart,$limit);
            $db     -> setQuery($sql2,$this -> pagNav -> limitstart,$this -> pagNav -> limit);
            $row    =  $db->loadObjectList();
            return $row;
        }

        /*
         * Method paging
         */
        function getPagination(){
            if(!$this->pagNav)
            return '';
            return $this->pagNav;
        }

        /*
         * Method get data author
        */
        function getAuthor(){
            $db     = JFactory::getDbo();
            $sql    = "SELECT u.id AS value, u.name AS text
                        FROM #__users AS u INNER JOIN #__comment AS c ON c.id_us  = u.id group by u.id";
            $db     -> setQuery($sql);
            $row    = $db->loadObjectList();

            return $row;
        }

        /*
         * Method unpublich
        */
        function unpulich(){
            $idd    =  $this->getState('id_input');
            $string =  implode(",",$idd);
            $db     =  JFactory::getDbo();
            $sql    =  "UPDATE #__comment SET status =0 WHERE id_cm in($string)";
            $db     -> setQuery($sql);
            $db     -> query();
        }

        /*
         * Method publish
        */
        function publish(){
            $idd    =  $this->getState('id_input');
            $string =  implode(",",$idd);
            $db     =  JFactory::getDbo();
            $sql    =  "UPDATE #__comment SET status =1 WHERE id_cm in($string)";
            $db     -> setQuery($sql);
            $db     -> query();
        }

        /*
         * method delete
        */
        function delete(){
            $idd    = $this->getState('id_input');
            $string = implode(",",$idd);
            $db     = JFactory::getDbo();
            $sql    = "delete from  #__comment  WHERE id_cm in($string)";
            $db     -> setQuery($sql);
            $db     -> query();
        }

        /*
         * method view detail comment
        */
        function getDetail(){
            $id_input    = $this->getState('id_input');

            $id_script    = $this->getState('detail2');
            $id_in    = $id_input[0];

            if(isset($id_in) && $id_in !=""){
                $id = $id_in;
            }
            else if(isset($id_script) && $id_script !=""){
                $id = $id_script;
            }else{
                $id =0;
            }
            $db     = JFactory::getDbo();
            $sql    = "SELECT c.name AS cname,  c.email AS cemail,  c.title AS ctitle, c.content AS ccontent,  c.public AS cpublic,
                              c.date AS cdate, c.status AS cstatus, u.name AS uname,  c.website as cwebsite
                        FROM #__users AS u RIGHT JOIN #__comment AS c ON c.id_us  = u.id
                        WHERE c.id_cm = $id";
            $db     -> setQuery($sql);
            $db     -> query();
            $row    = $db->loadObject();
            return $row;
        }

    }
?>