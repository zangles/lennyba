<?php

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_2_0($object)
{
		return true;
		$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
		$db->execute("ALTER TABLE  `"._DB_PREFIX_."pagelink_module` 															
						ADD  `position_name` VARCHAR(63) NOT NULL AFTER  `id_shop` ");													
		$items = $db->executeS("Select * From "._DB_PREFIX_."pagelink_module_position");
		if($items){
			foreach($items as $item){	
				$db->update('pagelink_module', array('position_name'=>$item['position_name']), "`id`='".$item['module_id']."'");
			}
		}		
		return true;
}
