<?php
/*
*  @author SonNC <nguyencaoson.zpt@gmail.com>
*/
class CustomHtml extends Module
{
    const INSTALL_SQL_FILE = 'install.sql';
	protected static $tables = array(	'customhtml_module'=>'', 
										'customhtml_module_lang'=>'lang', 										
										);
    public $arrLayout = array();
	public static $sameDatas = '';
	public $page_name = '';
	protected $arrHook = array(
		'displayHome', 
		'displayTop', 
		'displayLeftColumn', 
		'displayRightColumn', 
		'displayFooter', 
		'displayNav', 
		'displayTopColumn', 
		'CustomHtml', 
		'Contactform',
		'displaySmartBlogLeft',
		'displaySmartBlogRight',
		'displayBottomContact',		
		'displayHomeBottomContent',
		'displayHomeBottomColumn',
		'displayBottomColumn',
		'displayCustomHtml1',
		'displayCustomHtml2',
		'displayCustomHtml3',
		'displayCustomHtml4',
		'displayCustomHtml5',
		);
	public function __construct()
	{
		$this->name = 'customhtml';		
		$this->arrLayout = array('default'=>$this->l('Default layout'));
		$this->arrCol = array();
		$this->secure_key = Tools::encrypt($this->name);        
		self::$sameDatas = dirname(__FILE__).'/samedatas/';
		$this->tab = 'front_office_features';
		$this->version = '2.0';
		$this->author = 'OVIC-SOFT';		
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('Custom HTML module');
		$this->description = $this->l('Custom HTML module');
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
	}
	/*
    public function  __call($method, $args){        
        if(!method_exists($this, $method)) {
            return $this->hooks($method, $args);
        }
    }
	*/
	public function install($keep = true)
	{
	   if ($keep)
		{			
			if (!file_exists(dirname(__FILE__).'/'.self::INSTALL_SQL_FILE))
				return false;
			else if (!$sql = file_get_contents(dirname(__FILE__).'/'.self::INSTALL_SQL_FILE))
				return false;
			$sql = str_replace(array('PREFIX_', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $sql);
			$sql = preg_split("/;\s*[\r\n]+/", trim($sql));					
			foreach ($sql as $query){
				if (!Db::getInstance()->execute(trim($query))) return false;
			}
		}		
		if(!parent::install() || !$this->registerHook('displayHeader')) return false;
		if($this->arrHook)
			foreach($this->arrHook as $hook)
				if(!$this->registerHook($hook)) 
					return false;	
		if (!Configuration::updateGlobalValue('MOD_CUSTOM_HTML', '1')) return false;
		$this->importSameData();
		return true;
	}
	public  function importSameData($directory=''){
	   if($directory) self::$sameDatas = $directory;
		$langs = Db::getInstance()->executeS("Select id_lang From "._DB_PREFIX_."lang Where active = 1");			
		if(self::$tables){
			$currentOption = Configuration::get('OVIC_CURRENT_DIR');
            if($currentOption) $currentOption .= '.';
            else $currentOption = '';
			foreach(self::$tables as $table=>$value){                
				if (file_exists(self::$sameDatas.$currentOption.$table.'.sql')){				    
					$sql = @file_get_contents(self::$sameDatas.$currentOption.$table.'.sql');
					if($sql){
						Db::getInstance()->execute('TRUNCATE TABLE '._DB_PREFIX_.$table);
						$sql = str_replace(array('PREFIX_', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $sql);
						$sql = preg_split("/;\s*[\r\n]+/", trim($sql));
						if($value == 'lang'){
							foreach ($sql as $query){
								foreach($langs as $lang){
									
									$query_result = str_replace(array('©','®'), array('&copy;','&reg;'), trim($query));
									$query_result = str_replace('id_lang', $lang['id_lang'], trim($query));
									if($query_result) Db::getInstance()->execute($query_result);
								}
							}	
						}else{
							foreach ($sql as $query){
							$query = str_replace(array('©','®'), array('&copy;','&reg;'), trim($query));
							  if($query)
								Db::getInstance()->execute(trim($query));
							}
						}
					}
					
				}
			}
		}
		return true;
	}
	public function uninstall($keep = true)
	{	   
		if (!parent::uninstall()) return false;		
        if($keep){
			if(self::$tables){
				foreach(self::$tables as $table=>$value)
					Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.$table.'`');
			}
        }		
        if (!Configuration::deleteByName('MOD_CUSTOM_HTML')) return false;
		return true;
	}
	public function reset()
	{
		if (!$this->uninstall(false))
			return false;
		if (!$this->install(false))
			return false;
		return true;
	}
	
    private function getLangOptions(){    	
        $langId = Context::getContext()->language->id;
        $items = Db::getInstance()->executeS("Select id_lang, name, iso_code From "._DB_PREFIX_."lang Where active = 1");
        $langOptions = '';
        if($items){
            foreach($items as $item){
                if($item['id_lang'] == $langId){
                    $langOptions .= '<option value="'.$item['id_lang'].'" selected="selected">'.$item['iso_code'].'</option>';
                }else{
                    $langOptions .= '<option value="'.$item['id_lang'].'">'.$item['iso_code'].'</option>';
                }
            }
        }
        return $langOptions;
    }
	
	private function getPositionOptions($selected=''){
		$options = '';		
		if($this->arrHook){			
			foreach($this->arrHook as $value){
				$hookId = Hook::getIdByName($value);
				if($value == $selected) $options .='<option selected="selected" value="'.$value.'">'.$value.'</option>';
				else $options .='<option value="'.$value.'">'.$value.'</option>';
			}
		}
        return $options;
    }	
    private function getLayoutOptions($selected = ''){
        $options = '';        
        foreach($this->arrLayout as $key=> $value){
            if($key == $selected) $options .= '<option selected="selected" value="'.$key.'">'.$value.'</option>';
            else $options .= '<option  value="'.$key.'">'.$value.'</option>';            
        }        
        return $options; 
    }
    
	public function getAllLanguage(){
        $langId = Context::getContext()->language->id;
        $items = Db::getInstance()->executeS("Select id_lang, name, iso_code From "._DB_PREFIX_."lang Where active = 1 Order By id_lang");
        $languages = array();
        if($items){
            foreach($items as $i=>$item){
            	$objItem = new stdClass();
				$objItem->id = $item['id_lang'];
				$objItem->iso_code = $item['iso_code'];
                if($item['id_lang'] == $langId){
                    $objItem->active = 1;
                }else{
                    $objItem->active = 0;
                }
				$languages[$i] = $objItem;
            }
        }
        return $languages;
    }
    public function getModuleByLang($id, $langId=0, $shopId=0){
    	if(!$langId) $langId = Context::getContext()->language->id;
        if(!$shopId) $shopId = Context::getContext()->shop->id;
		$itemLang = Db::getInstance()->getRow("Select name, content From "._DB_PREFIX_."customhtml_module_lang Where module_id = $id AND `id_lang` = '$langId'" );
		if(!$itemLang) $itemLang = array('name'=>'', 'content'=>'');
		return $itemLang;
    }
	
	public function renderModuleForm($id=0){
		$langId = $this->context->language->id;
        $shopId = $this->context->shop->id;
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."customhtml_module Where id = $id AND `id_shop` = ".$shopId);		
		if(!$item) $item = array(
			'id'			=>	0, 
			'id_shop'		=>	$shopId,
			'position_name'	=>	'', 
			'display_name'	=>	1, 
			'layout'		=>	'default', 
			'ordering'		=>	1, 
			'status'		=>	1, 
			'custom_class'	=>	'', 
			'params'		=>	'',
			);
		$langActive = '<input type="hidden" id="moduleLangActive" value="0" />';
		$names = '';
		$contents = '';
		$languages = $this->getAllLanguage();
		if($languages){
			foreach ($languages as $key => $lang) {				
				$itemLang = $this->getModuleByLang($id, $lang->id);
				if($lang->active == '1'){
					$langActive = '<input type="hidden" id="moduleLangActive" value="'.$lang->id.'" />';
					$names .= '<input type="text" value="'.$itemLang['name'].'" name="names[]" id="module_titles_'.$lang->id.'" class="form-control module-lang-'.$lang->id.'" />';
					$contents .= '<div class="module-lang-'.$lang->id.'"><textarea class="editor" name="contents[]" id="content-'.$lang->id.'">'.$itemLang['content'].'</textarea></div>';	
				}else{
					$names .= '<input type="text" value="'.$itemLang['name'].'" name="names[]" id="module_titles_'.$lang->id.'" class="form-control module-lang-'.$lang->id.'" style="display:none" />';
					$contents .= '<div style="display:none" class="module-lang-'.$lang->id.'"><textarea class="editor" name="contents[]" id="content-'.$lang->id.'">'.$itemLang['content'].'</textarea></div>';					
				}				
			}
		}
		$langOptions = $this->getLangOptions();
		$html = '<input type="hidden" name="moduleId" value="'.$item['id'].'" />';
		$html .= $langActive;
		$html .= '<input type="hidden" name="action" value="saveModule" />';
		$html .= '<input type="hidden" name="secure_key" value="'.$this->secure_key.'" />';
		$html .= '	<div class="form-group">
						<label class="control-label col-sm-2">'.$this->l('Name').'</label>
						<div class="col-sm-10">
							<div class="col-sm-10">'.$names.'</div>
							<div class="col-sm-2">
								<select class="module-lang" onchange="moduleChangeLanguage(this.value)">'.$langOptions.'</select>
							</div>
						</div>
					</div>';
		$html .= '	<div class="form-group">
						<label class="control-label col-sm-2">'.$this->l('Content').'</label>
						<div class="col-sm-10">
							<div class="col-sm-10">'.$contents.'</div>
							<div class="col-sm-2">
								<select class="module-lang" onchange="moduleChangeLanguage(this.value)">'.$langOptions.'</select>
							</div>
						</div>
					</div>';
		if($item['display_name'] == 1){
			$html .= '<div class="form-group">
                    <label class="control-label col-sm-2">'.$this->l('Display name').'</label>
                    <div class="col-sm-10">
                        <div class="col-sm-5">
                            <span class="switch prestashop-switch fixed-width-lg" id="module-display-name">
                                <input type="radio" value="1" class="display_name" checked="checked" id="display_name_on" name="display_name" />
            					<label for="module_display_name_on">Yes</label>
            				    <input type="radio" value="0" class="display_name" id="display_name_off" name="display_name" />
            					<label for="display_name_off">No</label>
                                <a class="slide-button btn"></a>
            				</span>
                        </div>                        
                    </div>				    
                </div>';	
		}else{
			$html .= '<div class="form-group">
                    <label class="control-label col-sm-2">'.$this->l('Display name').'</label>
                    <div class="col-sm-10">
                        <div class="col-sm-5">
                            <span class="switch prestashop-switch fixed-width-lg" id="module-display-name">
                                <input type="radio" value="1" class="display_name" id="display_name_off" name="display_name" />
            					<label for="display_name_off">Yes</label>
            				    <input type="radio" value="0" class="display_name" checked="checked" id="display_name_on" name="display_name" />
            					<label for="display_name_on">No</label>
                                <a class="slide-button btn"></a>
            				</span>
                        </div>                        
                    </div>				    
                </div>';
		}
		$html .= '<div class="form-group"><label class="control-label col-sm-2">'.$this->l('Position').'</label><div class="col-sm-10"><div class="col-sm-12"><select  name="position_name">'.$this->getPositionOptions($item['position_name']).'</select></div></div></div>';
		$html .= '<div class="form-group"><label class="control-label col-sm-2">'.$this->l('Layout').'</label><div class="col-sm-10"><div class="col-sm-12"><select class="form-control" name="moduleLayout">'.$this->getLayoutOptions($item['layout']).'</select></div></div></div>';
		$html .= '<div class="form-group"><label class="control-label col-sm-2">'.$this->l('Custom class').'</label><div class="col-sm-10"><div class="col-sm-12"><input type="text" value="'.$item['custom_class'].'" name="custom_class"  class="form-control" /></div></div></div>';
		return $html;
	}
	
	function getCurrentUrl($excls=array())
	{
		$pageURL = 'http';		
     	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
     	$pageURL .= "://";
     	if ($_SERVER["SERVER_PORT"] != "80") {
    		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    	} else {
    		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
     	}
     	return $pageURL;
	}
	public function getContent()
	{
		// foreach($this->arrHook as $hook)
			// $this->registerHook($hook);
		//$this->registerHook('displaySmartBlogLeft') ;
		//$this->registerHook('displaySmartBlogRight') ;
		//$this->registerHook('displayBottomContact') ;
		 
		$action = Tools::getValue('action', 'view');
		if($action == 'view'){
			$this->context->controller->addJquery();
			$this->context->controller->addjQueryPlugin('tablednd');			
			$this->context->controller->addJS(($this->_path).'js/admin/common.js');                
			$this->context->controller->addJS(($this->_path).'js/admin/jquery.serialize-object.min.js');
			$this->context->controller->addJS(__PS_BASE_URI__.'js/tiny_mce/tinymce.min.js');
			$this->context->controller->addJS(($this->_path).'js/admin/tinymce.inc.js');
					   	        
	        $this->context->controller->addCSS(($this->_path).'css/admin/style.css');	        
	        $langId = $this->context->language->id;
	        $shopId = $this->context->shop->id;
	        $items = Db::getInstance()->executeS("Select m.*, ml.name 
	        	From "._DB_PREFIX_."customhtml_module AS m 
	        	Left Join "._DB_PREFIX_."customhtml_module_lang AS ml On ml.module_id = m.id 
	        	Where m.id_shop = '".$shopId."' AND ml.id_lang = ".$langId." 
	        	Order By m.position_name, m.ordering");			
	        $listModule = '';
	        if($items){
	            foreach($items as &$item){	            	
	            	$item['layout_value'] = $this->arrLayout[$item['layout']];           
	            }
	        }                 
	        $this->context->smarty->assign(array(
	            'baseModuleUrl'	=>	__PS_BASE_URI__.'modules/'.$this->name,
	            'currentUrl'	=>	$this->getCurrentUrl(),
	            'moduleId'		=>	$this->id,
	            'langId'		=>	$langId,	            
				'iso'			=>	$this->context->language->iso_code,
	            'ad'			=>	$ad = dirname($_SERVER["PHP_SELF"]),
	            'secure_key'	=>	$this->secure_key,
	            'moduleForm' 	=>	$this->renderModuleForm(),
				'items'			=>	$items,
	        ));
			return $this->display(__FILE__, 'views/templates/admin/modules.tpl');
		}else if($action == 'data-export'){
			$this->exportSameData();
			echo $this->l('Export data success!');
			die;
			die(Tools::jsonEncode($this->l('Export data success!')));
		}elseif($action == 'data-import'){
			$this->importSameData();
			echo $this->l('Install data success!');
			die;
			die(Tools::jsonEncode($this->l('Install data success!')));	
		}else{
			if(method_exists ($this, $action)){
				$this->$action();
			}else{
				$response = new stdClass();
				if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
		            $response->status = '1';
            		$response->msg = $this->l("Method ".$action."() not found!.");
					die(Tools::jsonEncode($response));
		        }else{
		        	die($this->l("Method ".$action."() not found!."));
		        }
			}			
		}
	}
	public function exportSameData($directory=''){
	   if($directory) self::$sameDatas = $directory;
        $langId = Context::getContext()->language->id;
		$link = mysql_connect(_DB_SERVER_,_DB_USER_,_DB_PASSWD_);
		mysql_select_db(_DB_NAME_,$link);
        $currentOption = Configuration::get('OVIC_CURRENT_DIR');
            if($currentOption) $currentOption .= '.';
            else $currentOption = '';
		foreach(self::$tables as $table=>$type){			
			$fields = array();
			$query2 = mysql_query('SHOW COLUMNS FROM '._DB_PREFIX_.$table);				
				while($row = mysql_fetch_row($query2))
					$fields[] = $row[0];
			$return = '';
			if($type == 'lang'){
				$query1 = mysql_query('SELECT * FROM '._DB_PREFIX_.$table." Where id_lang = ". $langId);		
				$num_fields = mysql_num_fields($query1);				
				//for ($i = 0; $i < $num_fields; $i++) {
					while($row = mysql_fetch_row($query1)){
						$return.= 'INSERT INTO PREFIX_'.$table.' VALUES(';
						for($j=0; $j<$num_fields; $j++) 
						{
							$row[$j] = addslashes($row[$j]);
							$row[$j] = str_replace(array("\n", "\r"), '', $row[$j]);
							if (isset($row[$j])) {
								if($fields[$j] == 'id_lang')
									$return.= '"id_lang"';							
								else
									$return.= '"'.$row[$j].'"' ; 
							} else {
								 $return.= '""'; 
							}
							if ($j<($num_fields-1)) { $return.= ','; }
						}
						$return.= ");\n";
					}
				//}
			}else{
				$query1 = mysql_query('SELECT * FROM '._DB_PREFIX_.$table);		
				$num_fields = mysql_num_fields($query1);
				//for ($i = 0; $i < $num_fields; $i++) {
					while($row = mysql_fetch_row($query1))
					{
						$return.= 'INSERT INTO PREFIX_'.$table.' VALUES(';
						for($j=0; $j<$num_fields; $j++) 
						{
							$row[$j] = addslashes($row[$j]);
							$row[$j] = str_replace(array("\n", "\r"), '', $row[$j]);
							if (isset($row[$j])) {								
								$return.= '"'.$row[$j].'"' ; 
							} else {
								 $return.= '""'; 
							}
							if ($j<($num_fields-1)) { $return.= ','; }
						}
						$return.= ");\n";
					}
				//}					
			}
			$return.="\n";
			$handle = fopen(self::$sameDatas.$currentOption.$table.'.sql','w+');
			fwrite($handle,$return);
			fclose($handle);
		}
		return true;
	}	
    public function saveModule(){
    	    	
        $shopId = Context::getContext()->shop->id;
		$languages = $this->getAllLanguage();        
        $response = new stdClass();		
        $itemId = intval($_POST['moduleId']);
		$db = Db::getInstance();
		$names = Tools::getValue('names', array());
		$contents = Tools::getValue('contents', array());		
        $layout = Tools::getValue('moduleLayout', 'default');        
        $display_name = Tools::getValue('display_name', 1);
        $custom_class = Tools::getValue('custom_class', '');
		$params = '';
		$position_name = Tools::getValue('position_name', '');
		$defaultContent = '';
		$defaultName = '';
        if($itemId == 0){
			$maxOrdering = $db->getValue("Select MAX(ordering) From "._DB_PREFIX_."customhtml_module Where `position_name` = '$position_name'");
		   	if($maxOrdering >0) $maxOrdering++;
		   	else $maxOrdering = 1;
            if($db->execute("Insert Into "._DB_PREFIX_."customhtml_module (`id_shop`, `position_name`, `display_name`, `layout`, `ordering`, `status`, `custom_class`, `params`) Values ('$shopId', '$position_name', '".$display_name."', '".$layout."', '$maxOrdering', '1', '$custom_class', '$params')")){
                $insertId = $db->Insert_ID();				
				if($languages){
                	$insertDatas = array();
                	foreach($languages as $index=>$language){
                		$content = Db::getInstance(_PS_USE_SQL_SLAVE_)->escape($contents[$index], true);
						if(!$defaultContent == '') $defaultContent = $content;
						else
							if(!$content) $content = $defaultContent;                		
						$name = Db::getInstance()->escape($names[$index]);
						if(!$defaultName) $defaultName = $name;
						else
							if(!$name) $name = $defaultName;
						$insertDatas[] = array('module_id'=>$insertId, 'id_lang'=>$language->id, 'name'=>$name, 'content'=>$content);                   		                
                	}
					if($insertDatas) $db->insert('customhtml_module_lang', $insertDatas);
                }                
                $response->status = '1';
                $response->msg = $this->l('Add new Module Success!');
                $this->clearCache();  
            }else{
                $response->status = '0';
                $response->msg = $this->l('Add new Module not Success!');
            }
        }else{
            $item = $db->getRow("Select * From "._DB_PREFIX_."customhtml_module Where id = ".$itemId);
            $db->execute("Update "._DB_PREFIX_."customhtml_module Set `position_name`='$position_name', `layout`='".$layout."', `params` = '".$params."', `custom_class`='$custom_class', `display_name`='$display_name' Where id = ".$itemId);            
			
			if($languages){
				$insertDatas = array();            	
            	foreach($languages as $index=>$language){
            		$content = Db::getInstance(_PS_USE_SQL_SLAVE_)->escape($contents[$index], true);	
            		if(!$defaultContent == '') $defaultContent = $content;
					else
						if(!$content) $content = $defaultContent;                		
					$name = Db::getInstance()->escape($names[$index]);
					if(!$defaultName) $defaultName = $name;
					else
						if(!$name) $name = $defaultName;						
            		$check = $db->getValue("Select module_id From "._DB_PREFIX_."customhtml_module_lang Where module_id = $itemId AND id_lang = ".$language->id);
            		if($check){
            			$db->execute("Update "._DB_PREFIX_."customhtml_module_lang Set `name` = '".$name."', `content`='".$content."' Where `module_id` = ".$itemId." AND `id_lang` = ".$language->id);	
            		}else{
            			$insertDatas[] = array('module_id'=>$itemId, 'id_lang'=>$language->id, 'name'=>$name, 'content'=>$content);
            		}
            	}
            	if($insertDatas) $db->insert('customhtml_module_lang', $insertDatas);
            }            
            $response->status = '1';
            $response->msg = $this->l('Update Module Success!');
			$this->clearCache();
        }
        die(Tools::jsonEncode($response));
    }
	
	public function changModuleStatus(){
		$itemId = intval($_POST['itemId']);
		$value = intval($_POST['value']);		
		$response = new stdClass();
		if($value == '1'){
			Db::getInstance()->execute("Update "._DB_PREFIX_."customhtml_module Set `status` = 0 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
			$this->clearCache();
		}else{
			Db::getInstance()->execute("Update "._DB_PREFIX_."customhtml_module Set `status` = 1 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}
		die(Tools::jsonEncode($response));
	}	
	
	public function getModuleItem(){		
        $response = new stdClass();
        $itemId = intval($_POST['itemId']);
        if($itemId){
        	$response->form = $this->renderModuleForm($itemId);		       
            $response->status = '1';
            $response->msg = '';
        }else{
            $response->status = '0';
            $response->msg = $this->l('Item not found!');
        }		
        die(Tools::jsonEncode($response));
	}
	
	public function deleteModule(){
		$itemId = intval($_POST['itemId']);
        $response = new stdClass();        
        if(Db::getInstance()->execute("Delete From "._DB_PREFIX_."customhtml_module Where id = ".$itemId)){
            Db::getInstance()->execute("Delete From "._DB_PREFIX_."customhtml_module_lang Where module_id = ".$itemId);			
            $response->status = '1';
            $response->msg = $this->l('Delete Module Success!');
			$this->clearCache();
        }else{
            $response->status = '0';
            $response->msg = $this->l('Delete Module not Success!');
        }
        die(Tools::jsonEncode($response));
	}
	
	public function updateModuleOrdering(){
        $response = new stdClass();
        $ids = $_POST['ids'];        
        if($ids){            
            foreach($ids as $i=>$id){
                Db::getInstance()->query("Update "._DB_PREFIX_."customhtml_module Set ordering=".(1 + $i)." Where id = ".$id);                
            }
            $response->status = '1';
            $response->msg = $this->l('Update Module Ordering Success!');
			$this->clearCache();
        }else{
            $response->status = '0';
            $response->msg = $this->l('Update Module Ordering not Success!');
        }
        die(Tools::jsonEncode($response));
	}
	public function hookdisplayHeader(){        
        $this->context->controller->addJS(array(
			$this->_path.'js/hook/customhtml.js',			
		));		
		$this->context->controller->addCSS(($this->_path).'css/hook/customhtml.css');        		
	}
	public function hookdisplayLeftColumn($params){	
		return $this->hooks('hookdisplayLeftColumn', $params);		
	}		
	public function hookdisplayHome($params){
		return $this->hooks('hookdisplayHome', $params);		
	}
	public function hookdisplayTop($params){
		return $this->hooks('hookdisplayTop', $params);		
	}
	
	public function hookdisplayRightColumn($params){		
		return $this->hooks('hookdisplayRightColumn', $params);		
	}
	public function hookdisplayFooter($params){		
		return $this->hooks('hookdisplayFooter', $params);		
	}
	public function hookdisplayNav($params){		
		return $this->hooks('hookdisplayNav', $params);		
	}
	public function hookdisplayTopColumn($params){		
		return $this->hooks('hookdisplayTopColumn', $params);		
	}
	public function hookCustomHtml($params){		
		return $this->hooks('hookCustomHtml', $params);		
	}
	public function hookContactform($params){		
		return $this->hooks('hookContactform', $params);		
	}
	public function hookdisplaySmartBlogLeft($params){
		return $this->hooks('hookDisplaySmartBlogLeft', $params);		
	}
	public function hookdisplaySmartBlogRight($params){
		return $this->hooks('hookDisplaySmartBlogRight', $params);		
	}
	public function hookdisplayBottomContact($params){
		return $this->hooks('displayBottomContact', $params);		
	}



	
public function hookdisplayHomeBottomContent($params){
		return $this->hooks('displayHomeBottomContent', $params);		
	}
public function hookdisplayHomeBottomColumn($params){
		return $this->hooks('displayHomeBottomColumn', $params);		
	}
public function hookdisplayBottomColumn($params){
		return $this->hooks('displayBottomColumn', $params);		
	}
public function hookdisplayCustomHtml1($params){
		return $this->hooks('displayCustomHtml1', $params);		
	}
public function hookdisplayCustomHtml2($params){
		return $this->hooks('displayCustomHtml2', $params);		
	}
public function hookdisplayCustomHtml3($params){
		return $this->hooks('displayCustomHtml3', $params);		
	}
public function hookdisplayCustomHtml4($params){
		return $this->hooks('displayCustomHtml4', $params);		
	}
public function hookdisplayCustomHtml5($params){
		return $this->hooks('displayCustomHtml5', $params);		
	}		
	public function s_print($content, $id_employee=0){
        echo "<pre>";
        	print_r($content);
        echo "</pre>";
        die();
		
	}
    public function hooks($hookName, $param){    	
        $page_name = Dispatcher::getInstance()->getController();
		$page_name = (preg_match('/^[0-9]/', $page_name) ? 'page_'.$page_name : $page_name);
        $this->context->smarty->assign('page_name', $page_name);
        $langId = Context::getContext()->language->id;
        $shopId = Context::getContext()->shop->id;        
        $hookName = strtolower(str_replace('hook','', $hookName));        
        $hookId = Hook::getIdByName($hookName);
		if(!$hookId)  return "";
		$cacheKey = 'customhtml|'.$langId.'|'.$hookName.'|'.$page_name;
		
		if (!$this->isCached('customhtml.tpl', Tools::encrypt($cacheKey))){
			$sql = "Select DISTINCT m.*, ml.`name`, ml.`content`   
	    		From "._DB_PREFIX_."customhtml_module AS m 
	    		INNER JOIN "._DB_PREFIX_."customhtml_module_lang AS ml 
	    			On m.id = ml.module_id         	
	    		Where 
	    			LOWER(m.position_name) = '".$hookName."' 
	    			AND m.status = 1 
	    			AND  m.id_shop = ".$shopId." 
	    			AND ml.id_lang = ".$langId." 
	    		Order 
	    			By m.ordering";
	    	$items = Db::getInstance()->executeS($sql);
			
			$modules = array();
			if($items){
	            foreach($items as $item){            	
	            	$modules[] = $this->buildContentWithLayout($item, $hookName, $shopId, $langId, $cacheKey.'|'.$item['id']);				
	            }
	            $this->context->smarty->assign('customhtml_modules', $modules);
				            
	        }else return ""; 
		}
		return $this->display(__FILE__, 'customhtml.tpl', Tools::encrypt($cacheKey));
    }
	protected function buildContentWithLayout($item, $hookName, $shopId, $langId, $cacheKey){
		
		if (!$this->isCached('customhtml.'.$item['layout'].'.tpl', Tools::encrypt($cacheKey))){
			
			// short codes
			//if($item['content']) $item['content'] = Tools::htmlentitiesDecodeUTF8($item['content']);
	        $content = $item['content'];
			if($content){				
				// short code deal
		        $pattern = '/\{module\}(.*?)\{\/module\}/';
		        $check = preg_match_all($pattern, $content, $match);
		        if($check){
		            $results = $match[1];
		            if($results){
		                foreach($results as $result){
		                	$module_content = '';                    
		                    $config = json_decode(str_replace(array('\\', '\''), array('', '"'), $result));                    
		                    if($config){
		                    	if(is_object($config)){
		                    		if(isset($config->mod) && $config->mod != '' && isset($config->hook) && $config->hook != ''){
		                    			$module = @Module::getInstanceByName($config->mod);
										if($module){
											if (Validate::isLoadedObject($module) && $module->id){
												if (Validate::isHookName($config->hook)){
													$functionName = 'hook'.$config->hook;
													if(method_exists($module, $functionName)){
														$hookArgs = array();
														$hookArgs['cookie'] = $this->context->cookie;
														$hookArgs['cart'] = $this->context->cart;								
														$module_content = $module->$functionName($hookArgs);
														$item['content'] = str_replace('{module}'.$result.'{/module}', $module_content, $item['content']);														
													}else{
														$item['content'] = str_replace('{module}'.$result.'{/module}', '', $item['content']);					
													}
												}else{
													$item['content'] = str_replace('{module}'.$result.'{/module}', '', $item['content']);
												}
											}
										}else{
											$item['content'] = str_replace('{module}'.$result.'{/module}', '', $item['content']);
										}	
		                    		}else{
		                    			$item['content'] = str_replace('{module}'.$result.'{/module}', '', $item['content']);
		                    		}
		                    			
		                    	}else{
		                    		$item['content'] = str_replace('{module}'.$result.'{/module}', '', $item['content']);	
		                    	}
		                    }else{
		                        $item['content'] = str_replace('{module}'.$result.'{/module}', '', $item['content']);
		                    }
		                    
		                }
		            }else{
		            	$item['content'] = preg_replace($pattern, '', $item['content']);
		            }
		        }
			}						
			$this->context->smarty->assign('customhtml_item', $item);
			
		}
		
		return $this->display(__file__, 'customhtml.'.$item['layout'].'.tpl', Tools::encrypt($cacheKey));
	}
	
	function clearCache($cacheKey=''){
		Tools::clearCache();
		return true;
		if(!$cacheKey){
			parent::_clearCache('customhtml.tpl');
			if($this->arrLayout)
				foreach($this->arrLayout as $key=>$value)
					parent::_clearCache('customhtml.'.$key.'.tpl');
		}else{
			parent::_clearCache('customhtml.tpl', Tools::encrypt($cacheKey));
			if($this->arrLayout)
				foreach($this->arrLayout as $key=>$value)
					parent::_clearCache('customhtml.'.$key.'.tpl', Tools::encrypt($cacheKey));
		} 		
       return true;
	}
      
}