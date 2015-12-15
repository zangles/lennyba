<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_2_0($object)
{
		$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
		$items = $db->executeS("Select * From "._DB_PREFIX_."bannerslider_module_lang");
		if($items){
			foreach($items as $item){
				$description = @Tools::htmlentitiesDecodeUTF8($item['description']);
				if(isset($description) && $description){
					$db->update('bannerslider_module_lang', array('description'=>$db->escape($description, true)), "`item_id`='".$item['item_id']."' AND `id_lang`='".$item['id_lang']."'");	
				}				
			}
		}
		$items = $db->executeS("Select * From "._DB_PREFIX_."bannerslider_item_lang");
		if($items){
			foreach($items as $item){
				$description = @Tools::htmlentitiesDecodeUTF8($item['description']);
				if(isset($description) && $description){
					$db->update('bannerslider_item_lang', array('description'=>$db->escape($description, true)), "`item_id`='".$item['item_id']."' AND `id_lang`='".$item['id_lang']."'");	
				}
				
			}
		}		
		return true;
}
