<?php
class FlexGroupBanners extends Module
{
    const INSTALL_SQL_FILE = 'install.sql';	
	protected static $tables = array(	'flexgroupbanners_module'=>'', 
										'flexgroupbanners_module_lang'=>'lang', 
										'flexgroupbanners_module_position'=>'position', 
										'flexgroupbanners_row'=>'', 
										'flexgroupbanners_row_lang'=>'lang', 
										'flexgroupbanners_banner'=>'', 
										'flexgroupbanners_banner_lang'=>'lang', 
										'flexgroupbanners_group'=>'', 
										'flexgroupbanners_group_lang'=>'lang'
										);
    public $arrLayout = array();
    public $arrCol = array();
	public $imageHomeSize = array();
    public $liveImage = '';
    public $pathImage = '';
	public static $sameDatas = '';
	public $page_name = '';
	protected static $arrPosition = array('displayHomeTopColumn', 'displayHome', 'displayHomeBottomContent', 'displayHomeBottomColumn', 'displayHomeTopContent', 'displayBottomColumn', 'displayGroupBanner1', 'displayGroupBanner2', 'displayGroupBanner3', 'displayGroupBanner4', 'displayGroupBanner5');
	public function __construct()
	{
		$this->name = 'flexgroupbanners';		
		$this->arrLayout = array('default'=>$this->l('Layout [default]'), 'granada'=>$this->l('Granada'));
        $this->arrCol = array('0'=>'None col', '1'=>$this->l('Col 1'),'2'=>$this->l('Col 2'),'3'=>$this->l('Col 3'),'4'=>$this->l('Col 4'),'5'=>$this->l('Col 5'),'6'=>$this->l('Col 6'),'7'=>$this->l('Col 7'),'8'=>$this->l('Col 8'),'9'=>$this->l('Col 9'),'10'=>$this->l('Col 10'),'11'=>$this->l('Col 11'),'12'=>$this->l('Col 12'));
		$this->secure_key = Tools::encrypt('flexible-themes'.$this->name);
        $this->pathImage = dirname(__FILE__).'/images/';
		// option 7
        
        
        self::$sameDatas = dirname(__FILE__).'/samedatas/';
		if(Configuration::get('PS_SSL_ENABLED'))
			$this->liveImage = _PS_BASE_URL_SSL_.__PS_BASE_URI__.'modules/flexgroupbanners/images/'; 
		else
			$this->liveImage = _PS_BASE_URL_.__PS_BASE_URI__.'modules/flexgroupbanners/images/';
		$this->tab = 'front_office_features';
		$this->version = '2.0';
		$this->author = 'OVIC-SOFT';		
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('Ovic - Flexible Group Banners Module');
		$this->description = $this->l('Group banners manager');
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
		if(self::$arrPosition)
			foreach(self::$arrPosition as $hook)
				if(!$this->registerHook($hook)) 
					return false;
		if (!Configuration::updateGlobalValue('FLEX_GROUP_BANNERS', '1')) return false;		
		$this->importSameData();
		return true;
	}
	public function importSameData($directory=''){
	   //foreach(self::$tables as $table=>$value) Db::getInstance()->execute('TRUNCATE TABLE '._DB_PREFIX_.$table);
	   if($directory) self::$sameDatas = $directory;
		$langs = Db::getInstance()->executeS("Select id_lang From "._DB_PREFIX_."lang Where active = 1");			
		if(self::$tables){
            
            $currentOption = Configuration::get('OVIC_CURRENT_DIR');
            if($currentOption) $currentOption .= '.';
            else $currentOption = '';
            
			foreach(self::$tables as $table=>$value){
                
				if (file_exists(self::$sameDatas.$currentOption.$table.'.sql')){
				    Db::getInstance()->execute('TRUNCATE TABLE '._DB_PREFIX_.$table);
					$sql = file_get_contents(self::$sameDatas.$currentOption.$table.'.sql');
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
							//if (!Db::getInstance()->execute(trim($query))) return false;
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
        if (!Configuration::deleteByName('FLEX_GROUP_BANNERS')) return false;
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
	private function getAllCategories($langId, $shopId, $parentId = 0, $sp='', $arr=null, $maxDepth = 10){
        if($arr == null) $arr = array();
        $items = Db::getInstance()->executeS("Select c.id_category, cl.name From "._DB_PREFIX_."category as c Inner Join "._DB_PREFIX_."category_lang as cl On c.id_category = cl.id_category Where c.active = 1 AND c.level_depth <= $maxDepth AND c.id_shop_default = $shopId AND c.id_parent = $parentId AND cl.id_lang = ".$langId." AND cl.id_shop = ".$shopId);
        if($items){
            foreach($items as $item){
                $arr[] = array('id_category'=>$item['id_category'], 'name'=>$item['name'], 'sp'=>$sp);
                $arr = $this->getAllCategories($langId, $shopId, $item['id_category'], $sp.'- ', $arr);
            }
        }
        return $arr;
    }
	private function getModuleOptions($moduleName=''){
        $id_shop = (int)Context::getContext()->shop->id;
		$options = '';
        $items = Db::getInstance()->executeS('SELECT m.id_module, m.name FROM `' . _DB_PREFIX_ . 'module` m JOIN `' . _DB_PREFIX_ . 'module_shop` ms ON (m.`id_module` = ms.`id_module` AND ms.`id_shop` = ' . (int)($id_shop) . ') WHERE m.active = 1 AND m.`name` <> \'' . $this->name . '\'');
		if($items){
			foreach($items as $item){
				if($item['name'] == $moduleName) $options .='<option selected="selected" value="'.$item['name'].'">'.$item['name'].'</option>';
				else $options .='<option value="'.$item['name'].'">'.$item['name'].'</option>';
			}
		}
        return $options;
    }		
	private function getHookOptions($moduleName='', $hookName=''){		
        $id_shop = (int)Context::getContext()->shop->id;
		$options = '';		
		$moduleId = $this->getModuleIdByName($moduleName);
        $items = Db::getInstance()->executeS("Select h.name, h.id_hook From "._DB_PREFIX_."hook AS h Inner Join "._DB_PREFIX_."hook_module as hm On h.id_hook = hm.id_hook Where h.name NOT LIKE '%action%' AND hm.id_module = ".$moduleId." AND hm.id_shop = ".$id_shop);		
		if($items){
			foreach($items as $item){
				if($item['name'] == $hookName) $options .='<option selected="selected" value="'.$item['name'].'">'.$item['name'].'</option>';
				else $options .='<option value="'.$item['name'].'">'.$item['name'].'</option>';
			}
		}
        return $options;
    }    
    private function getImageSrc($image = '', $check = false){
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
                return $this->liveImage.'default.jpg';
		*/ 
    }
    private function getCategoryOptions($selected = 0, $parentId = 0){
        $langId = Context::getContext()->language->id;
        $shopId = Context::getContext()->shop->id;
        $categoryOptions = '';
        if($parentId <=0) $parentId = Configuration::get('PS_HOME_CATEGORY');
        $items = $this->getAllCategories($langId, $shopId, $parentId, '|- ', null);        
        if($items){
            foreach($items as $item){
                if($item['id_category'] == $selected) $categoryOptions .='<option selected="selected" value="'.$item['id_category'].'">'.$item['sp'].$item['name'].'</option>';
                else $categoryOptions .='<option value="'.$item['id_category'].'">'.$item['sp'].$item['name'].'</option>';
            }
        }
        return  $categoryOptions;
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
    private function getPositionOptions($selected = ''){
        $options = '';
        foreach(self::$arrPosition as $value){
            if($selected == $value) $options .= '<option selected="selected" value="'.$value.'">'.$value.'</option>';
            else $options .= '<option value="'.$value.'">'.$value.'</option>';
        }
       
        return $options; 
    }
	
/*
	private function getPositionMultipleOptions($moduleId=0){
		$options = '';
		$selected = array();
		$id_shop = (int)Context::getContext()->shop->id;		
		$items = Db::getInstance()->executeS("Select * From "._DB_PREFIX_."flexgroupbanners_module_position Where module_id = $moduleId");
		if($items){
			foreach($items as $item) $selected[] = $item['position_id'];
		}
		$items = Db::getInstance()->executeS("Select h.name, h.id_hook From "._DB_PREFIX_."hook AS h Inner Join "._DB_PREFIX_."hook_module as hm On h.id_hook = hm.id_hook Where hm.id_module = ".$this->id." AND hm.id_shop = ".$id_shop);        		
		if($items){
			foreach($items as $item){
				if(in_array($item['id_hook'], $selected)) $options .='<option selected="selected" value="'.$item['id_hook'].'">'.$item['name'].'</option>';
				else $options .='<option value="'.$item['id_hook'].'">'.$item['name'].'</option>';
			}
		}
        return $options;
    }
 */
	private function getPositionMultipleOptions($moduleId=0){		
		$options = '';
		$selected = array();
		$id_shop = (int)Context::getContext()->shop->id;		
		$items = Db::getInstance()->executeS("Select * From "._DB_PREFIX_."flexgroupbanners_module_position Where module_id = $moduleId");
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
	public static function buildPositionOfModule($moduleId=0){
		if(!$moduleId) return '';
		$html = '';
		$items = Db::getInstance()->executeS("Select * From "._DB_PREFIX_."flexgroupbanners_module_position Where module_id = $moduleId");
		if($items){
			foreach($items as $item) $html .= $item['position_name'].'<br />';
		}
		return $html;
	}  
    private function getLayoutOptions($selected = ''){
        $options = '';        
        foreach($this->arrLayout as $key=> $value){
            if($key == $selected) $options .= '<option selected="selected" value="'.$key.'">'.$value.'</option>';
            else $options .= '<option  value="'.$key.'">'.$value.'</option>';            
        }        
        return $options; 
    }
    private function getColumnOptions($selected = ''){
        $options = '';               
        foreach($this->arrCol as $key=> $value){
            if($key == $selected) $options .= '<option selected="selected" value="'.$key.'">'.$value.'</option>';
            else $options .= '<option  value="'.$key.'">'.$value.'</option>';            
        }        
        return $options; 
    }      
	private function getAllLanguage(){
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
    private function getModuleByLang($id, $langId=0, $shopId=0){
    	if(!$langId) $langId = Context::getContext()->language->id;
        if(!$shopId) $shopId = Context::getContext()->shop->id;
		$itemLang = Db::getInstance()->getRow("Select name From "._DB_PREFIX_."flexgroupbanners_module_lang Where module_id = $id AND `id_lang` = '$langId'" );
		if(!$itemLang) $itemLang = array('name'=>'');
		return $itemLang;
    }
	private function getRowByLang($id, $langId=0, $shopId = 0){
		if(!$langId) $langId = Context::getContext()->language->id;
        if(!$shopId) $shopId = Context::getContext()->shop->id;		
		$itemLang = Db::getInstance()->getRow("Select name From "._DB_PREFIX_."flexgroupbanners_row_lang Where row_id = $id AND `id_lang` = '$langId'" );
		if(!$itemLang) $itemLang = array('name'=>'');
		return $itemLang;
	}
	private function getbannerByLang($id, $langId=0, $shopId=0){
		if(!$langId) $langId = Context::getContext()->language->id;
		$itemLang = Db::getInstance()->getRow("Select `link`, image, alt, description From "._DB_PREFIX_."flexgroupbanners_banner_lang Where banner_id = $id AND `id_lang` = '$langId'" );
		if(!$itemLang) $itemLang = array('link'=>'', 'image'=>'', 'alt'=>'', 'description'=>'');
		return $itemLang;
	}
	private function getGroupByLang($id, $langId=0, $shopId=0){
		if(!$langId) $langId = Context::getContext()->language->id;
		$itemLang = Db::getInstance()->getRow("Select name From "._DB_PREFIX_."flexgroupbanners_group_lang Where group_id = $id AND `id_lang` = '$langId'" );
		if(!$itemLang) $itemLang = array('name'=>'');
		return $itemLang;
	}
	private function renderModuleForm($id=0){
		$langId = $this->context->language->id;
        $shopId = $this->context->shop->id;
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."flexgroupbanners_module Where id = $id AND `id_shop` = '$shopId'");
			
		if(!$item) $item = array('id'=>0, 'id_shop'=>$shopId, 'position_name'=>'', 'display_name'=>1, 'layout'=>'', 'ordering'=>1, 'status'=>1, 'custom_class'=>'', 'params'=>"");
		
		$langActive = '<input type="hidden" id="moduleLangActive" value="0" />';
		$inputName = '';
		$languages = $this->getAllLanguage();
		if($languages){
			foreach ($languages as $key => $lang) {
				$itemLang = $this->getModuleByLang($id, $lang->id);
				if($lang->active == '1'){
					$langActive = '<input type="hidden" id="moduleLangActive" value="'.$lang->id.'" />';
					$inputName .= '<input type="text" value="'.$itemLang['name'].'" name="module_titles[]" id="module_titles_'.$lang->id.'" class="form-control module-lang-'.$lang->id.'" />';	
				}else{
					$inputName .= '<input type="text" value="'.$itemLang['name'].'" name="module_titles[]" id="module_titles_'.$lang->id.'" class="form-control module-lang-'.$lang->id.'" style="display:none" />';					
				}				
			}
		}
		$langOptions = $this->getLangOptions();
		$html = '<input type="hidden" name="moduleId" value="'.$item['id'].'" />';
		$html .= $langActive;
		$html .= '<input type="hidden" name="action" value="saveModule" />';
		$html .= '<input type="hidden" name="secure_key" value="'.$this->secure_key.'" />';
		$html .= '<div class="form-group"><label class="control-label col-sm-3">'.$this->l('Name').'</label><div class="col-sm-9"><div class="col-sm-10">'.$inputName.'</div><div class="col-sm-2"><select class="module-lang" onchange="moduleChangeLanguage(this.value)">'.$langOptions.'</select></div></div></div>';
		if($item['display_name'] == 1){
			$html .= '<div class="form-group">
                    <label class="control-label col-sm-3">'.$this->l('Display name').'</label>
                    <div class="col-sm-9">
                        <div class="col-sm-5">
                            <span class="switch prestashop-switch fixed-width-lg" id="module-display-name">
                                <input type="radio" value="1" class="module_display_name" checked="checked" id="module_display_name_on" name="module_display_name" />
            					<label for="module_display_name_on">Yes</label>
            				    <input type="radio" value="0" class="module_display_name" id="module_display_name_off" name="module_display_name" />
            					<label for="module_display_name_off">No</label>
                                <a class="slide-button btn"></a>
            				</span>
                        </div>                        
                    </div>				    
                </div>';	
		}else{
			$html .= '<div class="form-group">
                    <label class="control-label col-sm-3">'.$this->l('Display name').'</label>
                    <div class="col-sm-9">
                        <div class="col-sm-5">
                            <span class="switch prestashop-switch fixed-width-lg" id="module-display-name">
                                <input type="radio" value="1" class="module_display_name" id="module_display_name_off" name="module_display_name" />
            					<label for="module_display_name_off">Yes</label>
            				    <input type="radio" value="0" class="module_display_name" checked="checked" id="module_display_name_on" name="module_display_name" />
            					<label for="module_display_name_on">No</label>
                                <a class="slide-button btn"></a>
            				</span>
                        </div>                        
                    </div>				    
                </div>';
		}
		$html .= '<div class="form-group">
					<label class="control-label col-sm-3">'.$this->l('Position').'</label>
					<div class="col-sm-9">
						<div class="col-sm-12">
							<select  name="position_name">'.$this->getPositionOptions($item['position_name']).'</select>
						</div>
					</div>
				</div>';
		$html .= '<div class="form-group">
					<label class="control-label col-sm-3">'.$this->l('Layout').'</label>
					<div class="col-sm-9">
						<div class="col-sm-12">
							<select class="form-control" name="moduleLayout">'.$this->getLayoutOptions($item['layout']).'</select>
						</div>
					</div>
				</div>';
		$html .= '<div class="form-group">
                    <label class="control-label col-sm-3">'.$this->l('Custom class').'</label>
                    <div class="col-sm-9">
                        <div class="col-sm-12">
                            <input type="text" value="'.$item['custom_class'].'" name="custom_class"  class="form-control" />
                        </div>                        
                    </div>				    
                </div>';
		return $html;
	}
	private function renderRowForm($itemId=0){
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."flexgroupbanners_row Where id = $itemId");
		if(!$item) $item = array('id'=>0, 'module_id'=>0, 'display_title'=>1, 'width'=>12, 'ordering'=>1, 'status'=>1, 'custom_class'=>'');
		$langActive = '<input type="hidden" id="rowLangActive" value="0" />';
		$inputName = '';
		$languages = $this->getAllLanguage();
		if($languages){
			foreach ($languages as $key => $lang) {				
				$itemLang = $this->getRowByLang($itemId, $lang->id);				
				if($lang->active == '1'){
					$langActive = '<input type="hidden" id="rowLangActive" value="'.$lang->id.'" />';
					$inputName .= '<input type="text" value="'.$itemLang['name'].'" name="row_names[]" id="row_names_'.$lang->id.'" class="form-control row-lang-'.$lang->id.'" />';	
				}else{
					$inputName .= '<input type="text" value="'.$itemLang['name'].'" name="row_names[]" id="row_names_'.$lang->id.'" class="form-control row-lang-'.$lang->id.'" style="display:none" />';					
				}				
			}
		}
		$langOptions = $this->getLangOptions();
		$html = '<input type="hidden" name="rowId" value="'.$itemId.'" />';
		$html .= $langActive;
		$html .= '<input type="hidden" name="action" value="saveRow" />';
		$html .= '<input type="hidden" name="secure_key" value="'.$this->secure_key.'" />';
		$html .= '<div class="form-group"><label class="control-label col-sm-3">'.$this->l('Name').'</label><div class="col-sm-9"><div class="col-sm-10">'.$inputName.'</div><div class="col-sm-2"><select class="row-lang" onchange="rowChangeLanguage(this.value)">'.$langOptions.'</select></div></div></div>';
		if($item['display_title'] == 1){
			$html .= '<div class="form-group">
                    <label class="control-label col-sm-3">'.$this->l('Display name').'</label>
                    <div class="col-sm-9">
                        <div class="col-sm-5">
                            <span class="switch prestashop-switch fixed-width-lg" id="row-display-title">
                                <input type="radio" value="1" class="row_display_title" checked="checked" id="row_display_title_on" name="row_display_title" />
            					<label for="row_display_title_on">Yes</label>
            				    <input type="radio" value="0" class="row_display_title" id="row_display_title_off" name="row_display_title" />
            					<label for="row_display_title_off">No</label>
                                <a class="slide-button btn"></a>
            				</span>
                        </div>                        
                    </div>				    
                </div>';	
		}else{
			$html .= '<div class="form-group">
                    <label class="control-label col-sm-3">'.$this->l('Display name').'</label>
                    <div class="col-sm-9">
                        <div class="col-sm-5">
                            <span class="switch prestashop-switch fixed-width-lg" id="row-display-title">
                                <input type="radio" value="1" class="row_display_title" id="row_display_title_off" name="row_display_title" />
            					<label for="row_display_title_off">Yes</label>
            				    <input type="radio" value="0" class="row_display_title" checked="checked" id="row_display_title_on" name="row_display_title" />
            					<label for="row_display_title_on">No</label>
                                <a class="slide-button btn"></a>
            				</span>
                        </div>                        
                    </div>				    
                </div>';
		}
		$html .= '<div class="form-group"><label class="control-label col-sm-3">'.$this->l('Width').'</label><div class="col-sm-9"><div class="col-sm-12"><select class="form-control" name="width">'.$this->getColumnOptions($item['width']).'</select></div></div></div>';
		$html .= '<div class="form-group">
                    <label class="control-label col-sm-3">'.$this->l('Custom class').'</label>
                    <div class="col-sm-9">
                        <div class="col-sm-10">
                            <input type="text" value="'.$item['custom_class'].'" name="custom_class"  class="form-control" />
                        </div>                        
                    </div>				    
                </div>';
		return $html;
	}
	private function renderGroupForm($id=0){		
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."flexgroupbanners_group Where id = $id");		
		$params = new stdClass();
		if(!$item){
			$item = array('id'=>0, 'module_id'=>0, 'row_id', 'custom_class'=>'', 'params'=>'', 'width'=>'12', 'status'=>1, 'ordering'=>1);			
		}
		$langActive = '<input type="hidden" id="groupLangActive" value="0" />';
		$languages = $this->getAllLanguage();
		$inputTitle = '';
		if($languages){
			foreach ($languages as $key => $language){
				$itemLang = $this->getgroupByLang($id, $language->id);
				if($language->active == '1'){
					$langActive = '<input type="hidden" id="groupLangActive" value="'.$language->id.'" />';
					$inputTitle .= '<input type="text" value="'.$itemLang['name'].'" name="names[]"  class="form-control group-lang-'.$language->id.'" />';					
				}else{
					$inputTitle .= '<input type="text" value="'.$itemLang['name'].'" name="names[]" class="form-control group-lang-'.$language->id.'" style="display:none" />';					
				}				
			}
		}
		$langOptions = $this->getLangOptions();
		$html = '';
		$html .= '<input type="hidden" name="groupId" value="'.$item['id'].'" />';
		$html .= $langActive;
		$html .= '<input type="hidden" name="action" value="saveGroup" />';
		$html .= '<input type="hidden" name="secure_key" value="'.$this->secure_key.'" />';
		$html .= '<div class="form-group"><label class="control-label col-sm-3 required">'.$this->l('Name').'</label><div class="col-sm-9"><div class="col-sm-10">'.$inputTitle.'</div><div class="col-sm-2"><select class="group-lang" onchange="groupChangeLanguage(this.value)">'.$langOptions.'</select></div></div></div>';
		$html .= '<div class="form-group">
                    <label class="control-label col-sm-3">'.$this->l('Custom class CSS').'</label>
                    <div class="col-sm-9">
                        <div class="col-sm-10">
                            <input type="text" value="'.$item['custom_class'].'" name="custom_class"  class="form-control" />
                        </div>                        
                    </div>				    
                </div>';		
		$html .= '<div class="form-group clearfix">
                    <label class="control-label col-sm-3">'.$this->l('Group width').'</label>
                    <div class="col-sm-9">
                        <div class="col-sm-5">                        
                            <select name="width" id="group-width" class="form-control">'.$this->getColumnOptions($item['width']).'</select>                       
                        </div>                        
                    </div>  
                </div>';		
		return $html;
	}
	private function renderBannerForm($id = 0){
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."flexgroupbanners_banner Where id = $id");
		if(!$item) $item = array('id'=>0, 'module_id'=>0, 'row_id'=>0, 'group_id'=>0, 'status'=>1, 'custom_class'=>'', 'ordering'=>1);		
		$langActive = '<input type="hidden" id="bannerLangActive" value="0" />';
		$languages = $this->getAllLanguage();
		$inputTitle = '';
		$inputLink = '';
		$inputImage = '';
		$inputAlt = '';
		$inputDescription = '';
		if($languages){
			foreach ($languages as $key => $language) {				
				$itemLang = $this->getBannerByLang($id, $language->id);				
				if($language->active == '1'){
					$langActive = '<input type="hidden" id="bannerLangActive" value="'.$language->id.'" />';					
					$inputLink .= '<input type="text" value="'.$itemLang['link'].'" name="links[]"  class="form-control banner-lang-'.$language->id.'" />';
					$inputImage .= '<input type="text" value="'.$itemLang['image'].'" name="images[]" id="bannerImage-'.$language->id.'" class="form-control banner-lang-'.$language->id.'"  />';
					$inputAlt .= '<input type="text" value="'.$itemLang['alt'].'" name="alts[]" class="form-control banner-lang-'.$language->id.'" />';
					$inputDescription .= '<div class="banner-lang-'.$language->id.'"><textarea class="editor" name="descriptions[]" id="banner-description-'.$language->id.'">'.$itemLang['description'].'</textarea></div>';
				}else{
					$inputLink .= '<input type="text" value="'.$itemLang['link'].'" name="links[]"  class="form-control banner-lang-'.$language->id.'" style="display:none" />';
					$inputImage .= '<input type="text" value="'.$itemLang['image'].'" name="images[]" id="bannerImage-'.$language->id.'" class="form-control banner-lang-'.$language->id.'"  style="display:none" />';
					$inputAlt .= '<input type="text" value="'.$itemLang['alt'].'" name="alts[]" class="form-control banner-lang-'.$language->id.'" style="display:none" />';
					$inputDescription .= '<div style="display:none" class="banner-lang-'.$language->id.'"><textarea class="editor" name="descriptions[]" id="banner-description-'.$language->id.'">'.$itemLang['description'].'</textarea></div>';					
				}				
			}
		}		
		$langOptions = $this->getLangOptions();
		$html = '';
		$html .= '<input type="hidden" name="bannerId" value="'.$item['id'].'" />';		
		$html .= $langActive;
		$html .= '<input type="hidden" name="action" value="saveBanner" />';	
		$html .= '<input type="hidden" name="secure_key" value="'.$this->secure_key.'" />';
		$html .= '<div class="form-group">
                    <label class="control-label col-sm-2">'.$this->l('Custom class CSS').'</label>
                    <div class="col-sm-10">
                        <div class="col-sm-10">
                            <input type="text" value="'.$item['custom_class'].'" name="custom_class"  class="form-control" />
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
                                <select class="banner-lang form-control" onchange="bannerChangeLanguage(this.value)">'.$langOptions.'</select>
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
                                <select class="banner-lang form-control" onchange="bannerChangeLanguage(this.value)">'.$langOptions.'</select>
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
                                <select class="banner-lang form-control" onchange="bannerChangeLanguage(this.value)">'.$langOptions.'</select>
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
                                <select class="banner-lang form-control" onchange="bannerChangeLanguage(this.value)">'.$langOptions.'</select>
                            </div>
                        </div>
                    </div>';
		return $html;
	}
	private function getCurrentUrl($excls=array())
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
		 //foreach(self::$arrPosition as $hook)
			 //$this->registerHook($hook);
		$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
		$items = $db->executeS("Select * From "._DB_PREFIX_."flexgroupbanners_banner_lang");		
		$action = Tools::getValue('action', 'view');
		if($action == 'view'){
			$this->context->controller->addJquery();
            $this->context->controller->addJQueryUI('ui.sortable');
			$this->context->controller->addJS(($this->_path).'js/back-end/common.js');                
	        $this->context->controller->addJS(($this->_path).'js/back-end/ajaxupload.3.5.js');
			$this->context->controller->addJS(($this->_path).'js/back-end/tinymce.inc.js');
			$this->context->controller->addJS(($this->_path).'js/back-end/jquery.serialize-object.min.js');		
			$this->context->controller->addJS(__PS_BASE_URI__.'js/jquery/plugins/jquery.tablednd.js');
	        $this->context->controller->addJS(__PS_BASE_URI__.'js/jquery/plugins/jquery.colorpicker.js');        
	        $this->context->controller->addJS(__PS_BASE_URI__.'js/tiny_mce/tinymce.min.js');
	        $this->context->controller->addCSS(($this->_path).'css/back-end/style.css');
	        $this->context->controller->addCSS(($this->_path).'css/back-end/style-upload.css');
	        $langId = $this->context->language->id;
	        $shopId = $this->context->shop->id;
	        $items = Db::getInstance()->executeS("Select m.*, ml.name 
	        	From "._DB_PREFIX_."flexgroupbanners_module AS m 
	        	Left Join "._DB_PREFIX_."flexgroupbanners_module_lang AS ml On ml.module_id = m.id 
	        	Where m.id_shop = '".$shopId."' AND ml.id_lang = ".$langId." 
	        	Order By m.ordering");			
	        $listModule = '';
	        if($items){
	            foreach($items as &$item){	            	
	            	$item['layout_value'] = $this->arrLayout[$item['layout']];	                
	            }
	        }                 
	        $this->context->smarty->assign(array(
	            'baseModuleUrl'=> __PS_BASE_URI__.'modules/'.$this->name,
	            'currentUrl'=> $this->getCurrentUrl(),
	            'moduleId'=>$this->id,
	            'langId'=>$langId,
	            'iso'=>$this->context->language->iso_code,
	            'ad'=>$ad = dirname($_SERVER["PHP_SELF"]),
	            'listModule'=>$listModule,	            
	            'secure_key'=>$this->secure_key,
	            'moduleForm' => $this->renderModuleForm(),
	            'rowForm' => $this->renderRowForm(),
	            'groupForm'=>$this->renderGroupForm(),
	            'bannerForm'=>$this->renderBannerForm(),	            
				'items'=>$items
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
        $currentOption = Configuration::get('OVIC_CURRENT_DIR');
        if($currentOption) $currentOption .= '.';
        else $currentOption = '';
        
		$link = mysql_connect(_DB_SERVER_,_DB_USER_,_DB_PASSWD_);
		mysql_select_db(_DB_NAME_,$link);
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
	}
	public function loadHook(){
		$response = '';
		$moduleName = Tools::getValue('moduleName', '');		
		if($moduleName == '') $response = '<option value="">['.$this->l('Select hook').']</option>';
		else{			
			$response = '<option value="">['.$this->l('Select hook').']</option>'.$this->getHookOptions($moduleName);
			if(!$response) $response = '<option value="">['.$this->l('Select hook').']</option>';
		}
		die(Tools::jsonEncode($response));
	}
    private function saveModule(){        
        $shopId = Context::getContext()->shop->id;
		$languages = $this->getAllLanguage();        
        $response = new stdClass();		
        $itemId = intval($_POST['moduleId']);
		$db = Db::getInstance();
		$names = $_POST['module_titles'];
        $layout = Tools::getValue('moduleLayout', 'default');        
        $display_name = Tools::getValue('module_display_name', 1);
        $custom_class = Tools::getValue('custom_class', '');
		$params = '';
		$position_name = Tools::getValue('position_name', '');
		//$positions = Tools::getValue('positions', array());		        
        if($itemId == 0){
			$maxOrdering = $db->getValue("Select MAX(ordering) From "._DB_PREFIX_."flexgroupbanners_module");
		   	if($maxOrdering >0) $maxOrdering++;
		   	else $maxOrdering = 1;
            if($db->execute("Insert Into "._DB_PREFIX_."flexgroupbanners_module (`id_shop`, `position_name`, `layout`, `ordering`, `status`, `params`, `custom_class`, `display_name`) Values ('$shopId', '$position_name', '".$layout."', '".$maxOrdering."', '1', '".$params."', '$custom_class', '$display_name')")){
                $insertId = $db->Insert_ID();
				/*
				if($positions){
					$insertModuleHook = array();
					foreach($positions as $position){						
						$insertModuleHook[] = array('module_id'=>$insertId, 'position_id'=>$position, 'position_name'=>Hook::getNameById($position));
					}
					if($insertModuleHook) Db::getInstance()->insert('flexgroupbanners_module_position', $insertModuleHook);
				}
				 * 
				 */ 
				if($languages){
                	$insertDatas = array();
                	foreach($languages as $index=>$language){
                		$name = pSQL($names[$index], true);
						$insertDatas[] = array('module_id'=>$insertId, 'id_lang'=>$language->id, 'name'=>$name);                   		                
                	}
					if($insertDatas) $db->insert('flexgroupbanners_module_lang', $insertDatas);
                }                
                $response->status = '1';
                $response->msg = $this->l('Add new Module Success!'); 
            }else{
                $response->status = '0';
                $response->msg = $this->l('Add new Module not Success!');
            }
        }else{
            $item = $db->getRow("Select * From "._DB_PREFIX_."flexgroupbanners_module Where id = ".$itemId);
            $db->execute("Update "._DB_PREFIX_."flexgroupbanners_module Set `position_name`='$position_name',  `layout`='".$layout."', `params` = '".$params."', `custom_class`='$custom_class', `display_name`='$display_name' Where id = ".$itemId);            
			/*
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_module_position Where `module_id` = ".$itemId);
			if($positions){
				$insertModuleHook = array();
				foreach($positions as $position){						
					$insertModuleHook[] = array('module_id'=>$itemId, 'position_id'=>$position, 'position_name'=>Hook::getNameById($position));
				}
				if($insertModuleHook) Db::getInstance()->insert('flexgroupbanners_module_position', $insertModuleHook);
			}
			 * 
			 */ 
			if($languages){
				$insertDatas = array();            	
            	foreach($languages as $index=>$language){
            		$name = pSQL($names[$index], true);
            		$check = $db->getValue("Select module_id From "._DB_PREFIX_."flexgroupbanners_module_lang Where module_id = $itemId AND id_lang = ".$language->id);
            		if($check){
            			$db->execute("Update "._DB_PREFIX_."flexgroupbanners_module_lang Set `name` = '".$name."' Where `module_id` = ".$itemId." AND `id_lang` = ".$language->id);	
            		}else{
            			$insertDatas[] = array('module_id'=>$itemId, 'id_lang'=>$language->id, 'name'=>$name);
            		}
            	}
            	if($insertDatas) $db->insert('flexgroupbanners_module_lang', $insertDatas);
            }            
            $response->status = '1';
            $response->msg = $this->l('Update Module Success!');
        }
		$this->clearCache();
        die(Tools::jsonEncode($response));
    }
	private function saveRow(){
		$languages = $this->getAllLanguage();        
        $response = new stdClass();		
        $itemId = intval($_POST['rowId']);        
		$db = Db::getInstance();
		$moduleId = intval($_POST['moduleId']);
		$names = $_POST['row_names'];
        $width = intval($_POST['width']); 
		$custom_class = Tools::getValue('custom_class', '');
		$display_title = Tools::getValue('row_display_title', 1);
        if($itemId == 0){
			$maxOrdering = $db->getValue("Select MAX(ordering) From "._DB_PREFIX_."flexgroupbanners_row Where `module_id` = ".$moduleId);
		   	if($maxOrdering >0) $maxOrdering++;
		   	else $maxOrdering = 1;
            if($db->execute("Insert Into "._DB_PREFIX_."flexgroupbanners_row (`module_id`, `width`, `ordering`, `status`, `custom_class`, `display_title`) Values ('".$moduleId."', '$width', '".$maxOrdering."', '1', '$custom_class', '$display_title')")){
                $insertId = $db->Insert_ID();  
				if($languages){
                	$insertDatas = array();
                	foreach($languages as $index=>$language){                		
						$insertDatas[] = array('row_id'=>$insertId, 'id_lang'=>$language->id, 'name'=>$db->escape($names[$index]));                   		                
                	}
					if($insertDatas) $db->insert('flexgroupbanners_row_lang', $insertDatas);
                }                
                $response->status = '1';
                $response->msg = $this->l('Add new row Success!');     
            }else{
                $response->status = '0';
                $response->msg = $this->l('Add new row not Success!');
            }
        }else{
            $item = $db->getRow("Select * From "._DB_PREFIX_."flexgroupbanners_row Where id = ".$itemId);
            $db->execute("Update "._DB_PREFIX_."flexgroupbanners_row Set `width` = '".$width."', `custom_class`='$custom_class', `display_title`='$display_title' Where id = ".$itemId);            
			if($languages){
				$insertDatas = array();            	
            	foreach($languages as $index=>$language){
            		$check = $db->getValue("Select row_id From "._DB_PREFIX_."flexgroupbanners_row_lang Where row_id = $itemId AND id_lang = ".$language->id);
            		if($check){
            			$db->execute("Update "._DB_PREFIX_."flexgroupbanners_row_lang Set `name` = '".$db->escape($names[$index])."' Where `row_id` = ".$itemId." AND `id_lang` = ".$language->id);	
            		}else{
            			$insertDatas[] = array('row_id'=>$itemId, 'id_lang'=>$language->id, 'name'=>$db->escape($names[$index]));
            		}
            	}
            	if($insertDatas) $db->insert('flexgroupbanners_row_lang', $insertDatas);
            }            
            $response->status = '1';
            $response->msg = $this->l('Update row Success!');
        }
		$this->clearCache();
        die(Tools::jsonEncode($response));
	}
	private function saveGroup(){
		$languages = $this->getAllLanguage();  
		$db = Db::getInstance();
        $itemId = Tools::getValue('groupId', 0);
		$names = $_POST['names'];
		$custom_class = Tools::getValue('custom_class', '');
		//$group_display_title = Tools::getValue('group_display_title', 1);
		$width = Tools::getValue('width', 0);
		//$groupType = Tools::getValue('groupType', 'link');
		//$params = new stdClass();
		//$params->productCategory = Tools::getValue('groupProductCategory', 0);;
		//$params->productType = Tools::getValue('groupProductType', 'arrival');
		//$params->productCount = Tools::getValue('groupCountProduct', 3);
		//$params->productWidth = Tools::getValue('groupProductWidth', 4);	
		//$params->customWidth = '12';
		//$productIds = Tools::getValue('groupProductIds');                        
        //$params->productIds = explode(',', $productIds);		
		//$params->moduleName = Tools::getValue('module', '');
		//if($params->moduleName)
		//	$params->moduleId = Db::getInstance()->getValue("Select id_module From "._DB_PREFIX_."module Where `name`='".$params->moduleName."'");
		///else
		//	$params->moduleId = 0;
		//$params->hookName = Tools::getValue('hook', '');;
		//if($params->hookName)
		//	$params->hookId = Hook::getIdByName($params->hookName);
		//else 
		//	$params->hookId = 0;
		$params = '';
		$moduleId = intval($_POST['moduleId']);
		$rowId = intval($_POST['rowId']);
		$response = new stdClass();
		if($moduleId >0 && $rowId >0){				
	            if($itemId <=0){
	            	$maxOrdering = $db->getValue("Select MAX(ordering) From "._DB_PREFIX_."flexgroupbanners_group Where `module_id` = ".$moduleId." AND `row_id` = ".$rowId);
			   		if($maxOrdering >0) $maxOrdering++;
			   		else $maxOrdering = 1;
	                if($db->execute("Insert Into "._DB_PREFIX_."flexgroupbanners_group (`module_id`, `row_id`,  `custom_class`, `params`, `width`, `status`, `ordering`) Values ('".$moduleId."', '".$rowId."', '$custom_class', '$params', '".$width."', '1', '".$maxOrdering."')")){
	                    $insertId = $db->Insert_ID();
						if($languages){
		                	$insertDatas = array();
		                	foreach($languages as $index=>$language){	                			                			                		
				                $insertDatas[] = array('group_id'=>$insertId, 'id_lang'=>$language->id, 'name'=>$db->escape($names[$index])) ;			                
		                	}
							if($insertDatas) $db->insert('flexgroupbanners_group_lang', $insertDatas);
		                }
	                    $response->status ='1';
	                    $response->msg = 'Add new Group Success.';
	                }else{
	                    $response->status ='0';
	                    $response->msg = 'Add new Group not success.';
	                }
	            } else{
	                $item = $db->getRow("Select * From "._DB_PREFIX_."flexgroupbanners_group Where id = ".$itemId);
	                $db->execute("Update "._DB_PREFIX_."flexgroupbanners_group Set `custom_class`='$custom_class', `params` = '$params', `width`='".$width."' Where id = ".$itemId);
	                if($languages){
	                	$insertDatas = array();          	
	                	foreach($languages as $index=>$language){
	                		$check = $db->getValue("Select group_id From "._DB_PREFIX_."flexgroupbanners_group_lang Where group_id = '".$itemId."' AND `id_lang` = ".$language->id);
							if($check)
	                			$db->execute("Update "._DB_PREFIX_."flexgroupbanners_group_lang Set name = '".$db->escape($names[$index])."' Where `group_id` = ".$itemId." AND `id_lang` = ".$language->id);
							else {
								$insertDatas[] = array('group_id'=>$itemId, 'id_lang'=>$language->id, 'name'=>$db->escape($names[$index])) ;
							}	                			                			                					                
	                	}
						if($insertDatas) $db->insert('flexgroupbanners_group_lang', $insertDatas);
	                }                
	                $response->status ='1';
	                $response->msg = 'Update Group success.';
	            }
		}else{
			$response->status ='1';
	        $response->msg = 'Module or Row not found!';
		}
		$this->clearCache();
        die(Tools::jsonEncode($response));
    }
	private function savebanner(){
		$languages = $this->getAllLanguage();
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
		$moduleId = intval($_POST['moduleId']);
		$rowId = intval($_POST['rowId']);		
        $groupId = intval($_POST['groupId']);
        $itemId = intval($_POST['bannerId']);        		
		$custom_class = Tools::getValue('custom_class', '');		
		$images = Tools::getValue('images', array());
		$alts = Tools::getValue('alts', array());
		$links = Tools::getValue('links', array());
		$descriptions = Tools::getValue('descriptions', array());			
		$response = new stdClass();
        if($moduleId >0 && $rowId >0 && $groupId >0){            
            if($itemId == 0){
				$maxOrdering = $db->getValue("Select MAX(ordering) From "._DB_PREFIX_."flexgroupbanners_banner Where `module_id` = ".$moduleId." AND `row_id` = ".$rowId." AND `group_id` = ".$groupId);
		   		if($maxOrdering >0) $maxOrdering++;
		   		else $maxOrdering = 1;	
                if($db->execute("Insert Into "._DB_PREFIX_."flexgroupbanners_banner (`module_id`, `row_id`, `group_id`,  `custom_class`,  `status`, `ordering`) Values ('".$moduleId."', '".$rowId."', '".$groupId."',  '".$custom_class."', '1', '".$maxOrdering."')")){
                    $insertId = $db->Insert_ID();										
					if($languages){
	                	$insertDatas = array();
	                	foreach($languages as $index=>$language){
	                		$description = $db->escape($descriptions[$index], true);// Tools::htmlentitiesUTF8($descriptions[$index]);
							$link = $db->escape($links[$index]);
							$alt = $db->escape($alts[$index]);
							if($images[$index]){
								if(strpos($images[$index], 'http') !== false){
									$insertDatas[] = array('banner_id'=>$insertId, 'id_lang'=>$language->id, 'link'=>$link, 'image'=>$images[$index], 'alt'=>$alt, 'description'=>$description) ;
								}else{
									if(file_exists($this->pathImage.'temps/'.$images[$index])){
					                    if(copy($this->pathImage.'temps/'.$images[$index], $this->pathImage.$images[$index])){
					                    	unlink($this->pathImage.'temps/'.$images[$index]);
					                    	$insertDatas[] = array('banner_id'=>$insertId, 'id_lang'=>$language->id, 'link'=>$link, 'image'=>$images[$index], 'alt'=>$alt, 'description'=>$description) ;	
					                    }else{
					                    	$insertDatas[] = array('banner_id'=>$insertId, 'id_lang'=>$language->id, 'link'=>$link, 'image'=>'', 'alt'=>$alt, 'description'=>$description) ;
					                    }
					                }else{
					                	$insertDatas[] = array('banner_id'=>$insertId, 'id_lang'=>$language->id, 'link'=>$link, 'image'=>'', 'alt'=>$alt, 'description'=>$description) ;
					                }
								}
							}else{
								$insertDatas[] = array('banner_id'=>$insertId, 'id_lang'=>$language->id, 'link'=>$link, 'image'=>'', 'alt'=>$alt, 'description'=>$description) ;
							}
	                	}
						if($insertDatas) $db->insert('flexgroupbanners_banner_lang', $insertDatas);
	                }                    
                    $response->status = '1';
                    $response->msg = $this->l("Add new banner Success!");
                }else{
                    $response->status = '0';
                    $response->msg = $this->l("Add new banner not Success!");
                }
            }else{
                $item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."flexgroupbanners_banner Where id = ".$itemId);                
                Db::getInstance()->execute("Update "._DB_PREFIX_."flexgroupbanners_banner Set  `custom_class`='".$custom_class."' Where id = ".$itemId);                
				if($languages){
					$insertDatas = array();
                	foreach($languages as $index=>$language){
                		//$description = pSQL(Tools::htmlentitiesUTF8($descriptions[$index]), true);
                		$description = $db->escape($descriptions[$index], true);// Tools::htmlentitiesUTF8($descriptions[$index]);
						$link = $db->escape($links[$index], true);
						$alt = $db->escape($alts[$index], true);
						$check = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."flexgroupbanners_banner_lang Where banner_id = ".$itemId." AND `id_lang` = ".$language->id);	                		                		
                		if($images[$index]){
                			if(strpos($images[$index], 'http') !== false){
                				if($check){
			                    	if($check['image'] && file_exists($this->pathImage.$check['image'])) unlink($this->pathImage.$check['image']);
			                    	$db->execute("Update "._DB_PREFIX_."flexgroupbanners_banner_lang Set  `link` = '".$link."', `image` = '".$images[$index]."', `alt` = '".$alt."', `description` = '".$description."' Where `banner_id` = $itemId AND `id_lang` = ".$language->id);	
			                    }else{
			                    	$insertDatas[] = array('banner_id'=>$itemId, 'id_lang'=>$language->id,  'link'=>$link, 'image'=>$images[$index], 'alt'=>$alt, 'description'=>$description) ;
			                    }
							}else{
								if(file_exists($this->pathImage.'temps/'.$images[$index])){
				                    copy($this->pathImage.'temps/'.$images[$index], $this->pathImage.$images[$index]);
				                    unlink($this->pathImage.'temps/'.$images[$index]);		                    
				                    if($check){
				                    	if($check['image'] && file_exists($this->pathImage.$check['image'])) unlink($this->pathImage.$check['image']);
				                    	$db->execute("Update "._DB_PREFIX_."flexgroupbanners_banner_lang Set  `link` = '".$link."', `image` = '".$images[$index]."', `alt` = '".$alt."', `description` = '".$description."' Where `banner_id` = $itemId AND `id_lang` = ".$language->id);	
				                    }else{
				                    	$insertDatas[] = array('banner_id'=>$itemId, 'id_lang'=>$language->id,  'link'=>$link, 'image'=>$images[$index], 'alt'=>$alt, 'description'=>$description) ;
				                    }
				                }else{
				                	if($check){
				                    	$db->execute("Update "._DB_PREFIX_."flexgroupbanners_banner_lang Set  `link` = '".$link."', `alt` = '".$alt."', `description` = '".$description."'  Where `banner_id` = $itemId AND `id_lang` = ".$language->id);	
				                    }else{
				                    	$insertDatas[] = array('banner_id'=>$itemId, 'id_lang'=>$language->id, 'link'=>$link, 'image'=>'', 'alt'=>$alt, 'description'=>$description) ;
				                    }				                	
				                }
							}
						}else{
							if($check){
		                    	$db->execute("Update "._DB_PREFIX_."flexgroupbanners_banner_lang Set  `link` = '".$link."', `alt` = '".$alt."', `description` = '".$description."'  Where `banner_id` = $itemId AND `id_lang` = ".$language->id);	
		                    }else{
		                    	$insertDatas[] = array('banner_id'=>$itemId, 'id_lang'=>$language->id, 'link'=>$link, 'image'=>'', 'alt'=>$alt, 'description'=>$description) ;
		                    }
						}
						if($insertDatas) Db::getInstance()->insert('flexgroupbanners_banner', $insertDatas);
                	}
                }
				$response->status = 1;
            	$response->msg = $this->l("Update banner success!");
            }
        }else{
            $response->status = '0';
            $response->msg = $this->l('Module or Row or Group not found');
        }
		$this->clearCache();
        die(Tools::jsonEncode($response));
    }
	public function changModuleStatus(){
		$itemId = intval($_POST['itemId']);
		$value = intval($_POST['value']);		
		$response = new stdClass();
		if($value == '1'){
			Db::getInstance()->execute("Update "._DB_PREFIX_."flexgroupbanners_module Set `status` = 0 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}else{
			Db::getInstance()->execute("Update "._DB_PREFIX_."flexgroupbanners_module Set `status` = 1 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}
		$this->clearCache();
		die(Tools::jsonEncode($response));
	}
	public function changRowStatus(){
		$itemId = intval($_POST['itemId']);
		$value = intval($_POST['value']);		
		$response = new stdClass();
		if($value == '1'){
			Db::getInstance()->execute("Update "._DB_PREFIX_."flexgroupbanners_row Set `status` = 0 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}else{
			Db::getInstance()->execute("Update "._DB_PREFIX_."flexgroupbanners_row Set `status` = 1 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}
		$this->clearCache();
		die(Tools::jsonEncode($response));
	}
	public function changGroupStatus(){
		$itemId = intval($_POST['itemId']);
		$value = intval($_POST['value']);		
		$response = new stdClass();
		if($value == '1'){
			Db::getInstance()->execute("Update "._DB_PREFIX_."flexgroupbanners_group Set `status` = 0 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}else{
			Db::getInstance()->execute("Update "._DB_PREFIX_."flexgroupbanners_group Set `status` = 1 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}
		$this->clearCache();
		die(Tools::jsonEncode($response));
	}
	public function changbannerStatus(){
		$itemId = intval($_POST['itemId']);
		$value = intval($_POST['value']);		
		$response = new stdClass();
		if($value == '1'){
			Db::getInstance()->execute("Update "._DB_PREFIX_."flexgroupbanners_banner Set `status` = 0 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}else{
			Db::getInstance()->execute("Update "._DB_PREFIX_."flexgroupbanners_banner Set `status` = 1 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}
		$this->clearCache();
		die(Tools::jsonEncode($response));
	}
	public function getModuleItem(){		
        $response = new stdClass();
        $itemId = intval($_POST['itemId']);
        if($itemId){
        	$response->form = $this->renderModuleForm($itemId);// $module->ovicRenderModuleForm($itemId);			       
            $response->status = '1';
            $response->msg = '';
        }else{
            $response->status = '0';
            $response->msg = $this->l('Item not found!');
        }
        die(Tools::jsonEncode($response));
	}
	public function getRowItem(){		
        $response = new stdClass();
        $itemId = intval($_POST['itemId']);
        if($itemId){
        	$response->form = $this->renderRowForm($itemId);			       
            $response->status = '1';
            $response->msg = '';
        }else{
            $response->status = '0';
            $response->msg = $this->l('Item not found!');
        }
        die(Tools::jsonEncode($response));
	}
	public function getGroupItem(){		
        $response = new stdClass();
        $itemId = intval($_POST['itemId']);
        if($itemId){
        	$response->form = $this->renderGroupForm($itemId);			       
            $response->status = '1';
            $response->msg = '';
        }else{
            $response->status = '0';
            $response->msg = $this->l('Item not found!');
        }
        die(Tools::jsonEncode($response));
	}
	public function getbannerItem(){		
        $response = new stdClass();
        $itemId = intval($_POST['itemId']);
        if($itemId){
        	$response->form = $this->renderBannerForm($itemId);
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
        if(Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_module Where id = ".$itemId)){
            Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_module_lang Where module_id = ".$itemId);
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_row_lang Where row_id IN (Select id From "._DB_PREFIX_."flexgroupbanners_row Where module_id = ".$itemId.")");
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_row Where module_id = ".$itemId);
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_group_lang Where group_id IN (Select id From "._DB_PREFIX_."flexgroupbanners_group Where module_id = $itemId)");
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_group Where module_id = ".$itemId);
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_banner_lang Where banner_id IN (Select id From "._DB_PREFIX_."flexgroupbanners_banner Where module_id = $itemId)");
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_banner Where module_id = ".$itemId);						
            $response->status = '1';
            $response->msg = $this->l('Delete Module Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Delete Module not Success!');
        }
        $this->clearCache();
        die(Tools::jsonEncode($response));
	}
	public function deleteRow(){
		$itemId = intval($_POST['itemId']);
        $response = new stdClass();        
        if(Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_row Where id = ".$itemId)){
            Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_row_lang Where row_id = ".$itemId);
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_group_lang Where group_id IN (Select id From "._DB_PREFIX_."flexgroupbanners_group Where row_id = $itemId)");
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_group Where row_id = ".$itemId);
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_banner_lang Where banner_id IN (Select id From "._DB_PREFIX_."flexgroupbanners_banner Where row_id = $itemId)");
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_banner Where row_id = ".$itemId);						
            $response->status = '1';
            $response->msg = $this->l('Delete row Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Delete row not Success!');
        }
		$this->clearCache();
        die(Tools::jsonEncode($response));
	}
	public function deleteGroup(){
		$itemId = intval($_POST['itemId']);
        $response = new stdClass();        
        if(Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_group Where id = ".$itemId)){
            Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_group_lang Where group_id = ".$itemId);			
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_banner_lang Where banner_id IN (Select id From "._DB_PREFIX_."flexgroupbanners_banner Where group_id = $itemId)");
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_banner Where group_id = ".$itemId);						
            $response->status = '1';
            $response->msg = $this->l('Delete group Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Delete group not Success!');
        }
		$this->clearCache();
        die(Tools::jsonEncode($response));
	}
    public function deleteBanner(){
		$itemId = intval($_POST['itemId']);
        $response = new stdClass();        
        if(Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_banner Where id = ".$itemId)){
        	$images = Db::getInstance()->executeS("Select image From "._DB_PREFIX_."flexgroupbanners_banner_lang Where banner_id = $itemId");
			if($images){
				foreach($images as $image){
					if($image['image'] && file_exists($this->pathImage.$image['image'])) unlink($this->pathImage.$image['image']);
				}
			}
            Db::getInstance()->execute("Delete From "._DB_PREFIX_."flexgroupbanners_banner_lang Where banner_id = ".$itemId);	
            $response->status = '1';
            $response->msg = $this->l('Delete menu item Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Delete menu item not Success!');
        }
        $this->clearCache();
        die(Tools::jsonEncode($response));
	}
    
	public function updateModuleOrdering(){
        $response = new stdClass();
        $ids = $_POST['ids'];        
        if($ids){
            $strIds = implode(', ', $ids);            
            $minOrder = Db::getInstance()->getValue("Select Min(ordering) From "._DB_PREFIX_."flexgroupbanners_module Where id IN ($strIds)");            
            foreach($ids as $i=>$id){
                Db::getInstance()->query("Update "._DB_PREFIX_."flexgroupbanners_module Set ordering=".($minOrder + $i)." Where id = ".$id);                
            }
            $response->status = '1';
            $response->msg = $this->l('Update Module Ordering Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Update Module Ordering not Success!');
        }
		$this->clearCache();
        die(Tools::jsonEncode($response));
	}
	public function updateRowOrdering(){
        $response = new stdClass();
        $ids = $_POST['ids'];        
        if($ids){
        	foreach($ids as $index=>$id){
        		Db::getInstance()->execute("Update "._DB_PREFIX_."flexgroupbanners_row Set `ordering` = '".(1 + $index)."' Where id = ".$id);
        	}			
            $response->status = '1';
            $response->msg = $this->l('Update Row Ordering Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Update Row Ordering not Success!');
        }
        $this->clearCache();
        die(Tools::jsonEncode($response));
	}
	public function updateGroupOrdering(){
        $response = new stdClass();
        $ids = $_POST['ids'];
		$moduleId = intval($_POST['moduleId']);
		$rowId = intval($_POST['rowId']);
        if($ids){
        	foreach($ids as $index=>$id){
        		Db::getInstance()->execute("Update "._DB_PREFIX_."flexgroupbanners_group Set `ordering` = '".(1 + $index)."' Where id = ".$id." AND `module_id` = '$moduleId' AND `row_id` = '$rowId'");
        	}			
            $response->status = '1';
            $response->msg = $this->l('Update Group Ordering Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Update Group Ordering not Success!');
        }
		$this->clearCache();
        die(Tools::jsonEncode($response));
	}
	public function updatebannerOrdering(){
        $response = new stdClass();
        $ids = $_POST['ids'];
		$moduleId = intval($_POST['moduleId']);
		$rowId = intval($_POST['rowId']);
		$groupId = intval($_POST['groupId']);
        if($ids){
        	foreach($ids as $index=>$id){
        		Db::getInstance()->execute("Update "._DB_PREFIX_."flexgroupbanners_banner Set `ordering` = '".(1 + $index)."' Where id = ".$id." AND `module_id` = '$moduleId' AND `row_id` = '$rowId' AND `group_id`='".$groupId."'");
        	}			
            $response->status = '1';
            $response->msg = $this->l('Update banner Ordering Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Update banner Ordering not Success!');
        }
		$this->clearCache();
        die(Tools::jsonEncode($response));
	}
	public function loadRowContent(){
		$moduleId = intval($_POST['moduleId']);
		$rowId = intval($_POST['rowId']);		
        $response = $this->getRowContent($moduleId, $rowId);
        die(Tools::jsonEncode($response));
	}
	public function loadGroupContent(){
		$moduleId = intval($_POST['moduleId']);
		$rowId = intval($_POST['rowId']);
		$groupId = intval($_POST['groupId']);		
        $response = $this->getGroupContent($moduleId, $rowId, $groupId);
        die(Tools::jsonEncode($response));
	}
	function loadModuleContent(){
		$langId = Context::getContext()->language->id;
	    $shopId = Context::getContext()->shop->id;
		$moduleId = intval($_POST['moduleId']);
		$response = new stdClass();
		$html = '';
		if($moduleId >0){
			$rows = Db::getInstance()->executeS("Select r.*, rl.name 
				From "._DB_PREFIX_."flexgroupbanners_row AS r 
				Left Join "._DB_PREFIX_."flexgroupbanners_row_lang AS rl On rl.row_id = r.id 
				Where r.module_id = $moduleId AND rl.id_lang=$langId 
				Order By r.ordering");			
			if($rows){
				$html .= '<div class="row-sortable" data-module="'.$moduleId.'">';
				foreach($rows as $row){
					if($row['status'] == '0')
						$status = '<i class="icon-square-o"></i> '.$this->l('Disable');
					else
						$status = '<i class="icon-check-square-o"></i> '.$this->l('Enable');
					$html .= '<div class="panel panel-sup module-'.$moduleId. ($row['width'] >0 ? 'col-sm-'.$row['width'] : 'clearfix').'" data-id="'.$row['id'].'">    
								            <div class="panel-heading">
								                <span class="panel-sup-title '.($row['status'] == 1 ? 'enable' : 'disable').'">'.($row['name'] ? $row['name'] : $this->l('No name [ID: '.$row['id'].']')).'</span>
								                <span class="panel-heading-action panel-item-group pull-right">
								                	<a class="lik-action lik-row-status status-'.$row['status'].'" title="'.$this->l('Change item status').'" data-id="'.$row['id'].'" data-value="'.$row['status'].'" href="javascript:void(0)">'.$status.'</a>                                        
								                    <a class="lik-action lik-row-edit" title="'.$this->l('Edit item').'" data-id="'.$row['id'].'" href="javascript:void(0)"><i class="icon-edit"></i> '.$this->l('Edit').'</a>                                      
								                    <a class="lik-action lik-row-addgroup" title="'.$this->l('Add new group').'" data-id="'.$row['id'].'" href="javascript:void(0)"><i class="icon-addnew"></i> '.$this->l('Add group').'</a>
								                    <a class="lik-action lik-row-delete c-red" title="'.$this->l('Delete item').'" data-id="'.$row['id'].'" href="javascript:void(0)"><i class="icon-trash"></i> '.$this->l('Delete').'</a>								                    
								                </span>
								            </div>
								            <div class="panel-body" id="row-'.$row['id'].'-body" style="padding:0">                              
								                <div class="group-sortable" id="row-'.$row['id'].'-content" data-row="'.$row['id'].'" data-module="'.$moduleId.'">
								                    '.$this->getRowContent($moduleId, $row['id']).'
								                </div>
								            </div>
								        </div>';
				}
				$html .= '</div>';
			}
		}
		die(Tools::jsonEncode($html));
	}
	function getRowContent($moduleId, $rowId){
		$langId = Context::getContext()->language->id;
	    $shopId = Context::getContext()->shop->id;
		$groups = Db::getInstance()->executeS("Select g.*, gl.name 
			From "._DB_PREFIX_."flexgroupbanners_group AS g 
			Left Join "._DB_PREFIX_."flexgroupbanners_group_lang AS gl On gl.group_id = g.id 
			Where g.row_id = $rowId AND gl.id_lang = $langId 
			Order By g.ordering");		
		$html = '';
		if($groups){
			$col12 = 0;			
			foreach ($groups as $group) {				
				if($group['status'] == '0')
					$status = '<i class="icon-square-o"></i> '.$this->l('Disable');
				else
					$status = '<i class="icon-check-square-o"></i> '.$this->l('Enable');
				if($group['width'] ==0){
					$html .= '<div class="clearfix"></div>';
					$col12 = 0;
				}else{
					$col12 += $group['width'];
					if($col12 > 12){
						$html .= '<div class="clearfix"></div>';
						$col12 = 0;
					}	
				}			
				$html .= '<div class="group-item '.($group['width'] > 0 ? ' col-sm-'.$group['width'] : 'clearfix').' row-'.$rowId.'" data-id="'.$group['id'].'">
							<div class="panel">    
								<div class="panel-heading clearfix">
									<div class="pull-left group-name">'.$this->l('Group').'</div>
									<span class="panel-heading-action panel-item-group pull-right">
										<a class="lik-action lik-group-status status-'.$group['status'].'" title="'.$this->l('Change item status').'" data-id="'.$group['id'].'" data-module="'.$moduleId.'" data-row="'.$rowId.'" data-value="'.$group['status'].'" href="javascript:void(0)">'.$status.'</a>                                        
					                    <a class="lik-action lik-group-edit" title="'.$this->l('Edit item').'" data-id="'.$group['id'].'" data-module="'.$moduleId.'" data-row="'.$rowId.'" href="javascript:void(0)"><i class="icon-edit"></i> '.$this->l('Edit').'</a>                                      					                    
					                    <a class="lik-action lik-group-additem" title="'.$this->l('Add new banner').'" data-id="'.$group['id'].'" data-module="'.$moduleId.'" data-row="'.$rowId.'" href="javascript:void(0)"><i class="icon-addnew"></i> '.$this->l('Add banner').'</a>
					                    <a class="lik-action lik-group-delete c-red" title="'.$this->l('Delete item').'" data-id="'.$group['id'].'" data-module="'.$moduleId.'" data-row="'.$rowId.'" href="javascript:void(0)"><i class="icon-trash"></i> '.$this->l('Delete').'</a>
									</span>									
								</div>
								<div class="panel-body" style="padding:0" id="group-'.$group['id'].'-body">
									<div class="menuitem-sortable" data-module="'.$moduleId.'" data-row="'.$rowId.'" data-group="'.$group['id'].'" id="group-'.$group['id'].'-content">
										'.$this->getGroupContent($moduleId, $rowId, $group['id']).'
									</div>
								</div> 
							</div>						
						</div>';
			}
		}
		return $html;
	}
	function getGroupContent($moduleId, $rowId, $groupId){
		$html = '';
		$langId = Context::getContext()->language->id;
		$items = Db::getInstance()->executeS("Select mi.*, mil.image, mil.alt  
			From "._DB_PREFIX_."flexgroupbanners_banner AS mi 
			Left Join "._DB_PREFIX_."flexgroupbanners_banner_lang AS mil On mil.banner_id = mi.id 
			Where mi.group_id = $groupId AND mil.id_lang = $langId 
			Order By mi.ordering");
		if($items){
			foreach($items as $item){
				if($item['status'] == '0')
					$status = '<i class="icon-square-o"></i> '.$this->l('Disable');
				else
					$status = '<i class="icon-check-square-o"></i> '.$this->l('Enable');
				$fullPath = $this->getImageSrc($item['image'], true);
					$html .= '<div class="menu-item group-'.$groupId.'" data-id="'.$item['id'].'">
                                <div class="clearfix banner-item">
	                                <div class="menu-item-name pull-left">'.$this->l('item').'</div>
	                                <span class="pull-right">
	                                	<a class="lik-action lik-menu-item-status status-'.$item['status'].'" title="'.$this->l('Change item status').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-module="'.$moduleId.'" data-id="'.$item['id'].'" data-value="'.$item['status'].'" href="javascript:void(0)">'.$status.'</a>                                  
					                    <a class="lik-action lik-menu-item-edit" title="'.$this->l('Edit item').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-module="'.$moduleId.'" data-id="'.$item['id'].'" href="javascript:void(0)"><i class="icon-edit"></i> '.$this->l('Edit').'</a>                                        
					                    <a class="lik-action lik-menu-item-delete c-red" title="'.$this->l('Delete item').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-module="'.$moduleId.'" data-id="'.$item['id'].'" href="javascript:void(0)"><i class="icon-trash"></i> '.$this->l('Delete').'</a>					                        
	                                </span>
								</div>
                                <div class="banner-img">
                                	<img src="'.$fullPath.'" class="img-responsive" alt="'.$item['alt'].'" />
                                </div>
                            </div>';
			}
		}
		return $html;
	}
    public function hookdisplayHeader()
	{
		// Call in calmodule.css
		//$this->context->controller->addCSS(($this->_path).'css/front-end/style.css');
        $this->context->controller->addJS(($this->_path).'js/front-end/common.js');
        $this->context->controller->addJS(($this->_path).'js/front-end/jquery.actual.min.js');
	}
	public function hookdisplayHome($params)
	{		
		return $this->hooks('hookdisplayHome', $params);
	}
	public function hookdisplayHomeTopColumn($params)
	{		
		return $this->hooks('hookdisplayHomeTopColumn', $params);
	}
    public function hookdisplayHomeBottomContent($params)
	{		
		return $this->hooks('hookdisplayHomeBottomContent', $params);
	}
    public function hookdisplayHomeBottomColumn($params)
	{		
		return $this->hooks('hookdisplayHomeBottomColumn', $params);
	}
    public function hookdisplayHomeTopContent($params)
	{		
		return $this->hooks('hookdisplayHomeTopContent', $params);
	}
    public function hookdisplayBottomColumn($params)
	{		
		return $this->hooks('hookdisplayBottomColumn', $params);
	}
	public function hookdisplayGroupBanner1($params)
	{		
		return $this->hooks('hookdisplayGroupBanner1', $params);
	}
	public function hookdisplayGroupBanner2($params)
	{		
		return $this->hooks('hookdisplayGroupBanner2', $params);
	}
	public function hookdisplayGroupBanner3($params)
	{		
		return $this->hooks('hookdisplayGroupBanner3', $params);
	}
	public function hookdisplayGroupBanner4($params)
	{		
		return $this->hooks('hookdisplayGroupBanner4', $params);
	}
	public function hookdisplayGroupBanner5($params)
	{		
		return $this->hooks('hookdisplayGroupBanner5', $params);
	}
    
    public function hooks($hookName, $param){
        $page_name = Dispatcher::getInstance()->getController();
		$page_name = (preg_match('/^[0-9]/', $page_name) ? 'page_'.$page_name : $page_name);
        //$this->context->smarty->assign('page_name', $page_name);
        $langId = Context::getContext()->language->id;
        $shopId = Context::getContext()->shop->id;        
        $hookName = str_replace('hook','', $hookName);        
        $hookId =  (int) Hook::getIdByName($hookName);
		if($hookId <=0) return '';
		$cacheKey = 'flexgroupbanners|'.$hookName.'|'.$langId.'|'.$shopId.'|'.$page_name;
		if (!$this->isCached('flexgroupbanners.tpl', Tools::encrypt($cacheKey))){			
			$items = Db::getInstance()->executeS("Select DISTINCT m.*, ml.`name` 
	        	From ("._DB_PREFIX_."flexgroupbanners_module AS m 
	        	INNER JOIN "._DB_PREFIX_."flexgroupbanners_module_lang AS ml On m.id = ml.module_id) 
	        	
	        	Where 
	        		m.`position_name` = '".$hookName."' 
	        		AND m.status = 1 
	        		AND  m.id_shop = ".$shopId." 
	        		AND ml.id_lang = ".$langId." 
	        	Order By m.ordering");			
	        $modules = array();
	        if($items){	        	
	            foreach($items as $i=>$item){
	            	$modules[] = array('name'=>$item['name'], 'moduleContents'=>$this->frontGetModuleContents($item, $cacheKey.'|'.$item['id']));				
	            }
	        }else return '';
			$this->context->smarty->assign('flexgroupbanners_modules', $modules); 
		}
		return $this->display(__FILE__, 'flexgroupbanners.tpl', Tools::encrypt($cacheKey));
    }
	function frontGetModuleContents($module, $cacheKey=''){		
		$contents = array();
		$langId = $this->context->language->id;
	    $shopId = $this->context->shop->id;
	    if (!$this->isCached('flexgroupbanners.'.$module['layout'].'.tpl', Tools::encrypt($cacheKey))){
		    $items = Db::getInstance()->executeS("Select r.*, rl.name 
				From "._DB_PREFIX_."flexgroupbanners_row AS r 
				Inner Join "._DB_PREFIX_."flexgroupbanners_row_lang AS rl On r.id = rl.row_id 
				Where r.module_id = ".$module['id']." AND r.status = 1 AND rl.id_lang = ".$langId." 
				Order By r.ordering");		
			if($items){
				foreach($items as $item){
					$contents[] = array(
						'id'=>$item['id'],
						'name'=>$item['name'],
						'custom_class'=>$item['custom_class'],
						'width'=>$item['width'],
						'display_title'=>$item['display_title'],
						'groups' => $this->frontGetGroupContents($module['id'], $item['id'])
					);
				}
				$this->context->smarty->assign(array(			 
					'module_name'=>$module['name'], 
					'module_id'=>$module['id'], 
					'module_layout'=>$module['layout'],
					'display_name'=>$module['display_name'],			
					'custom_class'=>$module['custom_class'],
					'liveImage'=>$this->liveImage,
					'rowContents'=>$contents			
				));
			}else return '';
	    }
		return $this->display(__FILE__, 'flexgroupbanners.'.$module['layout'].'.tpl', Tools::encrypt($cacheKey));
    }
	function frontGetGroupContents($moduleId, $rowId){
		$contents = array();
		$langId = $this->context->language->id;
	    $shopId = $this->context->shop->id;
		$items = Db::getInstance()->executeS("Select g.*, gl.name 
			From "._DB_PREFIX_."flexgroupbanners_group AS g 
			Inner Join "._DB_PREFIX_."flexgroupbanners_group_lang AS gl On g.id = gl.group_id 
			Where g.row_id = ".$rowId." AND g.status = 1 AND gl.id_lang = ".$langId." 
			Order By g.ordering");
		if($items){
			foreach($items as $item){
				$itemContents = $this->frontGetItemContents($moduleId, $rowId, $item['id']);
				$contents[] = array(
					'id'=>$item['id'],
					'name'=>$item['name'],
					'custom_class'=>$item['custom_class'],
					'width'=>$item['width'],
					'items' => $itemContents
				);
			}
		}
		return $contents;
    }	
	function frontGetItemContents($moduleId, $rowId, $groupId){
		$contents = array();
		$langId = $this->context->language->id;
	    $shopId = $this->context->shop->id;
		$items = Db::getInstance()->executeS("Select m.*, ml.link, ml.image, ml.alt, ml.description 
			From "._DB_PREFIX_."flexgroupbanners_banner AS m 
			Inner Join "._DB_PREFIX_."flexgroupbanners_banner_lang AS ml On m.id = ml.banner_id 
			Where m.group_id = ".$groupId." AND m.status = 1 AND ml.id_lang = ".$langId." 
			Order By m.ordering");		
		$contents = array();
		if($items){
			foreach($items as &$item){
				//$item['description'] = Tools::htmlentitiesDecodeUTF8($item['description']);
				
				
				
				$content = $item['description'];
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
															$item['description'] = str_replace('{module}'.$result.'{/module}', $module_content, $item['description']);														
														}else{
															$item['description'] = str_replace('{module}'.$result.'{/module}', '', $item['description']);					
														}
													}else{
														$item['description'] = str_replace('{module}'.$result.'{/module}', '', $item['description']);
													}
												}
											}else{
												$item['description'] = str_replace('{module}'.$result.'{/module}', '', $item['description']);
											}	
			                    		}else{
			                    			$item['description'] = str_replace('{module}'.$result.'{/module}', '', $item['description']);
			                    		}
			                    			
			                    	}else{
			                    		$item['description'] = str_replace('{module}'.$result.'{/module}', '', $item['description']);	
			                    	}
			                    }else{
			                        $item['description'] = str_replace('{module}'.$result.'{/module}', '', $item['description']);
			                    }
			                    
			                }
			            }else{
			            	$item['description'] = preg_replace($pattern, '', $item['description']);
			            }
			        }
				}	
				
				
				
				
				
				
				$item['full_path'] = $this->getImageSrc($item['image']);				
			}
		}
		return $items;
	}
	public function clearCache($cacheKey='')
	{
		if(!$cacheKey){
			$this->_clearCache('flexgroupbanners.tpl');		
			if($this->arrLayout)
				foreach($this->arrLayout as $key=>$value)
					$this->_clearCache('flexgroupbanners.'.$key.'.tpl');	
		}else{
			$this->_clearCache('flexgroupbanners.tpl', $cacheKey);		
			if($this->arrLayout)
				foreach($this->arrLayout as $key=>$value)
					$this->_clearCache('flexgroupbanners.'.$key.'.tpl', $cacheKey);
		}
				
		return true;
	}
}