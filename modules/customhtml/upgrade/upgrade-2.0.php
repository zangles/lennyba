<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_2_0($object)
{
		$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
		$items = $db->executeS("Select * From "._DB_PREFIX_."customhtml_module_lang");
		if($items){
			foreach($items as $item){
				$content = @Tools::htmlentitiesDecodeUTF8($item['content']);
				if(isset($content) && $content){				
					$db->update('customhtml_module_lang', array('content'=>$db->escape($content, true)), "`module_id`='".$item['module_id']."' AND `id_lang`='".$item['id_lang']."'");	
				}
				
			}
		}
			
		return true;
}
