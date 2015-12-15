<?php
/*
*  @author SonNC Ovic <nguyencaoson.zpt@gmail.com>
*/
class FlexBanner extends Module
{
    const INSTALL_SQL_FILE = 'install.sql';	
	protected static $tables = array('flexbanner_banner'=>'', 'flexbanner_banner_lang'=>'lang', 'flexbanner_banner_position'=>'position');
    public $arrLayout = array();
	public $imageHomeSize = array();
    public $arrCol = array();	
	public $pathImage = '';
	public static $sameDatas = '';
	public $liveImage = '';	
	protected static $arrPosition = array('displayHomeTopColumn', 'displayHome', 'displayLeftColumn', 'displayRightColumn','displayHomeBottomColumn');
	public function __construct()
	{
		$this->name = 'flexbanner';
		$this->tab = 'front_office_features';
		$this->version = '1.0';
		$this->author = 'OVIC-SOFT';		
		$this->secure_key = Tools::encrypt($this->name);
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('Ovic - Flexible Banner Module');
		$this->description = $this->l('Banner manager');
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);		
		$this->pathImage = dirname(__FILE__).'/images/';
		self::$sameDatas = dirname(__FILE__).'/samedatas/';
		if(Configuration::get('PS_SSL_ENABLED'))
			$this->liveImage = _PS_BASE_URL_SSL_.__PS_BASE_URI__.'modules/flexbanner/images/'; 
		else
			$this->liveImage = _PS_BASE_URL_.__PS_BASE_URI__.'modules/flexbanner/images/';
		$this->arrCol = array('0'=>$this->l('Full') ,'1'=>$this->l('Col 1'),'2'=>$this->l('Col 2'),'3'=>$this->l('Col 3'),'4'=>$this->l('Col 4'),'5'=>$this->l('Col 5'),'6'=>$this->l('Col 6'),'7'=>$this->l('Col 7'),'8'=>$this->l('Col 8'),'9'=>$this->l('Col 9'),'10'=>$this->l('Col 10'),'11'=>$this->l('Col 11'),'12'=>$this->l('Col 12'));
		$this->arrLayout = array('default'=>$this->l('Default'), 'granada'=>$this->l('Granada'), 'granadahome5' => $this->l('Granada home5'));		
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
			foreach ($sql as $query)
				if (!Db::getInstance()->execute(trim($query))) return false;
		}
		if(!parent::install() 
			|| !$this->registerHook('displayHomeTopColumn')
			|| !$this->registerHook('displayHome')
			|| !$this->registerHook('displayLeftColumn')
			|| !$this->registerHook('displayRightColumn')
			|| !$this->registerHook('displayHeader')
            || !$this->registerHook('displayHomeBottomColumn')) return false;
		if (!Configuration::updateGlobalValue('FLEX_BANNER', '1')) return false;
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
									$query_result = str_replace('id_lang', $lang['id_lang'], trim($query));
									if($query_result) Db::getInstance()->execute($query_result);
								}
							}
						}else{                        
							foreach ($sql as $query){
	                            if($query) Db::getInstance()->execute(trim($query));
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
			foreach(self::$tables as $table=>$value) Db::getInstance()->execute('DROP TABLE IF EXISTS '._DB_PREFIX_.$table);
        }	
        if (!Configuration::deleteByName('FLEX_BANNER')) return false;
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
	public function getBannerSrc($image = '', $check = false){		
		if($image){
			if(strpos($image, 'http') !== false){
				return $image;
			}else{
				if(file_exists($this->pathImage.$image))		
		            return $this->liveImage.$image;
		        else
		            if($check == true) 
		                return '';
		            else
		                return $this->liveImage.'default.jpg';
			}
		}else{
			if($check == true) 
                return '';
            else
                return $this->liveImage.'default.jpg';
		}
		/*
        if($image && file_exists($this->pathImage.$image))
            return $this->liveImage.$image;
        else
            if($check == true) 
                return '';
            else
                return $this->livePath.'default.jpg';
		*/ 
    }
	public function getLangOptions($langId = 0){
        if(intval($langId) == 0) $langId = Context::getContext()->language->id;
        $items = Db::getInstance()->executeS("Select id_lang, name, iso_code From "._DB_PREFIX_."lang Where active = 1");
        $options = '';
        if($items){
            foreach($items as $item){
                if($item['id_lang'] == $langId){
                    $options .= '<option value="'.$item['id_lang'].'" selected="selected">'.$item['iso_code'].'</option>';
                }else{
                    $options .= '<option value="'.$item['id_lang'].'">'.$item['iso_code'].'</option>';
                }
            }
        }
        return $options;
    }
	public function getAllLanguages(){
        $langId = Context::getContext()->language->id;
        $items = Db::getInstance()->executeS("Select id_lang, name, iso_code From "._DB_PREFIX_."lang Where active = 1 Order By id_lang");
        $arr = array();
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
				$arr[$i] = $objItem;
            }
        }
        return $arr;
    }
    public function getPositionOptions($selected = ''){
        $positionOptions = '';
        //$items = Db::getInstance()->executeS("Select id_hook From "._DB_PREFIX_."hook_module Where id_module = ".$this->id);
        $options = '';
        //if($items){
            foreach(self::$arrPosition as $value){
                if($selected == $value) $options .= '<option selected="selected" value="'.$value.'">'.$value.'</option>';
                else $options .= '<option value="'.$value.'">'.$value.'</option>';
            }
        //}
        return $options; 
    }
	/*
	public function getPositionMultipleOptions($itemId=0){
		$options = '';
		$selected = array();
		$id_shop = (int)Context::getContext()->shop->id;		
		$items = Db::getInstance()->executeS("Select * From "._DB_PREFIX_."flexbanner_banner_position Where banner_id = $itemId");
		if($items){
			foreach($items as $item) $selected[] = $item['position_id'];
		}
		$items = Db::getInstance()->executeS("Select h.name, h.id_hook From "._DB_PREFIX_."hook AS h Inner Join "._DB_PREFIX_."hook_module as hm On h.id_hook = hm.id_hook Where h.name NOT LIKE 'action%' AND hm.id_module = ".$this->id." AND hm.id_shop = ".$id_shop);        		
		if($items){
			foreach($items as $item){
				if(in_array($item['id_hook'], $selected)) $options .='<option selected="selected" value="'.$item['id_hook'].'">'.$item['name'].'</option>';
				else $options .='<option value="'.$item['id_hook'].'">'.$item['name'].'</option>';
			}
		}
        return $options;
    }
	*/
	public function getPositionMultipleOptions($moduleId=0){		
		$options = '';
		$selected = array();
		$id_shop = (int)Context::getContext()->shop->id;		
		$items = Db::getInstance()->executeS("Select * From "._DB_PREFIX_."flexbanner_banner_position Where banner_id = $moduleId");
		if($items){
			foreach($items as $item) $selected[] = $item['position_id'];
		}
		if(self::$arrPosition){			
			foreach(self::$arrPosition as $value){
				$hookId = Hook::getIdByName($value);
				if(in_array($hookId, $selected)) $options .='<option selected="selected" value="'.$hookId.'">'.$value.'</option>';
				else $options .='<option value="'.$hookId.'">'.$value.'</option>';
			}
		}		
        return $options;
    }   
    public function getLayoutOptions($selected=''){
        $options = '';        
        foreach($this->arrLayout as $key=>$value){
            if($selected == $key) $options .= '<option selected="selected" value="'.$key.'">'.$value.'</option>';
            else $options .= '<option value="'.$key.'">'.$value.'</option>';
        }        
        return $options;
    }
    public function getColumnOptions($selected = ''){
        $options = '';               
        foreach($this->arrCol as $key=> $value){
            if($key == $selected) $options .= '<option selected="selected" value="'.$key.'">'.$value.'</option>';
            else $options .= '<option  value="'.$key.'">'.$value.'</option>';            
        }        
        return $options; 
    }
	public function getBannerByLang($itemId=0, $langId=0){
		if($langId == 0) $langId = Context::getContext()->language->id;		
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."flexbanner_banner_lang Where `banner_id` = ".$itemId." AND `id_lang` = ".$langId);
		if(!$item) $item = array('banner_id'=>$itemId, 'id_lang'=>$langId, 'image'=>'', 'link'=>'', 'alt'=>'', 'description'=>'');		
		return $item;		
	}
	public function renderForm($id = 0){		
		$shopId = Context::getContext()->shop->id;
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."flexbanner_banner Where id = ".$id);
        if(!$item) $item = array('id'=>0, 'id_shop'=>1, 'position_name'=>'', 'custom_class'=>'', 'width'=>0, 'layout'=>'default', 'status'=>1, 'ordering'=>1, 'params'=>'');
		$langs = $this->getAllLanguages();
		$inputAlt = '';
		$inputLink = '';
		$inputImage = '';
		$inputDescription = '';
		$langActive = '<input type="hidden" id="langActive" value="0" />';
		if($langs){
			foreach ($langs as $key => $lang) {
				$itemLang = $this->getBannerByLang($id, $lang->id);
				if($lang->active == '1'){
					$langActive = '<input type="hidden" id="langActive" value="'.$lang->id.'" />';
					$inputAlt .= '<input type="text" value="'.$itemLang['alt'].'" name="alts[]" id="title-'.$lang->id.'" class="form-control lang-'.$lang->id.'" />';
					$inputLink .= '<input type="text" id="link-'.$lang->id.'"  name="links[]" value="'.$itemLang['link'].'" class="form-control lang-'.$lang->id.'" />';
					$inputImage .= '<input type="text" name="images[]" id="image-'.$lang->id.'" value="'.$itemLang['image'].'" class="form-control lang-'.$lang->id.'" />';
					$inputDescription .= '<div class="lang-'.$lang->id.'"><textarea class="editor" name="descriptions[]" id="description-'.$lang->id.'">'.$itemLang['description'].'</textarea></div>';	
				}else{
					$inputAlt .= '<input type="text" value="'.$itemLang['alt'].'" name="alts[]" id="title-'.$lang->id.'" class="form-control lang-'.$lang->id.'" style="display:none" />';
					$inputLink .= '<input type="text" id="link-'.$lang->id.'"  name="links[]" value="'.$itemLang['link'].'" class="form-control lang-'.$lang->id.'" style="display:none" />';
					$inputImage .= '<input type="text" name="images[]" id="image-'.$lang->id.'" value="'.$itemLang['image'].'" class="form-control lang-'.$lang->id.'" style="display:none" />';
					$inputDescription .= '<div style="display:none" class="lang-'.$lang->id.'"><textarea class="editor" name="descriptions[]" id="description-'.$lang->id.'">'.$itemLang['description'].'</textarea></div>';
				}				
			}
		}
		$langOptions = $this->getLangOptions();
		$html = '<input type="hidden" name="bannerId" value="'.$item['id'].'" />';
		$html .= '<input type="hidden" name="action" value="saveBanner" />';
		$html .= '<input type="hidden" name="secure_key" value="'.$this->secure_key.'" />';
		$html .= $langActive;
		$html .= '<div class="form-group">                    
                        <label class="control-label col-sm-2">'.$this->l('Position').'</label>
                        <div class="col-sm-10">
                            <div class="col-sm-5">
                                <select name="position_name" class="form-control">'.$this->getPositionOptions($item['position_name']).'</select>
                            </div>
                            <label class="control-label col-sm-2">'.$this->l('Layout').'</label>
                            <div class="col-sm-5">
                                <select name="layout" class="form-control">'.$this->getLayoutOptions($item['layout']).'</select>
                            </div>
                        </div>                                             
                    </div>';
                    
		$html .= '<div class="form-group">                    
                        <label class="control-label col-sm-2">'.$this->l('Width').'</label>
                        <div class="col-lg-10 ">
                            <div class="col-sm-5">
                                <select name="width" class="form-control">'.$this->getColumnOptions($item['width']).'</select>
                            </div>
                            <label class="control-label col-sm-2">'.$this->l('Custom class').'</label>
                            <div class="col-sm-5">
                                <input type="text" name="custom_class" value="'.$item['custom_class'].'" class="form-control" />
                            </div>
                        </div>
                    </div>';
		$html .= '<div class="form-group clearfix">
                        <label class="control-label col-sm-2">'.$this->l('Banner').'</label>
                        <div class="col-sm-10">
                            <div class="col-sm-10">                        
                                <div class="input-group">
                                    '.$inputImage.'                                
                                    <span class="input-group-btn">
                                        <button id="banner" type="button" class="btn btn-default"><i class="icon-folder-open"></i></button>
                                    </span>
                                </div>                        
                            </div>
                            <div class="col-sm-2">
                                <select class="lang form-control" onchange="changeLanguage(this.value)">'.$langOptions.'</select>
                            </div>
                        </div>  
                    </div>';
		$html .= '<div class="form-group">
                        <label class="control-label col-lg-2">'.$this->l('Alt').'</label>
                        <div class="col-lg-10 ">
                            <div class="col-sm-10">
                                '.$inputAlt.'
                            </div>
                            <div class="col-sm-2">
                                <select class="lang form-control" onchange="changeLanguage(this.value)">'.$langOptions.'</select>
                            </div>
                        </div>
                    </div>';
		$html .= '<div class="form-group">
                        <label class="control-label col-lg-2">'.$this->l('Link').'</label>
                        <div class="col-lg-10 ">
                            <div class="col-sm-10">
                                '.$inputLink.'
                            </div>
                            <div class="col-sm-2">
                                <select class="lang form-control" onchange="changeLanguage(this.value)">'.$langOptions.'</select>
                            </div>
                        </div>
                    </div>';
		$html .= '<div class="form-group">
                        <label class="control-label col-lg-2">'.$this->l('Description').'</label>
                        <div class="col-lg-10 ">
                            <div class="col-sm-10">
                                '.$inputDescription.'
                            </div>
                            <div class="col-sm-2">
                                <select class="lang form-control" onchange="changeLanguage(this.value)">'.$langOptions.'</select>
                            </div>
                        </div>
                    </div>';
		return $html;
	}
	public function getPositionNameByBanner($id = 0){
		$items = Db::getInstance()->executeS("Select * From "._DB_PREFIX_."flexbanner_banner_position Where banner_id = $id");
		$results = array();
		if($items){
			foreach ($items as $item) {
				$results[] = $item['position_name'];
			}
		}
		return implode('<br />', $results);
	}
	public function getContent()
	{
		// foreach(self::$arrPosition as $hook)
			// $this->registerHook($hook);
		//$this->registerHook('displayLeftColumn');
		//$this->registerHook('displayRightColumn');
		$action = Tools::getValue('action', 'view');	   	
		if($action == 'view'){
			$langId = Context::getContext()->language->id;
	        $shopId = Context::getContext()->shop->id;
			$this->context->controller->addJS(($this->_path).'js/back-end/common.js');                
			$this->context->controller->addJS(($this->_path).'js/back-end/jquery.serialize-object.min.js');
			$this->context->controller->addJS(__PS_BASE_URI__.'js/jquery/plugins/jquery.tablednd.js');
			$this->context->controller->addJS(__PS_BASE_URI__.'js/tiny_mce/tinymce.min.js');
			$this->context->controller->addJS(($this->_path).'js/back-end/tinymce.inc.js');
			$this->context->controller->addJS(($this->_path).'js/back-end/ajaxupload.3.5.js');
	        $this->context->controller->addCSS(($this->_path).'css/back-end/style.css');
			$this->context->controller->addCSS(($this->_path).'css/back-end/style-upload.css'); 
			$items = Db::getInstance()->executeS("Select b.*, bl.image, bl.alt From "._DB_PREFIX_."flexbanner_banner as b Left Join "._DB_PREFIX_."flexbanner_banner_lang as bl On bl.banner_id = b.id Where bl.id_lang = ".$langId." Order By b.ordering");
			if($items){
				foreach($items as &$item){
					$item['image'] = $this->getBannerSrc($item['image'],true);
				}
			}         
	        $this->context->smarty->assign(array(
	            'baseModuleUrl'=> __PS_BASE_URI__.'modules/'.$this->name,            
	            'currentUrl'=> $this->getCurrentUrl(),
	            'moduleId'=>$this->id,
	            'langId'=>$langId,
	            'iso'=>$this->context->language->iso_code,
	            'ad'=>$ad = dirname($_SERVER["PHP_SELF"]),
	            'secure_key'=> $this->secure_key,
	            'form'=>$this->renderForm(),
	            'items'=>$items
	        ));
			return $this->display(__FILE__, 'views/templates/admin/modules.tpl');
		}elseif($action == 'data-export'){
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
			if(method_exists($this, $action)){			 
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
				$query1 = mysql_query('SELECT * FROM '._DB_PREFIX_.$table." Where id_lang = ".$langId);		
				$num_fields = mysql_num_fields($query1);
				for ($i = 0; $i < $num_fields; $i++) 
				{
					while($row = mysql_fetch_row($query1))
					{
						$return.= 'INSERT INTO PREFIX_'.$table.' VALUES(';
						for($j=0; $j<$num_fields; $j++) 
						{
							$row[$j] = addslashes($row[$j]);
							$row[$j] = str_replace(array("\n", "\r"), '', $row[$j]);
							if (isset($row[$j])) {
								if($fields[$j] == 'id_lang')
								 	$return.= '"id_lang"' ;								
								else
									$return.= '"'.$row[$j].'"' ; 
							} else {
								 $return.= '""'; 
							}
							if ($j<($num_fields-1)) { $return.= ','; }
						}
						$return.= ");\n";
					}
				}
			
			}else{
				$query1 = mysql_query('SELECT * FROM '._DB_PREFIX_.$table);		
				$num_fields = mysql_num_fields($query1);
				for ($i = 0; $i < $num_fields; $i++) 
				{
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
				}	
			}
			$return.="\n";			
			$handle = fopen(self::$sameDatas.$currentOption.$table.'.sql','w+');
			fwrite($handle,$return);
			fclose($handle);
		}		
		return true;
		$files = scandir($this->pathImage);
		foreach ($files as $file)
			if($file !='.' && $file !='..' && $file != 'temps')
				copy($this->pathImage.$file, $this->sameDatas.$file);
		$zip = new ZipArchive;
		$zip->open($this->sameDatas.'bak.zip', ZipArchive::CREATE);
        $handle = fopen($this->sameDatas.$currentOption.$table.'.sql','w+');
		while (false !== ($file = readdir($handle))) {
			if($file != '.' && $file != '..' && is_dir($this->sameDatas.$file)){
				//$fileContents = file_get_contents($this->sameDatas.$file);
				$zip->addFile($this->sameDatas.$file, $file);
			}
		}
		closedir($handle);				
		$zip->close();
		header("Location: bak.zip");
		exit;	
	}
	function saveBanner(){		
		$shopId = Context::getContext()->shop->id;
		$languages = $this->getAllLanguages();		
        $db = Db::getInstance();
		$itemId = intval($_POST['bannerId']);
		$position_name = Tools::getValue('position_name', '');
		//$positions = Tools::getValue('positions', array());
		$layout = Tools::getValue('layout', '');
		$width = intval($_POST['width']);
		$custom_class = Tools::getValue('custom_class', '');
		$images = Tools::getValue('images', array());
		$alts = Tools::getValue('alts', array());
		$links = Tools::getValue('links', array());
		$descriptions = Tools::getValue('descriptions', array());
		$response = new stdClass();
		$params = '';
        if($itemId == 0){				
			$maxOrdering = $db->getValue("Select MAX(ordering) From "._DB_PREFIX_."flexbanner_banner Where `id_shop` = ".$shopId);
	   		if($maxOrdering >0) $maxOrdering++;
	   		else $maxOrdering = 1;
            if($db->execute("Insert Into "._DB_PREFIX_."flexbanner_banner (`id_shop`, `position_name`, `custom_class`, `width`, `layout`, `params`, `status`, `ordering`) Values ('".$shopId."', '$position_name', '".$custom_class."', '".$width."', '".$layout."', '$params', '1' ,'$maxOrdering')")){
                $insertId = $db->Insert_ID();
				/*
				if($positions){
					foreach($positions as $position){
						if($position >0){
							$positionName = Hook::getNameById($position);
							Db::getInstance()->execute("Insert Into "._DB_PREFIX_."flexbanner_banner_position (`banner_id`, `position_id`, `position_name`) Values ('$insertId', '$position', '$positionName')");							
						}
					}
				}				
				*/
				if($languages){
                	$insertDatas = array();
                	foreach($languages as $index=>$language){
                		$description = Tools::htmlentitiesUTF8($descriptions[$index]);
                		$link = pSQL($links[$index], true);
						$alt = pSQL($alts[$index], true);
                		if($images){
                			if($images[$index]){
                				if(strpos($images[$index], 'http') !== false){
                					$insertDatas[] = array('banner_id'=>$insertId, 'id_lang'=>$language->id, 'image'=>$images[$index], 'link'=>$link, 'alt'=>$alt, 'description'=>$description) ;
                				}else{
	                				if(file_exists($this->pathImage.'temps/'.$images[$index])){	                			                 					                    
					                    if(@copy($this->pathImage.'temps/'.$images[$index], $this->pathImage.$images[$index])){
					                    	unlink($this->pathImage.'temps/'.$images[$index]);
					                    	$insertDatas[] = array('banner_id'=>$insertId, 'id_lang'=>$language->id, 'image'=>$images[$index], 'link'=>$link, 'alt'=>$alt, 'description'=>$description) ;	
					                    }else{
					                    	$insertDatas[] = array('banner_id'=>$insertId, 'id_lang'=>$language->id, 'image'=>'', 'link'=>$link, 'alt'=>$alt, 'description'=>$description) ;
					                    }
					                }else{
					                	$insertDatas[] = array('banner_id'=>$insertId, 'id_lang'=>$language->id, 'image'=>'', 'link'=>$link, 'alt'=>$alt, 'description'=>$description) ;
					                }	
                				}
                			}else{
                				$insertDatas[] = array('banner_id'=>$insertId, 'id_lang'=>$language->id, 'image'=>'', 'link'=>$link, 'alt'=>$alt, 'description'=>$description) ;
                			}                			
                		}else{                			
			                $insertDatas[] = array('banner_id'=>$insertId, 'id_lang'=>$language->id, 'image'=>'', 'link'=>$link, 'alt'=>$alt, 'description'=>$description) ;
                		}
                	}						
					if($insertDatas) $db->insert('flexbanner_banner_lang', $insertDatas);
                }                    
                $response->status = '1';
                $response->msg = $this->l("Add new banner Success!");
            }else{
                $response->status = '0';
                $response->msg = $this->l("Add new banner not Success!");
            }
        }else{
            $item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."flexbanner_banner Where id = ".$itemId);                
            Db::getInstance()->execute("Update "._DB_PREFIX_."flexbanner_banner Set `position_name`='$position_name', `custom_class` = '".$custom_class."', `width` = '".$width."', `layout`='".$layout."', `params` = '".$params."' Where id = ".$itemId);
			/*
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexbanner_banner_position Where `banner_id` = ".$itemId);
			if($positions){
				foreach($positions as $position){
					if($position >0){
						$positionName = Hook::getNameById($position);
						Db::getInstance()->execute("Insert Into "._DB_PREFIX_."flexbanner_banner_position (`banner_id`, `position_id`, `position_name`) Values ('$itemId', '$position', '$positionName')");							
					}
				}
			}
			*/
			if($languages){
				$insertDatas = array();
            	foreach($languages as $index=>$language){
            		$description = Tools::htmlentitiesUTF8($descriptions[$index]);
            		$link = pSQL($links[$index], true);
					$alt = pSQL($alts[$index], true);
					$check = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."flexbanner_banner_lang Where banner_id = ".$itemId." AND `id_lang` = ".$language->id);	                		
            		if($images){
            			if($images[$index]){
            				if(strpos($images[$index], 'http') !== false){
            					if($check){
            						if($check['image'] && file_exists($this->pathImage.$check['image'])) unlink($this->pathImage.$check['image']);
			                    	$db->execute("Update "._DB_PREFIX_."flexbanner_banner_lang Set `image`='".$images[$index]."',  `link` = '$link', `alt` = '$alt', `description` = '".$description."'  Where `banner_id` = $itemId AND `id_lang` = ".$language->id);	
			                    }else{
			                    	$insertDatas[] = array('banner_id'=>$itemId, 'id_lang'=>$language->id, 'image'=>$images[$index], 'link'=>$link, 'alt'=>$alt, 'description'=>$description) ;
			                    }
							}else{
								if(file_exists($this->pathImage.'temps/'.$images[$index])){                    		                    
				                    copy($this->pathImage.'temps/'.$images[$index], $this->pathImage.$images[$index]);                    
				                    unlink($this->pathImage.'temps/'.$images[$index]);		                    
				                    if($check){
				                    	if($check['image'] && file_exists($this->pathImage.$check['image'])) unlink($this->pathImage.$check['image']);
				                    	$db->execute("Update "._DB_PREFIX_."flexbanner_banner_lang Set  `link` = '$link', `image` = '".$images[$index]."', `alt` = '$alt', `description` = '".$description."' Where `banner_id` = $itemId AND `id_lang` = ".$language->id);	
				                    }else{
				                    	$insertDatas[] = array('banner_id'=>$itemId, 'id_lang'=>$language->id, 'image'=>$images[$index], 'link'=>$link, 'alt'=>$alt, 'description'=>$description) ;
				                    }
				                }else{
				                	if($check){
				                    	$db->execute("Update "._DB_PREFIX_."flexbanner_banner_lang Set  `link` = '$link', `alt` = '$alt', `description` = '".$description."'  Where `banner_id` = $itemId AND `id_lang` = ".$language->id);	
				                    }else{
				                    	$insertDatas[] = array('banner_id'=>$itemId, 'id_lang'=>$language->id, 'image'=>'', 'link'=>$link, 'alt'=>$alt, 'description'=>$description) ;
				                    }
				                }
							}	
						}else{
							if($check){
		                    	$db->execute("Update "._DB_PREFIX_."flexbanner_banner_lang Set  `link` = '$link', `alt` = '$alt', `description` = '".$description."'  Where `banner_id` = $itemId AND `id_lang` = ".$language->id);	
		                    }else{
		                    	$insertDatas[] = array('banner_id'=>$itemId, 'id_lang'=>$language->id, 'image'=>'', 'link'=>$link, 'alt'=>$alt, 'description'=>$description) ;
		                    }
						}
            		}else{            			
	                	if($check){
	                    	$db->execute("Update "._DB_PREFIX_."flexbanner_banner_lang Set  `link` = '".$db->escape($links[$index])."', `alt` = '".$db->escape($alts[$index])."', `description` = '".$description."'  Where `banner_id` = $itemId AND `id_lang` = ".$language->id);	
	                    }else{
	                    	$insertDatas[] = array('banner_id'=>$itemId, 'id_lang'=>$language->id, 'image'=>'', 'link'=>$db->escape($links[$index]), 'alt'=>$db->escape($alts[$index]), 'description'=>$description) ;
	                    }
            		}
					if($insertDatas) Db::getInstance()->insert('flexbanner_banner_lang', $insertDatas);
            	}
            }
			$response->status = 1;
        	$response->msg = $this->l("Update banner success!");
        }
        die(Tools::jsonEncode($response));
	}
	public function changeBannerStatus(){
		$itemId = intval($_POST['itemId']);
		$value = intval($_POST['value']);		
		$response = new stdClass();
		$this->clearCache();
		if($value == '1'){
			DB::getInstance()->execute("Update "._DB_PREFIX_."flexbanner_banner Set `status` = 0 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = 'Update status success';
		}else{
			DB::getInstance()->execute("Update "._DB_PREFIX_."flexbanner_banner Set `status` = 1 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = 'Update status success';
		}
		die(Tools::jsonEncode($response));
	}
	public static function updateBannerOrdering(){
		$shopId = Context::getContext()->shop->id;
		$ids = $_POST['ids'];     
		$response = new stdClass();
        if($ids){
            $strIds = implode(', ', $ids);            
            $minOrder = DB::getInstance()->getValue("Select Min(ordering) From "._DB_PREFIX_."flexbanner_banner Where id IN ($strIds)");            
            foreach($ids as $i=>$id){
                DB::getInstance()->query("Update "._DB_PREFIX_."flexbanner_banner Set ordering=".($minOrder + $i)." Where id = ".$id);                
            }
            $response->status = 1;
            $response->msg='Update ordering success!';
        }else{
        	$response->status = 0;
            $response->msg='Update ordering not success!';
        }
		$this->clearCache();
        die(Tools::jsonEncode($response));
	}
	public function getBannerItem(){		
        $response = new stdClass();
        $itemId = intval($_POST['itemId']);
        if($itemId){
        	$response->form = $this->renderForm($itemId);		       
            $response->status = '1';
            $response->msg = '';
        }else{
            $response->status = '0';
            $response->msg = $this->l('Item not found!');
        }		
        die(Tools::jsonEncode($response));
	}
	public function deleteBanner(){
		$itemId = intval($_POST['itemId']);
		$response = new stdClass();
		if(DB::getInstance()->execute("Delete From "._DB_PREFIX_."flexbanner_banner where id = $itemId")){
			$items = DB::getInstance()->executeS("Select * From "._DB_PREFIX_."flexbanner_banner_lang Where banner_id = ".$itemId);
			if($items){
				foreach($items as $item){
					if($item['image'] && file_exists($this->pathImage.$item['image'])) unlink($this->pathImage.$item['image']);
				}
			}
			DB::getInstance()->execute("Delete From "._DB_PREFIX_."flexbanner_banner_lang where banner_id = $itemId");
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexbanner_banner_position Where banner_id = $itemId");
			$response->status = 1;
			$response->msg = "Delete banner Success!";
		}else{
			$response->status = 0;
			$response->msg = "Delete banner not Success!";
		}
		$this->clearCache();
		die(Tools::jsonEncode($response));
	}
    public function hookdisplayHeader()
	{
	    // Call in : callmosules.css 
		//$this->context->controller->addCSS(($this->_path).'css/front-end/style.css');	
        $this->context->controller->addJS(($this->_path).'js/front-end/common.js');
	}
	public function hookdisplayHomeTopColumn($params)
	{		
		return $this->hooks('hookdisplayHomeTopColumn', $params);
	}
	public function hookdisplayHome($params)
	{		
		return $this->hooks('hookdisplayHome', $params);
	}
	public function hookdisplayLeftColumn($params)
	{		
		return $this->hooks('hookdisplayLeftColumn', $params);
	}
	public function hookdisplayRightColumn($params)
	{		
		return $this->hooks('hookdisplayRightColumn', $params);
	}	
    public function hookdisplayHomeBottomColumn($params)
	{		
		return $this->hooks('hookdisplayHomeBottomColumn', $params);
	}
    public function hooks($hookName, $param){        
        $langId = Context::getContext()->language->id;
        $shopId = Context::getContext()->shop->id;        
        $hookName = str_replace('hook','', $hookName);        
        $hookId = (int)Hook::getIdByName($hookName);
        if($hookId <=0) return '';
        $this->context->smarty->assign('hookname', $hookName);
		$page_name = Dispatcher::getInstance()->getController();
		$page_name = (preg_match('/^[0-9]/', $page_name) ? 'page_'.$page_name : $page_name);
		$cacheKey = 'flexbanner|'.$langId.'|'.$hookId.'|'.$page_name;		
        if (!$this->isCached('flexbanner.tpl', Tools::encrypt($cacheKey))){
			$items = DB::getInstance()->executeS("Select DISTINCT b.*, bl.`image`, bl.alt, bl.link, bl.description 
			From "._DB_PREFIX_."flexbanner_banner AS b 
			INNER JOIN "._DB_PREFIX_."flexbanner_banner_lang AS bl 
				On b.id = bl.banner_id 
			Where 
				b.`position_name` = '".$hookName."' 
				AND b.status = 1 
				AND b.id_shop = ".$shopId." 
				AND bl.id_lang = ".$langId." 
			Order 
				By ordering");            
			if($items){
				foreach($items as &$item){
					$item['image'] = $this->getBannerSrc($item['image'], true);                    
                    $item['html'] = $this->frontBuildBanner($item, $cacheKey.'|'.$item['id']);                                                                    					
				}
			}			
			$this->context->smarty->assign('flexbanner_contents', $items);
		}else return '';
		return $this->display(__FILE__, 'flexbanner.tpl', Tools::encrypt($cacheKey));		
    }    
    function frontBuildBanner($banner, $cacheKey=''){
    	if (!$this->isCached('flexbanner.'.$banner['layout'].'.tpl', Tools::encrypt($cacheKey))){
    		$this->context->smarty->assign('banner', $banner);		
    	}        
        return $this->display(__FILE__, 'flexbanner.'.$banner['layout'].'.tpl', Tools::encrypt($cacheKey));
    }   
    function clearCache($cacheKey=''){
		if(!$cacheKey){
			parent::_clearCache('flexbanner.tpl');
			if($this->arrLayout)
				foreach($this->arrLayout as $key=>$value)
					parent::_clearCache('flexbanner.'.$key.'.tpl');
		}else{
			parent::_clearCache('flexbanner.tpl', Tools::encrypt($cacheKey));
			if($this->arrLayout)
				foreach($this->arrLayout as $key=>$value)
					parent::_clearCache('flexbanner.'.$key.'.tpl', Tools::encrypt($cacheKey));
		} 		
       return true;
	}    
}