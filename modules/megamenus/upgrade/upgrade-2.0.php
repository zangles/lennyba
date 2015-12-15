<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_2_0($object)
{
		$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
		$items = $db->executeS("Select * From "._DB_PREFIX_."megamenus_group_lang");
		if($items){
			foreach($items as $item){
				$description = @Tools::htmlentitiesDecodeUTF8($item['description']);
				if(isset($description) && $description){									
					$db->update('megamenus_group_lang', array('description'=>$db->escape($description, true)), "`group_id`='".$item['group_id']."' AND `id_lang`='".$item['id_lang']."'");	
				}
				
			}
		}
		$items = $db->executeS("Select * From "._DB_PREFIX_."megamenus_menuitem_lang");
		if($items){
			foreach($items as $item){
				$html = @Tools::htmlentitiesDecodeUTF8($item['html']);
				if(isset($html) && $html){				
					$db->update('megamenus_menuitem_lang', array('html'=>$db->escape($html, true)), "`menuitem_id`='".$item['menuitem_id']."' AND `id_lang`='".$item['id_lang']."'");	
				}
				
			}
		}
		return true;
}
