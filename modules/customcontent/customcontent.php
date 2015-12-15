<?php
/*
*  @author SonNC <nguyencaoson.zpt@gmail.com>
*/
class CustomContent extends Module
{
    const INSTALL_SQL_FILE = 'install.sql';
	protected static $tables = array(	'customcontent_module'=>'', 
										'customcontent_module_lang'=>'lang',  
										'customcontent_item'=>'', 
										'customcontent_item_lang'=>'lang',
										);
    public $arrLayout = array();
    public $arrCol = array();	
    public $pathImage = '';
    public $liveImage = '';
	public static $sameDatas = '';
	public $page_name = '';
	protected $arrPosition = array(
		'displayHome', 
		'displayTop', 
		'displayLeftColumn', 
		'displayRightColumn', 
		'displayFooter', 
		'displayNav', 
		'displayTopColumn', 		
		'displaySmartBlogLeft',
		'displaySmartBlogRight',
		'displayBottomContact',		
		'displayHomeBottomContent',
		'displayHomeBottomColumn',
		'displayBottomColumn',
		'displayCustomContent1',
		'displayCustomContent2',
		'displayCustomContent3',
		'displayCustomContent4',
		'displayCustomContent5',
	);	
	public function __construct()
	{
		$this->name = 'customcontent';		
		$this->arrLayout = array('default'=>$this->l('Default layout'), 'fsvs'=>$this->l('FSVS Slider'), 'owl-carousel'=>$this->l('Owl carousel'));
		$this->arrCol = array('0'=>$this->l('None column'), '1'=>$this->l('1 Column'),'2'=>$this->l('2 Columns'),'3'=>$this->l('3 Columns'),'4'=>$this->l('4 Columns'),'5'=>$this->l('5 Columns'),'6'=>$this->l('6 Columns'),'7'=>$this->l('7 Columns'),'8'=>$this->l('8 Columns'),'9'=>$this->l('9 Columns'),'10'=>$this->l('10 Columns'),'11'=>$this->l('11 Columns'),'12'=>$this->l('12 Columns'));
		$this->secure_key = Tools::encrypt($this->name);
        $this->pathImage = dirname(__FILE__).'/images/';
		self::$sameDatas = dirname(__FILE__).'/samedatas/';
		if(Configuration::get('PS_SSL_ENABLED'))
			$this->liveImage = _PS_BASE_URL_SSL_.__PS_BASE_URI__.'modules/customcontent/images/'; 
		else
			$this->liveImage = _PS_BASE_URL_.__PS_BASE_URI__.'modules/customcontent/images/';
		$this->tab = 'front_office_features';
		$this->version = '1.0';
		$this->author = 'OVIC-SOFT';		
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('Custom content module');
		$this->description = $this->l('Custom content module');
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
		if($this->arrPosition)
			foreach($this->arrPosition as $hook)
				if(!$this->registerHook($hook)) 
					return false;	
				

		if (!Configuration::updateGlobalValue('MOD_CUSTOM_CONTENT', '1')) return false;
		$this->importSameData();
		return true;
	}
	public  function importSameData($directory=''){
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
        if (!Configuration::deleteByName('MOD_CUSTOM_CONTENT')) return false;
		return true;
	}
	public function reset()
	{
		if (!$this->uninstall(true))
			return false;
		if (!$this->install(true))
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
        $items = Db::getInstance()->executeS("Select id From "._DB_PREFIX_."customcontent_item Where parent_id = ".$parentId);
        if($items){
            foreach($items as $item){
                $arr[] = $item['id'];
                $arr = $this->getSubMenuIds($item['id'], $arr);
            }
        }
        return $arr;
    }
    private function getIconSrc($image = '', $check = false){
    	$result = new stdClass();
        if($image){
        	if(strpos($image, '.') !== false){
        		$result->type='image';
	        	if(strpos($image, 'http') !== false){
	                $result->img = $image;
	            }else{
	                if($image && file_exists($this->pathImage.$image))
	                    $result->img = $this->liveImage.$image;
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
	private function getImageSrc($image = '', $check = false){
    	$result = new stdClass();
        if($image){
        	if(strpos($image, '.') !== false){
	        	if(strpos($image, 'http') !== false){
	                return $image;
	            }else{
	                if(file_exists($this->pathImage.$image))
	                    return $this->liveImage.$image;
	                else
						$result->img = '';	                       
	            }	
        	}else{
        		return $image;
        	}
        }else{
        	return '';
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
	private function getPositionOptions($selected=''){
		$options = '';		
		if($this->arrPosition){			
			foreach($this->arrPosition as $value){
				if($selected == $value) $options .='<option selected="selected" value="'.$value.'">'.$value.'</option>';
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
		$itemLang = Db::getInstance()->getRow("Select `name`, `before`, `after` From "._DB_PREFIX_."customcontent_module_lang Where module_id = $id AND `id_lang` = '$langId'" );
		if(!$itemLang) $itemLang = array('name'=>'', 'before'=>'', 'after'=>'');
		return $itemLang;
    }
	public function getItemByLang($id, $langId=0, $shopId=0){
		if(!$langId) $langId = Context::getContext()->language->id;
		$itemLang = Db::getInstance()->getRow("Select `name`, `link`, `content`, `before`, `after`   
			From "._DB_PREFIX_."customcontent_item_lang 
			Where item_id = $id AND `id_lang` = '$langId'" );
		if(!$itemLang) $itemLang = array('name'=>'', 'link'=>'', 'content'=>'', 'before'=>'', 'after'=>'');
		return $itemLang;
	}
	public function renderModuleForm($id=0){
		$langId = $this->context->language->id;
        $shopId = $this->context->shop->id;
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."customcontent_module Where id = $id AND `id_shop` = ".$shopId);		
		if(!$item) 
			$item = array(
							'id'			=>	0, 
							'id_shop'		=>	$shopId, 
							'position_name'	=>	'', 
							'display_name'	=>	1, 
							'layout'		=>	'', 
							'ordering'		=>	1, 
							'status'		=>	1, 
							'custom_class'	=>	'', 
							'background'	=>	'', 
						);
		$langActive = '<input type="hidden" id="moduleLangActive" value="0" />';
		$inputName = '';
		$befores = '';
		$afters = '';
		$languages = $this->getAllLanguage();
		if($languages){
			foreach ($languages as $key => $lang) {				
				$itemLang = $this->getModuleByLang($id, $lang->id);
				if($lang->active == '1'){
					$langActive = '<input type="hidden" id="moduleLangActive" value="'.$lang->id.'" />';
					$inputName 	.= '<input type="text" value="'.$itemLang['name'].'" name="names[]" id="module_name_'.$lang->id.'" class="form-control module-lang-'.$lang->id.'" />';
					$befores	.=	'<textarea name="befores[]" class="form-control module-lang-'.$lang->id.'" rows="3">'.$itemLang['before'].'</textarea>';
					$afters	.=	'<textarea name="afters[]" class="form-control module-lang-'.$lang->id.'" rows="3">'.$itemLang['after'].'</textarea>';	
				}else{
					$inputName 	.= '<input type="text" value="'.$itemLang['name'].'" name="names[]" id="module_name_'.$lang->id.'" class="form-control module-lang-'.$lang->id.'" style="display:none" />';
					$befores	.=	'<textarea name="befores[]" class="form-control module-lang-'.$lang->id.'" rows="3" style="display:none">'.$itemLang['before'].'</textarea>';
					$afters	.=	'<textarea name="afters[]" class="form-control module-lang-'.$lang->id.'" rows="3" style="display:none">'.$itemLang['after'].'</textarea>';					
				}				
			}
		}
		$langOptions = $this->getLangOptions();
		$html = '<input type="hidden" name="moduleId" value="'.$item['id'].'" />';
		$html .= $langActive;
		$html .= '<input type="hidden" name="action" value="saveModule" />';
		$html .= '<input type="hidden" name="secure_key" value="'.$this->secure_key.'" />';
		$html .= '<div class="form-group">
						<label class="control-label col-sm-2">'.$this->l('Name').'</label>
						<div class="col-sm-10">
							<div class="col-sm-10">'.$inputName.'</div>
							<div class="col-sm-2">
								<select class="module-lang" onchange="moduleChangeLanguage(this.value)">'.$langOptions.'</select>
							</div>
						</div>
					</div>';
		$html .= '<div class="form-group">
                    <label class="control-label col-sm-2">'.$this->l('Display name').'</label>
                    <div class="col-sm-10">
                        <div class="col-sm-5">
                            <span class="switch prestashop-switch fixed-width-lg" id="module-display-name">
                                <input type="radio" value="1" class="module_display_name" '.($item['display_name'] == 1 ? 'checked="checked"' : '').' id="module_display_name_on" name="module_display_name" />
            					<label for="module_display_name_on">Yes</label>
            				    <input type="radio" value="0" class="module_display_name" '.($item['display_name'] == 0 ? 'checked="checked"' : '').' id="module_display_name_off" name="module_display_name" />
            					<label for="module_display_name_off">No</label>
                                <a class="slide-button btn"></a>
            				</span>
                        </div>                        
                    </div>				    
                </div>';
		$html .= '<div class="form-group">
						<label class="control-label col-sm-2">'.$this->l('Position').'</label>
						<div class="col-sm-10">
							<div class="col-sm-5">
								<select  name="position_name">'.$this->getPositionOptions($item['position_name']).'</select>
							</div>
							<label class="control-label col-sm-2">'.$this->l('Layout').'</label>
							<div class="col-sm-5">
								<select class="form-control" name="moduleLayout">'.$this->getLayoutOptions($item['layout']).'</select>								
							</div>							
						</div>
					</div>';		
		$html .= '<div class="form-group">
						<label class="control-label col-sm-2">'.$this->l('Custom class').'</label>
						<div class="col-sm-10">
							<div class="col-sm-5">
								<input type="text" value="'.$item['custom_class'].'" name="custom_class"  class="form-control" />
							</div>
							<label class="control-label col-sm-2">'.$this->l('Background').'</label>
							<div class="col-sm-5">
								<div class="input-group">
									<input type="text" class="form-control" value="'.$item['background'].'" name="background" id="module-background" />
									<span class="input-group-btn">
										<button id="module-background-uploader" type="button" class="btn btn-default">
											<i class="icon-folder-open"></i>
										</button>
									</span>
								</div>
							</div>							
						</div>
					</div>';						
		$html .= '<div class="form-group">
                    <label class="control-label col-sm-2">'.$this->l('Before').'</label>
                    <div class="col-sm-10">
                        <div class="col-sm-10">'.$befores.'</div>
                        <div class="col-sm-2">
							<select class="module-lang" onchange="moduleChangeLanguage(this.value)">'.$langOptions.'</select>
						</div>                        
                    </div>				    
                </div>';
		$html .= '<div class="form-group">
                    <label class="control-label col-sm-2">'.$this->l('After').'</label>
                    <div class="col-sm-10">
                        <div class="col-sm-10">'.$afters.'</div> 
                        <div class="col-sm-2">
							<select class="module-lang" onchange="moduleChangeLanguage(this.value)">'.$langOptions.'</select>
						</div>                       
                    </div>				    
                </div>';
		return $html;
	}
	public function renderItemForm($id = 0){
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."customcontent_item Where id = $id");
				
		if(!$item) 
			$item = array(
				'id'			=>	0, 
				'module_id'		=>	0, 
				'parent_id'		=>	0, 
				'link_type'		=>	'CUSTOMLINK-0', 
				'product_id'	=>	0, 
				'custom_class'	=>	'', 
				'status'		=>	1, 
				'ordering'		=>	1, 
				'icon'			=>	'',
				'background'	=>	'',
				'width'			=>	4,
			);		
		$langActive = '<input type="hidden" id="itemLangActive" value="0" />';
		$languages = $this->getAllLanguage();
		$names = '';
		$links = '';
		$contents = '';
		$befores = '';
		$afters = '';		
		if($languages){
			foreach ($languages as $key => $language) {				
				$itemLang = $this->getItemByLang($id, $language->id);
				
				if($language->active == '1'){
					$langActive = '<input type="hidden" id="itemLangActive" value="'.$language->id.'" />';
					$names 		.= 	'<input type="text" value="'.$itemLang['name'].'" name="names[]"  class="form-control item-lang-'.$language->id.'" />';
					$links 		.= 	'<input type="text" value="'.$itemLang['link'].'" name="links[]"  class="form-control item-lang-'.$language->id.'" />';
					$contents 	.=	 '<div class="item-lang-'.$language->id.'"><textarea class="editor" name="contents[]" id="content-'.$language->id.'">'.$itemLang['content'].'</textarea></div>';
					$befores	.=	'<textarea name="befores[]" class="form-control item-lang-'.$language->id.'" rows="3">'.$itemLang['before'].'</textarea>';
					$afters		.=	'<textarea name="afters[]" class="form-control item-lang-'.$language->id.'" rows="3">'.$itemLang['after'].'</textarea>';
				}else{
					$names 		.= 	'<input type="text" value="'.$itemLang['name'].'" name="names[]"  class="form-control item-lang-'.$language->id.'" style="display:none" />';
					$links 		.= 	'<input type="text" value="'.$itemLang['link'].'" name="links[]"  class="form-control item-lang-'.$language->id.'" style="display:none" />';
					$contents 	.= 	'<div style="display:none" class="item-lang-'.$language->id.'"><textarea class="editor" name="contents[]" id="content-'.$language->id.'">'.$itemLang['content'].'</textarea></div>';
					$befores	.=	'<textarea name="befores[]" class="form-control item-lang-'.$language->id.'" rows="3" style="display:none">'.$itemLang['before'].'</textarea>';
					$afters		.=	'<textarea name="afters[]" class="form-control item-lang-'.$language->id.'" rows="3" style="display:none">'.$itemLang['after'].'</textarea>';
				}				
			}
		}
		$langOptions = $this->getLangOptions();
		$html = '';
		$html .= '<input type="hidden" name="itemId" value="'.$item['id'].'" />';		
		$html .= $langActive;
		$html .= '<input type="hidden" name="action" value="saveItem" />';	
		$html .= '<input type="hidden" name="secure_key" value="'.$this->secure_key.'" />';
		$html .= '<div class="form-group">
                    <label class="control-label col-sm-2">'.$this->l('Title').'</label>
				    <div class="col-sm-10">
                        <div class="col-sm-10">'.$names.'</div>
                        <div class="col-sm-2">
                            <select class="menu-item-lang" onchange="itemChangeLanguage(this.value)">'.$langOptions.'</select>
                        </div>                                                                        
                    </div>
                </div> ';
		$html .= '<div class="form-group">
                    <label class="control-label col-sm-2">'.$this->l('Avatar').'</label>
				    <div class="col-sm-10">
                        <div class="col-sm-5">
                        	<div class="input-group">
								<input type="text" class="form-control" value="'.$item['icon'].'" name="icon" id="item-icon" />
								<span class="input-group-btn">
									<button id="item-icon-uploader" type="button" class="btn btn-default">
										<i class="icon-folder-open"></i>
									</button>
								</span>
							</div>
                        </div>
                        <label class="control-label col-sm-2">'.$this->l('Background').'</label>						
						<div class="col-sm-5">
                        	<div class="input-group">
								<input type="text" class="form-control" value="'.$item['background'].'" name="background" id="item-background" />
								<span class="input-group-btn">
									<button id="item-background-uploader" type="button" class="btn btn-default">
										<i class="icon-folder-open"></i>
									</button>
								</span>
							</div>
                        </div>
                    </div>
                </div> ';
		$html .= '<div class="form-group clearfix">
			                    <label class="control-label col-sm-2">'.$this->l('Width').'</label>
			                    <div class="col-sm-10">
			                        <div class="col-sm-5">                        
			                            <select name="width" id="group-width" class="form-control">'.$this->getColumnOptions($item['width']).'</select>                       
			                        </div>
			                        <label class="control-label col-sm-2">'.$this->l('Custom class').'</label>
			                        <div class="col-sm-5">                        
			                            <input type="text" value="'.$item['custom_class'].'" name="custom_class"  class="form-control" />                        
			                        </div>
			                    </div>  
			                </div>';
		$html .= '<div class="form-group">
                    <label class="control-label col-sm-2">'.$this->l('Select Link').'</label>
                    <div class="col-sm-10">                        
						<div class="col-sm-5">
                            <select name="link_type" class="form-control" onchange="changeLinkType(this.value)">'.$this->getAllLinkOptions($item['link_type']).'</select>
                        </div>                        
                    </div>				    
                </div>';
		
		$html .= '<div class="item-link-type item-link-type-custom" style="display:'.($item['link_type'] == 'CUSTOMLINK-0' ? 'block' : 'none').'">
                  	<div class="form-group clearfix">
	                    <label class="control-label col-sm-2">'.$this->l('Url').'</label>
	                    <div class="col-sm-10">
	                        <div class="col-sm-10">'.$links.'</div>
	                        <div class="col-sm-2">
	                            <select class="menu-item-lang" onchange="itemChangeLanguage(this.value)">'.$langOptions.'</select>
	                        </div>
	                    </div>  
	                </div>
                </div>';
		$html .= '<div class="item-link-type item-link-type-product" style="display:'.($item['link_type'] == 'PRODUCT-0' ? 'block' : 'none').'">
                  	<div class="form-group clearfix">
	                    <label class="control-label col-sm-2">'.$this->l('Product Id').'</label>
	                    <div class="col-sm-10">
	                        <div class="col-sm-7">                        
	                            <input name="product_id" type="text" id="item-product-id" value="'.$item['product_id'].'" class="form-control" />                   
	                        </div>
	                    </div>  
	                </div>
                </div>';
		$html .= '	<div class="form-group">
						<label class="control-label col-sm-2">'.$this->l('Content').'</label>
						<div class="col-sm-10">
							<div class="col-sm-10">'.$contents.'</div>
							<div class="col-sm-2">
								<select class="module-lang" onchange="itemChangeLanguage(this.value)">'.$langOptions.'</select>
							</div>
						</div>
					</div>';
		$html .= '<div class="form-group">
                    <label class="control-label col-sm-2">'.$this->l('Before').'</label>
                    <div class="col-sm-10">
                        <div class="col-sm-10">'.$befores.'</div>
                        <div class="col-sm-2">
							<select class="module-lang" onchange="moduleChangeLanguage(this.value)">'.$langOptions.'</select>
						</div>                        
                    </div>				    
                </div>';
		$html .= '<div class="form-group">
                    <label class="control-label col-sm-2">'.$this->l('After').'</label>
                    <div class="col-sm-10">
                        <div class="col-sm-10">'.$afters.'</div> 
                        <div class="col-sm-2">
							<select class="module-lang" onchange="moduleChangeLanguage(this.value)">'.$langOptions.'</select>
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
		// if($this->arrPosition)
			// foreach($this->arrPosition as $hook)
				// $this->registerHook($hook); 

		$action = Tools::getValue('action', 'view');
		if($action == 'view'){
			$this->context->controller->addJquery();
            $this->context->controller->addJQueryUI('ui.sortable');            
			$this->context->controller->addJS(array(
				$this->_path.'js/admin/common.js',
				$this->_path.'js/admin/ajaxupload.3.5.js',
				$this->_path.'js/admin/tinymce.inc.js',
				$this->_path.'js/admin/jquery.serialize-object.min.js',
				__PS_BASE_URI__.'js/tiny_mce/tinymce.min.js',
				__PS_BASE_URI__.'js/jquery/plugins/jquery.tablednd.js',
			));                	        	
	        $this->context->controller->addCSS(($this->_path).'css/admin/style.css');	        
	        $langId = $this->context->language->id;
	        $shopId = $this->context->shop->id;
	        $items = Db::getInstance()->executeS("Select m.*, ml.name 
	        	From "._DB_PREFIX_."customcontent_module AS m 
	        	Left Join "._DB_PREFIX_."customcontent_module_lang AS ml On ml.module_id = m.id 
	        	Where m.id_shop = '".$shopId."' AND ml.id_lang = ".$langId." 
	        	Order By m.ordering");
					
	        $listModule = '';
	        if($items){
	            foreach($items as &$item){	            	
	            	$item['layout_value'] = $this->arrLayout[$item['layout']];               
	            }
	        }                 
	        $this->context->smarty->assign(array(
	            'baseModuleUrl'	=> __PS_BASE_URI__.'modules/'.$this->name,
	            'currentUrl'	=> $this->getCurrentUrl(),
	            'moduleId'		=>$this->id,
	            'iso'			=>	$this->context->language->iso_code,
	            'ad'			=>	$ad = dirname($_SERVER["PHP_SELF"]),
	            'langId'		=>$langId,	            
	            'secure_key'	=>$this->secure_key,
	            'moduleForm' 	=> $this->renderModuleForm(),
	            'itemForm' 		=> $this->renderItemForm(),
				'items'			=>$items,
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
						$return.= ");\r\n";
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
						$return.= ");\r\n";
					}
				}					
			}
			$return.="\r\n";
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
		$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
		$names = Tools::getValue('names', array());
		$befores = Tools::getValue('befores', array());
		$afters = Tools::getValue('afters', array());
        $layout = Tools::getValue('moduleLayout', 'default');        
        $display_name = Tools::getValue('module_display_name', 1);
		$background = Tools::getValue('background', '');
        $custom_class = Tools::getValue('custom_class', '');
		$width = Tools::getValue('width', 0);		
		$position_name = Tools::getValue('position_name', '');
        if($itemId == 0){        	
			$maxOrdering = $db->getValue("Select MAX(ordering) From "._DB_PREFIX_."customcontent_module");
		   	if($maxOrdering >0) $maxOrdering++;
		   	else $maxOrdering = 1;
			$arrInsert = array(
				'id_shop'	=>	$shopId,
				'position_name'	=>	$position_name,
				'display_name'	=>	$display_name,
				'layout'		=>	$layout,
				'ordering'		=>	$maxOrdering,
				'status'		=>	1,
				'custom_class'	=>	$custom_class,
				'background'	=>	'',				
			);
			if($background){
				if(strpos($background, 'http') !== false){
					$arrInsert['background'] = $background;
				}else{
					if(file_exists($this->pathImage.'temps/'.$background)){
						if(copy($this->pathImage.'temps/'.$background, $this->pathImage.$background)){
							$arrInsert['background'] = $background;
						}
						unlink($this->pathImage.'temps/'.$background);
					}		
				}	
			}			
            if($db->insert('customcontent_module', $arrInsert)){
                $insertId = $db->Insert_ID();
				$nameDefault = ''; 
				$beforeDefault = '';
				$afterDefault = '';  
				if($languages){
                	$arrInserts = array();
                	foreach($languages as $index=>$language){
                		
                		$name = $db->escape($names[$index]);
						if(!$nameDefault) $nameDefault = $name;
						else 
							if(!$name) $name = $nameDefault;
						
						$before = $db->escape($befores[$index], true);
						if(!$beforeDefault) $beforeDefault = $before;
						else 
							if(!$before) $before = $beforeDefault;
						
						$after = $db->escape($afters[$index], true);
						if(!$afterDefault) $afterDefault = $after;
						else 
							if(!$after) $after = $afterDefault;
						
						$arrInserts[] = array('module_id'=>$insertId, 'id_lang'=>$language->id, 'name'=>$name, 'before'=>$before, 'after'=>$after);                   		                
                	}
					if($arrInserts) $db->insert('customcontent_module_lang', $arrInserts);
                }                
                $response->status = '1';
                $response->msg = $this->l('Add new group Success!');  
				Tools::clearCache();
            }else{
                $response->status = '0';
                $response->msg = $this->l('Add new group not Success!');
            }
        }else{
            $item = $db->getRow("Select * From "._DB_PREFIX_."customcontent_module Where id = ".$itemId);
			$arrUpdate = array(
				'position_name'	=>	$position_name,
				'display_name'	=>	$display_name,
				'layout'		=>	$layout,
				'custom_class'	=>	$custom_class,
				'background'	=>	$item['background'],				
			);
			if($background){				
				if(strpos($background, 'http') !== false){
					$arrUpdate['background'] = $background;
					if($item['background'] && file_exists($this->pathImage.$item['background'])) unlink($this->pathImage.$item['background']);
				}else{
					if(file_exists($this->pathImage.'temps/'.$background)){
						if(copy($this->pathImage.'temps/'.$background, $this->pathImage.$background)){
							$arrUpdate['background'] = $background;
							if($item['background'] && file_exists($this->pathImage.$item['background'])) unlink($this->pathImage.$item['background']);
						}
						unlink($this->pathImage.'temps/'.$background);
					}	
				}	
			}else{
				$arrUpdate['background'] = '';
				if($item['background'] && file_exists($this->pathImage.$item['background'])) unlink($this->pathImage.$item['background']);
			}
			$db->update('customcontent_module', $arrUpdate, "`id`='$itemId'");            			
			if($languages){
				
				$arrInserts = array();
				$nameDefault = '';
				$beforeDefault = '';     
				$afterDefault = '';       	
            	foreach($languages as $index=>$language){
            		$check = $db->getValue("Select module_id From "._DB_PREFIX_."customcontent_module_lang Where module_id = $itemId AND id_lang = ".$language->id);
					
					$name = $db->escape($names[$index]);
					if(!$nameDefault) $nameDefault = $name;
					else
						if(!$name) $name = $nameDefault;
					
					$before = $db->escape($befores[$index], true);
					if(!$beforeDefault) $beforeDefault = $before;
					else 
						if(!$before) $before = $beforeDefault;
					
					$after = $db->escape($afters[$index], true);
					if(!$afterDefault) $afterDefault = $after;
					else 
						if(!$after) $after = $afterDefault;
										
            		if($check){
            			$db->update('customcontent_module_lang', array('name'=>$name, 'before'=>$before, 'after'=>$after), "`module_id`='$itemId' AND `id_lang`='".$language->id."'");	
            		}else{
            			$arrInserts[] = array('module_id'=>$itemId, 'id_lang'=>$language->id, 'name'=>$name, 'before'=>$before, 'after'=>$after);
            		}
            	}
            	if($arrInserts) $db->insert('customcontent_module_lang', $arrInserts);
            }            
            $response->status = '1';
            $response->msg = $this->l('Update Module Success!');
			Tools::clearCache();
        }
        die(Tools::jsonEncode($response));
    }
	public function saveItem(){
		$languages = $this->getAllLanguage();
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
		$moduleId = intval($_POST['moduleId']);
		//$parentId = intval($_POST['parent_id']);		
        $itemId = intval($_POST['itemId']);        
		$names = Tools::getValue('names', array());
		$links = Tools::getValue('links', array());
		$befores = Tools::getValue('befores', array());
		$afters = Tools::getValue('afters', array());
		$contents = Tools::getValue('contents', array());		
		$custom_class = Tools::getValue('custom_class', '');
		$link_type = Tools::getValue('link_type', 'CUSTOMLINK-0');
		$product_id = Tools::getValue('product_id', 0);
		$width = Tools::getValue('width', 3);
		$icon = Tools::getValue('icon', '');
		$background = Tools::getValue('background', '');		
		$response = new stdClass();
		
        if($moduleId >0){            
            if($itemId == 0){            	
				$maxOrdering = $db->getValue("Select MAX(ordering) From "._DB_PREFIX_."customcontent_item Where `module_id` = ".$moduleId);
		   		if($maxOrdering >0) $maxOrdering++;
		   		else $maxOrdering = 1;
				$arrInsert = array(
					'module_id'		=>	$moduleId,
					'link_type'		=>	$link_type,
					'product_id'		=>	$product_id,
					'custom_class'		=>	$custom_class,
					'status'		=>	1,
					'ordering'		=>	$maxOrdering,
					'icon'			=>	'',
					'background'	=>	'',
					'width'			=>	$width,
				);	
				
				if($icon){					
					if(strpos($icon, '.') === false){
						$arrInsert['icon'] = $icon;
					}else{
						if(strpos($icon, 'http') !== false){
							$arrInsert['icon'] = $icon;
						}else{
							if(file_exists($this->pathImage.'temps/'.$icon)){
								if(copy($this->pathImage.'temps/'.$icon, $this->pathImage.$icon)){
									$arrInsert['icon'] = $icon;
								}
								unlink($this->pathImage.'temps/'.$icon);
							}		
						}	
					}
				}
				if($background){
					if(strpos($background, 'http') !== false){
						$arrInsert['background'] = $background;
					}else{
						if(file_exists($this->pathImage.'temps/'.$background)){
							if(copy($this->pathImage.'temps/'.$background, $this->pathImage.$background)){
								$arrInsert['background'] = $background;
							}
							unlink($this->pathImage.'temps/'.$background);
						}		
					}	
				}	
                if($db->insert('customcontent_item', $arrInsert)){
                    $insertId = $db->Insert_ID();
                    $nameDefault = '';
					$beforeDefault = '';
					$afterDefault = '';
					$linkDeafult = '';
					$contentDefault = '';
					if($languages){
	                	$insertDatas = array();
	                	foreach($languages as $index=>$language){
	                		$name = $db->escape($names[$index]);
							if(!$nameDefault) $nameDefault = $name;
							else
								if(!$name) $name = $nameDefault;
							
							$link = $db->escape($links[$index]);
							if(!$linkDeafult) $linkDeafult = $link;
							else
								if(!$link) $link = $linkDeafult;
							
							$before = $db->escape($befores[$index], true);
							if(!$beforeDefault) $beforeDefault = $before;
							else
								if(!$before) $before = $beforeDefault;
							
							$after = $db->escape($afters[$index], true);
							if(!$afterDefault) $afterDefault = $after;
							else
								if(!$after) $after = $afterDefault;
							
							$content = $db->escape($contents[$index], true);
							if(!$contentDefault) $contentDefault = $content;
							else
								if(!$content) $content = $contentDefault;
								                		
			                $insertDatas[] = array(
			                	'item_id'=>$insertId, 
			                	'id_lang'=>$language->id, 
			                	'name'=>$name, 
			                	'link'=>$link,
			                	'before'=>$before,
			                	'after'=>$after,
			                	'content'=>$content,
								) ;			                
	                	}
						if($insertDatas) $db->insert('customcontent_item_lang', $insertDatas);
	                }                    
                    $response->status = '1';
                    $response->msg = $this->l("Add new item Success!");
					Tools::clearCache();
                }else{
                    $response->status = '0';
                    $response->msg = $this->l("Add new item not Success!");
                }
            }else{
                $item = $db->getRow("Select * From "._DB_PREFIX_."customcontent_item Where id = ".$itemId);
				$arrUpdate = array(
					'link_type'		=>	$link_type,
					'product_id'	=>	$product_id,
					'custom_class'	=>	$custom_class,
					'icon'			=>	$item['icon'],
					'background'	=>	$item['background'],
					'width'			=>	$width,
				);
				if($icon){
					if(strpos($icon, '.') === false){
						$arrUpdate['icon'] = $icon;
					}else{
						if(strpos($icon, 'http') !== false){
							$arrUpdate['icon'] = $icon;
							if($item['icon'] && file_exists($this->pathImage.$item['icon'])) unlink($this->pathImage.$item['icon']);
						}else{
							if(file_exists($this->pathImage.'temps/'.$icon)){
								if(copy($this->pathImage.'temps/'.$icon, $this->pathImage.$icon)){
									$arrUpdate['icon'] = $icon;
									if($item['icon'] && file_exists($this->pathImage.$item['icon'])) unlink($this->pathImage.$item['icon']);
								}
								unlink($this->pathImage.'temps/'.$icon);
							}	
						}	
					}			
				}else{
					$arrUpdate['icon'] = '';
					if($item['icon'] && file_exists($this->pathImage.$item['icon'])) unlink($this->pathImage.$item['icon']);
				}
				if($background){				
					if(strpos($background, 'http') !== false){
						$arrUpdate['background'] = $background;
						if($item['background'] && file_exists($this->pathImage.$item['background'])) unlink($this->pathImage.$item['background']);
					}else{
						if(file_exists($this->pathImage.'temps/'.$background)){
							if(copy($this->pathImage.'temps/'.$background, $this->pathImage.$background)){
								$arrUpdate['background'] = $background;
								if($item['background'] && file_exists($this->pathImage.$item['background'])) unlink($this->pathImage.$item['background']);
							}
							unlink($this->pathImage.'temps/'.$background);
						}	
					}	
				}else{
					$arrUpdate['background'] = '';
					if($item['background'] && file_exists($this->pathImage.$item['background'])) unlink($this->pathImage.$item['background']);
				}				
				$db->update('customcontent_item', $arrUpdate, "`id`='$itemId'");
				if($languages){
					$nameDefault = '';
					$beforeDefault = '';
					$afterDefault = '';
					$linkDeafult = '';
					$contentDefault = '';
					$insertDatas = array();
                	foreach($languages as $index=>$language){
                		$name = $db->escape($names[$index]);
						if(!$nameDefault) $nameDefault = $name;
						else
							if(!$name) $name = $nameDefault;
						
						$link = $db->escape($links[$index]);
						if(!$linkDeafult) $linkDeafult = $link;
						else
							if(!$link) $link = $linkDeafult;
						
						$before = $db->escape($befores[$index], true);
						if(!$beforeDefault) $beforeDefault = $before;
						else
							if(!$before) $before = $beforeDefault;
						
						$after = $db->escape($afters[$index], true);
						if(!$afterDefault) $afterDefault = $after;
						else
							if(!$after) $after = $afterDefault;
						
						$content = $db->escape($contents[$index], true);
						if(!$contentDefault) $contentDefault = $content;
						else
							if(!$content) $content = $contentDefault;
						
						$check = $db->getRow("Select * From "._DB_PREFIX_."customcontent_item_lang Where item_id = ".$itemId." AND `id_lang` = ".$language->id);	                		                		
	                	if($check){
	                		$db->update('customcontent_item_lang', array('name'=>$name, 'link'=>$link, 'content'=>$content, 'before'=>$before, 'after'=>$after), " `item_id` = $itemId AND `id_lang` = ".$language->id);	
	                    }else{
	                    	$insertDatas[] = array('item_id'=>$itemId, 'id_lang'=>$language->id, 'name'=>$name, 'link'=>$link, 'content'=>$content, 'before'=>$before, 'after'=>$after) ;
	                    }
						if($insertDatas) $db->insert('customcontent_item_lang', $insertDatas);
                	}
                }
				$response->status = 1;
            	$response->msg = $this->l("Update item success!");
				Tools::clearCache();
            }
        }else{
            $response->status = '0';
            $response->msg = $this->l('Group not found');
        }
        die(Tools::jsonEncode($response));
    }
	public function changModuleStatus(){
		$itemId = intval($_POST['itemId']);
		$value = intval($_POST['value']);		
		$response = new stdClass();
		if($value == '1'){
			Db::getInstance()->execute("Update "._DB_PREFIX_."customcontent_module Set `status` = 0 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}else{
			Db::getInstance()->execute("Update "._DB_PREFIX_."customcontent_module Set `status` = 1 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}
		die(Tools::jsonEncode($response));
	}	
	public function changeItemStatus(){
		$itemId = intval($_POST['itemId']);
		$value = intval($_POST['value']);		
		$response = new stdClass();
		if($value == '1'){
			Db::getInstance()->execute("Update "._DB_PREFIX_."customcontent_item Set `status` = 0 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}else{
			Db::getInstance()->execute("Update "._DB_PREFIX_."customcontent_item Set `status` = 1 Where id = ".$itemId);
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
	public function getItem(){		
        $response = new stdClass();
        $itemId = intval($_POST['itemId']);	
        if($itemId){
        	$response->form = $this->renderItemForm($itemId);
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
        if(Db::getInstance()->execute("Delete From "._DB_PREFIX_."customcontent_module Where id = ".$itemId)){
            Db::getInstance()->execute("Delete From "._DB_PREFIX_."customcontent_module_lang Where module_id = ".$itemId);		
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."customcontent_item_lang Where item_id IN (Select id From "._DB_PREFIX_."customcontent_item Where module_id = $itemId)");
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."customcontent_item Where module_id = ".$itemId);						
            $response->status = '1';
            $response->msg = $this->l('Delete Module Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Delete Module not Success!');
        }
        die(Tools::jsonEncode($response));
	}
	public function deleteItem(){
		$itemId = Tools::getValue('itemId', 0);
        $response = new stdClass();		
		if($itemId){			
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."customcontent_item Where id = '$itemId'");
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."customcontent_item_lang Where item_id = '$itemId'");			
		}else{
            $response->status = '0';
            $response->msg = $this->l('Delete item not Success!');
        }
        die(Tools::jsonEncode($response));
	}
	public function updateModuleOrdering(){
        $response = new stdClass();
        $ids = $_POST['ids'];        
        if($ids){            
            foreach($ids as $i=>$id){
                Db::getInstance()->query("Update "._DB_PREFIX_."customcontent_module Set ordering=".(1 + $i)." Where id = ".$id);                
            }
            $response->status = '1';
            $response->msg = $this->l('Update Module Ordering Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Update Module Ordering not Success!');
        }
        die(Tools::jsonEncode($response));
	}
	public function updateItemOrdering(){
        $response = new stdClass();
        $ids = $_POST['ids'];
        if($ids){
        	foreach($ids as $index=>$id){
        		Db::getInstance()->execute("Update "._DB_PREFIX_."customcontent_item Set `ordering` = '".(1 + $index)."' Where id = ".$id);
        	}			
            $response->status = '1';
            $response->msg = $this->l('Update Item Ordering Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Update Item Ordering not Success!');
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
		$moduleId = Tools::getValue('moduleId');
		$response = new stdClass();
		$html = '';
		if($moduleId >0){
			$items = Db::getInstance()->executeS("Select r.*, rl.name 
				From "._DB_PREFIX_."customcontent_item AS r 
				Left Join "._DB_PREFIX_."customcontent_item_lang AS rl On rl.item_id = r.id 
				Where r.module_id = $moduleId AND rl.id_lang=$langId Order By r.ordering");				
			if($items){				
				foreach($items as $item){                                       
                    if($item['status'] == "1"){
                        $status = '<a class="list-action-enable action-enabled lik-item-status" item-id="'.$item['id'].'" value="'.$item['status'].'"><i class="icon-check"></i></a>';
                    }else{
                        $status = '<a class="list-action-enable action-disabled lik-item-status" item-id="'.$item['id'].'" value="'.$item['status'].'"><i class="icon-check"></i></a>';
                    }
                    $html .= '<tr id="it_'.$item['id'].'">
                                                <td>'.$item['id'].'</td>
                                                <td>'.$item['name'].'</td>
                                                <td class="pointer dragHandle center" ><div class="dragGroup"><div class="positions">'.$item['ordering'].'</div></div></td>
                                                <td class="center">'.$status.'</td>
                                                <td class="center">
                                                    <a href="javascript:void(0)" item-id="'.$item['id'].'" class="lik-item-edit"><i class="icon-edit"></i></a>&nbsp;
                                                    <a href="javascript:void(0)" item-id="'.$item['id'].'" class="lik-item-delete"><i class="icon-trash" ></i></a>
                                                </td>
                                            </tr>';
                }
			}
		}
		die(Tools::jsonEncode($html));
	}	
    public function hookdisplayHeader()
	{
		
		$this->context->controller->addCSS(($this->_path).'css/front-end/style.css');
        $this->context->controller->addJS(array(
			$this->_path.'js/hook/common.js',
			$this->_path.'js/hook/fsvs.js',
		));
	}
	public function hookdisplayTop($params){
		return $this->hooks('hookdisplayTop', $params);		
	}
	public function hookdisplayLeftColumn($params){
		return $this->hooks('hookdisplayLeftColumn', $params);		
	}
	public function hookdisplayRightColumn($params){
		return $this->hooks('hookdisplayRightColumn', $params);		
	}

	public function hookdisplayFooterp($params){
		return $this->hooks('hookdisplayFooter', $params);		
	}
	
	public function hookdisplayNav($params){
		return $this->hooks('hookdisplayNav', $params);		
	}
	public function hookdisplayTopColumn($params){
		return $this->hooks('hookdisplayTopColumn', $params);		
	}
	public function hookdisplaySmartBlogLeft($params){
		return $this->hooks('hookdisplaySmartBlogLeft', $params);		
	}
	public function hookdisplaySmartBlogRight($params){
		return $this->hooks('hookdisplaySmartBlogRight', $params);		
	}
	public function hookdisplayBottomContact($params){
		return $this->hooks('hookdisplayBottomContact', $params);		
	}
	public function hookdisplayHome($params){
		return $this->hooks('hookdisplayHome', $params);		
	}
	public function hookdisplayHomeBottomContent($params){
		return $this->hooks('hookdisplayHomeBottomContent', $params);		
	}
	public function hookdisplayHomeBottomColumn($params){
		return $this->hooks('hookdisplayHomeBottomColumn', $params);		
	}
	public function hookdisplayBottomColumn($params){
		return $this->hooks('hookdisplayBottomColumn', $params);		
	}
	public function hookdisplayCustomContent1($params){
		return $this->hooks('hookdisplayCustomContent1', $params);		
	}
	public function hookdisplayCustomContent2($params){
		return $this->hooks('hookdisplayCustomContent2', $params);		
	}
	public function hookdisplayCustomContent3($params){
		return $this->hooks('hookdisplayCustomContent3', $params);		
	}
	public function hookdisplayCustomContent4($params){
		return $this->hooks('hookdisplayCustomContent4', $params);		
	}
	public function hookdisplayCustomContent5($params){
		return $this->hooks('hookdisplayCustomContent5', $params);		
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
		$cacheKey = 'customcontent|'.$hookName.'|'.$langId.'|'.$shopId.'|'.$page_name;
		$items = Db::getInstance()->executeS("Select DISTINCT m.*, ml.`name`, ml.`before`, ml.`after`  
        	From "._DB_PREFIX_."customcontent_module AS m 
        	INNER JOIN "._DB_PREFIX_."customcontent_module_lang AS ml On m.id = ml.module_id  	        	 
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
            	$modules[] = array(
            		'name'=>$item['name'],
            		'content'=>$this->frontGetModuleContents($item, $cacheKey.'|'.$item['id']),
				);
            }
			
            $this->context->smarty->assign('customcontent_modules', $modules);
        }else return ''; 		
        return $this->display(__FILE__, 'customcontent.tpl');
    }
	function frontGetModuleContents($module, $cacheKey=''){
		//if (!$this->isCached('customcontent.'.$module['layout'].'.tpl', Tools::encrypt($cacheKey))){
			$contents = array();
			$langId = $this->context->language->id;
		    $shopId = $this->context->shop->id;
			$items = Db::getInstance()->executeS("Select r.*, rl.`name`, rl.`link`, rl.`content`, rl.`before`, rl.`after`   
				From "._DB_PREFIX_."customcontent_item AS r 
				Inner Join "._DB_PREFIX_."customcontent_item_lang AS rl On r.id = rl.item_id 
				Where r.module_id = ".$module['id']." AND r.status = 1 AND rl.id_lang = ".$langId." Order By r.ordering");
			if($items){
				foreach($items as &$item){
					$icon = $this->getIconSrc($item['icon'], true);					
					$item['icon_type'] = $icon->type;
					$item['full_path'] = $icon->img;
					$item['background'] = $this->getImageSrc($item['background'], true);
					$item['link'] = $this->frontGenerationUrl($item['link_type'], $item['link']);
					if($item['link_type'] == 'PRODUCT-0'){
						$item['link'] = $this->frontGenerationUrl('PRD-'.$item['product_id'], $item['link']);								
					}else{
						$item['link'] = $this->frontGenerationUrl($item['link_type'], $item['link']);
					}
				}
			}	
			$this->context->smarty->assign(array(			 
				'module_display_name'=>$module['display_name'],			
				'module_custom_class'=>$module['custom_class'],
				'module_name'=>$module['name'],
				'module_background'=>$this->getImageSrc($module['background']),
				'module_before'=>$module['before'],			
				'module_after'=>$module['after'],
				'module_items'=>$items			
			));				
		//}
		return $this->display(__FILE__, 'customcontent.'.$module['layout'].'.tpl', Tools::encrypt($cacheKey));
    }
	function s_print($content){
		echo "<pre>";
		print_r($content);
		echo "</pre>";
		die;
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