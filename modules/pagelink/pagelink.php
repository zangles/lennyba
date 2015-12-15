<?php
/*
*  @author SonNC <nguyencaoson.zpt@gmail.com>
*/
class PageLink extends Module
{
    const INSTALL_SQL_FILE = 'install.sql';
	protected static $tables = array(	'pagelink_module'=>'', 
										'pagelink_module_lang'=>'lang', 
										'pagelink_module_position'=>'position', 
										'pagelink_item'=>'', 
										'pagelink_item_lang'=>'lang'
										);
    public $arrLayout = array();
    public $arrCol = array();	
    public $pathImage = '';
    public $liveImage = '';
	public static $sameDatas = '';
	public $page_name = '';
	protected static $arrPosition = array('displayNav', 'displayTop', 'displayPageLink');
	public function __construct()
	{
		$this->name = 'pagelink';		
		$this->arrLayout = array('default'=>$this->l('Default layout'), 'vertical'=>$this->l('Vertical layout'));
		$this->arrCol = array('0'=>$this->l('None column'), '1'=>$this->l('1 Column'),'2'=>$this->l('2 Columns'),'3'=>$this->l('3 Columns'),'4'=>$this->l('4 Columns'),'5'=>$this->l('5 Columns'),'6'=>$this->l('6 Columns'),'7'=>$this->l('7 Columns'),'8'=>$this->l('8 Columns'),'9'=>$this->l('9 Columns'),'10'=>$this->l('10 Columns'),'11'=>$this->l('11 Columns'),'12'=>$this->l('12 Columns'));
		$this->secure_key = Tools::encrypt($this->name);
        $this->pathImage = dirname(__FILE__).'/images/';
		self::$sameDatas = dirname(__FILE__).'/samedatas/';
		if(Configuration::get('PS_SSL_ENABLED'))
			$this->liveImage = _PS_BASE_URL_SSL_.__PS_BASE_URI__.'modules/pagelink/images/'; 
		else
			$this->liveImage = _PS_BASE_URL_.__PS_BASE_URI__.'modules/pagelink/images/';
		$this->tab = 'front_office_features';
		$this->version = '2.0';
		$this->author = 'OVIC-SOFT';		
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('Ovic Page Link Module');
		$this->description = $this->l('Ovic Page Link Module');
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
		if(!parent::install() 
			|| !$this->registerHook('displayHeader')
			|| !$this->registerHook('displayNav')
			|| !$this->registerHook('displayTop')
			|| !$this->registerHook('displayPageLink')
			|| !$this->registerHook('displayBackOfficeHeader')) return false;
		if (!Configuration::updateGlobalValue('MOD_PAGELINK', '1')) return false;
		$this->importSameData();
		return true;
	}
	public  function importSameData($directory=''){
	   //foreach(self::$tables as $table=>$value) Db::getInstance()->execute('TRUNCATE TABLE '._DB_PREFIX_.$table);
	   $shopId = $this->context->shop->id;
	   if($directory) self::$sameDatas = $directory;
		$langs = Db::getInstance()->executeS("Select id_lang From "._DB_PREFIX_."lang Where active = 1");			
		if(self::$tables){
		  $currentOption = Configuration::get('OVIC_CURRENT_DIR');
            if($currentOption) $currentOption .= '.';
            else $currentOption = '';
			foreach(self::$tables as $table=>$value){
				$sqlFile =	self::$sameDatas.$currentOption.$table.'.sql';
				if(!file_exists($sqlFile))
					$sqlFile =	self::$sameDatas.$currentOption.$table.'.sql';					
				if (file_exists($sqlFile)){
				    
					$sql = @file_get_contents($sqlFile);
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
							  if($query)
	                            Db::getInstance()->execute(trim($query));
								//if (!DB::getInstance()->execute(trim($query))) return false;
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
        if (!Configuration::deleteByName('MOD_PAGELINK')) return false;
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
        $items = Db::getInstance()->executeS("Select c.id_category, cl.name 
        	From "._DB_PREFIX_."category as c 
        	Inner Join "._DB_PREFIX_."category_lang as cl On c.id_category = cl.id_category 
        	Where c.active = 1 AND c.level_depth <= $maxDepth AND c.id_shop_default = $shopId AND c.id_parent = $parentId AND cl.id_lang = ".$langId." AND cl.id_shop = ".$shopId);
        if($items){
            foreach($items as $item){
                $arr[] = array('id_category'=>$item['id_category'], 'name'=>$item['name'], 'sp'=>$sp);
                $arr = $this->getAllCategories($langId, $shopId, $item['id_category'], $sp.'- ', $arr);
            }
        }
        return $arr;
    }
	private function getSubMenuIds($parentId = 0, $arr=null){
        if($arr == null) $arr = array();
        $items = Db::getInstance()->executeS("Select id From "._DB_PREFIX_."pagelink_item Where parent_id = ".$parentId);
        if($items){
            foreach($items as $item){
                $arr[] = $item['id'];
                $arr = $this->getSubMenuIds($item['id'], $arr);
            }
        }
        return $arr;
    }
    private function getImageSrc($image = '', $check = false){
    	$result = new stdClass();
        if($image){
        	if(strpos($image, '.') !== false){
        		$result->type='image';
	        	if(strpos($image, 'http') !== false){
	                $result->img = $image;
	            }else{
	                if(file_exists($this->pathImage.$image))
	                    $result->img = $this->liveImage.$image;
	        		else if($image && file_exists($this->pathImage.'icons/'.$image))
	                    $result->img = $this->liveImage.'icons/'.$image;
	                else
						$result->img = '';
	                        
	            }	
        	}else{
        		$result->type='class';
        		$result->img = $image;
        	}
        }else{
        	$result->type='image';
            $result->img = '';
        }    
		return $result;
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
	/*
	private function getPositionMultipleOptions($moduleId=0){
		$options = '';
		$selected = array();
		$id_shop = (int)Context::getContext()->shop->id;		
		$items = Db::getInstance()->executeS("Select * 
			From "._DB_PREFIX_."pagelink_module_position 
			Where module_id = $moduleId");
		if($items){
			foreach($items as $item) $selected[] = $item['position_id'];
		}
		$items = Db::getInstance()->executeS("Select h.name, h.id_hook 
			From "._DB_PREFIX_."hook AS h 
			Inner Join "._DB_PREFIX_."hook_module as hm On h.id_hook = hm.id_hook 
			Where hm.id_module = ".$this->id." AND hm.id_shop = ".$id_shop);        		
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
		$items = Db::getInstance()->executeS("Select * 
			From "._DB_PREFIX_."pagelink_module_position 
			Where module_id = $moduleId");
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
	private function getPositionOptions($selected=''){
		$options = '';		
		if(self::$arrPosition){			
			foreach(self::$arrPosition as $value){
				if($selected == $value) $options .='<option selected="selected" value="'.$value.'">'.$value.'</option>';
				else $options .='<option value="'.$value.'">'.$value.'</option>';
			}
		}
        return $options;
		
    }
	private function buildPositionOfModule($moduleId=0){
		if(!$moduleId) return '';
		$html = '';
		$items = Db::getInstance()->executeS("Select * From "._DB_PREFIX_."pagelink_module_position Where module_id = $moduleId");
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
    private function getCMSCategories($recursive = false, $parent = 1, $id_lang = false)
	{
		$id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;
		if ($recursive === false)
		{
			$sql = 'SELECT bcp.`id_cms_category`, bcp.`id_parent`, bcp.`level_depth`, bcp.`active`, bcp.`position`, cl.`name`, cl.`link_rewrite`
				FROM `'._DB_PREFIX_.'cms_category` bcp
				INNER JOIN `'._DB_PREFIX_.'cms_category_lang` cl
				ON (bcp.`id_cms_category` = cl.`id_cms_category`)
				WHERE cl.`id_lang` = '.(int)$id_lang.'
				AND bcp.`id_parent` = '.(int)$parent;
			return Db::getInstance()->executeS($sql);
		}
		else
		{
			$sql = 'SELECT bcp.`id_cms_category`, bcp.`id_parent`, bcp.`level_depth`, bcp.`active`, bcp.`position`, cl.`name`, cl.`link_rewrite`
				FROM `'._DB_PREFIX_.'cms_category` bcp
				INNER JOIN `'._DB_PREFIX_.'cms_category_lang` cl
				ON (bcp.`id_cms_category` = cl.`id_cms_category`)
				WHERE cl.`id_lang` = '.(int)$id_lang.'
				AND bcp.`id_parent` = '.(int)$parent;
			$results = Db::getInstance()->executeS($sql);
			foreach ($results as $result)
			{
				$sub_categories = $this->getCMSCategories(true, $result['id_cms_category'], (int)$id_lang);
				if ($sub_categories && count($sub_categories) > 0)
					$result['sub_categories'] = $sub_categories;
				$categories[] = $result;
			}
			return isset($categories) ? $categories : false;
		}
	}
    private function getCMSPages($id_cms_category, $id_shop = false, $id_lang = false)
	{
		$id_shop = ($id_shop !== false) ? (int)$id_shop : (int)Context::getContext()->shop->id;
		$id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;
		$sql = 'SELECT c.`id_cms`, cl.`meta_title`, cl.`link_rewrite`
			FROM `'._DB_PREFIX_.'cms` c
			INNER JOIN `'._DB_PREFIX_.'cms_shop` cs
			ON (c.`id_cms` = cs.`id_cms`)
			INNER JOIN `'._DB_PREFIX_.'cms_lang` cl
			ON (c.`id_cms` = cl.`id_cms`)
			WHERE c.`id_cms_category` = '.(int)$id_cms_category.'
			AND cs.`id_shop` = '.(int)$id_shop.'
			AND cl.`id_lang` = '.(int)$id_lang.'
			AND c.`active` = 1
			ORDER BY `position`';
		return Db::getInstance()->executeS($sql);
	} 
    private function getCMSOptions($parent = 0, $depth = 1, $id_lang = false, $selected='')
	{
		$html = '';
		$id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;		
		$categories = $this->getCMSCategories(false, (int)$parent, (int)$id_lang);
		$pages = $this->getCMSPages((int)$parent, false, (int)$id_lang);
		$spacer = str_repeat('|- ', 1 * (int)$depth);
		foreach ($categories as $category)
		{
			//if (isset($items_to_skip) && !in_array('CMS_CAT'.$category['id_cms_category'], $items_to_skip))
			$key = 'CMS_CAT-'.$category['id_cms_category'];
            if($key == $selected)
                $html .= '<option selected="selected" value="'.$key.'" style="font-weight: bold;">'.$spacer.$category['name'].'</option>';
            else 
               $html .= '<option value="'.$key.'" style="font-weight: bold;">'.$spacer.$category['name'].'</option>';
			$html .= $this->getCMSOptions($category['id_cms_category'], (int)$depth + 1, (int)$id_lang, $selected);
		}
		foreach ($pages as $page){
            $key = 'CMS-'.$page['id_cms'];
            if($key == $selected)
			    $html .= '<option selected="selected" value="'.$key.'">'.$spacer.$page['meta_title'].'</option>';
            else 
                $html .= '<option value="'.$key.'">'.$spacer.$page['meta_title'].'</option>';
		}
			//if (isset($items_to_skip) && !in_array('CMS'.$page['id_cms'], $items_to_skip))
		return $html;
	}
    private function getPagesOption($id_lang = null, $selected = '')
    {
        if (is_null($id_lang)) $id_lang = (int)$this->context->cookie->id_lang;
        $files = Meta::getMetasByIdLang($id_lang);
        $html = '';
        foreach ($files as $file)
        {
            $key = 'PAG-'.$file['page'];
            if($key == $selected)
                $html .= '<option selected="selected" value="'.$key.'">' . (($file['title'] !='') ? $file['title'] : $file['page']) . '</option>';
            else
                $html .= '<option value="'.$key.'">' . (($file['title'] !='') ? $file['title'] : $file['page']) . '</option>';
        }
        return $html;
    }
    public function getCategoryLinkOptions($parentId = 0, $selected = ''){
        $langId = Context::getContext()->language->id;
        $shopId = Context::getContext()->shop->id;
        $categoryOptions = '';
        if($parentId <=0) $parentId = Configuration::get('PS_HOME_CATEGORY');
        $items = $this->getAllCategories($langId, $shopId, $parentId, '|- ', null);        
        if($items){
            foreach($items as $item){
                $key = 'CAT-'.$item['id_category'];                
                if($key == $selected) $categoryOptions .='<option selected="selected" value="'.$key.'">'.$item['sp'].$item['name'].'</option>';
                else $categoryOptions .='<option value="'.$key.'">'.$item['sp'].$item['name'].'</option>';
            }
        }
        return  $categoryOptions;
    }
	static function getCategoryNameById($id, $langId=0, $shopId=0){
		if(!$langId) $langId = Context::getContext()->language->id;
        if(!$shopId) $shopId = Context::getContext()->shop->id;
        $name =  Db::getInstance()->getValue("Select name From "._DB_PREFIX_."category_lang Where id_category = $id AND `id_shop` = '$shopId' AND `id_lang` = '$langId'");
        if($name) return $name;
        else return '';   
    }
    public function getAllLinkOptions($selected = '')
    {
    	$suppliers = Supplier::getSuppliers(false, false);
        $manufacturers = Manufacturer::getManufacturers(false, false);
        $allLink = '';
        if($selected == 'CUSTOMLINK-0')
            $allLink .= '<option selected="selected" value="CUSTOMLINK-0">'.$this->l('-- Custom Link --').'</option>';
        else
            $allLink .= '<option value="CUSTOMLINK-0">'.$this->l('-- Custom Link --').'</option>';
       	if($selected == 'CURRENCY-BOX')
            $allLink .= '<option selected="selected" value="CURRENCY-BOX">'.$this->l('-- Box Currency --').'</option>';
        else
            $allLink .= '<option value="CURRENCY-BOX">'.$this->l('-- Box Currency --').'</option>';
		if($selected == 'LANGUAGE-BOX')
            $allLink .= '<option selected="selected" value="LANGUAGE-BOX">'.$this->l('-- Box Languages --').'</option>';
        else
            $allLink .= '<option value="LANGUAGE-BOX">'.$this->l('-- Box Languages --').'</option>';
        $allLink .= '<optgroup label="' . $this->l('Category Link') . '">'.$this->getCategoryLinkOptions(0, $selected).'</optgroup>';
        $allLink .= '<optgroup label="' . $this->l('CMS Link') . '">'.$this->getCMSOptions(0, 1, false, $selected).'</optgroup>';        
        $allLink .= '<optgroup label="'.$this->l('Supplier Link').'">';
		if($selected == 'ALLSUP-0')
            $allLink .= '<option value="ALLSUP-0">'.$this->l('All suppliers').'</option>';
        else
            $allLink .= '<option value="ALLSUP-0">'.$this->l('All suppliers').'</option>';
            foreach ($suppliers as $supplier){
                $key = 'SUP-'.$supplier['id_supplier'];
                if($key == $selected)
                    $allLink .= '<option selected="selected" value="'.$key.'">|- '.$supplier['name'].'</option>';  
                else 
                    $allLink .= '<option value="'.$key.'">|- '.$supplier['name'].'</option>';
            } 
		$allLink .= '</optgroup>';
        $allLink .= '<optgroup label="'.$this->l('Manufacturer Link').'">';
        if($selected == 'ALLMAN-0')
            $allLink .= '<option value="ALLMAN-0">'.$this->l('All manufacturers').'</option>';
        else 
            $allLink .= '<option value="ALLMAN-0">'.$this->l('All manufacturers').'</option>';
        foreach ($manufacturers as $manufacturer){
            $key = 'MAN-'.$manufacturer['id_manufacturer'];
            if($key == $selected)
                $allLink .= '<option selected="selected" value="'.$key.'">|- '.$manufacturer['name'].'</option>';
            else
                $allLink .= '<option value="'.$key.'">|- '.$manufacturer['name'].'</option>';
        }
		$allLink .= '</optgroup>';
        $allLink .= '<optgroup label="' . $this->l('Page Link') . '">'.$this->getPagesOption(null, $selected).'</optgroup>';
        if (Shop::isFeatureActive())
		{
			$allLink .= '<optgroup label="'.$this->l('Shops Link').'">';
			$shops = Shop::getShopsCollection();
			foreach ($shops as $shop)
			{
				if (!$shop->setUrl() && !$shop->getBaseURL()) continue;
                $key = 'SHO-'.$shop->id;
                if($key == $selected)
                    $allLink .= '<option selected="selected" value="SHOP-'.(int)$shop->id.'">'.$shop->name.'</option>';
                else
                    $allLink .= '<option value="SHOP-'.(int)$shop->id.'">'.$shop->name.'</option>';
			}	
			$allLink .= '</optgroup>';
		}
        $allLink .= '<optgroup label="'.$this->l('Product Link').'">';
        if($selected == 'PRODUCT-0')
            $allLink .= '<option selected value="PRODUCT-0" style="font-style:italic">'.$this->l('Choose product ID').'</option>';
        else
            $allLink .= '<option value="PRODUCT-0" style="font-style:italic">'.$this->l('Choose product ID').'</option>';
		$allLink .= '</optgroup>';
        return $allLink;
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
		$itemLang = Db::getInstance()->getRow("Select name From "._DB_PREFIX_."pagelink_module_lang Where module_id = $id AND `id_lang` = '$langId'" );
		if(!$itemLang) $itemLang = array('name'=>'');
		return $itemLang;
    }
	public function getMenuItemByLang($id, $langId=0, $shopId=0){
		if(!$langId) $langId = Context::getContext()->language->id;
		$itemLang = Db::getInstance()->getRow("Select name, `link`  
			From "._DB_PREFIX_."pagelink_item_lang 
			Where menuitem_id = $id AND `id_lang` = '$langId'" );
		if(!$itemLang) $itemLang = array('name'=>'', 'link'=>'');
		return $itemLang;
	}
	public function renderModuleForm($id=0){
		$langId = $this->context->language->id;
        $shopId = $this->context->shop->id;
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."pagelink_module Where id = $id AND `id_shop` = ".$shopId);		
		if(!$item) $item = array('id'=>0, 'id_shop'=>$shopId, 'position_name'=>'', 'display_name'=>1, 'layout'=>'', 'ordering'=>1, 'status'=>1, 'custom_class'=>'', 'width'=>0, 'params'=>'');
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
		$html .= '<div class="form-group"><label class="control-label col-sm-3">'.$this->l('Position').'</label><div class="col-sm-9"><div class="col-sm-12"><select  name="position_name">'.$this->getPositionOptions($item['position_name']).'</select></div></div></div>';
		$html .= '<div class="form-group"><label class="control-label col-sm-3">'.$this->l('Layout').'</label><div class="col-sm-9"><div class="col-sm-12"><select class="form-control" name="moduleLayout">'.$this->getLayoutOptions($item['layout']).'</select></div></div></div>';
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
	public function renderMenuItemForm($id = 0){
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."pagelink_item Where id = $id");		
		if(!$item) $item = array('id'=>0, 'module_id'=>0, 'parent_id'=>0, 'link_type'=>'CUSTOMLINK-0', 'product_id'=>0, 'custom_class'=>'', 'status'=>1, 'ordering'=>1, 'icon'=>'');		
		$langActive = '<input type="hidden" id="menuItemLangActive" value="0" />';
		$languages = $this->getAllLanguage();
		$inputTitle = '';
		$inputLinks = '';
		$inputImage = '';
		$inputImageAlt = '';
		$inputHtml = '';
		if($languages){
			foreach ($languages as $key => $language) {				
				$itemLang = $this->getMenuItemByLang($id, $language->id);
				if($language->active == '1'){
					$langActive = '<input type="hidden" id="menuItemLangActive" value="'.$language->id.'" />';
					$inputTitle .= '<input type="text" value="'.$itemLang['name'].'" name="names[]"  class="form-control menu-item-lang-'.$language->id.'" />';
					$inputLinks .= '<input type="text" value="'.$itemLang['link'].'" name="links[]"  class="form-control menu-item-lang-'.$language->id.'" />';
				}else{
					$inputTitle .= '<input type="text" value="'.$itemLang['name'].'" name="names[]"  class="form-control menu-item-lang-'.$language->id.'" style="display:none" />';
					$inputLinks .= '<input type="text" value="'.$itemLang['link'].'" name="links[]"  class="form-control menu-item-lang-'.$language->id.'" style="display:none" />';
				}				
			}
		}
		$langOptions = $this->getLangOptions();
		$html = '';
		$html .= '<input type="hidden" name="menuItemId" value="'.$item['id'].'" />';		
		$html .= '<input type="hidden" name="parent_id" value="'.$item['parent_id'].'" id="parent_id" />';
		$html .= $langActive;
		$html .= '<input type="hidden" name="action" value="saveMenuItem" />';	
		$html .= '<input type="hidden" name="secure_key" value="'.$this->secure_key.'" />';
		$html .= '<div class="form-group">
                    <label class="control-label col-sm-2 required">'.$this->l('Name').'</label>
				    <div class="col-sm-10">
                        <div class="col-sm-9">'.$inputTitle.'</div>
                        <div class="col-sm-3">
                            <select class="menu-item-lang" onchange="menuItemChangeLanguage(this.value)">'.$langOptions.'</select>
                        </div>                                                                        
                    </div>
                </div> ';
		$html .= '<div class="form-group">
                    <label class="control-label col-sm-2">'.$this->l('Icon').'</label>
				    <div class="col-sm-10">
                        <div class="col-sm-9">
                        	<div class="input-group">
								<input type="text" class="form-control" value="'.$item['icon'].'" name="icon" id="menu-item-icon" />
								<span class="input-group-btn">
									<button id="menu-item-icon-uploader" type="button" class="btn btn-default">
										<i class="icon-folder-open"></i>
									</button>
								</span>
							</div>
                        </div>
                    </div>
                </div> ';
		$html .= '<div class="form-group clearfix">
                    <label class="control-label col-sm-2">'.$this->l('Select Link').'</label>
                    <div class="col-sm-10">
                        <div class="col-sm-9">                        
                            <select name="linkType" class="form-control" onchange="changeLinkType_MenuItem(this.value)">'.$this->getAllLinkOptions($item['link_type']).'</select>                        
                        </div>                        
                    </div>  
                </div>';
		$html .= '<div class="menu-item-link-type-custom" style="display:'.($item['link_type'] == 'CUSTOMLINK-0' ? 'block' : 'none').'">
                  	<div class="form-group clearfix">
	                    <label class="control-label col-sm-2 required">'.$this->l('Url').'</label>
	                    <div class="col-sm-10">
	                        <div class="col-sm-9">'.$inputLinks.'</div>
	                        <div class="col-sm-3">
	                            <select class="menu-item-lang" onchange="menuItemChangeLanguage(this.value)">'.$langOptions.'</select>
	                        </div>
	                    </div>  
	                </div>
                </div>';
		$html .= '<div class="menu-item-link-type-product" style="display:'.($item['link_type'] == 'PRODUCT-0' ? 'block' : 'none').'">
                  	<div class="form-group clearfix">
	                    <label class="control-label col-sm-2 required">'.$this->l('Product Id').'</label>
	                    <div class="col-sm-10">
	                        <div class="col-sm-7">                        
	                            <input name="product_id" type="text" id="menu-item-product-id" value="'.$item['product_id'].'" class="form-control" />                   
	                        </div>
	                    </div>  
	                </div>
                </div>';
		$html .= '<div class="form-group">
                    <label class="control-label col-sm-2">'.$this->l('Custom class').'</label>
                    <div class="col-sm-10">
                        <div class="col-sm-9">
                            <input type="text" value="'.$item['custom_class'].'" name="custom_class"  class="form-control" />
                        </div>                        
                    </div>				    
                </div>';			
		return $html;
	}
	public function hookDisplayBackOfficeHeader()
    {        
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
		// foreach(self::$arrPosition as $hook)
			// $this->registerHook($hook);
		$action = Tools::getValue('action', 'view');
		if($action == 'view'){
			$this->context->controller->addJquery();
            $this->context->controller->addJQueryUI('ui.sortable');            
			$this->context->controller->addJS(($this->_path).'js/back-end/common.js');                
	        $this->context->controller->addJS(($this->_path).'js/back-end/ajaxupload.3.5.js');
			$this->context->controller->addJS(($this->_path).'js/back-end/jquery.serialize-object.min.js');		
			$this->context->controller->addJS(__PS_BASE_URI__.'js/jquery/plugins/jquery.tablednd.js');        	        
	        $this->context->controller->addCSS(($this->_path).'css/back-end/style.css');	        
	        $langId = $this->context->language->id;
	        $shopId = $this->context->shop->id;
	        $items = Db::getInstance()->executeS("Select m.*, ml.name 
	        	From "._DB_PREFIX_."pagelink_module AS m 
	        	Left Join "._DB_PREFIX_."pagelink_module_lang AS ml On ml.module_id = m.id 
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
	            'secure_key'=>$this->secure_key,
	            'moduleForm' => $this->renderModuleForm(),
	            'menuItemForm' => $this->renderMenuItemForm(),
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
		$shopId = $this->context->shop->id;
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
			//$handle = fopen(self::$sameDatas.'store'.$shopId.'.'.$currentOption.$table.'.sql','w+');
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
    public function saveModule(){
        $shopId = Context::getContext()->shop->id;
		$languages = $this->getAllLanguage();        
        $response = new stdClass();		
        $itemId = intval($_POST['moduleId']);
		$db = Db::getInstance();
		$names = $_POST['module_titles'];
        $layout = Tools::getValue('moduleLayout', 'default');        
        $display_name = Tools::getValue('module_display_name', 1);
        $custom_class = Tools::getValue('custom_class', '');
		$width = Tools::getValue('width', 0);
		$params = '';
		$position_name = Tools::getValue('position_name', '');
		//$positions = Tools::getValue('positions', array());		        
        if($itemId == 0){
			$maxOrdering = $db->getValue("Select MAX(ordering) From "._DB_PREFIX_."pagelink_module");
		   	if($maxOrdering >0) $maxOrdering++;
		   	else $maxOrdering = 1;
            if($db->execute("Insert Into "._DB_PREFIX_."pagelink_module (`id_shop`, `position_name`, `display_name`, `layout`, `ordering`, `status`, `custom_class`, `width`, `params`) Values ('$shopId', '$position_name', '".$display_name."', '".$layout."', '$maxOrdering', '1', '$custom_class', '$width', '$params')")){
                $insertId = $db->Insert_ID();
				/*
				if($positions){
					$insertModuleHook = array();
					foreach($positions as $position){						
						$insertModuleHook[] = array('module_id'=>$insertId, 'position_id'=>$position, 'position_name'=>Hook::getNameById($position));
					}
					if($insertModuleHook) Db::getInstance()->insert('pagelink_module_position', $insertModuleHook);
				}
				*/   
				if($languages){
                	$insertDatas = array();
                	foreach($languages as $index=>$language){                		
						$insertDatas[] = array('module_id'=>$insertId, 'id_lang'=>$language->id, 'name'=>$db->escape($names[$index]));                   		                
                	}
					if($insertDatas) $db->insert('pagelink_module_lang', $insertDatas);
                }                
                $response->status = '1';
                $response->msg = $this->l('Add new Module Success!');  
            }else{
                $response->status = '0';
                $response->msg = $this->l('Add new Module not Success!');
            }
        }else{
            $item = $db->getRow("Select * From "._DB_PREFIX_."pagelink_module Where id = ".$itemId);
            $db->execute("Update "._DB_PREFIX_."pagelink_module Set `position_name`='$position_name',  `layout`='".$layout."', `params` = '".$params."', `custom_class`='$custom_class', `display_name`='$display_name', `width`='$width' Where id = ".$itemId);            
			/*
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."pagelink_module_position Where `module_id` = ".$itemId);
			if($positions){
				$insertModuleHook = array();
				foreach($positions as $position){						
					$insertModuleHook[] = array('module_id'=>$itemId, 'position_id'=>$position, 'position_name'=>Hook::getNameById($position));
				}
				if($insertModuleHook) Db::getInstance()->insert('pagelink_module_position', $insertModuleHook);
			}
			*/  
			if($languages){
				$insertDatas = array();            	
            	foreach($languages as $index=>$language){
            		$check = $db->getValue("Select module_id From "._DB_PREFIX_."pagelink_module_lang Where module_id = $itemId AND id_lang = ".$language->id);
            		if($check){
            			$db->execute("Update "._DB_PREFIX_."pagelink_module_lang Set `name` = '".$db->escape($names[$index])."' Where `module_id` = ".$itemId." AND `id_lang` = ".$language->id);	
            		}else{
            			$insertDatas[] = array('module_id'=>$itemId, 'id_lang'=>$language->id, 'name'=>$db->escape($names[$index]));
            		}
            	}
            	if($insertDatas) $db->insert('pagelink_module_lang', $insertDatas);
            }            
            $response->status = '1';
            $response->msg = $this->l('Update Module Success!');
			Tools::clearCache();
        }
        die(Tools::jsonEncode($response));
    }
	public function saveMenuItem(){
		$languages = $this->getAllLanguage();
        $db = Db::getInstance();
		$moduleId = intval($_POST['moduleId']);
		$parentId = intval($_POST['parent_id']);		
        $itemId = intval($_POST['menuItemId']);        
		$names = Tools::getValue('names', array());
		$custom_class = Tools::getValue('custom_class', '');
		$link_type = Tools::getValue('linkType', 'CUSTOMLINK-0');
		$product_id = Tools::getValue('product_id', 0);
		$links = Tools::getValue('links', array());
		$icon = Tools::getValue('icon', array());			
		$response = new stdClass();
        if($moduleId >0){            
            if($itemId == 0){
				$maxOrdering = $db->getValue("Select MAX(ordering) From "._DB_PREFIX_."pagelink_item Where `module_id` = ".$moduleId." AND `parent_id` = ".$parentId);
		   		if($maxOrdering >0) $maxOrdering++;
		   		else $maxOrdering = 1;	
                if($db->execute("Insert Into "._DB_PREFIX_."pagelink_item (`module_id`, `parent_id`, `link_type`, `product_id`, `custom_class`, `status`, `ordering`, `icon`) Values ('".$moduleId."', '".$parentId."', '".$link_type."', '".$product_id."', '".$custom_class."', '1', '$maxOrdering', '".$icon."')")){
                    $insertId = $db->Insert_ID();
                    if($icon){
                        if(strpos($icon, 'http') === false && strpos($icon, '.') !== false){
                            if(file_exists($this->pathImage.'temps/'.$icon)){
        						copy($this->pathImage.'temps/'.$icon, $this->pathImage.'icons/'.$icon);
        						unlink($this->pathImage.'temps/'.$icon);
        					}        
                        }
                    }
					if($languages){
	                	$insertDatas = array();
	                	foreach($languages as $index=>$language){	                		
			                $insertDatas[] = array('menuitem_id'=>$insertId, 'id_lang'=>$language->id, 'name'=>$db->escape($names[$index]), 'link'=>$db->escape($links[$index])) ;			                
	                	}
						if($insertDatas) $db->insert('pagelink_item_lang', $insertDatas);
	                }                    
                    $response->status = '1';
                    $response->msg = $this->l("Add new Menu item Success!");
                }else{
                    $response->status = '0';
                    $response->msg = $this->l("Add new Menu item not Success!");
                }
            }else{
                $item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."pagelink_item Where id = ".$itemId);
				if($icon){
				    if(strpos($icon, 'http') !== false || strpos($icon, '.') === false){
				        Db::getInstance()->execute("Update "._DB_PREFIX_."pagelink_item Set `link_type` = '".$link_type."', `product_id` = '".$product_id."', `custom_class`='".$custom_class."', `icon`='$icon' Where id = ".$itemId);
                    }else{
                        if(file_exists($this->pathImage.'temps/'.$icon)){
        					if(copy($this->pathImage.'temps/'.$icon, $this->pathImage.'icons/'.$icon)){
        						Db::getInstance()->execute("Update "._DB_PREFIX_."pagelink_item Set `link_type` = '".$link_type."', `product_id` = '".$product_id."', `custom_class`='".$custom_class."', `icon`='$icon' Where id = ".$itemId);		
        					}else{
        						Db::getInstance()->execute("Update "._DB_PREFIX_."pagelink_item Set `link_type` = '".$link_type."', `product_id` = '".$product_id."', `custom_class`='".$custom_class."' Where id = ".$itemId);
        					}
        					unlink($this->pathImage.'temps/'.$icon);
        				}else{        					
       						Db::getInstance()->execute("Update "._DB_PREFIX_."pagelink_item Set `link_type` = '".$link_type."', `product_id` = '".$product_id."', `custom_class`='".$custom_class."' Where id = ".$itemId);        					
        				}    
                    }
                    
				}else{
				    Db::getInstance()->execute("Update "._DB_PREFIX_."pagelink_item Set `link_type` = '".$link_type."', `product_id` = '".$product_id."', `custom_class`='".$custom_class."', `icon`='' Where id = ".$itemId);
				}
                
                
				if($languages){
					$insertDatas = array();
                	foreach($languages as $index=>$language){
						$check = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."pagelink_item_lang Where menuitem_id = ".$itemId." AND `id_lang` = ".$language->id);	                		                		
	                	if($check){
	                    	$db->execute("Update "._DB_PREFIX_."pagelink_item_lang Set `name` = '".$db->escape($names[$index])."', `link` = '".$db->escape($links[$index])."'  Where `menuitem_id` = $itemId AND `id_lang` = ".$language->id);	
	                    }else{
	                    	$insertDatas[] = array('menuitem_id'=>$itemId, 'id_lang'=>$language->id, 'name'=>$db->escape($names[$index]), 'link'=>$db->escape($links[$index])) ;
	                    }
						if($insertDatas) Db::getInstance()->insert('pagelink_item_lang', $insertDatas);
                	}
                }
				$response->status = 1;
            	$response->msg = $this->l("Update menu item success!");
            }
        }else{
            $response->status = '0';
            $response->msg = $this->l('Module not found');
        }
        die(Tools::jsonEncode($response));
    }
	public function changModuleStatus(){
		$itemId = intval($_POST['itemId']);
		$value = intval($_POST['value']);		
		$response = new stdClass();
		if($value == '1'){
			Db::getInstance()->execute("Update "._DB_PREFIX_."pagelink_module Set `status` = 0 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}else{
			Db::getInstance()->execute("Update "._DB_PREFIX_."pagelink_module Set `status` = 1 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}
		die(Tools::jsonEncode($response));
	}	
	public function changMenuItemStatus(){
		$itemId = intval($_POST['itemId']);
		$value = intval($_POST['value']);		
		$response = new stdClass();
		if($value == '1'){
			Db::getInstance()->execute("Update "._DB_PREFIX_."pagelink_item Set `status` = 0 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}else{
			Db::getInstance()->execute("Update "._DB_PREFIX_."pagelink_item Set `status` = 1 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}
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
	public function getMenuItemItem(){		
        $response = new stdClass();
        $itemId = intval($_POST['itemId']);
        if($itemId){
        	$response->form = $this->renderMenuItemForm($itemId);
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
        if(Db::getInstance()->execute("Delete From "._DB_PREFIX_."pagelink_module Where id = ".$itemId)){
            Db::getInstance()->execute("Delete From "._DB_PREFIX_."pagelink_module_lang Where module_id = ".$itemId);
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."pagelink_module_position Where module_id = ".$itemId);			
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."pagelink_item_lang Where menuitem_id IN (Select id From "._DB_PREFIX_."pagelink_item Where module_id = $itemId)");
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."pagelink_item Where module_id = ".$itemId);						
            $response->status = '1';
            $response->msg = $this->l('Delete Module Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Delete Module not Success!');
        }
        die(Tools::jsonEncode($response));
	}
	public function deleteMenuItem(){
		$itemId = intval($_POST['itemId']);
        $response = new stdClass();
        $subIds = $this->getSubMenuIds($itemId, array($itemId));
		if($subIds){
			foreach($subIds as $subId){
				Db::getInstance()->execute("Delete From "._DB_PREFIX_."pagelink_item Where id = '$subId'");
				Db::getInstance()->execute("Delete From "._DB_PREFIX_."pagelink_item_lang Where menuitem_id = '$subId'");
			}
		}else{
            $response->status = '0';
            $response->msg = $this->l('Delete menu item not Success!');
        }
        die(Tools::jsonEncode($response));
	}
	public function updateModuleOrdering(){
        $response = new stdClass();
        $ids = $_POST['ids'];        
        if($ids){            
            foreach($ids as $i=>$id){
                Db::getInstance()->query("Update "._DB_PREFIX_."pagelink_module Set ordering=".(1 + $i)." Where id = ".$id);                
            }
            $response->status = '1';
            $response->msg = $this->l('Update Module Ordering Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Update Module Ordering not Success!');
        }
        die(Tools::jsonEncode($response));
	}
	public function updateMenuItemOrdering(){
        $response = new stdClass();
        $ids = $_POST['ids'];
        if($ids){
        	foreach($ids as $index=>$id){
        		Db::getInstance()->execute("Update "._DB_PREFIX_."pagelink_item Set `ordering` = '".(1 + $index)."' Where id = ".$id);
        	}			
            $response->status = '1';
            $response->msg = $this->l('Update Menu Item Ordering Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Update Menu Item Ordering not Success!');
        }
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
				From "._DB_PREFIX_."pagelink_item AS r 
				Left Join "._DB_PREFIX_."pagelink_item_lang AS rl On rl.menuitem_id = r.id 
				Where r.module_id = $moduleId AND r.parent_id = 0 AND rl.id_lang=$langId Order By r.ordering");
			if($rows){
				$html .= '<ul class="row-sortable menu-sub-items" data-module="'.$moduleId.'">';
				foreach($rows as $row){
					if($row['status'] == '0')
						$status = '<i class="icon-square-o"></i> '.$this->l('Disable');
					else
						$status = '<i class="icon-check-square-o"></i> '.$this->l('Enable');					
					$html .= '<li class="module-'.$moduleId.'" data-id="'.$row['id'].'"><span id="menu-item-title-'.$row['id'].'" class="'.($row['status'] == '1' ? '' :'red' ).'">'.$row['name'].'</span>
								<span class="pull-right">
									<a class="lik-menu-item-status action-item" title="'.$this->l('Change item status').'" data-id="'.$row['id'].'" data-module="'.$moduleId.'"  data-value="'.$row['status'].'" href="javascript:void(0)">'.$status.'</a>
									<a class="lik-menu-item-edit action-item" title="'.$this->l('Edit item').'" data-id="'.$row['id'].'" data-module="'.$moduleId.'"  href="javascript:void(0)"><i class="icon-edit"></i> '.$this->l('Edit').'</a>
									<a class="lik-menu-item-delete action-item" title="'.$this->l('Delete item').'" data-id="'.$row['id'].'" data-module="'.$moduleId.'"  href="javascript:void(0)"><i class="icon-trash"></i> '.$this->l('Delete').'</a>
								</span>
							</li>';
				}
				$html .= '</ul>';
			}
		}
		die(Tools::jsonEncode($html));
	}
	/*
	function loadModuleContent(){
		$langId = Context::getContext()->language->id;
	    $shopId = Context::getContext()->shop->id;
		$moduleId = intval($_POST['moduleId']);
		$response = new stdClass();
		$html = '';
		if($moduleId >0){
			$rows = Db::getInstance()->executeS("Select r.*, rl.name 
				From "._DB_PREFIX_."pagelink_item AS r 
				Left Join "._DB_PREFIX_."pagelink_item_lang AS rl On rl.menuitem_id = r.id 
				Where r.module_id = $moduleId AND r.parent_id = 0 AND rl.id_lang=$langId Order By r.ordering");
			if($rows){
				$html .= '<div class="row-sortable" data-module="'.$moduleId.'">';
				foreach($rows as $row){
					if($row['status'] == '0')
						$status = '<i class="icon-square-o"></i> '.$this->l('Disable');
					else
						$status = '<i class="icon-check-square-o"></i> '.$this->l('Enable');					
					$html .= '<div class="panel panel-sup module-'.$moduleId.' col-sm-12" data-id="'.$row['id'].'">    
								            <div class="panel-heading clearfix">
								                <span id="menu-item-title-'.$row['id'].'" class="pull-left panel-sup-title '.($row['status'] == 1 ? '' : 'red').'">'.($row['name'] ? $row['name'] : $this->l('No name [ID: '.$row['id'].']')).'</span>
								                <span class="pull-right">
							                	 	<a class="action-item lik-menu-item-status" title="'.$this->l('Change item status').'" data-module="'.$moduleId.'" data-id="'.$row['id'].'" data-value="'.$row['status'].'" href="javascript:void(0)">'.$status.'</a>
							                	 	<a class="action-item lik-menu-item-edit" title="'.$this->l('Edit item').'" data-module="'.$moduleId.'" data-id="'.$row['id'].'" href="javascript:void(0)"><i class="icon-edit"></i> '.$this->l('Edit').'</a>                                    
							                        <a class="action-item lik-menu-item-delete" title="'.$this->l('Delete item').'" data-module="'.$moduleId.'" data-id="'.$row['id'].'" href="javascript:void(0)"><i class="icon-trash"></i> '.$this->l('Delete').'</a>								                        
							                        <a class="action-item lik-menu-item-addsub" title="'.$this->l('Add sub menu').'" data-module="'.$moduleId.'" data-id="'.$row['id'].'" href="javascript:void(0)"><i class="icon-addnew"></i> '.$this->l('Add sub menu').'</a>
								                </span>
								            </div>
								            <div class="panel-body" id="row-'.$row['id'].'-body" style="padding:0">                              
								                <ul class="group-sortable menu-sub-items" id="row-'.$row['id'].'-content" data-row="'.$row['id'].'" data-module="'.$moduleId.'">
								                    '.$this->getParentContent($moduleId, $row['id']).'
								                </ul>
								            </div>								             
								        </div>';
				}
				$html .= '</div>';
			}
		}
		die(Tools::jsonEncode($html));
	}
	function getParentContent($moduleId, $rowId){
		$langId = Context::getContext()->language->id;
	    $shopId = Context::getContext()->shop->id;
		$groups = Db::getInstance()->executeS("Select g.*, gl.name 
			From "._DB_PREFIX_."pagelink_item AS g 
			Left Join "._DB_PREFIX_."pagelink_item_lang AS gl On gl.menuitem_id = g.id 
			Where g.module_id = $moduleId AND g.parent_id = '$rowId' AND gl.id_lang = $langId Order By g.ordering");			
		$html = '';
		if($groups){	
			foreach ($groups as $group) {				
				if($group['status'] == '0')
					$status = '<i class="icon-square-o"></i> '.$this->l('Disable');
				else
					$status = '<i class="icon-check-square-o"></i> '.$this->l('Enable');
				$html .= '<li class="row-'.$rowId.'" data-id="'.$group['id'].'"><span id="menu-item-title-'.$group['id'].'" class="'.($group['status'] == '1' ? '' :'red' ).'">'.$group['name'].'</span>
								<span class="pull-right">
									<a class="lik-menu-item-status action-item" title="'.$this->l('Change item status').'" data-id="'.$group['id'].'" data-module="'.$moduleId.'" data-row="'.$rowId.'" data-value="'.$group['status'].'" href="javascript:void(0)">'.$status.'</a>
									<a class="lik-menu-item-edit action-item" title="'.$this->l('Edit item').'" data-id="'.$group['id'].'" data-module="'.$moduleId.'" data-row="'.$rowId.'" href="javascript:void(0)"><i class="icon-edit"></i> '.$this->l('Edit').'</a>
									<a class="lik-menu-item-delete action-item" title="'.$this->l('Delete item').'" data-id="'.$group['id'].'" data-module="'.$moduleId.'" data-row="'.$rowId.'" href="javascript:void(0)"><i class="icon-trash"></i> '.$this->l('Delete').'</a>
								</span>
							</li>';
			}
		}
		return $html;
	}
	*/
    public function hookdisplayHeader()
	{
		// callmodules.css
		//$this->context->controller->addCSS(($this->_path).'css/front-end/style.css');
        $this->context->controller->addJS(($this->_path).'js/front-end/common.js');
        $this->context->controller->addJS(($this->_path).'js/front-end/jquery.actual.min.js');
	}
	public function hookdisplayNav($params)
	{
		return $this->hooks('hookdisplayNav', $params);		
	}
	public function hookdisplayPageLink($params)
	{
		
		return $this->hooks('hookdisplayPageLink', $params);		
	}
	public function hookdisplayTop($params)
	{
		return $this->hooks('hookdisplayTop', $params);		
	}
    public function hooks($hookName, $param){
    	
        $page_name = Dispatcher::getInstance()->getController();
		$page_name = (preg_match('/^[0-9]/', $page_name) ? 'page_'.$page_name : $page_name);
        $this->context->smarty->assign('page_name', $page_name);
        $langId = Context::getContext()->language->id;
        $shopId = Context::getContext()->shop->id;        
        $hookName = str_replace('hook','', $hookName);        
        $hookId = Hook::getIdByName($hookName);
		if(!$hookId) return "";
		$cacheKey = 'pagelink|'.$hookName.'|'.$langId.'|'.$shopId.'|'.$page_name;
		if (!$this->isCached('pagelink.tpl', Tools::encrypt($cacheKey))){
			$items = Db::getInstance()->executeS("Select DISTINCT m.*, ml.`name` 
	        	From "._DB_PREFIX_."pagelink_module AS m 
	        	INNER JOIN "._DB_PREFIX_."pagelink_module_lang AS ml On m.id = ml.module_id  	        	 
	        	Where 
	        		m.`position_name` = '".$hookName."' 
	        		AND m.status = 1 
	        		AND  m.id_shop = ".$shopId." 
	        		AND ml.id_lang = ".$langId." 
	        	Order By 
	        		m.ordering");		
	        $modules = array();		
	        if($items){        	 	
	            foreach($items as $i=>$item){
	            	$modules[] = array('moduleContents'=>$this->frontGetModuleContents($item, $cacheKey.'|'.$item['id']));				
	            }
	            $this->context->smarty->assign('pagelink_modules', $modules);
	        }else return ''; 
		}
        return $this->display(__FILE__, 'pagelink.tpl', Tools::encrypt($cacheKey));
    }
	function frontGetModuleContents($module, $cacheKey=''){
		if (!$this->isCached('pagelink.'.$module['layout'].'.tpl', Tools::encrypt($cacheKey))){
			$contents = array();
			$langId = $this->context->language->id;
		    $shopId = $this->context->shop->id;
			$items = Db::getInstance()->executeS("Select r.*, rl.name, rl.link  
				From "._DB_PREFIX_."pagelink_item AS r 
				Inner Join "._DB_PREFIX_."pagelink_item_lang AS rl On r.id = rl.menuitem_id 
				Where r.parent_id = 0 AND r.module_id = ".$module['id']." AND r.status = 1 AND rl.id_lang = ".$langId." Order By r.ordering");
			if($items){
				foreach($items as &$item){
					$icon = $this->getImageSrc($item['icon'], true);
					$item['icon_type'] = $icon->type;
					$item['full_path'] = $icon->img;				
					if($item['link_type'] == 'PAG-authentication'){
						if($this->context->customer->logged){
							$item['link'] = $this->context->link->getPageLink('index', true, NULL, "mylogout");
							$item['name'] = $this->l('Sign out');
							$item['custom_class'] = 'nav-logout';
						}else{
							$item['link'] = $this->frontGenerationUrl($item['link_type'], $item['link']);
						}	
					}elseif($item['link_type'] == 'PRODUCT-0'){
						$item['link'] = $this->frontGenerationUrl('PRD-'.$item['product_id'], $item['link']);
					}elseif($item['link_type'] == 'CURRENCY-BOX'){			
						$item['currencies'] = array(
							'name'		=>	$this->context->currency->name,
							'iso_code'	=>	$this->context->currency->iso_code,
							'sign'		=>	$this->context->currency->sign,
							);
					}elseif($item['link_type'] == 'LANGUAGE-BOX'){
						$languages = Language::getLanguages(true, $this->context->shop->id);
						if(count($languages) >0){
							$link = new Link();			
							if ((int)Configuration::get('PS_REWRITING_SETTINGS'))
							{
								$default_rewrite = array();
								if (Dispatcher::getInstance()->getController() == 'product' && ($id_product = (int)Tools::getValue('id_product')))
								{
									$rewrite_infos = Product::getUrlRewriteInformations((int)$id_product);
									foreach ($rewrite_infos as $infos)
										$default_rewrite[$infos['id_lang']] = $link->getProductLink((int)$id_product, $infos['link_rewrite'], $infos['category_rewrite'], $infos['ean13'], (int)$infos['id_lang']);
								}				
								if (Dispatcher::getInstance()->getController() == 'category' && ($id_category = (int)Tools::getValue('id_category')))
								{
									$rewrite_infos = Category::getUrlRewriteInformations((int)$id_category);
									foreach ($rewrite_infos as $infos)
										$default_rewrite[$infos['id_lang']] = $link->getCategoryLink((int)$id_category, $infos['link_rewrite'], $infos['id_lang']);
								}				
								if (Dispatcher::getInstance()->getController() == 'cms' && (($id_cms = (int)Tools::getValue('id_cms')) || ($id_cms_category = (int)Tools::getValue('id_cms_category'))))
								{
									$rewrite_infos = (isset($id_cms) && !isset($id_cms_category)) ? CMS::getUrlRewriteInformations($id_cms) : CMSCategory::getUrlRewriteInformations($id_cms_category);
									foreach ($rewrite_infos as $infos)
									{
										$arr_link = (isset($id_cms) && !isset($id_cms_category)) ?
											$link->getCMSLink($id_cms, $infos['link_rewrite'], null, $infos['id_lang']) :
											$link->getCMSCategoryLink($id_cms_category, $infos['link_rewrite'], $infos['id_lang']);
										$default_rewrite[$infos['id_lang']] = $arr_link;
									}
								}
								$this->smarty->assign(array(
									'lang_rewrite_urls'	=>	$default_rewrite,
									'lang_name'			=>	$this->context->language->name,
									'lang_iso_code'		=>	$this->context->language->iso_code,
								));
							}
						}					
					}else{
						$item['link'] = $this->frontGenerationUrl($item['link_type'], $item['link']);
					}
					$item['submenus'] = $this->frontGetSubMenus($module['id'], $item['id']);
				}
			}			
			$this->context->smarty->assign(array(			 
				'module_layout'=>$module['layout'],
				'display_name'=>$module['display_name'],			
				'custom_class'=>$module['custom_class'],
				'name'=>$module['name'],
				'menuContents'=>$items			
			));	
		}		
		
		
		return $this->display(__FILE__, 'pagelink.'.$module['layout'].'.tpl', Tools::encrypt($cacheKey));
    }
	function s_print($content){
		echo "<pre>";
		print_r($content);
		echo "</pre>";
		die;
	}
	function frontGetSubMenus($moduleId, $parentId){
		$contents = array();
		$langId = $this->context->language->id;
	    $shopId = $this->context->shop->id;
		$items = Db::getInstance()->executeS("Select r.*, rl.name, rl.link  
			From "._DB_PREFIX_."pagelink_item AS r 
			Inner Join "._DB_PREFIX_."pagelink_item_lang AS rl On r.id = rl.menuitem_id 
			Where r.parent_id = ".$parentId." AND r.module_id = ".$moduleId." AND r.status = 1 AND rl.id_lang = ".$langId." Order By r.ordering");
		if($items){
			foreach($items as &$item){				
				$item['full_path'] = $this->getImageSrc($item['icon'], true);
				if($item['link_type'] == 'CUSTOMLINK-0'){					
				}elseif($item['link_type'] == 'PRODUCT-0'){
					$item['link'] = $this->frontGenerationUrl('PRD-'.$item['product_id'], $item['link']);
				}else{
					$item['link'] = $this->frontGenerationUrl($item['link_type'], $item['link']);
				}
			}
		}
		return $contents;
    }
	protected function frontGenerationUrl($value='', $default='#', $prefix = ''){
        $response = $default;
		if($prefix) $value .= $prefix; 
        if($value){
            $langId = $this->context->language->id;
	    	$shopId = $this->context->shop->id;	    	
            $arr = explode('-', $value);
            switch ($arr[0]){
                case 'PRD':
					$product = new Product((int)$arr[1], true, (int)$langId);
                    $response = Tools::HtmlEntitiesUTF8($product->getLink());                    
					break;
                case 'CAT':           
				    $response = Tools::HtmlEntitiesUTF8(Context::getContext()->link->getCategoryLink((int)$arr[1], null, $langId));
                    break;
                case 'CMS_CAT':                                                    
                    $response = Tools::HtmlEntitiesUTF8(Context::getContext()->link->getCMSCategoryLink((int)$arr[1], null, $langId));
                    break;    
                case 'CMS':                                
                    $response = Tools::HtmlEntitiesUTF8(Context::getContext()->link->getCMSLink((int)$arr[1], null, $langId));                
                    break;
                case 'ALLMAN':
                    $response = Tools::HtmlEntitiesUTF8(Context::getContext()->link->getPageLink('manufacturer'), true, $langId);					
					break;        
                case 'MAN':
                    $man = new Manufacturer((int)$arr[1], $langId);
                    $response = Tools::HtmlEntitiesUTF8(Context::getContext()->link->getManufacturerLink($man->id, $man->link_rewrite, $langId)); 
                    break;
                case 'ALLSUP':
					$response = Tools::HtmlEntitiesUTF8(Context::getContext()->link->getPageLink('supplier'), true, $langId);
					break;    
                case 'SUP':
					//$page = str_replace('SUP-', '', $value)
                    $sup = new Supplier((int)$arr[1], $langId);    
                    $response = Tools::HtmlEntitiesUTF8(Context::getContext()->link->getSupplierLink($sup->id, $sup->link_rewrite, $langId));
                    break;
                case 'PAG':
                    $pag = Meta::getMetaByPage(str_replace('PAG-', '', $value), $langId);					
					if(strpos($pag['page'], 'module-') === false){
						$response = Tools::HtmlEntitiesUTF8(Context::getContext()->link->getPageLink($pag['page'], true, $langId));
					}else{
						$page = explode('-', $pag['page']);	
						Context::getContext()->link->getModuleLink($page[1], $page[2]);						
						$response = Tools::HtmlEntitiesUTF8(Context::getContext()->link->getModuleLink($page[1], $page[2]));
					}
                    break;
                case 'SHO':
                    $shop = new Shop((int)$key);
                    $response = $shop->getBaseURL();    
                    break;    
                default:
                    break;
            }
        }		
        return $response;
    }

    public function clearCache($cacheKey=''){
		if(!$cacheKey){
			$this->_clearCache('pagelink.tpl');		
			if($this->arrLayout)
				foreach($this->arrLayout as $key=>$value)
					$this->_clearCache('pagelink.'.$key.'.tpl');	
		}else{
			$this->_clearCache('pagelink.tpl', $cacheKey);		
			if($this->arrLayout)
				foreach($this->arrLayout as $key=>$value)
					$this->_clearCache('pagelink.'.$key.'.tpl', $cacheKey);
		}
				
		return true;
	}
	
}