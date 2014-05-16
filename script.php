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
		
		$fields2 = $db -> getTableColumns('#__comment');
        $arr2   = null;
        if(!array_key_exists('catid',$fields2)){
            $arr2[]  = 'ADD `catid` INT NOT NULL';
        }
        if($arr2 && count($arr2)>0){
            $arr2    = implode(',',$arr2);
            if($arr2){
                $query  = 'ALTER TABLE `#__comment` '.$arr2;
                $db -> setQuery($query);
                $db -> query();
            }
        }
		$query_check = "select * from #__assets where title='Uncategory_TZ_Guestbook'";
		$db->setQuery($query_check);
		$check_assets = $db->loadObjectList();
		if($check_assets == null){		
			$user = JFactory::getUser();
			$query3 = "INSERT INTO #__assets(level,name, title) VALUES (2,'','Uncategory_TZ_Guestbook')";
			$db->setQuery($query3);
			$db->execute();
			$latest_id_asset = $db->insertid();
			$val_param  = '{"category_layout":"","image":""}';
			$meta_data = '{"author":"","robots":""}';
			$query1 = "insert into #__categories (parent_id,asset_id,path,extension,title,alias,published,params,metadata,language,access,level,created_user_id) values (1,$latest_id_asset,'uncategory','com_tz_guestbook','Uncategory','uncategory',1,'$val_param','$meta_data','*',1,1,$user->id)";
			$db->setQuery($query1);
			$db->execute();
			$latest_id = $db ->insertid() ;
			$query4 = "Update #__assets set name='com_tz_guestbook.category.$latest_id' where id=$latest_id_asset";
			$db->setQuery($query4);
			$db->execute();
			$query2  = "Update #__comment set catid =".$latest_id." where catid=0";
			$db->setQuery($query2);
			$db->execute();
		}
        //Install plugins
        $status = new stdClass;
        $status->modules = array();
        $src = $parent->getParent()->getPath('source');

        if(version_compare( JVERSION, '1.6.0', 'ge' )) {
            $modules = $parent->getParent()->manifest->xpath('modules/module');

            foreach($modules as $module){
                $result = null;
                $mname = $module->attributes() -> module;
                $client = $module->attributes() -> client;
                if(is_null($client)) $client = 'site';
                ($client=='administrator')? $path=$src.'/'.'administrator'.'/'.'modules'.'/'.$mname: $path = $src.'/'.'modules'.'/'.$mname;
                $installer = new JInstaller();
                $result = $installer->install($path);
                $status->modules[] = array('name'=>$mname,'client'=>$client, 'result'=>$result);
            }

            $plugins = $parent->getParent()->manifest->xpath('plugins/plugin');
            foreach($plugins as $plugin){
                $result = null;
                $folder = null;
                $pname  = $plugin->attributes() -> plugin;
                $group  = $plugin->attributes() -> group;
                $folder = $plugin -> attributes() -> folder;
                if(isset($folder)){
                    $folder = $plugin -> attributes() -> folder;
                }
                $path   = $src.'/'.'plugins'.'/'.$group.'/'.$folder;

                $installer = new JInstaller();
                $result = $installer->install($path);
                $status->plugins[] = array('name'=>$pname,'group'=>$group, 'result'=>$result);
            }
        }
        $this -> installationResult($status);
    }

    function uninstall($parent){

        $status = new stdClass();
        $status->modules = array ();
        $status->plugins = array ();

        $modules = & $parent -> getParent() -> manifest -> xpath('modules/module');
        $plugins = & $parent -> getParent() -> manifest -> xpath('plugins/plugin');

        $result = null;
		
		$db = JFactory::getDBo();
		$query1 = "Select asset_id from #__categories where extension='com_tz_guestbook'";
		$db->setQuery($query1);
		$a = $db->loadObjectList();
		for($i = 0; $i<count($a);$i++){
			$query2 = "Delete from #__assets where id =".$a[$i]->asset_id."";
			$db->setQuery($query2);
			$db->execute();		
		}		
		$query3 = "Delete from #__categories where extension = 'com_tz_guestbook'";
		$db->setQuery($query3);
		$db->execute();
		
        if($modules){
            foreach($modules as $module){
                $mname = (string)$module->attributes() -> module;
                $client = (string)$module->attributes() -> client;

                $db = JFactory::getDBO();
                $query = "SELECT `extension_id` FROM #__extensions WHERE `type`='module' AND `element` = ".$db->Quote($mname)."";
                $db->setQuery($query);
                $IDs = $db->loadColumn();
                if (count($IDs)) {
                    foreach ($IDs as $id) {
                        $installer = new JInstaller;
                        $result = $installer->uninstall('module', $id);
                    }
                }
                $status->modules[] = array ('name'=>$mname, 'client'=>$client, 'result'=>$result);
            }
        }

        if($plugins){
            foreach ($plugins as $plugin) {

                $pname = (string)$plugin->attributes() -> plugin;
                $pgroup = (string)$plugin->attributes() -> group;

                $db = & JFactory::getDBO();
                $query = "SELECT `extension_id` FROM #__extensions WHERE `type`='plugin' AND `element` = "
                         .$db->Quote($pname)." AND `folder` = ".$db->Quote($pgroup);
                $db->setQuery($query);
                $IDs = $db->loadColumn();
                if (count($IDs)) {
                    foreach ($IDs as $id) {
                        $installer = new JInstaller;
                        $result = $installer->uninstall('plugin', $id);
                    }
                }
                $status->plugins[] = array ('name'=>$pname, 'group'=>$pgroup, 'result'=>$result);
            }
        }
        $this -> uninstallationResult($status);
    }
    public function installationResult($status){
        $lang = JFactory::getLanguage();
        $lang -> load('com_tz_guestbook');
        $rows   = 0;
    ?>
        <h2><?php echo JText::_('COM_TZ_GUESTBOOK_HEADING_INSTALL_STATUS'); ?></h2>
        <table class="table table-striped table-condensed">
           <thead>
               <tr>
                   <th class="title" colspan="2"><?php echo JText::_('COM_TZ_GUESTBOOK_EXTENSION'); ?></th>
                   <th width="30%"><?php echo JText::_('COM_TZ_GUESTBOOK_STATUS'); ?></th>
               </tr>
           </thead>
           <tfoot>
               <tr>
                   <td colspan="3"></td>
               </tr>
           </tfoot>
           <tbody>
               <tr class="row0">
                   <td class="key" colspan="2"><?php echo JText::_('COM_TZ_GUESTBOOK').' '.JText::_('COM_TZ_GUESTBOOK_COMPONENT'); ?></td>
                   <td><strong><?php echo JText::_('COM_TZ_GUESTBOOK_INSTALLED'); ?></strong></td>
               </tr>
               <?php if (isset($status -> modules) AND count($status->modules)): ?>
               <tr>
                   <th><?php echo JText::_('COM_TZ_GUESTBOOK_MODULE'); ?></th>
                   <th><?php echo JText::_('COM_TZ_GUESTBOOK_CLIENT'); ?></th>
                   <th></th>
               </tr>
               <?php foreach ($status->modules as $module):?>
               <?php
                   if($lang -> exists($module['name'])){
                       $lang -> load($module['name']);
                   }
               ?>
               <tr class="row<?php echo (++ $rows % 2); ?>">
                   <td class="key"><?php echo JText::_($module['name']); ?></td>
                   <td class="key"><?php echo ucfirst($module['client']); ?></td>
                   <td><strong><?php echo ($module['result'])?JText::_('COM_TZ_GUESTBOOK_INSTALLED'):JText::_('COM_TZ_GUESTBOOK_NOT_INSTALLED'); ?></strong></td>
               </tr>
               <?php endforeach; ?>
               <?php endif; ?>

               <?php if (isset($status -> plugins) AND count($status->plugins)): ?>
               <tr>
                   <th><?php echo JText::_('COM_TZ_GUESTBOOK_PLUGIN'); ?></th>
                   <th><?php echo JText::_('COM_TZ_GUESTBOOK_GROUP'); ?></th>
                   <th></th>
               </tr>
               <?php foreach ($status->plugins as $plugin): ?>
                   <?php
                      if($lang -> exists($module['name'])){
                          $lang -> load($module['name']);
                      }
                  ?>
               <tr class="row<?php echo (++ $rows % 2); ?>">
                   <td class="key"><?php echo JText::_(ucfirst($plugin['name'])); ?></td>
                   <td class="key"><?php echo ucfirst($plugin['group']); ?></td>
                   <td><strong><?php echo ($plugin['result'])?JText::_('COM_TZ_GUESTBOOK_INSTALLED'):JText::_('COM_TZ_GUESTBOOK_NOT_INSTALLED'); ?></strong></td>
               </tr>
               <?php endforeach; ?>
               <?php endif; ?>

               <?php if (isset($status -> languages) AND count($status->languages)): ?>
               <tr>
                   <th><?php echo JText::_('COM_TZ_GUESTBOOK_LANGUAGES'); ?></th>
                   <th><?php echo JText::_('COM_TZ_GUESTBOOK_COUNTRY'); ?></th>
                   <th></th>
               </tr>
               <?php foreach ($status->languages as $language): ?>
               <tr class="row<?php echo (++ $rows % 2); ?>">
                   <td class="key"><?php echo ucfirst($language['language']); ?></td>
                   <td class="key"><?php echo ucfirst($language['country']); ?></td>
                   <td><strong><?php echo ($language['result'])?JText::_('COM_TZ_GUESTBOOK_INSTALLED'):JText::_('COM_TZ_GUESTBOOK_NOT_INSTALLED'); ?></strong></td>
               </tr>
               <?php endforeach; ?>
               <?php endif; ?>

           </tbody>
        </table>
    <?php
    }
    function uninstallationResult($status){
       JFactory::getLanguage()->load('com_tz_guestbook');
       $rows   = 0;
    ?>
        <h2><?php echo JText::_('COM_TZ_GUESTBOOK_HEADING_REMOVE_STATUS'); ?></h2>
        <table class="table table-striped table-condensed">
           <thead>
               <tr>
                   <th class="title" colspan="2"><?php echo JText::_('COM_TZ_GUESTBOOK_EXTENSION'); ?></th>
                   <th width="30%"><?php echo JText::_('COM_TZ_GUESTBOOK_STATUS'); ?></th>
               </tr>
           </thead>
           <tfoot>
               <tr>
                   <td colspan="3"></td>
               </tr>
           </tfoot>
           <tbody>
               <tr class="row0">
                   <td class="key" colspan="2"><?php echo JText::_('COM_TZ_GUESTBOOK').' '.JText::_('COM_TZ_GUESTBOOK_COMPONENT'); ?></td>
                   <td><strong><?php echo JText::_('COM_TZ_GUESTBOOK_REMOVED'); ?></strong></td>
               </tr>
               <?php if (count($status->modules)): ?>
               <tr>
                   <th><?php echo JText::_('COM_TZ_GUESTBOOK_MODULE'); ?></th>
                   <th><?php echo JText::_('COM_TZ_GUESTBOOK_CLIENT'); ?></th>
                   <th></th>
               </tr>
               <?php foreach ($status->modules as $module): ?>
               <tr class="row<?php echo (++ $rows % 2); ?>">
                   <td class="key"><?php echo $module['name']; ?></td>
                   <td class="key"><?php echo ucfirst($module['client']); ?></td>
                   <td><strong><?php echo ($module['result'])?JText::_('COM_TZ_GUESTBOOK_REMOVED'):JText::_('COM_TZ_GUESTBOOK_NOT_REMOVED'); ?></strong></td>
               </tr>
               <?php endforeach; ?>
               <?php endif; ?>

               <?php if (count($status->plugins)): ?>
               <tr>
                   <th><?php echo JText::_('COM_TZ_GUESTBOOK_PLUGIN'); ?></th>
                   <th><?php echo JText::_('COM_TZ_GUESTBOOK_GROUP'); ?></th>
                   <th></th>
               </tr>
               <?php foreach ($status->plugins as $plugin): ?>
               <tr class="row<?php echo (++ $rows % 2); ?>">
                   <td class="key"><?php echo ucfirst($plugin['name']); ?></td>
                   <td class="key"><?php echo ucfirst($plugin['group']); ?></td>
                   <td><strong><?php echo ($plugin['result'])?JText::_('COM_TZ_GUESTBOOK_REMOVED'):JText::_('COM_TZ_GUESTBOOK_NOT_REMOVED'); ?></strong></td>
               </tr>
               <?php endforeach; ?>
               <?php endif; ?>

               <?php if (count($status->languages)): ?>
               <tr>
                   <th><?php echo JText::_('COM_TZ_GUESTBOOK_LANGUAGES'); ?></th>
                   <th><?php echo JText::_('COM_TZ_GUESTBOOK_COUNTRY'); ?></th>
                   <th></th>
               </tr>
               <?php foreach ($status->languages as $language): ?>
               <tr class="row<?php echo (++ $rows % 2); ?>">
                   <td class="key"><?php echo ucfirst($language['language']); ?></td>
                   <td class="key"><?php echo ucfirst($language['country']); ?></td>
                   <td><strong><?php echo ($language['result'])?JText::_('COM_TZ_GUESTBOOK_REMOVED'):JText::_('COM_TZ_GUESTBOOK_NOT_REMOVED'); ?></strong></td>
               </tr>
               <?php endforeach; ?>
               <?php endif; ?>
           </tbody>
        </table>
<?php
    }
}
?>