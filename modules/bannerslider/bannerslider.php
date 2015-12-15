<?php
/*
*  @author SonNC Ovic <nguyencaoson.zpt@gmail.com>
*/
class BannerSlider extends Module
{
    const INSTALL_SQL_FILE = 'install.sql';	
	protected static $tables = array('bannerslider_module'=>'module', 'bannerslider_module_lang'=>'lang', 'bannerslider_item'=>'', 'bannerslider_item_lang'=>'lang');
    
    protected static $tablesHomeSlider = array('homeslider'=>'', 'homeslider_slides_lang'=>'lang', 'homeslider_slides'=>'');
    
	protected static $arrPosition = array('displayBannerSlider1', 'displayBannerSlider2', 'displayBannerSlider3', 'displayBannerSlider4', 'displayBannerSlider5', 'displayBannerSlider6', 'displayBannerSlider7', 'displayBannerSlider8', 'displayBannerSlider9');
    public $arrLayout = array();
	public $imageHomeSize = array();
    public $arrCol = array();	
	public $pathImage = '';
	protected static $sameDatas = '';
	public $liveImage = '';	
	public function __construct()
	{
		$this->name = 'bannerslider';
		$this->tab = 'front_office_features';
		$this->version = '2.0';
		$this->author = 'OVIC-SOFT';		
		$this->secure_key = Tools::encrypt($this->name);
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('Ovic - Banner Slider Module');
		$this->description = $this->l('Ovic - Banner Slider Module');
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);		
		$this->pathImage = dirname(__FILE__).'/images/';
		self::$sameDatas = dirname(__FILE__).'/samedatas/';
		if(Configuration::get('PS_SSL_ENABLED'))
			$this->liveImage = _PS_BASE_URL_SSL_.__PS_BASE_URI__.'modules/'.$this->name.'/images/'; 
		else
			$this->liveImage = _PS_BASE_URL_.__PS_BASE_URI__.'modules/'.$this->name.'/images/';
		$this->arrCol = array('1'=>$this->l('1 Column'),'2'=>$this->l('2 Columns'),'3'=>$this->l('3 Columns'),'4'=>$this->l('4 Columns'),'5'=>$this->l('5 Columns'),'6'=>$this->l('6 Columns'),'7'=>$this->l('7 Columns'),'8'=>$this->l('8 Columns'),'9'=>$this->l('9 Columns'),'10'=>$this->l('10 Columns'),'11'=>$this->l('11 Columns'),'12'=>$this->l('12 Columns'));
		$this->arrLayout = 	array('default'=>$this->l('Default'), 'lookbook' => $this->l('LookBook Slider'));
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
			|| !$this->registerHook('displayHeader')
			|| !$this->registerHook('displayBannerSlider1')
			|| !$this->registerHook('displayBannerSlider2')
			|| !$this->registerHook('displayBannerSlider3')
			|| !$this->registerHook('displayBannerSlider4')
			|| !$this->registerHook('displayBannerSlider5')
			|| !$this->registerHook('displayBannerSlider6')
			|| !$this->registerHook('displayBannerSlider7')
			|| !$this->registerHook('displayBannerSlider8')
			|| !$this->registerHook('displayBannerSlider9')) return false;
		if (!Configuration::updateGlobalValue('MOD_BANNER_SLIDER', '1')) return false;
		$this->importSameData();
		return true;
	}
	public function importSameData($directory=''){
	   //foreach(self::$tables as $table=>$value) Db::getInstance()->execute('TRUNCATE TABLE '._DB_PREFIX_.$table);
		if($directory) self::$sameDatas = $directory;
		$langs = DB::getInstance()->executeS("Select id_lang From "._DB_PREFIX_."lang Where active = 1");		
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
									if($query_result)
	                                    Db::getInstance()->execute($query_result);
								}
							}
						}else{                        
							foreach ($sql as $query){
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
    public function importHomeSliderSameData(){
		
		$langs = DB::getInstance()->executeS("Select id_lang From "._DB_PREFIX_."lang Where active = 1");		
		if(self::$tablesHomeSlider){
		      $currentOption = Configuration::get('OVIC_CURRENT_DIR');
                if($currentOption) $currentOption .= '.';
                else $currentOption = '';
			foreach(self::$tablesHomeSlider as $table=>$value){
                
				if (file_exists(self::$sameDatas.$currentOption.$table.'.sql')){
				    Db::getInstance()->execute('TRUNCATE TABLE '._DB_PREFIX_.$table);
					$sql = file_get_contents(self::$sameDatas.$currentOption.$table.'.sql');
					$sql = str_replace(array('PREFIX_', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $sql);
					$sql = preg_split("/;\s*[\r\n]+/", trim($sql));
					if($value == 'lang'){
						foreach ($sql as $query){
							foreach($langs as $lang){								    
								$query_result = str_replace('id_lang', $lang['id_lang'], trim($query));
								if($query_result)
                                    Db::getInstance()->execute($query_result);
							}
						}
                        	
					}else{                        
						foreach ($sql as $query){
                            if($query)
                                Db::getInstance()->execute(trim($query));
						}
                        
					}
				}
				
			}
		}
		return true;
	}
	public function uninstall($keep = true){	   
		if (!parent::uninstall()) return false;		
        if($keep){
			if(self::$tables){
				foreach(self::$tables as $table=>$value)
					Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.$table.'`');
			}			
        }			
        if (!Configuration::deleteByName('MOD_BANNER_SLIDER')) return false;
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
	/*
    public function getPositionOptions($selected = 0){
        $positionOptions = '';
        $items = Db::getInstance()->executeS("Select id_hook From "._DB_PREFIX_."hook_module Where id_module = ".$this->id);
        $options = '';
        if($items){
            foreach($items as $item){
                if($selected == $item['id_hook']) $options .= '<option selected="selected" value="'.$item['id_hook'].'">'.Hook::getNameById($item['id_hook']).'</option>';
                else $options .= '<option value="'.$item['id_hook'].'">'.Hook::getNameById($item['id_hook']).'</option>';
            }
        }
        return $options; 
    }
 * 
 */
	public function getPositionOptions($selected=''){		
		$options = '';
		if(self::$arrPosition){			
			foreach(self::$arrPosition as $value){
				//$hookId = Hook::getIdByName($value);
				if($value == $selected) $options .='<option selected="selected" value="'.$value.'">'.$value.'</option>';
				else $options .='<option value="'.$value.'">'.$value.'</option>';
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
	protected function getModuleByLang($itemId=0, $langId=0){
		if($langId == 0) $langId = Context::getContext()->language->id;
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."bannerslider_module_lang Where `item_id` = ".$itemId." AND `id_lang` = ".$langId);
		if(!$item) $item = array('item_id'=>$itemId, 'id_lang'=>$langId, 'name'=>'', 'title'=>'', 'description'=>'', 'link_text'=>'', 'link'=>'');		
		return $item;		
	}
	protected function getSlideByLang($itemId=0, $langId=0){
		if($langId == 0) $langId = Context::getContext()->language->id;
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."bannerslider_item_lang Where `item_id` = ".$itemId." AND `id_lang` = ".$langId);
		if(!$item) $item = array('item_id'=>$itemId, 'id_lang'=>$langId, 'image'=>'', 'alt'=>'', 'description'=>'');		
		return $item;		
	}	
	public function renderModuleForm($id = 0){		
		$shopId = Context::getContext()->shop->id;
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."bannerslider_module Where id = ".$id);
        if(!$item) $item = array('id'=>0, 'id_shop'=>0, 'position_id'=>0, 'position_name'=>'', 'layout'=>'default', 'custom_class'=>'', 'display_name'=>1, 'status'=>1, 'ordering'=>1, 'params'=>'');
		$langs = $this->getAllLanguages();
		$inputName = '';
		$inputTitle = '';
		$inputLink = '';
		$inputLinkText = '';
		$inputDescription = '';
		$langActive = '<input type="hidden" id="langModuleActive" value="0" />';
		if($langs){
			foreach ($langs as $key => $lang) {
				$itemLang = $this->getModuleByLang($id, $lang->id);
				if($lang->active == '1'){
					$langActive = '<input type="hidden" id="langModuleActive" value="'.$lang->id.'" />';
					$inputName .= '<input type="text" value="'.$itemLang['name'].'" name="names[]" class="form-control module-lang-'.$lang->id.'" />';
					$inputTitle .= '<input type="text" value="'.$itemLang['title'].'" name="titles[]" class="form-control module-lang-'.$lang->id.'" />';
					$inputLink .= '<input type="text"  name="links[]" value="'.$itemLang['link'].'" class="form-control module-lang-'.$lang->id.'" />';
					$inputLinkText .= '<input type="text" value="'.$itemLang['link_text'].'" name="link_texts[]" class="form-control module-lang-'.$lang->id.'" />';
					$inputDescription .= '<div class="module-lang-'.$lang->id.'"><textarea class="editor" name="descriptions[]" id="module-description-'.$lang->id.'">'.$itemLang['description'].'</textarea></div>';					
				}else{
					$inputName .= '<input type="text" value="'.$itemLang['name'].'" name="names[]" class="form-control module-lang-'.$lang->id.'" style="display:none" />';
					$inputTitle .= '<input type="text" value="'.$itemLang['title'].'" name="titles[]" class="form-control module-lang-'.$lang->id.'" style="display:none" />';
					$inputLink .= '<input type="text"  name="links[]" value="'.$itemLang['link'].'" class="form-control module-lang-'.$lang->id.'" style="display:none" />';
					$inputLinkText .= '<input type="text" value="'.$itemLang['link_text'].'" name="link_texts[]" class="form-control module-lang-'.$lang->id.'" style="display:none" />';					
					$inputDescription .= '<div style="display:none" class="module-lang-'.$lang->id.'"><textarea class="editor" name="descriptions[]" id="module-description-'.$lang->id.'">'.$itemLang['description'].'</textarea></div>';
				}				
			}
		}
		$langOptions = $this->getLangOptions();
		$html = '<input type="hidden" name="moduleId" value="'.$item['id'].'" />';
		$html .= '<input type="hidden" name="action" value="saveModule" />';
		$html .= '<input type="hidden" name="secure_key" value="'.$this->secure_key.'" />';
		$html .= $langActive;
		
		$html .= '<div class="form-group">                    
                        <label class="control-label col-sm-2">'.$this->l('Module name').'</label>
                        <div class="col-sm-10">
	                        <div class="col-sm-10">'.$inputName.'</div>
	                        <div class="col-sm-2">
	                            <select class="module-lang form-control" onchange="changeModuleLanguage(this.value)">'.$langOptions.'</select>
	                        </div>
                        </div>
                    </div>';
		$html .= '<div class="form-group">                    
                        <label class="control-label col-sm-2">'.$this->l('Position').'</label>
                        
                        <div class="col-sm-10">
                            <div class="col-sm-5">
                                <select name="position_name" class="form-control">'.$this->getPositionOptions($item['position_name']).'</select>
                            </div>
                            <label class="control-label col-sm-2">'.$this->l('Display name').'</label>
							<div class="col-sm-5">
	                            <span class="switch prestashop-switch fixed-width-lg" id="module-display-name">
	                                <input type="radio" value="1" class="module_display_name" '.($item['display_name'] == 1 ? 'checked="checked"' : '').' id="module_display_name_on" name="module_display_name" />
	            					<label for="module_display_name_on">Yes</label>
	            				    <input type="radio" value="0" class="module_display_name" '.($item['display_name'] == 0 ? ' checked="checked" ' : '').' id="module_display_name_off" name="module_display_name" />
	            					<label for="module_display_name_off">No</label>
	                                <a class="slide-button btn"></a>
	            				</span>
		                    </div>
                        </div>
                    </div>';
        $html .= '<div class="form-group">                    
                        <label class="control-label col-sm-2">'.$this->l('Module layout').'</label>
                        <div class="col-sm-10">
                            <div class="col-sm-5"><select name="layout">'.$this->getLayoutOptions($item['layout']).'</select></div>
                            <label class="control-label col-sm-2">'.$this->l('Custom class').'</label>
	                        <div class="col-sm-5">
	                            <input type="text" name="custom_class" value="'.$item['custom_class'].'" class="form-control" />
	                        </div>
                        </div>                        
                    </div>';        				
        $html .= '<div class="form-group">                    
                        <label class="control-label col-sm-2">'.$this->l('Description').'</label>
                        <div class="col-sm-10">
                            <div class="col-sm-10">'.$inputDescription.'</div>
                            <div class="col-sm-2">
	                            <select class="module-lang form-control" onchange="changeModuleLanguage(this.value)">'.$langOptions.'</select>
	                        </div>
                        </div>
                        
                    </div>';
		
		return $html;
	}	
	public function renderSlideForm($id = 0){		
		$shopId = Context::getContext()->shop->id;
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."bannerslider_item Where id = ".$id);
        if(!$item) $item = array('id'=>0, 'module_id'=>1, 'status'=>1, 'ordering'=>1, 'custom_class'=>'', 'params'=>'');
		$langs = $this->getAllLanguages();
		$inputAlt = '';
		$inputImage = '';
		$inputDescription = '';
		$langActive = '<input type="hidden" id="slideLangActive" value="0" />';
		if($langs){
			foreach ($langs as $key => $lang) {
				$itemLang = $this->getSlideByLang($id, $lang->id);
				if($lang->active == '1'){
					$langActive = '<input type="hidden" id="slideLangActive" value="'.$lang->id.'" />';
					$inputAlt .= '<input type="text" value="'.$itemLang['alt'].'" name="alts[]" id="alt-'.$lang->id.'" class="form-control slide-lang-'.$lang->id.'" />';
					$inputImage .= '<input type="text" name="images[]" id="slide-'.$lang->id.'" value="'.$itemLang['image'].'" class="form-control slide-lang-'.$lang->id.'" />';
					$inputDescription .= '<div class="slide-lang-'.$lang->id.'"><textarea class="editor" name="descriptions[]" id="description-'.$lang->id.'">'.$itemLang['description'].'</textarea></div>';	
				}else{
					$inputAlt .= '<input type="text" value="'.$itemLang['alt'].'" name="alts[]" id="alt-'.$lang->id.'" class="form-control slide-lang-'.$lang->id.'" style="display:none" />';
					$inputImage .= '<input type="text" name="images[]" id="slide-'.$lang->id.'" value="'.$itemLang['image'].'" class="form-control slide-lang-'.$lang->id.'" style="display:none" />';
					$inputDescription .= '<div style="display:none" class="slide-lang-'.$lang->id.'"><textarea class="editor" name="descriptions[]" id="description-'.$lang->id.'">'.$itemLang['description'].'</textarea></div>';
				}				
			}
		}
		$langOptions = $this->getLangOptions();
		$html = '<input type="hidden" name="itemId" value="'.$item['id'].'" />';
		$html .= '<input type="hidden" name="action" value="saveSlide" />';
		$html .= '<input type="hidden" name="secure_key" value="'.$this->secure_key.'" />';
		$html .= $langActive;
		$html .= '<div class="form-group clearfix">
                        <label class="control-label col-sm-2">'.$this->l('Image').'</label>
                        <div class="col-sm-10">
                            <div class="col-sm-10">                        
                                <div class="input-group">
                                    '.$inputImage.'                                
                                    <span class="input-group-btn">
                                        <button id="slide-uploader" type="button" class="btn btn-default"><i class="icon-folder-open"></i></button>
                                    </span>
                                </div>                        
                            </div>
                            <div class="col-sm-2">
                                <select class="slide-lang form-control" onchange="changeSlideLanguage(this.value)">'.$langOptions.'</select>
                            </div>
                        </div>  
                    </div>';
		$html .= '<div class="form-group">
                        <label class="control-label col-sm-2">'.$this->l('Alt').'</label>
                        <div class="col-lg-10 ">
                            <div class="col-sm-10">'.$inputAlt.'</div>
                            <div class="col-sm-2">
                                <select class="slide-lang form-control" onchange="changeSlideLanguage(this.value)">'.$langOptions.'</select>
                            </div>
                        </div>
                    </div>';
		$html .= '<div class="form-group">                    
                        <label class="control-label col-sm-2">'.$this->l('Custom class').'</label>
                        <div class="col-sm-10">
                            <div class="col-sm-10"><input type="text" name="custom_class" value="'.$item['custom_class'].'" class="form-control" /></div>
                        </div>                        
                    </div>';        
		$html .= '<div class="form-group">
                        <label class="control-label col-lg-2">'.$this->l('Description').'</label>
                        <div class="col-lg-10 ">
                            <div class="col-sm-10">'.$inputDescription.'</div>
                            <div class="col-sm-2">
                                <select class="slide-lang form-control" onchange="changeSlideLanguage(this.value)">'.$langOptions.'</select>
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
			$items = Db::getInstance()->executeS("Select m.*, ml.name 
				From "._DB_PREFIX_."bannerslider_module as m 
				Left Join "._DB_PREFIX_."bannerslider_module_lang as ml On ml.item_id = m.id 
				Where m.id_shop = ".$shopId." AND ml.id_lang = ".$langId." 
				Order By m.ordering");
	        $this->context->smarty->assign(array(
	            'baseModuleUrl'=> __PS_BASE_URI__.'modules/'.$this->name,            
	            'currentUrl'=> $this->getCurrentUrl(),
	            'moduleId'=>$this->id,
	            'langId'=>$langId,
	            'iso'=>$this->context->language->iso_code,
	            'ad'=>$ad = dirname($_SERVER["PHP_SELF"]),
	            'secure_key'=> $this->secure_key,
	            'form'=>$this->renderModuleForm(),
	            'slideForm'=>$this->renderSlideForm(),
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
        }elseif($action == 'data-export-homeslider'){
			$this->exportHomeSliderSameData();
			echo $this->l('Export data home slider success!');
			die;
			die(Tools::jsonEncode($this->l('Export data success!')));
		}elseif($action == 'data-import-homeslider'){
			$this->importHomeSliderSameData();
			echo $this->l('Install data home silder success!');
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
		$handle = opendir($this->sameDatas);
		while (false !== ($file = readdir($handle))) {
			if($file != '.' && $file != '..' && is_dir($this->sameDatas.$file)){
				$zip->addFile($this->sameDatas.$file, $file);
			}
		}
		closedir($handle);				
		$zip->close();
		header("Location: bak.zip");
		exit;	
	}
    public function exportHomeSliderSameData(){
        $langId = Context::getContext()->language->id;
		$link = mysql_connect(_DB_SERVER_,_DB_USER_,_DB_PASSWD_);
		mysql_select_db(_DB_NAME_,$link);
        $currentOption = Configuration::get('OVIC_CURRENT_DIR');
        if($currentOption) $currentOption .= '.';
        else $currentOption = '';
		foreach(self::$tablesHomeSlider as $table=>$type){			
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
		$handle = opendir($this->sameDatas);
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
	protected function loadModuleContent()
	{
		$moduleId = intval($_POST['moduleId']);
		$html = '';
		if($moduleId >0){
			$langId = Context::getContext()->language->id;
		    $shopId = Context::getContext()->shop->id;
			$items = Db::getInstance()->executeS("Select b.*, bl.image, bl.alt, bl.description From "._DB_PREFIX_."bannerslider_item as b Left Join "._DB_PREFIX_."bannerslider_item_lang as bl On bl.item_id = b.id Where b.module_id = ".$moduleId." AND bl.id_lang = ".$langId." Order By b.ordering");
			if($items){
				foreach ($items as $item) {
					$image = $this->getBannerSrc($item['image'], true);
					if($image){
						$image = '<img src="'.$image.'" alt="'.$item['alt'].'" style="max-height: 60px" class="img-responsive" />';
					}else{
						$image = 'no image';
					}
					if($item['status'] == "1"){
                        $status = '<a title="Enabled" class="list-action-enable action-enabled lik-slide-status" data-id="'.$item['id'].'" data-value="'.$item['status'].'"><i class="icon-check"></i></a>';
                    }else{
                        $status = '<a title="Disabled" class="list-action-enable action-disabled lik-slide-status" data-id="'.$item['id'].'" data-value="'.$item['status'].'"><i class="icon-check"></i></a>';
                    }
					$html .= '<tr id="sl_'.$item['id'].'">
									<td class="center">'.$item['id'].'</td>
									<td class="center">'.$image.'</td>
									<td>'.$item['description'].'</td>
									<td class="pointer dragHandle center" ><div class="dragGroup"><div class="positions sl_position_'.$item['id'].'">'.$item['ordering'].'</div></div></td>
									<td class="center">'.$status.'</td>
									<td class="center">
										<a href="javascript:void(0)" data-id="'.$item['id'].'" class="lik-slide-edit"><i class="icon-edit"></i></a>&nbsp;
                                        <a href="javascript:void(0)" data-id="'.$item['id'].'" class="lik-slide-delete"><i class="icon-trash" ></i></a>
									</td>
								</tr>';
				}
			}
		}
		die(Tools::jsonEncode($html));
	}
	protected function saveModule(){
		$shopId = Context::getContext()->shop->id;
		$languages = $this->getAllLanguages();
		$itemId = Tools::getValue('moduleId', 0);
		$position_id = 0;
		$position_name = Tools::getValue('position_name', 0);
		//if($position_id) $position_name = Hook::getNameById($position_id);
		$names = Tools::getValue('names', array());
		$custom_class = Tools::getValue('custom_class', '');
        $layout = Tools::getValue('layout', '');
		$display_name = Tools::getValue('module_display_name', 0);
		//$titles = Tools::getValue('titles', array());
		//$links = Tools::getValue('links', array());
		//$link_texts = Tools::getValue('link_texts', array());
		$descriptions = Tools::getValue('descriptions', array());		
		$response = new stdClass();
		$params = '';
		$nameDefault = '';
		$descriptionDefault='';
		$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        if($itemId == 0){				
			$maxOrdering =  $db->getValue("Select MAX(ordering) From "._DB_PREFIX_."bannerslider_module Where `id_shop` = ".$shopId);
	   		if($maxOrdering >0) $maxOrdering++;
	   		else $maxOrdering = 1;
            if($db->execute("Insert Into "._DB_PREFIX_."bannerslider_module (`id_shop`, `position_id`, `position_name`, `custom_class`, `layout`, `display_name`, `status`, `ordering`, `params`) Values ('".$shopId."', '".$position_id."', '".$position_name."', '".$custom_class."', '".$layout."', '$display_name', '1' ,'$maxOrdering', '$params')")){
                $itemId = $db->Insert_ID();				
				if($languages){
                	$insertDatas = array();
                	foreach($languages as $index=>$language){
                		$name = pSQL($names[$index], true);
						$description = $db->escape($descriptions[$index], true);// Tools::htmlentitiesUTF8();
						if(!$nameDefault) $nameDefault = $name;
						else
							if(!$name) $name = $nameDefault;
						if(!$descriptionDefault) $descriptionDefault = $description;
						else
							if(!$description) $description = $descriptionDefault;
							
						$insertDatas[] = array('item_id'=>$itemId, 'id_lang'=>$language->id, 'name'=>$name, 'description'=>$description) ;
                	}						
					if($insertDatas) $db->insert('bannerslider_module_lang', $insertDatas);
                }                    
                $response->status = '1';
                $response->msg = $this->l("Add new module successful!");
            }else{
                $response->status = '0';
                $response->msg = $this->l("Add new module not successful!");
            }
        }else{
            $item = $db->getRow("Select * From "._DB_PREFIX_."bannerslider_module Where id = ".$itemId);                
            $db->execute("Update "._DB_PREFIX_."bannerslider_module Set `position_id` = '".$position_id."', `position_name` = '".$position_name."', `custom_class`='".$custom_class."', `layout`='".$layout."', `display_name` = '".$display_name."', `params`='".$params."' Where id = ".$itemId);
			if($languages){
				$insertDatas = array();
            	foreach($languages as $index=>$language){
            		$name = pSQL($names[$index], true);
					$description = $db->escape($descriptions[$index], true);
					if(!$nameDefault) $nameDefault = $name;
					else
						if(!$name) $name = $nameDefault;
					if(!$descriptionDefault) $descriptionDefault = $description;
					else
						if(!$description) $description = $descriptionDefault;
					$check = $db->getRow("Select * From "._DB_PREFIX_."bannerslider_module_lang Where item_id = ".$itemId." AND `id_lang` = ".$language->id);	                		            		
                	if($check){
                    	$db->execute("Update "._DB_PREFIX_."bannerslider_module_lang Set  `name` = '".$name."',  `description` = '".$description."'  Where `item_id` = $itemId AND `id_lang` = ".$language->id);	
                    }else{
                    	$insertDatas[] = array('item_id'=>$itemId, 'id_lang'=>$language->id, 'name'=>$name, 'description'=>$description) ;
                    }
					if($insertDatas) $db->insert('bannerslider_module_lang', $insertDatas);
            	}
            }
			$response->status = 1;
        	$response->msg = $this->l("Update module successful!");
        }
        $this->clearCache();
        die(Tools::jsonEncode($response));
	}	
	protected function saveSlide(){
		$languages = $this->getAllLanguages();		
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
		$itemId = intval($_POST['itemId']);
		$custom_class = Tools::getValue('custom_class', '');
		$images = Tools::getValue('images', array());
		$alts = Tools::getValue('alts', array());
		$descriptions = Tools::getValue('descriptions', array());
		$moduleId = Tools::getValue('moduleId', 0);
		$response = new stdClass();
		$params = '';
        if($itemId == 0){				
			$maxOrdering = $db->getValue("Select MAX(ordering) From "._DB_PREFIX_."bannerslider_item Where `module_id` = ".$moduleId);
	   		if($maxOrdering >0) $maxOrdering++;
	   		else $maxOrdering = 1;
            if($db->execute("Insert Into "._DB_PREFIX_."bannerslider_item (`module_id`, `status`, `ordering`, `custom_class`, `params`) Values ('".$moduleId."', '1', '".$maxOrdering."', '".$custom_class."', '$params')")){
                $itemId = $db->Insert_ID();				
				if($languages){
                	$insertDatas = array();
                	foreach($languages as $index=>$language){
                        if($images[$index]){
                            if(strpos($images[$index], 'http') !== false){
                                $insertDatas[] = array('item_id'=>$itemId, 'id_lang'=>$language->id, 'image'=>$images[$index], 'alt'=>$db->escape($alts[$index]), 'description'=>$db->escape($descriptions[$index], true)) ;
                            }else{
                                if(file_exists($this->pathImage.'temps/'.$images[$index])){
        		                    if(@copy($this->pathImage.'temps/'.$images[$index], $this->pathImage.$images[$index])){
        		                    	unlink($this->pathImage.'temps/'.$images[$index]);
        		                    	$insertDatas[] = array('item_id'=>$itemId, 'id_lang'=>$language->id, 'image'=>$images[$index], 'alt'=>$db->escape($alts[$index]), 'description'=>$db->escape($descriptions[$index], true)) ;	
        		                    }else{
        		                    	$insertDatas[] = array('item_id'=>$itemId, 'id_lang'=>$language->id, 'image'=>'', 'alt'=>$db->escape($alts[$index]), 'description'=>$db->escape($descriptions[$index], true)) ;
        		                    }
        		                }else{
        		                	$insertDatas[] = array('item_id'=>$itemId, 'id_lang'=>$language->id, 'image'=>'', 'alt'=>$db->escape($alts[$index]), 'description'=>$db->escape($descriptions[$index], true)) ;
        		                }  
                            }
                        }else{
                            $insertDatas[] = array('item_id'=>$itemId, 'id_lang'=>$language->id, 'image'=>'', 'alt'=>$db->escape($alts[$index]), 'description'=>$db->escape($descriptions[$index], true)) ;
                        }
                		
                        
                	}						
					if($insertDatas) $db->insert('bannerslider_item_lang', $insertDatas);
                }                    
                $response->status = '1';
                $response->msg = $this->l("Add new slide item Success!");
            }else{
                $response->status = '0';
                $response->msg = $this->l("Add new slide item not Success!");
            }
        }else{        	
            $item = $db->getRow("Select * From "._DB_PREFIX_."bannerslider_item Where id = ".$itemId);                
            $db->execute("Update "._DB_PREFIX_."bannerslider_item Set `custom_class` = '".$custom_class."', `params` = '".$params."' Where id = ".$itemId);
			if($languages){				
				$insertDatas = array();
            	foreach($languages as $index=>$language){
					$check = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."bannerslider_item_lang Where item_id = ".$itemId." AND `id_lang` = ".$language->id);	                		
            		if($images[$index]){
            		      if(strpos($images[$index], 'http') !== false){
            		          if($check){    	                    	
    	                    	$db->execute("Update "._DB_PREFIX_."bannerslider_item_lang Set `image` = '".$images[$index]."', `alt` = '".$db->escape($alts[$index])."', `description` = '".$db->escape($descriptions[$index], true)."' Where `item_id` = $itemId AND `id_lang` = ".$language->id);	
    	                    }else{
    	                    	$insertDatas[] = array('item_id'=>$itemId, 'id_lang'=>$language->id, 'image'=>$images[$index], 'alt'=>$db->escape($alts[$index]), 'description'=>$db->escape($descriptions[$index], true)) ;
    	                    }
                          }else{
                                if(file_exists($this->pathImage.'temps/'.$images[$index])){                    		                    						
            	                    copy($this->pathImage.'temps/'.$images[$index], $this->pathImage.$images[$index]);                    
            	                    unlink($this->pathImage.'temps/'.$images[$index]);		                    
            	                    if($check){
            	                    	if($check['image'] && file_exists($this->pathImage.$check['image'])) unlink($this->pathImage.$check['image']);
            	                    	$db->execute("Update "._DB_PREFIX_."bannerslider_item_lang Set `image` = '".$images[$index]."', `alt` = '".$db->escape($alts[$index])."', `description` = '".$db->escape($descriptions[$index], true)."' Where `item_id` = $itemId AND `id_lang` = ".$language->id);	
            	                    }else{
            	                    	$insertDatas[] = array('item_id'=>$itemId, 'id_lang'=>$language->id, 'image'=>$images[$index], 'alt'=>$db->escape($alts[$index]), 'description'=>$db->escape($descriptions[$index]), true) ;
            	                    }
            	                }else{
            	                	if($check){            	                		
            	                    	$db->execute("Update "._DB_PREFIX_."bannerslider_item_lang Set `alt` = '".$db->escape($alts[$index])."', `description` = '".$db->escape($descriptions[$index], true)."'  Where `item_id` = $itemId AND `id_lang` = ".$language->id);	
            	                    }else{
            	                    	$insertDatas[] = array('item_id'=>$itemId, 'id_lang'=>$language->id, 'image'=>'', 'alt'=>$db->escape($alts[$index]), 'description'=>$db->escape($descriptions[$index], true)) ;
            	                    }
            	                }    
                          }                		 
            		}else{
                        if($check){	                		
	                    	$db->execute("Update "._DB_PREFIX_."bannerslider_item_lang Set `alt` = '".pSQL($alts[$index])."', `description` = '".$db->escape($descriptions[$index], true)."'  Where `item_id` = $itemId AND `id_lang` = ".$language->id);	
	                    }else{
	                    	$insertDatas[] = array('item_id'=>$itemId, 'id_lang'=>$language->id, 'image'=>'', 'alt'=>pSQL($alts[$index]), 'description'=>$db->escape($descriptions[$index], true)) ;
	                    }
            		}
					if($insertDatas) Db::getInstance()->insert('bannerslider_item_lang', $insertDatas);
            	}
            }
			$response->status = 1;
        	$response->msg = $this->l("Update slide item success!");
        }
        $this->clearCache();
        die(Tools::jsonEncode($response));
	}	
	protected function changeModuleStatus(){
		$itemId = intval($_POST['itemId']);
		$value = intval($_POST['value']);		
		$response = new stdClass();		
		if($value == '1'){
			DB::getInstance()->execute("Update "._DB_PREFIX_."bannerslider_module Set `status` = 0 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = 'Update status success';
		}else{
			DB::getInstance()->execute("Update "._DB_PREFIX_."bannerslider_module Set `status` = 1 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = 'Update status success';
		}
		$this->clearCache();
		die(Tools::jsonEncode($response));
	}
	public function changeSlideStatus(){
		$itemId = intval($_POST['itemId']);
		$value = intval($_POST['value']);		
		$response = new stdClass();		
		if($value == '1'){
			DB::getInstance()->execute("Update "._DB_PREFIX_."bannerslider_item Set `status` = 0 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = 'Update status success';
		}else{
			DB::getInstance()->execute("Update "._DB_PREFIX_."bannerslider_item Set `status` = 1 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = 'Update status success';
		}		
		$this->clearCache();
		die(Tools::jsonEncode($response));
	}
	protected function updateModuleOrdering(){
		$ids = $_POST['ids'];     
		$response = new stdClass();
        if($ids){
            foreach($ids as $i=>$id){
                DB::getInstance()->execute("Update "._DB_PREFIX_."bannerslider_module Set ordering=".(1 + $i)." Where id = ".$id);                
            }
            $response->status = 1;
            $response->msg='Update ordering successful!';
        }else{
        	$response->status = 0;
            $response->msg='Update ordering not successful!';
        }
		$this->clearCache();
        die(Tools::jsonEncode($response));
	}
	protected function updateSlideOrdering(){
		$ids = $_POST['ids'];     
		$response = new stdClass();
        if($ids){
            foreach($ids as $i=>$id){            	
                Db::getInstance()->execute("Update "._DB_PREFIX_."bannerslider_item Set ordering=".(1 + $i)." Where id = ".$id);                
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
	protected function getModuleItem(){
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
	protected function getSlideItem(){		
        $response = new stdClass();
        $itemId = intval($_POST['itemId']);
        if($itemId){
        	$response->form = $this->renderSlideForm($itemId);		       
            $response->status = '1';
            $response->msg = '';
        }else{
            $response->status = '0';
            $response->msg = $this->l('Item not found!');
        }		
        die(Tools::jsonEncode($response));
	}
	protected function deleteModule(){		
		$itemId = intval($_POST['itemId']);
		$response = new stdClass();
		if(Db::getInstance()->execute("Delete From "._DB_PREFIX_."bannerslider_module where id = $itemId")){			
			$items = Db::getInstance()->executeS("Select image From "._DB_PREFIX_."bannerslider_item_lang as bl Inner Join "._DB_PREFIX_."bannerslider_item as b On bl.item_id = b.id Where b.module_id = $itemId");			
			if($items){
				foreach($items as $item){
					if($item['image'] && file_exists($this->pathImage.$item['image'])) unlink($this->pathImage.$item['image']);
				}
			}			
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."bannerslider_item_lang where item_id IN (Select id From "._DB_PREFIX_."bannerslider_item Where module_id = $itemId)");
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."bannerslider_item where module_id = $itemId");
			$response->status = 1;
			$response->msg = "Delete module successful!";
		}else{
			$response->status = 0;
			$response->msg = "Delete module not successful!";
		}
		$this->clearCache();
		die(Tools::jsonEncode($response));
	}
	protected function deleteSlide(){
		$itemId = intval($_POST['itemId']);
		$response = new stdClass();
		if(DB::getInstance()->execute("Delete From "._DB_PREFIX_."bannerslider_item where id = $itemId")){
			$items = DB::getInstance()->executeS("Select * From "._DB_PREFIX_."bannerslider_item_lang Where item_id = ".$itemId);
			if($items){
				foreach($items as $item){
					if($item['image'] && file_exists($this->pathImage.$item['image'])) unlink($this->pathImage.$item['image']);
				}
			}
			DB::getInstance()->execute("Delete From "._DB_PREFIX_."bannerslider_item_lang where item_id = $itemId");
			$response->status = 1;
			$response->msg = "Delete slide item successful!";
		}else{
			$response->status = 0;
			$response->msg = "Delete slide item not successful!";
		}
		$this->clearCache();
		die(Tools::jsonEncode($response));
	}
    public function hookdisplayHeader()
	{	
        $this->context->controller->addJS(($this->_path).'js/front-end/common.js');
	}
	public function hookdisplayBannerSlider1($params)
	{		
		return $this->hooks('hookdisplayBannerSlider1', $params);
	}
	public function hookdisplayBannerSlider2($params)
	{		
		return $this->hooks('hookdisplayBannerSlider2', $params);
	}
	public function hookdisplayBannerSlider3($params)
	{		
		return $this->hooks('hookdisplayBannerSlider3', $params);
	}
	public function hookdisplayBannerSlider4($params)
	{		
		return $this->hooks('hookdisplayBannerSlider4', $params);
	}
	public function hookdisplayBannerSlider5($params)
	{		
		return $this->hooks('hookdisplayBannerSlider5', $params);
	}
	public function hookdisplayBannerSlider6($params)
	{		
		return $this->hooks('hookdisplayBannerSlider6', $params);
	}
	public function hookdisplayBannerSlider7($params)
	{		
		return $this->hooks('hookdisplayBannerSlider7', $params);
	}
	public function hookdisplayBannerSlider8($params)
	{		
		return $this->hooks('hookdisplayBannerSlider8', $params);
	}
	public function hookdisplayBannerSlider9($params)
	{		
		return $this->hooks('hookdisplayBannerSlider9', $params);
	}
    public function hooks($hookName, $param){
        $langId = Context::getContext()->language->id;
        $shopId = Context::getContext()->shop->id;        
        $hookName = str_replace('hook','', $hookName);        
        $hookId = (int)Hook::getIdByName($hookName);		
		if($hookId >0){
			$page_name = Dispatcher::getInstance()->getController();
			$page_name = (preg_match('/^[0-9]/', $page_name) ? 'page_'.$page_name : $page_name);
			$cacheKey = 'bannerslider|'.$langId.'|'.$hookName.'|'.$page_name;			
	        $this->context->smarty->assign('hookname', $hookName);
	        if (!$this->isCached('bannerslider.tpl', Tools::encrypt($cacheKey))){
				$results = array();
                $items = DB::getInstance()->executeS("Select DISTINCT m.*, ml.`name`, ml.title, ml.description, ml.link_text, ml.`link` 
                	From ("._DB_PREFIX_."bannerslider_module AS m 
                	INNER JOIN "._DB_PREFIX_."bannerslider_module_lang AS ml 
                		On m.id = ml.item_id) 
                	Where 
                		m.`position_name` = '".$hookName."'  
                		AND m.status = 1 
                		AND m.id_shop = ".$shopId." 
                		AND ml.id_lang = ".$langId." 
                	Order By 
                		m.ordering");				
				if($items){
					foreach($items as $item){
						$results[] = array(
							'moduleId'=>$item['id'], 
							'module_contents'=>$this->frontBuildModuleContent($item, $cacheKey.'|'.$item['id'])
						);
					}
				}			
				$this->context->smarty->assign('bannerslider_contents', $results);
			}
			return $this->display(__FILE__, 'bannerslider.tpl', Tools::encrypt($cacheKey));	
		}else{
			return '';
		}
    }    
	public function frontBuildModuleContent($module, $cacheKey=''){
		$langId = Context::getContext()->language->id;
		$shopId = Context::getContext()->shop->id;    
		if (!$this->isCached('bannerslider.'.$module['layout'].'.tpl', Tools::encrypt($cacheKey))){			
			$items = array();
			$items = DB::getInstance()->executeS("Select s.custom_class, sl.image, sl.alt, sl.description   
				From "._DB_PREFIX_."bannerslider_item AS s 
				Inner Join "._DB_PREFIX_."bannerslider_item_lang AS sl On s.id = sl.item_id 
				Where s.status = 1 AND s.module_id = ".$module['id']." AND sl.id_lang = ".$langId." 
				Order By s.ordering");			
			if($items){
				foreach($items as &$item){
				    //$item['description'] = Tools::htmlentitiesDecodeUTF8($item['description']);
					$image = $this->getBannerSrc($item['image'], true);
					if($image){
						$item['image'] = $image;
					}else{
						unset($item);
					}
				}
			}else return '';			
			$this->context->smarty->assign(array(
				'bannerslider_items'	=>	$items,
                'custom_class' 			=>	$module['custom_class'],
				'moduleDescription'		=>	$module['description'],
			));
		}
		return $this->display(__FILE__, 'bannerslider.'.$module['layout'].'.tpl', Tools::encrypt($cacheKey));		
    }        
    function clearCache($cacheKey='')
	{
		if(!$cacheKey){
			parent::_clearCache('bannerslider.tpl');
			if($this->arrLayout)
				foreach($this->arrLayout as $key=>$value)
					parent::_clearCache('bannerslider.'.$key.'.tpl');
		}else{
			parent::_clearCache('bannerslider.tpl', Tools::encrypt($cacheKey));
			if($this->arrLayout)
				foreach($this->arrLayout as $key=>$value)
					parent::_clearCache('bannerslider.'.$key.'.tpl', Tools::encrypt($cacheKey));
		} 		
       return true;
	}
   
}
