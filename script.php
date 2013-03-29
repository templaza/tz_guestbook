<?PHP
    defined('_JEXEC') or die;

    jimport('joomla.installer.installer');
    jimport( 'joomla.registry.registry' );

    class com_tz_guestbookInstallerScript{

        function postflight($type, $parent){

            $manifest   = $parent -> get('manifest');
            $params     = new JRegistry();

            $query  = 'SELECT params FROM #__extensions'
                      .' WHERE `type`="component" AND `name`="'.strtolower($manifest -> name).'"';
            $db     = JFactory::getDbo();
            $db -> setQuery($query);
            $db -> query();

            $params -> loadString($db ->loadResult());
            $paramNames = array();

            if(count($params -> toArray())>0){

                foreach($params -> toArray() as $key => $val){

                    $paramNames[]   = $key;
                }
            }

            $fields     = $manifest -> xPath('config/fields/field');

            foreach($fields as $field){
                $attribute  = $field -> attributes();
                     
                     $params -> set((string)$attribute -> name,(string)$attribute ->default);

            }

            $params = $params -> toString();

            $query  = 'UPDATE #__extensions SET `params`=\''.$params.'\''
                      .' WHERE `name`="'.strtolower($manifest -> name).'"'
                      .' AND `type`="component"';

            $db -> setQuery($query);
            $db -> query();
           

        }
    }



?>