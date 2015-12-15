<?php
/*
*  @author SonNC <nguyencaoson.zpt@gmail.com>
*/
class MegaMenus extends Module
{
    const INSTALL_SQL_FILE = 'install.sql';
    protected static $tables = array(
		'megamenus_module'			=>	'module', 
		'megamenus_module_lang'		=>	'lang', 
		'megamenus_module_position'	=>	'position', 
		'megamenus_menu'			=>	'', 
		'megamenus_menu_lang'		=>	'lang', 
		'megamenus_row'				=>	'', 
		'megamenus_row_lang'		=>	'lang', 
		'megamenus_menuitem'		=>	'', 
		'megamenus_menuitem_lang'	=>	'lang', 
		'megamenus_group'			=>	'', 
		'megamenus_group_lang'		=>	'lang',
	);
    public $arrHook = array();
    public $arrLayout = array();
    public $arrMenuType = array();
    public $arrGroupType = array();
    public $arrProductOrderBy = array();
	public $arrProductOrderWay = array();
	public $arrProductOnCondition = array();
	public $arrProductOnSale = array();
	public $arrProductOnNew = array();
	public $arrProductOnDiscount = array();
	public $arrProductType = array();
	public $arrCol = array();	
    public $pathImage = '';
    public $liveImage = '';
	public $datas = '';
	protected static $productCache = array();
	protected static $langsCache = array();
	protected $cache_time = 86400;		
	public function __construct()
	{
		$this->name = 'megamenus';
		$this->arrHook = array(
			'displayVerticalMenu', 
			'displayHorizontalMenu', 
			'displayLeftColumn',
			'displayTopColumn',
			'displayMegamenuLeft',
			'displayMegamenuRight',
		);
		$this->arrLayout = array(
			'vertical_left'		=>	$this->l('Vertical Left'), 
			'horizontal_top'	=>	$this->l('Horizontal Top'),
		);
		$this->arrMenuType = array(
        	'link'		=>	$this->l('Link'), 
        	'image'		=>	$this->l('Image'), 
        	'html'		=>	$this->l('Custom HTML'), 
        	'module'	=>	$this->l('Module'),
		);
        $this->arrGroupType = array(
        	'link'		=>	$this->l('Link'), 
        	'product'	=>	$this->l('Product'), 
        	'module'	=>	$this->l('Module'),
		);
		$this->arrProductOrderBy = array(
			'seller'	=>	$this->l('Seller'), 
			'price'		=>	$this->l('Price'), 
			'discount'	=>	$this->l('Discount'), 
			'date_add'	=>	$this->l('Add Date'), 
			'position'	=>	$this->l('Position'), 
			'review'	=>	$this->l('Review'),  
			'rate'		=>	$this->l('Rates'),
		);
        $this->arrProductOrderWay = array(
        	'asc'	=>	$this->l('Ascending'), 
        	'desc'	=>	$this->l('Descending'),
		);
        $this->arrProductOnCondition = array(
        	'all'			=>	$this->l('All'), 
        	'new'			=>	$this->l('New'), 
        	'used'			=>	$this->l('Used'), 
        	'refurbished'	=>	$this->l('Refurbished'),
		);
		$this->arrProductOnSale = array(
			'2'	=>	$this->l('All'), 
			'0'	=>	$this->l('No'), 
			'1'	=>	$this->l('Yes'),
		);
		$this->arrProductOnNew = array(
			'2'	=>	$this->l('All'), 
			'0'	=>	$this->l('No'), 
			'1'	=>	$this->l('Yes'),
		);
		$this->arrProductOnDiscount = array(
			'2'	=>	$this->l('All'), 
			'0'	=>	$this->l('No'), 
			'1'	=>	$this->l('Yes'),
		);
        $this->arrProductType = array(
        	'auto'		=>	$this->l('Auto'), 
        	'manual'	=>	$this->l('Manual'),
		);
        $this->arrCol = array(
        	'0'		=>	$this->l('None'),
        	'1'		=>	$this->l('Col 1'),
        	'2'		=>	$this->l('Col 2'),
        	'3'		=>	$this->l('Col 3'),
        	'4'		=>	$this->l('Col 4'),
        	'5'		=>	$this->l('Col 5'),
        	'6'		=>	$this->l('Col 6'),
        	'7'		=>	$this->l('Col 7'),
        	'8'		=>	$this->l('Col 8'),
        	'9'		=>	$this->l('Col 9'),
        	'10'	=>	$this->l('Col 10'),
        	'11'	=>	$this->l('Col 11'),
        	'12'	=>	$this->l('Col 12'),
		);
		$this->secure_key = Tools::encrypt($this->name);
        $this->pathImage = dirname(__FILE__).'/images/';
        if(Tools::usingSecureMode())
			$this->liveImage = _PS_BASE_URL_SSL_.__PS_BASE_URI__.'modules/'.$this->name.'/images/'; 
		else
			$this->liveImage = _PS_BASE_URL_.__PS_BASE_URI__.'modules/'.$this->name.'/images/';
		$this->tab = 'front_office_features';
		$this->version = '2.0';
		$this->author = 'OVIC-SOFT';		
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('Mega menus Module');
		$this->description = $this->l('Mega menus Module');
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		$this->datas = dirname(__FILE__).'/datas/';
	}
    /*	
    public function  __call($method, $args){        
        if(!method_exists($this, $method)) {			
            return $this->hooks($method, $args);
        }
    }	
    */
	public function install($keep = true){
	   if ($keep){
			if (!file_exists(dirname(__FILE__).'/'.self::INSTALL_SQL_FILE))
				return false;
			else if (!$sql = file_get_contents(dirname(__FILE__).'/'.self::INSTALL_SQL_FILE))
				return false;
			$sql = str_replace(array('PREFIX_', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $sql);
			$sql = preg_split("/;\s*[\r\n]+/", trim($sql));			
			foreach ($sql as $query){
				if (!DB::getInstance()->execute(trim($query))) return false;
			}
							
		}		
		if(!parent::install() || !$this->registerHook('header')) 
			return false;		
		if($this->arrHook)
			foreach($this->arrHook as $hook)
				if(!$this->registerHook($hook)) 
					return false;					
		if (!Configuration::updateGlobalValue('DTS_MEGA_MENUS', '1')) 
			return false;		
		//$this->installSameData();	
		return true;
	}
	function exportSameData($directory=''){
		$shopId = $this->context->shop->id;
		if($directory) $this->datas = $directory;
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
				$query1 = mysql_query('SELECT * FROM '._DB_PREFIX_.$table." Where id_lang = ". $this->context->language->id);		
				$num_fields = mysql_num_fields($query1);
				for ($i = 0; $i < $num_fields; $i++) 
				{
					while($row = mysql_fetch_row($query1))
					{
						$return.= 'INSERT INTO PREFIX_'.$table.' VALUES(';
						for($j=0; $j<$num_fields; $j++) 
						{
							$row[$j] = addslashes($row[$j]);
							$row[$j] = ereg_replace("\n","\\n",$row[$j]);
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
							$row[$j] = ereg_replace("\n","\\n",$row[$j]);
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
			//$return.="\n\n\n";
			$handle = fopen($this->datas.$currentOption.$table.'.sql','w+');
			//$handle = fopen($this->sameDatas.$table.'.sql','w+');
			fwrite($handle,$return);
			fclose($handle);
		}
		return true;
		//die(Tools::jsonEncode($this->l("Export data success!")));
	}
	function importSameData($directory=''){
		if($directory) $this->datas = $directory;
		$langs = DB::getInstance()->executeS("Select id_lang From "._DB_PREFIX_."lang Where active = 1");		
		if(self::$tables){
			$currentOption = Configuration::get('OVIC_CURRENT_DIR');
            if($currentOption) $currentOption .= '.';
            else $currentOption = '';
			foreach(self::$tables as $table=>$value){				
				if (file_exists($this->datas.$currentOption.$table.'.sql')){					
					$sql = @file_get_contents($this->datas.$currentOption.$table.'.sql');
					if($sql){
						DB::getInstance()->execute('TRUNCATE TABLE '._DB_PREFIX_.$table);
						$sql = str_replace(array('PREFIX_', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $sql);
						$sql = preg_split("/;\s*[\r\n]+/", trim($sql));
						if($value == 'lang'){
							foreach ($sql as $query){
								foreach($langs as $lang){								    
									$query_result = str_replace('id_lang', $lang['id_lang'], trim($query));
									DB::getInstance()->execute($query_result);
								}
							}
						}else{                        
							foreach ($sql as $query){
								if (!DB::getInstance()->execute(trim($query))) return false;
							}
	                        
						}
					}
					
				}
				
			}
		}
		return true;
		//die(Tools::jsonEncode($this->l("Install data demo success!")));
	} 
	public function uninstall($keep = true)
	{	   
		if (!parent::uninstall()) return false;		
        if($keep){
			foreach(self::$tables as $table=>$value){
    			Db::getInstance()->execute('DROP TABLE IF EXISTS '._DB_PREFIX_.$table);
    		}
        }	
        if (!Configuration::deleteByName('MEGA_MENUS')) return false;
		return true;
	}
	public function reset()
	{
		if (!$this->uninstall(false))
			return false;
		if (!$this->install(false))
			return false;
		$this->updateVersion();
		return true;
	}
	public function updateVersion(){
		return true;
	}
	protected function generatePositionOption($selected=''){
		$options = '';		
		if($this->arrHook){			
			foreach($this->arrHook as $hook){				
				if($hook == $selected) $options .='<option selected="selected" value="'.$hook.'">'.$hook.'</option>';
				else $options .='<option value="'.$hook.'">'.$hook.'</option>';
			}
		}
        return $options;
	}
	protected function generateLayoutOption($selected=''){
		$options = '';		
		if($this->arrLayout){			
			foreach($this->arrLayout as $key=>$value){				
				if($key == $selected) $options .='<option selected="selected" value="'.$key.'">'.$value.'</option>';
				else $options .='<option value="'.$key.'">'.$value.'</option>';
			}
		}
        return $options;
	}
	protected function generateMenuTypeOption($selected=''){
		$options = '';		
		if($this->arrMenuType){			
			foreach($this->arrMenuType as $key=>$value){				
				if($key == $selected) $options .='<option selected="selected" value="'.$key.'">'.$value.'</option>';
				else $options .='<option value="'.$key.'">'.$value.'</option>';
			}
		}
        return $options;
	}
	protected function generateGroupTypeOption($selected=''){
		$options = '';		
		if($this->arrGroupType){			
			foreach($this->arrGroupType as $key=>$value){				
				if($key == $selected) $options .='<option selected="selected" value="'.$key.'">'.$value.'</option>';
				else $options .='<option value="'.$key.'">'.$value.'</option>';
			}
		}
        return $options;
	}
	protected function generateProductOrderByOption($selected=''){
		$options = '';		
		if($this->arrProductOrderBy){			
			foreach($this->arrProductOrderBy as $key=>$value){				
				if($key == $selected) $options .='<option selected="selected" value="'.$key.'">'.$value.'</option>';
				else $options .='<option value="'.$key.'">'.$value.'</option>';
			}
		}
        return $options;
	}
	protected function generateProductOrderWayOption($selected=''){
		$options = '';		
		if($this->arrProductOrderWay){			
			foreach($this->arrProductOrderWay as $key=>$value){				
				if($key == $selected) $options .='<option selected="selected" value="'.$key.'">'.$value.'</option>';
				else $options .='<option value="'.$key.'">'.$value.'</option>';
			}
		}
        return $options;
	}
	protected function generateProductOnConditionOption($selected=''){
		$options = '';		
		if($this->arrProductOnCondition){			
			foreach($this->arrProductOnCondition as $key=>$value){				
				if($key == $selected) $options .='<option selected="selected" value="'.$key.'">'.$value.'</option>';
				else $options .='<option value="'.$key.'">'.$value.'</option>';
			}
		}
        return $options;
	}
	protected function generateProductOnSaleOption($selected=''){
		$options = '';		
		if($this->arrProductOnSale){			
			foreach($this->arrProductOnSale as $key=>$value){				
				if($key == $selected) $options .='<option selected="selected" value="'.$key.'">'.$value.'</option>';
				else $options .='<option value="'.$key.'">'.$value.'</option>';
			}
		}
        return $options;
	}
	protected function generateProductOnNewOption($selected=''){
		$options = '';		
		if($this->arrProductOnNew){			
			foreach($this->arrProductOnNew as $key=>$value){				
				if($key == $selected) $options .='<option selected="selected" value="'.$key.'">'.$value.'</option>';
				else $options .='<option value="'.$key.'">'.$value.'</option>';
			}
		}
        return $options;
	}
	protected function generateProductOnDiscountOption($selected=''){
		$options = '';		
		if($this->arrProductOnDiscount){			
			foreach($this->arrProductOnDiscount as $key=>$value){				
				if($key == $selected) $options .='<option selected="selected" value="'.$key.'">'.$value.'</option>';
				else $options .='<option value="'.$key.'">'.$value.'</option>';
			}
		}
        return $options;
	}
	/** function generateProductTypeOption
	 * var type = auto/manual
	 * 	 return type option
	 */
	protected function generateProductTypeOption($selected=''){
		$options = '';		
		if($this->arrProductType){			
			foreach($this->arrProductType as $key=>$value){				
				if($key == $selected) $options .='<option selected="selected" value="'.$key.'">'.$value.'</option>';
				else $options .='<option value="'.$key.'">'.$value.'</option>';
			}
		}
        return $options;
	}
	protected function generateColOption($selected=''){
		$options = '';		
		if($this->arrCol){			
			foreach($this->arrCol as $key=>$value){				
				if($key == $selected) $options .='<option selected="selected" value="'.$key.'">'.$value.'</option>';
				else $options .='<option value="'.$key.'">'.$value.'</option>';
			}
		}
        return $options;
	}
	
	protected function getAllCategories($langId, $shopId, $parentId = 0, $sp='', $arr=null, $maxDepth=10){
        if($arr == null) $arr = array();
		$sql = "Select c.id_category, cl.name 
			From "._DB_PREFIX_."category as c 
			Inner Join "._DB_PREFIX_."category_lang as cl On c.id_category = cl.id_category 
			Where 
				c.active = 1 AND 
				c.level_depth <= $maxDepth AND 
				c.id_shop_default = $shopId AND 
				c.id_parent = $parentId AND 
				cl.id_lang = ".$langId." AND 
				cl.id_shop = ".$shopId;
        $items = Db::getInstance()->executeS($sql);
        if($items){
            foreach($items as $item){
                $arr[] = array('id_category'=>$item['id_category'], 'name'=>$item['name'], 'sp'=>$sp);
                $arr = $this->getAllCategories($langId, $shopId, $item['id_category'], $sp.'|-', $arr, $maxDepth);
            }
        }
        return $arr;
    }
	public function _getAllCategoryIds($parentId = 0, $id_shop=0, $arr=null){
        if($arr == null) $arr = array();
		if(!$id_shop) $id_shop = (int) $this->context->shop->id;		
		$sql = "Select id_category 
			From "._DB_PREFIX_."category 
			Where 
				id_shop_default = $id_shop AND 
				active = 1 AND 
				id_parent = $parentId";	
        $items = DB::getInstance()->executeS($sql);
        if($items){
            foreach($items as $item){
                $arr[] = $item['id_category'];
                $arr = $this->_getAllCategoryIds($item['id_category'], $id_shop, $arr);
            }
        }
        return $arr;
    }
    protected function getAllProductIds($categoryId = 0, $id_shop=0, $arr=null){
        if($arr == null) $arr = array();
		if(!$id_shop) $id_shop = (int) $this->context->shop->id;
        if($categoryId >0)
			$sql = "Select id_product 
				From "._DB_PREFIX_."product_shop 
				Where 
					active = 1 AND  
					id_shop = $id_shop AND 
					id_category_default = '$categoryId'";            
        else
			$sql = "Select id_product 
				From "._DB_PREFIX_."product_shop 
				Where 
					active = 1 AND  
					id_shop = $id_shop";
		$items = DB::getInstance()->executeS($sql);
        if($items){
            foreach($items as $item){
                $arr[] = $item['id_product'];
            }
        }
        return $arr;
    }
		
	protected function generateModuleOption($selected='', $id_shop=0){
        if(!$id_shop) $id_shop = (int) $this->context->shop->id;
		$options = '';
		$sql = "Select m.id_module, m.name 
			From "._DB_PREFIX_."module AS m 
			Inner Join "._DB_PREFIX_."module_shop AS ms 
				On (m.`id_module` = ms.`id_module` AND ms.`id_shop`='$id_shop') 
			Where 
				m.active = 1 AND 
				m.`name` <> '".$this->name."'";
        $items = Db::getInstance()->executeS($sql);
		if($items){
			foreach($items as $item){
				if($item['name'] == $selected) $options .='<option selected="selected" value="'.$item['name'].'">'.$item['name'].'</option>';
				else $options .='<option value="'.$item['name'].'">'.$item['name'].'</option>';
			}
		}		
        return $options;
    }
    protected function generateCategoryOption($selected = 0, $parentId = 0, $langId=0, $shopId=0){
        $langId = (int) $this->context->language->id;
        $shopId = (int) $this->context->shop->id;
        $options = '';
        if($parentId <=0) $parentId = Configuration::get('PS_HOME_CATEGORY');						
		$parentName = DB::getInstance()->getValue("Select name From "._DB_PREFIX_."category_lang Where id_category = '$parentId' AND `id_shop` = '$shopId' AND `id_lang` = '$langId'");
		$options ='<option selected="selected" value="'.$parentId.'">'.$parentName.'</option>';
		//$options .='<option value="0">'.$this->l('Current category').'</option>';
        $items = $this->getAllCategories($langId, $shopId, $parentId, '|-', null);		
        if($items){
            foreach($items as $item){
                if($item['id_category'] == $selected) $options .='<option selected="selected" value="'.$item['id_category'].'">'.$item['sp'].$item['name'].'</option>';
                else $options .='<option value="'.$item['id_category'].'">'.$item['sp'].$item['name'].'</option>';
            }
        }
        return  $options;
    }
	protected function generateLanguageOption(){    	
        $langId = (int) $this->context->language->id;
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
	protected function generateHookModuleOption($moduleName='', $hookName='', $id_shop=0){		
		$options = '';
		if(!$moduleName) return $options;
		$module = @Module::getInstanceByName($moduleName);
		if($module){
			if (Validate::isLoadedObject($module) && $module->id){				
				$methods = get_class_methods($module);
				if($methods)
					foreach($methods as $method){
						
						if(strpos($method, 'hook') !== false AND strpos($method, 'Delete') === false AND strpos($method, 'Update') === false AND strpos($method, 'Action') === false AND strpos($method, 'Add') === false AND strpos($method, 'Exec') === false AND strpos($method, 'AjaxCall') === false AND strpos($method, 'BackOffice') === false AND strpos($method, 'dashboard') === false AND strpos($method, 'Save') === false AND strpos($method, 'Process') === false AND strpos($method, 'Form') === false AND strpos($method, 'Deletion') === false){
							$method = str_replace('hook', '', $method);
							if($method == $hookName) $options .='<option selected="selected" value="'.$method.'">'.$method.'</option>';
							else $options .='<option value="'.$method.'">'.$method.'</option>';
						}
					}		               
			}
		}
		/*	
		if(!$id_shop) $id_shop = (int)$this->context->shop->id;
		$options = '';
		$moduleId = Module::getModuleIdByName($moduleName);
		$sql = "Select h.name, h.id_hook 
			From "._DB_PREFIX_."hook AS h 
			Inner Join "._DB_PREFIX_."hook_module as hm 
				On h.id_hook = hm.id_hook 
			Where 				
				h.name NOT LIKE 'action%' AND 
				h.name NOT LIKE 'displayAdmin%' AND 
				h.name NOT LIKE 'displayBackOffice%' AND 
				h.name NOT LIKE 'dashboard%' AND 
				hm.id_module = ".$moduleId." AND 
				hm.id_shop = ".$id_shop;
        $items = DB::getInstance()->executeS($sql);		
		if($items){
			foreach($items as $item){
				if($item['name'] == $hookName) $options .='<option selected="selected" value="'.$item['name'].'">'.$item['name'].'</option>';
				else $options .='<option value="'.$item['name'].'">'.$item['name'].'</option>';
			}
		}
		*/
        return $options;		
    }
    protected function getImageSrc($image = ''){
    	if($image){
            if(strpos($image, 'http') !== false){
                return $image;
    	   }else{
                if(file_exists($this->pathImage.$image))
                    return $this->liveImage.$image;
                else 
					return '';                    	  	
          }    
        }else{            
			return '';            
        }
		
    }
	protected function getIconSrc($image = '', $check = false){
        if($image){
        	if(strpos($image, '.') !== false){        		
	        	if(strpos($image, 'http') !== false){
	                $results = array('type'=>'image', 'img'=>$image);
	            }else{
	                if(file_exists($this->pathImage.$image))
						$results = array('type'=>'image', 'img'=>$this->liveImage.$image);	                    
	        		else if($image && file_exists($this->pathImage.'icons/'.$image))
						$results = array('type'=>'image', 'img'=>$this->liveImage.'icons/'.$image);
	                else{
	                	$results = array('type'=>'none', 'img'=>'');
	                }
						
	                        
	            }	
        	}else{
        		$results = array('type'=>'class', 'img'=>$image);
        	}
        }else{
        	$results = array('type'=>'none', 'img'=>'');
        }    
		return $results;
    }
	/*
	protected function getIconSrc($image = '', $check = false){
		if($image){
            if(strpos($image, 'http') !== false){
                return $image;
    	   }else{
                if(file_exists($this->pathImage.'icons/'.$image))
                    return $this->liveImage.'icons/'.$image;
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
	*/
    private function getCMSCategories($recursive = false, $parent = 1, $id_lang = false){
		$id_lang = $id_lang ? (int)$id_lang : (int)$this->context->language->id;
		if ($recursive === false){
			$sql = 'SELECT bcp.`id_cms_category`, bcp.`id_parent`, bcp.`level_depth`, bcp.`active`, bcp.`position`, cl.`name`, cl.`link_rewrite`
				FROM `'._DB_PREFIX_.'cms_category` bcp
				INNER JOIN `'._DB_PREFIX_.'cms_category_lang` cl
					ON (bcp.`id_cms_category` = cl.`id_cms_category`)
				WHERE cl.`id_lang` = '.(int)$id_lang.'
					AND bcp.`id_parent` = '.(int)$parent;
			return Db::getInstance()->executeS($sql);
		}else{
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
		$id_shop = ($id_shop !== false) ? (int)$id_shop : (int)$this->context->shop->id;
		$id_lang = $id_lang ? (int)$id_lang : (int)$this->context->language->id;

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
    protected function generateCMSLinkOption($parent = 0, $depth = 1, $id_lang = false, $selected='')
	{
		$html = '';
		$id_lang = $id_lang ? (int)$id_lang : (int)$this->context->language->id;		
		$categories = $this->getCMSCategories(false, (int)$parent, (int)$id_lang);        
		$pages = $this->getCMSPages((int)$parent, false, (int)$id_lang);
		$spacer = str_repeat('|- ', 1 * (int)$depth);
		foreach ($categories as $category)
		{
			$key = 'CMS_CAT|'.$category['id_cms_category'];
            if($key == $selected)
                $html .= '<option selected="selected" value="'.$key.'" style="font-weight: bold;">'.$spacer.$category['name'].'</option>';
            else 
               $html .= '<option value="'.$key.'" style="font-weight: bold;">'.$spacer.$category['name'].'</option>';
                
			$html .= $this->generateCMSLinkOption($category['id_cms_category'], (int)$depth + 1, (int)$id_lang, $selected);
		}

		foreach ($pages as $page){
            $key = 'CMS|'.$page['id_cms'];
            if($key == $selected)
			    $html .= '<option selected="selected" value="'.$key.'">'.$spacer.$page['meta_title'].'</option>';
            else 
                $html .= '<option value="'.$key.'">'.$spacer.$page['meta_title'].'</option>';
		}
		return $html;
	}
    protected function generatePageLinkOption($id_lang = 0, $selected = '', $html=null){
    	//if($html == null) $html = '';
    	/*
    	$html = '';
        $controllers = Dispatcher::getControllers(_PS_FRONT_CONTROLLER_DIR_);
		ksort($controllers);		
		foreach ($controllers as $k => $v){
			$v = 'PAG|'.$k;
			if($k == $selected)
				$html .= '<option selected="selected" value="'.$v.'">'.$k.'</option>';
			else
				$html .= '<option value="'.$v.'">'.$k.'</option>';
		}
			
		
		$all_modules_controllers = Dispatcher::getModuleControllers('front');
		foreach ($all_modules_controllers as $module => $modules_controllers)
			foreach ($modules_controllers as $cont){
				$k = 'module-'.$module.'-'.$cont;
				$v = 'PAG|'.$k;
				if($k == $selected)
					$html	.=	'<option selected="selected" value="'.$v.'">'.$k.'</option>';
				else
					$html	.=	'<option  value="'.$v.'">'.$k.'</option>';
			}
		
		*/
        if (!$id_lang) $id_lang = (int)$langId = (int)$this->context->language->id;;        
        $files = Meta::getMetasByIdLang($id_lang);
        $html = '';
        foreach ($files as $file)
        {
            $key = 'PAG|'.$file['page'];
            if($key == $selected)
                $html .= '<option selected="selected" value="'.$key.'">' . (($file['title'] !='') ? $file['title'] : $file['page']) . '</option>';
            else
                $html .= '<option value="'.$key.'">' . (($file['title'] !='') ? $file['title'] : $file['page']) . '</option>';

        }
		
        return $html;
    }
    protected function generateCategoryLinkOption($parentId = 0, $selected = ''){
        $langId = (int)$this->context->language->id;
        $shopId = (int)$this->context->shop->id;
        $categoryOptions = '';
        if($parentId <=0) $parentId = Configuration::get('PS_HOME_CATEGORY');
        $items = $this->getAllCategories($langId, $shopId, $parentId, '|- ', null);        
        if($items){
            foreach($items as $item){
                $key = 'CAT|'.$item['id_category'];                
                if($key == $selected) $categoryOptions .='<option selected="selected" value="'.$key.'">'.$item['sp'].$item['name'].'</option>';
                else $categoryOptions .='<option value="'.$key.'">'.$item['sp'].$item['name'].'</option>';
            }
        }
        return  $categoryOptions;
    }
	protected function getCategoryNameById($id, $langId=0, $shopId=0){
		if(!$langId) $langId = (int)$this->context->language->id;
        if(!$shopId) $shopId = (int)$this->context->shop->id;
        $name =  Db::getInstance()->getValue("Select name From "._DB_PREFIX_."category_lang Where id_category = $id AND `id_shop` = '$shopId' AND `id_lang` = '$langId'");
        if($name) return $name;
        else return '';   
    }
    protected function generateAllLinkOptions($selected = ''){    	
    	$suppliers = Supplier::getSuppliers(false, false);
        $manufacturers = Manufacturer::getManufacturers(false, false);
        $allLink = '';
        if($selected == 'CUSTOMLINK|0')
            $allLink .= '<option selected="selected" value="CUSTOMLINK|0">'.$this->l('-- Custom Link --').'</option>';
        else
            $allLink .= '<option value="CUSTOMLINK|0">'.$this->l('-- Custom Link --').'</option>';
            
        $allLink .= '<optgroup label="' . $this->l('Category Link') . '">'.$this->generateCategoryLinkOption(0, $selected).'</optgroup>';
        $allLink .= '<optgroup label="' . $this->l('CMS Link') . '">'.$this->generateCMSLinkOption(0, 1, false, $selected).'</optgroup>';        
        $allLink .= '<optgroup label="'.$this->l('Supplier Link').'">';
		if($selected == 'ALLSUP|0')
            $allLink .= '<option selected="selected" value="ALLSUP|0">'.$this->l('All suppliers').'</option>';
        else
            $allLink .= '<option value="ALLSUP|0">'.$this->l('All suppliers').'</option>';
        foreach ($suppliers as $supplier){
            $key = 'SUP|'.$supplier['id_supplier'];
            if($key == $selected)            	
                $allLink .= '<option selected="selected" value="'.$key.'">|- '.$supplier['name'].'</option>';            				  
            else 
                $allLink .= '<option value="'.$key.'">|- '.$supplier['name'].'</option>';
        } 
		$allLink .= '</optgroup>';
        
        $allLink .= '<optgroup label="'.$this->l('Manufacturer Link').'">';
        if($selected == 'ALLMAN|0')
            $allLink .= '<option selected="selected" value="ALLMAN|0">'.$this->l('All manufacturers').'</option>';
        else 
            $allLink .= '<option value="ALLMAN|0">'.$this->l('All manufacturers').'</option>';
        foreach ($manufacturers as $manufacturer){
            $key = 'MAN|'.$manufacturer['id_manufacturer'];
            if($key == $selected)
                $allLink .= '<option selected="selected" value="'.$key.'">|- '.$manufacturer['name'].'</option>';
            else
                $allLink .= '<option value="'.$key.'">|- '.$manufacturer['name'].'</option>';
        }
		$allLink .= '</optgroup>';
        
        
        $allLink .= '<optgroup label="' . $this->l('Page Link') . '">'.$this->generatePageLinkOption(0, $selected).'</optgroup>';
        if (Shop::isFeatureActive())
		{
			$allLink .= '<optgroup label="'.$this->l('Shops Link').'">';
			$shops = Shop::getShopsCollection();
			foreach ($shops as $shop)
			{
				if (!$shop->setUrl() && !$shop->getBaseURL()) continue;
                $key = 'SHO|'.$shop->id;
                if($key == $selected)
                    $allLink .= '<option selected="selected" value="'.$key.'">'.$shop->name.'</option>';
                else
                    $allLink .= '<option value="'.$key.'">'.$shop->name.'</option>';
			}	
			$allLink .= '</optgroup>';
		}
        $allLink .= '<optgroup label="'.$this->l('Product Link').'">';
        if($selected == 'PRODUCT|0')
            $allLink .= '<option selected value="PRODUCT|0" style="font-style:italic">'.$this->l('Choose product ID').'</option>';
        else
            $allLink .= '<option value="PRODUCT|0" style="font-style:italic">'.$this->l('Choose product ID').'</option>';
		$allLink .= '</optgroup>';
        return $allLink;
    }
	protected function getAllLanguage(){
        $langId = (int)$this->context->language->id;
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
    protected function getModuleByLanguage($id, $langId=0){
    	if(!$langId) $langId = $this->context->language->id;
		$itemLang = Db::getInstance()->getRow("Select name From "._DB_PREFIX_."megamenus_module_lang Where module_id = $id AND `id_lang` = '$langId'" );
		if(!$itemLang) $itemLang = array('name'=>'');
		return $itemLang;
    }
	protected function getMenuByLanguage($id, $langId=0){
		if(!$langId) $langId = $this->context->language->id;
		$itemLang = Db::getInstance()->getRow("Select name, `link` From "._DB_PREFIX_."megamenus_menu_lang Where menu_id = $id AND `id_lang` = '$langId'" );
		if(!$itemLang) $itemLang = array('name'=>'', 'link'=>'', 'image'=>'', 'imageAlt'=>'', 'html'=>'');
		return $itemLang;
	}
	protected function getRowByLanguage($id, $langId=0){
		if(!$langId) $langId = $this->context->language->id;
		$itemLang = Db::getInstance()->getRow("Select name From "._DB_PREFIX_."megamenus_row_lang Where row_id = $id AND `id_lang` = '$langId'" );
		if(!$itemLang) $itemLang = array('name'=>'');
		return $itemLang;
	}
	protected function _getGroupByLanguage($id, $langId=0){
		if(!$langId) $langId = $this->context->language->id;
		$itemLang = Db::getInstance()->getRow("Select `name`, `description` From "._DB_PREFIX_."megamenus_group_lang Where group_id = $id AND `id_lang` = '$langId'" );
		if(!$itemLang) $itemLang = array('name'=>'', 'description'=>'');
		return $itemLang;
	}
	protected function getMenuItemByLanguage($id, $langId=0, $shopId=0){
		if(!$langId) $langId = $this->context->language->id;
		$itemLang = Db::getInstance()->getRow("Select name, `link`, image, imageAlt, html From "._DB_PREFIX_."megamenus_menuitem_lang Where menuitem_id = $id AND `id_lang` = '$langId'" );
		if(!$itemLang) $itemLang = array('name'=>'', 'link'=>'', 'image'=>'', 'imageAlt'=>'', 'html'=>'');
		return $itemLang;
	}
	protected function generateUrl($value, $default="#", $prefix=''){
		$response = $default;
		if($prefix) $value .= $prefix; 
        if($value){
            $langId = $this->context->language->id;
	    	$shopId = $this->context->shop->id;	    	
            $arr = explode('|', $value);
            switch ($arr[0]){
                case 'PRD':
					$product = new Product((int)$arr[1], true, (int)$langId);
                    $response = Tools::HtmlEntitiesUTF8($product->getLink());                    
					break;
                case 'CAT':           
				    $response = Tools::HtmlEntitiesUTF8($this->context->link->getCategoryLink((int)$arr[1], null, $langId));
                    break;
                case 'CMS_CAT':                                                    
                    $response = Tools::HtmlEntitiesUTF8($this->context->link->getCMSCategoryLink((int)$arr[1], null, $langId));
                    break;    
                case 'CMS':                                
                    $response = Tools::HtmlEntitiesUTF8($this->context->link->getCMSLink((int)$arr[1], null, $langId));                
                    break;
                case 'ALLMAN':
                    $response = Tools::HtmlEntitiesUTF8($this->context->link->getPageLink('manufacturer'), true, $langId);					
					break;        
                case 'MAN':
                    $man = new Manufacturer((int)$arr[1], $langId);
                    $response = Tools::HtmlEntitiesUTF8($this->context->link->getManufacturerLink($man->id, $man->link_rewrite, $langId)); 
                    break;
                case 'ALLSUP':
					$response = Tools::HtmlEntitiesUTF8($this->context->link->getPageLink('supplier'), true, $langId);
					break;    
                case 'SUP':
                    $sup = new Supplier((int)$arr[1], $langId);    
                    $response = Tools::HtmlEntitiesUTF8($this->context->link->getSupplierLink($sup->id, $sup->link_rewrite, $langId));
                    break;
                case 'SHO':
                    $shop = new Shop((int)$key);
                    $response = $shop->getBaseURL();    
                    break;
                case 'PAG': 					
                    $pag = Meta::getMetaByPage($arr[1], $langId);		
					if(strpos($pag['page'], 'module-') === false){						
						$response = Tools::HtmlEntitiesUTF8($this->context->link->getPageLink($pag['page'], true, $langId));
					}else{
						$page = explode('-', $pag['page']);	
						Context::getContext()->link->getModuleLink($page[1], $page[2]);						
						$response = Tools::HtmlEntitiesUTF8($this->context->link->getModuleLink($page[1], $page[2]));
					}
                    break; 
				default:
					break;                   
            }
        }
		return $response;
    }	
	protected function generateFormMegamenu($id=0){
		$langId = (int)$this->context->language->id;
        $shopId = (int)$this->context->shop->id;
		$themeId = (int)$this->context->shop->id_theme;
		$theme = new Theme($themeId);
		$optionDirectory = Configuration::get('CURRENT_OPTION_DIR') ?  Configuration::get('CURRENT_OPTION_DIR') : '';		
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."megamenus_module Where id = $id AND `id_shop` = ".$shopId);			
		if(!$item) $item = array(
			'id'				=>	0, 
			'id_shop'			=>	$shopId, 
			'theme_directory'	=>	$theme->directory,
			'option_directory'	=>	$optionDirectory,
			'position_name'		=>	'', 
			'layout'			=>	'vertical_left', 
			'display_name'		=>	1, 
			'show_count'		=>	10, 
			'ordering'			=>	1, 
			'status'			=>	1, 
			'params'			=>	"", 
			'custom_class'		=>	'',
		);
		$langActive = '<input type="hidden" id="moduleLanguageActive" value="0" />';
		$inputName = '';
		$languages = $this->getAllLanguage();
		if($languages){
			foreach ($languages as $key => $language) {				
				$itemLang = $this->getModuleByLanguage($id, $language->id);
				if($language->active == '1'){
					$langActive = '<input type="hidden" id="moduleLanguageActive" value="'.$language->id.'" />';
					$inputName .= '<input type="text" value="'.$itemLang['name'].'" name="names[]" id="module_name_'.$language->id.'" class="form-control module-lang-'.$language->id.'" />';	
				}else{
					$inputName .= '<input type="text" value="'.$itemLang['name'].'" name="names[]" id="module_name_'.$language->id.'" class="form-control module-lang-'.$language->id.'" style="display:none" />';					
				}				
			}
		}
		$langOptions = $this->generateLanguageOption();
		$html = '<input type="hidden" name="id" value="'.$item['id'].'" />';
		$html .= $langActive;
		$html .= '<input type="hidden" name="action" value="saveMegamenu" />';
		$html .= '<input type="hidden" name="secure_key" value="'.$this->secure_key.'" />';
		$html .= 	'<div class="form-group">
						<label class="control-label col-sm-3">'.$this->l('Name').'</label>
						<div class="col-sm-9">
							<div class="col-sm-10">'.$inputName.'</div>
							<div class="col-sm-2">
								<select class="module-lang" onchange="moduleChangeLanguage(this.value)">'.$langOptions.'</select>
							</div>
						</div>
					</div>';
		$html .= 	'<div class="form-group">
	                    <label class="control-label col-sm-3">'.$this->l('Custom class').'</label>
					    <div class="col-sm-9">
	                        <div class="col-sm-12">
	                        	<input name="custom_class" type="text" value="'.$item['custom_class'].'" class="form-control" />
	                        </div>
	                    </div>
	                </div>';
		if($item['display_name'] == 1){
			$html .= 	'<div class="form-group">
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
			$html .= 	'<div class="form-group">
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
		$html .= 	'<div class="form-group">
						<label class="control-label col-sm-3">'.$this->l('Position').'</label>
						<div class="col-sm-9">
							<div class="col-sm-12">
								<select class="form-control" name="position_name">'.$this->generatePositionOption($item['position_name']).'</select>
							</div>
						</div>
					</div>';
        //$html .= '<div class="form-group"><label class="control-label col-sm-3">'.$this->l('Position').'</label><div class="col-sm-9"><div class="col-sm-12"><select  name="positions[]" multiple="multiple" size="5">'.$this->getPositionMultipleOptions($item['id']).'</select></div></div></div>';
		$html .= 	'<div class="form-group">
						<label class="control-label col-sm-3">'.$this->l('Layout').'</label>
						<div class="col-sm-9">
							<div class="col-sm-12">
								<select class="form-control" name="layout">'.$this->generateLayoutOption($item['layout']).'</select>
							</div>
						</div>
					</div>';
		/*
		$html .= 	'<div class="form-group">
						<label class="control-label col-sm-3">'.$this->l('Show Item').'</label>
						<div class="col-sm-9">
							<div class="col-sm-3">
								<input type="text" onkeypress="return handleEnterNumberInt(event)" name="show_count" value="'.$item['show_count'].'" class="form-control" />
							</div>
						</div>
					</div>';
		*/
		return $html;
	}
	protected function generateFormMenu($id = 0){		
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."megamenus_menu Where id = $id");		
		if(!$item) 
			$item = array(
				'id'			=>	0, 
				'parent_id'		=>	0,
				'module_id'		=>	0, 
				'icon'			=>	'', 
				'icon_active'	=>	'',
				'background'	=>	'', 
				'link_type'		=>	'CUSTOMLINK|0', 
				'product_id'	=>	0, 
				'width'			=>	12, 
				'status'		=>	1, 
				'custom_class'	=>	'', 
				'display_name'	=>	1, 
				'ordering'		=>	1,
			);		
		$langActive = '<input type="hidden" id="menuLanguageActive" value="0" />';
		$languages = $this->getAllLanguage();
		$inputTitle = '';
		$inputLinks = '';
		if($languages){
			foreach ($languages as $key => $language) {				
				$itemLang = $this->getMenuByLanguage($id, $language->id);
				if($language->active == '1'){
					$langActive = '<input type="hidden" id="menuLanguageActive" value="'.$language->id.'" />';
					$inputTitle .= '<input type="text" value="'.$itemLang['name'].'" name="names[]" id="menu_name_'.$language->id.'"  class="form-control menu-lang-'.$language->id.'" />';
					$inputLinks .= '<input type="text" value="'.$itemLang['link'].'" name="links[]" id="menu_link_'.$language->id.'"  class="form-control menu-lang-'.$language->id.'" />';					
				}else{
					$inputTitle .= '<input type="text" value="'.$itemLang['name'].'" name="names[]" id="menu_name_'.$language->id.'"  class="form-control menu-lang-'.$language->id.'" style="display:none" />';
					$inputLinks .= '<input type="text" value="'.$itemLang['link'].'" name="links[]" id="menu_link_'.$language->id.'"  class="form-control menu-lang-'.$language->id.'" style="display:none" />';
				}				
			}
		}
		$langOptions = $this->generateLanguageOption();
		$html = '';
		$html .= '<input type="hidden" name="id" value="'.$item['id'].'" />';		
		$html .= $langActive;
		$html .= '<input type="hidden" name="action" value="saveMenu" />';	
		$html .= '<input type="hidden" name="secure_key" value="'.$this->secure_key.'" />';
		$html .= 	'<div class="form-group">
	                    <label class="control-label col-sm-2">'.$this->l('Name').'</label>
					    <div class="col-sm-10">
	                        <div class="col-sm-10">'.$inputTitle.'</div>
	                        <div class="col-sm-2">
	                            <select class="menu-lang" onchange="menuChangeLanguage(this.value)">'.$langOptions.'</select>
	                        </div>                                                                        
	                    </div>
	                </div> ';
		/*
		 $html .= '<div class="form-group clearfix">
                    <label class="control-label col-sm-2">'.$this->l('Select Link').'</label>
                    <div class="col-sm-10">
                        <div class="col-sm-5">                        
                            <select name="link_type" class="form-control" onchange="changeLinkType_MenuItem(this.value)">'.$this->generateAllLinkOptions($item['link_type']).'</select>                        
                        </div> 
                        <label class="control-label col-sm-2 ">'.$this->l('Menu type').'</label>	                    
                        <div class="col-sm-5">                        
                            <select name="menu_type" id="menu-item-type" class="form-control" onchange="showItemContentByType(this.value)">'.$this->generateMenuTypeOption($item['menu_type']).'</select>                   
                        </div>                        
	                                        
                    </div>  
                </div>'; 
		*/
		 
        if($item['display_name'] == 1){
			$html .= 	'<div class="form-group">
		                    <label class="control-label col-sm-2">'.$this->l('Display name').'</label>
		                    <div class="col-sm-10">
		                        <div class="col-sm-5">
		                            <span class="switch prestashop-switch fixed-width-lg" id="menu-display-name">
		                                <input type="radio" value="1" class="menu_display_name" checked="checked" id="menu_display_name_on" name="menu_display_name" />
		            					<label for="menu_display_name_on">Yes</label>
		            				    <input type="radio" value="0" class="menu_display_name" id="menu_display_name_off" name="menu_display_name" />
		            					<label for="menu_display_name_off">No</label>
		                                <a class="slide-button btn"></a>
		            				</span>
		                        </div>                        
		                    </div>				    
		                </div>';	
		}else{
			$html .= 	'<div class="form-group">
		                    <label class="control-label col-sm-2">'.$this->l('Display name').'</label>
		                    <div class="col-sm-10">
		                        <div class="col-sm-5">
		                            <span class="switch prestashop-switch fixed-width-lg" id="menu-display-name">
		                                <input type="radio" value="1" class="menu_display_name" id="menu_display_name_off" name="menu_display_name" />
		            					<label for="menu_display_name_off">Yes</label>
		            				    <input type="radio" value="0" class="menu_display_name" checked="checked" id="menu_display_name_on" name="menu_display_name" />
		            					<label for="menu_display_name_on">No</label>
		                                <a class="slide-button btn"></a>
		            				</span>
		                        </div>                        
		                    </div>				    
		                </div>';
		}
		$html .= 	'<div class="form-group">
	                    <label class="control-label col-sm-2">'.$this->l('Custom class').'</label>
					    <div class="col-sm-10">
	                        <div class="col-sm-5">
	                        	<input name="custom_class" type="text" value="'.$item['custom_class'].'" class="form-control" />
	                        </div>
	                        <label class="control-label col-sm-2">'.$this->l('Background').'</label>
	                        <div class="col-sm-5">
		                        <div class="input-group ">
									<input type="text" class="form-control" value="'.$item['background'].'" name="background" id="menu-background" />
									<span class="input-group-btn"><button id="menu-background-uploader" type="button" class="btn btn-default"><i class="icon-folder-open"></i></button></span>
								</div>
							</div>
	                    </div>
	                </div> ';
		$html .= 	'<div class="form-group">
	                    <label class="control-label col-sm-2">'.$this->l('Icon').'</label>
					    <div class="col-sm-10">
	                        <div class="col-sm-5">
	                        	<div class="input-group">
									<input type="text" class="form-control" value="'.$item['icon'].'" name="icon" id="menu-icon" />
									<span class="input-group-btn">
										<button id="menu-icon-uploader" type="button" class="btn btn-default">
											<i class="icon-folder-open"></i>
										</button>
									</span>
								</div>
	                        </div>
	                    	<label class="control-label col-sm-2">'.$this->l('Icon active').'</label>
	                    	<div class="col-sm-5">
	                        	<div class="input-group">
									<input type="text" class="form-control" value="'.$item['icon_active'].'" name="icon_active" id="menu-icon-active" />
									<span class="input-group-btn">
										<button id="menu-icon-active-uploader" type="button" class="btn btn-default">
											<i class="icon-folder-open"></i>
										</button>
									</span>
								</div>
	                        </div>
	                    </div>
	                </div> ';
        
        $html .= 	'<div class="form-group">
        				<label class="control-label col-sm-2">'.$this->l('Width').'</label>
        				<div class="col-sm-10">
        					<div class="col-sm-5">
        						<select class="form-control" name="width">'.$this->generateColOption($item['width']).'</select>
        					</div>
        					<label class="control-label col-sm-2">'.$this->l('Select Link').'</label>		                    
	                        <div class="col-sm-5">                        
	                            <select name="link_type" class="form-control" onchange="changeLinkType_Menu(this.value)">'.$this->generateAllLinkOptions($item['link_type']).'</select>                        
	                        </div>                        
		                    
        				</div>
        			</div>';
		$html .= '<div class="menu-link-type-custom" style="display:'.($item['link_type'] == 'CUSTOMLINK|0' ? 'block' : 'none').'">
                  	<div class="form-group clearfix">
	                    <label class="control-label col-sm-2">'.$this->l('Url').'</label>
	                    <div class="col-sm-10">
	                        <div class="col-sm-10">'.$inputLinks.'</div>
	                        <div class="col-sm-2">
	                            <select class="menu-lang" onchange="menuChangeLanguage(this.value)">'.$langOptions.'</select>
	                        </div>
	                    </div>  
	                </div>
                </div>';
		$html .= '<div class="menu-link-type-product" style="display:'.($item['link_type'] == 'PRODUCT|0' ? 'block' : 'none').'">
                  	<div class="form-group clearfix">
	                    <label class="control-label col-sm-2">'.$this->l('Product Id').'</label>
	                    <div class="col-sm-10">
	                        <div class="col-sm-12">                        
	                            <input name="product_id" type="text" id="menu-product-id" value="'.$item['product_id'].'" class="form-control" />                   
	                        </div>
	                    </div>  
	                </div>
                </div>';
		return $html;
	}
	protected function generateFormSubMenu($id = 0){		
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."megamenus_menu Where id = $id");		
		if(!$item) 
			$item = array(
				'id'			=>	0, 
				'parent_id'		=>	0,
				'module_id'		=>	0, 
				'icon'			=>	'', 
				'icon_active'	=>	'',
				'background'	=>	'', 
				'link_type'		=>	'CUSTOMLINK|0', 
				'product_id'	=>	0, 
				'width'			=>	12, 
				'status'		=>	1, 
				'custom_class'	=>	'', 
				'display_name'	=>	1, 
				'ordering'		=>	1,
			);		
		$langActive = '<input type="hidden" id="subMenuLanguageActive" value="0" />';
		$languages = $this->getAllLanguage();
		$inputTitle = '';
		$inputLinks = '';
		if($languages){
			foreach ($languages as $key => $language) {				
				$itemLang = $this->getMenuByLanguage($id, $language->id);
				if($language->active == '1'){
					$langActive = '<input type="hidden" id="subMenuLanguageActive" value="'.$language->id.'" />';
					$inputTitle .= '<input type="text" value="'.$itemLang['name'].'" name="names[]"  class="form-control submenu-lang-'.$language->id.'" />';
					$inputLinks .= '<input type="text" value="'.$itemLang['link'].'" name="links[]"  class="form-control submenu-lang-'.$language->id.'" />';					
				}else{
					$inputTitle .= '<input type="text" value="'.$itemLang['name'].'" name="names[]"  class="form-control submenu-lang-'.$language->id.'" style="display:none" />';
					$inputLinks .= '<input type="text" value="'.$itemLang['link'].'" name="links[]"  class="form-control submenu-lang-'.$language->id.'" style="display:none" />';
				}				
			}
		}
		$langOptions = $this->generateLanguageOption();
		$html = '';
		$html .= '<input type="hidden" name="id" value="'.$item['id'].'" />';		
		$html .= $langActive;
		$html .= '<input type="hidden" name="action" value="saveSubMenu" />';	
		$html .= '<input type="hidden" name="secure_key" value="'.$this->secure_key.'" />';
		$html .= 	'<div class="form-group">
	                    <label class="control-label col-sm-2">'.$this->l('Name').'</label>
					    <div class="col-sm-10">
	                        <div class="col-sm-10">'.$inputTitle.'</div>
	                        <div class="col-sm-2">
	                            <select class="submenu-lang" onchange="subMenuChangeLanguage(this.value)">'.$langOptions.'</select>
	                        </div>                                                                        
	                    </div>
	                </div> ';
		$html .= 	'<div class="form-group">
	                    <label class="control-label col-sm-2">'.$this->l('Icon').'</label>
					    <div class="col-sm-10">
	                        <div class="col-sm-5">
	                        	<div class="input-group">
									<input type="text" class="form-control" value="'.$item['icon'].'" name="icon" id="submenu-icon" />
									<span class="input-group-btn">
										<button id="submenu-icon-uploader" type="button" class="btn btn-default">
											<i class="icon-folder-open"></i>
										</button>
									</span>
								</div>
	                        </div>
	                    	<label class="control-label col-sm-2">'.$this->l('Icon active').'</label>
	                    	<div class="col-sm-5">
	                        	<div class="input-group">
									<input type="text" class="form-control" value="'.$item['icon_active'].'" name="icon_active" id="submenu-icon-active" />
									<span class="input-group-btn">
										<button id="submenu-icon-active-uploader" type="button" class="btn btn-default">
											<i class="icon-folder-open"></i>
										</button>
									</span>
								</div>
	                        </div>
	                    </div>
	                </div> ';
        $html .= 	'<div class="form-group">
	                    <label class="control-label col-sm-2">'.$this->l('Custom class').'</label>
					    <div class="col-sm-10">
	                        <div class="col-sm-5">
	                        	<input name="custom_class" type="text" value="'.$item['custom_class'].'" class="form-control" />
	                        </div>
	                        <label class="control-label col-sm-2">'.$this->l('Select Link').'</label>		                    
	                        <div class="col-sm-5">                        
	                            <select name="link_type" class="form-control" onchange="changeLinkType_SubMenu(this.value)">'.$this->generateAllLinkOptions($item['link_type']).'</select>                        
	                        </div> 
	                    </div>
	                </div> ';       
		$html .= '<div class="submenu-link-type-custom" style="display:'.($item['link_type'] == 'CUSTOMLINK|0' ? 'block' : 'none').'">
                  	<div class="form-group clearfix">
	                    <label class="control-label col-sm-2">'.$this->l('Url').'</label>
	                    <div class="col-sm-10">
	                        <div class="col-sm-10">'.$inputLinks.'</div>
	                        <div class="col-sm-2">
	                            <select class="submenu-lang" onchange="subMenuChangeLanguage(this.value)">'.$langOptions.'</select>
	                        </div>
	                    </div>  
	                </div>
                </div>';
		$html .= '<div class="submenu-link-type-product" style="display:'.($item['link_type'] == 'PRODUCT|0' ? 'block' : 'none').'">
                  	<div class="form-group clearfix">
	                    <label class="control-label col-sm-2">'.$this->l('Product Id').'</label>
	                    <div class="col-sm-10">
	                        <div class="col-sm-12">                        
	                            <input name="product_id" type="text" value="'.$item['product_id'].'" class="form-control" />                   
	                        </div>
	                    </div>  
	                </div>
                </div>';
		return $html;
	}
	protected function generateFormRow($itemId=0){
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."megamenus_row Where id = $itemId");
		if(!$item) 
			$item = array(
				'id'			=>	0, 
				'module_id'		=>	0, 
				'menu_id'		=>	0, 
				'width'			=>	12, 
				'ordering'		=>	1, 
				'status'		=>	1, 
				'custom_class'	=>	'',
				'background'	=>	'',				
			);
		$langActive = '<input type="hidden" id="rowLanguageActive" value="0" />';
		$inputName = '';
		$languages = $this->getAllLanguage();
		if($languages){
			foreach ($languages as $key => $language) {				
				$itemLang = $this->getRowByLanguage($itemId, $language->id);				
				if($language->active == '1'){
					$langActive = '<input type="hidden" id="rowLanguageActive" value="'.$language->id.'" />';
					$inputName .= '<input type="text" value="'.$itemLang['name'].'" name="names[]" id="row_name_'.$language->id.'" class="form-control row-lang-'.$language->id.'" />';	
				}else{
					$inputName .= '<input type="text" value="'.$itemLang['name'].'" name="names[]" id="row_name_'.$language->id.'" class="form-control row-lang-'.$language->id.'" style="display:none" />';					
				}				
			}
		}
		$langOptions = $this->generateLanguageOption();
		$html = '<input type="hidden" name="id" value="'.$itemId.'" />';
		$html .= $langActive;
		$html .= '<input type="hidden" name="action" value="saveRow" />';
		$html .= '<input type="hidden" name="secure_key" value="'.$this->secure_key.'" />';
		$html .= 	'<div class="form-group">
						<label class="control-label col-sm-3">'.$this->l('Name').'</label>
						<div class="col-sm-9">
							<div class="col-sm-10">'.$inputName.'</div>
							<div class="col-sm-2">
								<select class="row-lang" onchange="rowChangeLanguage(this.value)">'.$langOptions.'</select>
							</div>								
						</div>
					</div>';
		$html .= 	'<div class="form-group">
	                    <label class="control-label col-sm-3">'.$this->l('Custom class').'</label>
					    <div class="col-sm-9">
	                        <div class="col-sm-12">
	                        	<input name="custom_class" type="text" value="'.$item['custom_class'].'" class="form-control" />
	                        </div>
	                    </div>
	                </div> ';
		$html .=	'<div class="form-group">
						<label class="control-label col-sm-3">'.$this->l('Width').'</label>
						<div class="col-sm-9">
							<div class="col-sm-12">
								<select class="form-control" name="width">'.$this->generateColOption($item['width']).'</select>
							</div>
						</div>
					</div>';
		$html .=	'<div class="form-group">
						<label class="control-label col-sm-3">'.$this->l('Background').'</label>
						<div class="col-sm-9">
							<div class="col-sm-12">
								<div class="input-group ">
									<input type="text" class="form-control" value="'.$item['background'].'" name="background" id="row-background" />
									<span class="input-group-btn"><button id="row-background-uploader" type="button" class="btn btn-default"><i class="icon-folder-open"></i></button></span>
								</div>
							</div>
						</div>
					</div>';					
		return $html;
	}
	protected function generateGroupProductList($productIds=array()){		
        if(!$productIds) return '';
        $result = '';
        $langId = Context::getContext()->language->id;
        foreach($productIds as $productId){
            if((int)$productId >0){
                $productName = Product::getProductName((int)$productId, null, $langId);
                if($productName){
                    $result .= '<li id="manual-product-'.$productId.'" class="manual-product">
                                    <input type="hidden" class="manual_product_id" name="product_ids[]" value="'.$productId.'" />
                                    <span>'.$productName.'</span>
                                    <a href="javascript:void(0)" title="'.$this->l('Delete').'" class="link-trash-manual-product c-red pull-right" data-id="'.$productId.'"><i class="icon-trash"></i></a>
                                </li>';    
                }
            }
		}
		return $result;
	}
	protected function generateFormGroup($id=0){		
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."megamenus_group Where id = $id");		
		$params = new stdClass();
		if(!$item){
			$item = array(
				'id'			=>	0, 
				'module_id'		=>	0, 
				'menu_id'		=>	0, 
				'row_id'		=>	0, 
				'display_title'	=>	1 ,
				'custom_class'	=>	'', 
				'type'			=>	'link', 
				'params'		=>	'', 
				'width'			=>	'12', 
				'status'		=>	1, 
				'ordering'		=>	1,
			);
            $params->product = new stdClass();	
            $params->product->category = 0;
           	$params->product->type = 'auto';
            $params->product->orderBy = 'position';
            $params->product->orderWay = 'asc';
            $params->product->onCondition = 'all';
            $params->product->onSale = 2;
            $params->product->onNew = 2;
            $params->product->onDiscount = 2;
            $params->product->maxCount = 3;
            $params->product->width = 4;
            $params->product->customWidth = 12;
            $params->product->ids = array();            
            $params->module = new stdClass();
            $params->module->name = '';
            $params->module->hook = '';            
            /*
			$params->productCategory = 0;
			$params->productType = 'auto';
            
			$params->productCount = 3;
			$params->productWidth = '4';
			$params->customWidth = '12';
			$params->productIds = array();
			$params->moduleName = '';
			$params->moduleId = 0;
			$params->hookName = '';
			$params->hookId = 0;
            */			
		}else{
			$params = json_decode($item['params']);
		}
		$langActive = '<input type="hidden" id="groupLanguageActive" value="0" />';
		$languages = $this->getAllLanguage();
		$inputTitle = '';
		$descriptions = '';
		if($languages){
			foreach ($languages as $key => $language){
				$itemLang = $this->_getgroupByLanguage($id, $language->id);
				if($language->active == '1'){
					$langActive = '<input type="hidden" id="groupLangActive" value="'.$language->id.'" />';
					$inputTitle .= '<input type="text" value="'.$itemLang['name'].'" name="names[]"  class="form-control group-lang-'.$language->id.'" />';
					$descriptions .= '<div class="group-lang-'.$language->id.'"><textarea class="editor" name="descriptions[]" id="description-'.$language->id.'">'.$itemLang['description'].'</textarea></div>';					
				}else{
					$inputTitle .= '<input type="text" value="'.$itemLang['name'].'" name="names[]" class="form-control group-lang-'.$language->id.'" style="display:none" />';					
					$descriptions .= '<div style="display:none" class="group-lang-'.$language->id.'"><textarea class="editor" name="descriptions[]" id="description-'.$language->id.'">'.$itemLang['description'].'</textarea></div>';
				}				
			}
		}
		$langOptions = $this->generateLanguageOption();
		$html = array();
		$html['config'] = '';
		$html['description'] = '';
		$html['config'] .= '<input type="hidden" name="id" value="'.$item['id'].'" />';
		$html['config'] .= $langActive;
		$html['config'] .= '<input type="hidden" name="action" value="saveGroup" />';
		$html['config'] .= '<input type="hidden" name="secure_key" value="'.$this->secure_key.'" />';
		$html['config'] .= '<div class="form-group">
								<label class="control-label col-sm-3 ">'.$this->l('Name').'</label>
								<div class="col-sm-9">
									<div class="col-sm-10">'.$inputTitle.'</div>
									<div class="col-sm-2">
										<select class="group-lang" onchange="groupChangeLanguage(this.value)">'.$langOptions.'</select>
									</div>
								</div>
							</div>';
		$html['description'] .= '<div class="form-group">
									<label class="control-label col-sm-3 ">'.$this->l('Description').'</label>
									<div class="col-sm-9">
										<div class="col-sm-10">'.$descriptions.'</div>
										<div class="col-sm-2">
											<select class="group-lang" onchange="groupChangeLanguage(this.value)">'.$langOptions.'</select>
										</div>
									</div>
								</div>';
		$html['config'] .= '<div class="form-group">
		                    	<label class="control-label col-sm-3">'.$this->l('Custom class CSS').'</label>
			                    <div class="col-sm-9">
			                        <div class="col-sm-10">
			                            <input type="text" value="'.$item['custom_class'].'" name="custom_class"  class="form-control" />
			                        </div>                        
			                    </div>				    
			                </div>';
		if($item['display_title'] == 1){
			$html['config'] .= '<div class="form-group">
				                    <label class="control-label col-sm-3">'.$this->l('Display name').'</label>
				                    <div class="col-sm-9">
				                        <div class="col-sm-5">
				                            <span class="switch prestashop-switch fixed-width-lg" id="group-display-title">
				                                <input type="radio" value="1" class="group_display_title" checked="checked" id="group_display_title_on" name="group_display_title" />
				            					<label for="group_display_title_on">Yes</label>
				            				    <input type="radio" value="0" class="group_display_title" id="group_display_title_off" name="group_display_title" />
				            					<label for="group_display_title_off">No</label>
				                                <a class="slide-button btn"></a>
				            				</span>
				                        </div>                        
				                    </div>				    
				                </div>';	
		}else{
			$html['config'] .= '<div class="form-group">
				                    <label class="control-label col-sm-3">'.$this->l('Display name').'</label>
				                    <div class="col-sm-9">
				                        <div class="col-sm-5">
				                            <span class="switch prestashop-switch fixed-width-lg" id="group-display-title">
				                                <input type="radio" value="1" class="group_display_title" id="group_display_title_off" name="group_display_title" />
				            					<label for="group_display_title_off">Yes</label>
				            				    <input type="radio" value="0" class="group_display_title" checked="checked" id="group_display_title_on" name="group_display_title" />
				            					<label for="group_display_title_on">No</label>
				                                <a class="slide-button btn"></a>
				            				</span>
				                        </div>                        
				                    </div>				    
				                </div>';
		}
		$html['config'] .= '<div class="form-group clearfix">
			                    <label class="control-label col-sm-3">'.$this->l('Group width').'</label>
			                    <div class="col-sm-9">
			                        <div class="col-sm-5">                        
			                            <select name="width" id="group-width" class="form-control">'.$this->generateColOption($item['width']).'</select>                       
			                        </div>
			                        <label class="control-label col-sm-2">'.$this->l('Data type').'</label>
			                        <div class="col-sm-5">                        
			                            <select name = "groupType" id="group-type" class="form-control" onchange="showGroupType(this.value)">'.$this->generateGroupTypeOption($item['type']).'</select>                        
			                        </div>
			                    </div>  
			                </div>';
		$html['config'] .= '<div id="group-type-module" style="display:'.($item['type'] == 'module' ? 'block' : 'none').'">                    
			                  	<div class="form-group clearfix">
				                    <label class="control-label col-sm-3">'.$this->l('Select module').'</label>
				                    <div class="col-sm-9">
				                        <div class="col-sm-5">                        
				                            <select name="module" id="module" onchange="loadModuleHooks(this.value, \'group-hook\')" class="form-control">'.'<option value="">['.$this->l('Select module').']</option>'.$this->generateModuleOption($params->module->name).'</select>                       
				                        </div>
				                        <label class="control-label col-sm-2">'.$this->l('Select hook').'</label>
				                        <div class="col-sm-5">                        
				                            <select name = "hook" id="group-hook" class="form-control">'.'<option value="">['.$this->l('Select hook').']</option>'.$this->generateHookModuleOption($params->module->name, $params->module->hook).'</select>                        
				                        </div>
				                    </div>  
				                </div>
			                </div>';
		$html['config'] .= '<div id="group-type-product" style="display:'.($item['type'] == 'product' ? 'block' : 'none').'">
			                    <div class="form-group clearfix">
			                        <label class="control-label col-sm-3">'.$this->l('Category').'</label>
			                        <div class="col-sm-9">
			                            <div class="col-sm-8">                        
			                                <select name="groupProductCategory" id="group-product-category" class="form-control">'.$this->generateCategoryOption($params->product->category).'</select>                       
			                            </div>
			                            <div class="col-sm-4">
			                                <select name="groupProductType" id="group-product-type" class="form-control" onchange="showProductOption(this.value)">'.$this->generateProductTypeOption($params->product->type).'</select>
			                            </div>                        
			                        </div>  
			                    </div>
			                    <div class="form-group clearfix">
			                        <label class="control-label col-sm-3">'.$this->l('Item width').'</label>
			                        <div class="col-sm-9">
			                            <div class="col-sm-5">                        
			                                <select name="groupProductWidth" id="item-width" class="form-control">'.$this->generateColOption($params->product->width).'</select>                       
			                            </div>
			                            <label class="control-label col-sm-2 group-product-type-auto">'.$this->l('Max item').'</label>
			                            <div class="col-sm-5 group-product-type-auto">
											<input type="text" name="maxItem" value="'.$params->product->maxCount.'" class="form-control" />
										</div>                        
			                        </div>  
			                    </div>                    
			                    <div id="group-product-type-auto" class="group-product-type-auto" style="display:'.($params->product->type != 'manual' ? 'block' : 'none').'">
			                        <div class="form-group">
			                            <label class="control-label col-sm-3">'.$this->l('Only Sale').'</label>
			                            <div class="col-sm-9">
			                                <div class="col-sm-5">                        
			                                    <select name="on_sale">'.$this->generateProductOnSaleOption($params->product->onSale).'</select>                       
			                                </div>
			                                <label class="control-label col-sm-2">'.$this->l('Only New').'</label>
			                                <div class="col-sm-5">
			    								<select name="on_new">'.$this->generateProductOnNewOption($params->product->onNew).'</select>
			    							</div>                        
			                            </div>																																				
									</div>
			                        <div class="form-group">
			                            <label class="control-label col-sm-3">'.$this->l('Only Discount').'</label>
			                            <div class="col-sm-9">
			                                <div class="col-sm-5">                        
			                                    <select name="on_discount">'.$this->generateProductOnDiscountOption($params->product->onDiscount).'</select>                       
			                                </div>
			                                <label class="control-label col-sm-2">'.$this->l('Only condition').'</label>
			                                <div class="col-sm-5">
			    								<select name="on_condition">'.$this->generateProductOnConditionOption($params->product->onCondition).'</select>
			    							</div>                        
			                            </div>							
																															
									</div>
									<div class="form-group">
			                            <label class="control-label col-sm-3">'.$this->l('Order by').'</label>
			                            <div class="col-sm-9">
			                                <div class="col-sm-5">                        
			                                    <select name="order_by">'.$this->generateProductOrderByOption($params->product->orderBy).'</select>                       
			                                </div>
			                                <label class="control-label col-sm-2">'.$this->l('Order way').'</label>
			                                <div class="col-sm-5">
			    								<select name="order_way">'.$this->generateProductOrderWayOption($params->product->orderWay).'</select>
			    							</div>                        
			                            </div>                            								
									</div>                        
			                    </div>
			                    
			                    <div id="group-product-type-manual" class="group-product-type-manual" style="display:'.($params->product->type == 'manual' ? 'block' : 'none').'">
			                        <div class="form-group">
			                            <label class="control-label col-sm-3">'.$this->l('Product list').'</label>
										<div class="col-sm-9">
											<div class="col-sm-12 "><label class="control-label"><a href="javascript:void(0)" class="link-open-dialog-manual-product" onClick="showModal(\'dialog-product-list\');" data-group="'.$id.'" onclick="openProductsModal(\''.$id.'\')">'.$this->l('add product').'</a></label></div>
											<div class="col-sm-12 ">
												<ul id="manual-product-list" class="manual-product-list">'.$this->generateGroupProductList($params->product->ids).'</ul>
											</div>
										</div>
									</div>                    
			                    </div>
			                </div>';
		return $html;
	}
	 
	
	protected function generateFormMenuItem($id = 0){
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."megamenus_menuitem Where id = $id");		
		if(!$item) 
			$item = array(
				'id'			=>	0,
				'parent_id'		=>	0, 
				'module_id'		=>	0, 
				'menu_id'		=>	0, 
				'row_id'		=>	0, 
				'group_id'		=>	0, 
				'menu_type'		=>	'link', 
				'link_type'		=>	'CUSTOMLINK|0', 
				'link'			=>	'', 
				'module_name'	=>	'', 
				'hook_name'		=>	'', 
				'product_id'	=>	0, 
				'display_name'	=>	1, 
				'status'		=>	1, 
				'custom_class'	=>	'',
				'icon'			=>	'',
				'icon_active'	=>	'', 
				'ordering'		=>	1,
			);		
		$langActive = '<input type="hidden" id="menuItemLanguageActive" value="0" />';
		$languages = $this->getAllLanguage();
		$inputTitle = '';
		$inputLinks = '';
		$inputImage = '';
		$inputImageAlt = '';
		$inputHtml = '';
		if($languages){
			foreach ($languages as $key => $language) {				
				$itemLang = $this->getMenuItemByLanguage($id, $language->id);
				if($language->active == '1'){
					$langActive = '<input type="hidden" id="menuItemLanguageActive" value="'.$language->id.'" />';
					$inputTitle .= '<input type="text" value="'.$itemLang['name'].'" name="names[]"  class="form-control menu-item-lang-'.$language->id.'" />';
					$inputLinks .= '<input type="text" value="'.$itemLang['link'].'" name="links[]"  class="form-control menu-item-lang-'.$language->id.'" />';
					$inputImage .= '<input type="text" value="'.$itemLang['image'].'" name="images[]" id="menuItemImage-'.$language->id.'" class="form-control menu-item-lang-'.$language->id.'"  />';
					$inputImageAlt .= '<input type="text" value="'.$itemLang['imageAlt'].'" name="alts[]" class="form-control menu-item-lang-'.$language->id.'" />';
					$inputHtml .= '<div class="menu-item-lang-'.$language->id.'"><textarea class="editor" name="htmls[]" id="memu-item-custom-html-'.$language->id.'">'.$itemLang['html'].'</textarea></div>';
				}else{
					$inputTitle .= '<input type="text" value="'.$itemLang['name'].'" name="names[]"  class="form-control menu-item-lang-'.$language->id.'" style="display:none" />';
					$inputLinks .= '<input type="text" value="'.$itemLang['link'].'" name="links[]"  class="form-control menu-item-lang-'.$language->id.'" style="display:none" />';
					$inputImage .= '<input type="text" value="'.$itemLang['image'].'" name="images[]" id="menuItemImage-'.$language->id.'" class="form-control menu-item-lang-'.$language->id.'"  style="display:none" />';
					$inputImageAlt .= '<input type="text" value="'.$itemLang['imageAlt'].'" name="alts[]" class="form-control menu-item-lang-'.$language->id.'" style="display:none" />';
					$inputHtml .= '<div style="display:none" class="menu-item-lang-'.$language->id.'"><textarea class="editor" name="htmls[]" id="memu-item-custom-html-'.$language->id.'">'.$itemLang['html'].'</textarea></div>';					
				}				
			}
		}
		$langOptions = $this->generateLanguageOption();
		$html = '';
		$html .= '<input type="hidden" name="id" value="'.$item['id'].'" />';		
		$html .= $langActive;
		$html .= '<input type="hidden" name="action" value="saveMenuItem" />';	
		$html .= '<input type="hidden" name="secure_key" value="'.$this->secure_key.'" />';
		$html .= '<div class="form-group">
                    <label class="control-label col-sm-2">'.$this->l('Name').'</label>
				    <div class="col-sm-10">
                        <div class="col-sm-10">'.$inputTitle.'</div>
                        <div class="col-sm-2">
                            <select class="menu-item-lang" onchange="menuItemChangeLanguage(this.value)">'.$langOptions.'</select>
                        </div>                                                                        
                    </div>
                </div> ';
		$html .= 	'<div class="form-group">
	                    <label class="control-label col-sm-2">'.$this->l('Icon').'</label>
					    <div class="col-sm-10">
	                        <div class="col-sm-5">
	                        	<div class="input-group">
									<input type="text" class="form-control" value="'.$item['icon'].'" name="icon" id="menuitem-icon" />
									<span class="input-group-btn">
										<button id="menuitem-icon-uploader" type="button" class="btn btn-default">
											<i class="icon-folder-open"></i>
										</button>
									</span>
								</div>
	                        </div>
	                    	<label class="control-label col-sm-2">'.$this->l('Icon active').'</label>    
	                        <div class="col-sm-5">
	                        	<div class="input-group">
									<input type="text" class="form-control" value="'.$item['icon_active'].'" name="icon_active" id="menuitem-icon-active" />
									<span class="input-group-btn">
										<button id="menuitem-icon-active-uploader" type="button" class="btn btn-default">
											<i class="icon-folder-open"></i>
										</button>
									</span>
								</div>
	                        </div>
	                    </div>
	                </div> ';
		if($item['display_name'] == 1){
			$html .= '<div class="form-group">
					<label class="control-label col-sm-2 ">'.$this->l('Custom class').'</label>                    
                    <div class="col-sm-10">
                    	<div class="col-sm-5">                        
                            <input name="custom_class" type="text" value="'.$item['custom_class'].'" class="form-control" />
                        </div>                        
                        <label class="control-label col-sm-2">'.$this->l('Display name').'</label>
                        <div class="col-sm-3">
                            <span class="switch prestashop-switch fixed-width-lg" id="item-display-name">
                                <input type="radio" value="1" class="item_display_name" checked="checked" id="item_display_name_on" name="item_display_name" />
            					<label for="item_display_name_on">Yes</label>
            				    <input type="radio" value="0" class="item_display_name" id="item_display_name_off" name="item_display_name" />
            					<label for="item_display_name_off">No</label>
                                <a class="slide-button btn"></a>
            				</span>
                        </div>
                        
                        
                    </div>				    
                </div>';	
		}else{
			$html .= 	'<div class="form-group">
							<label class="control-label col-sm-2 ">'.$this->l('Custom class').'</label>                    
		                    <div class="col-sm-10">
		                    	<div class="col-sm-5">                        
		                            <input name="custom_class" type="text" value="'.$item['custom_class'].'" class="form-control" />                        
		                        </div>
		                        <label class="control-label col-sm-2">'.$this->l('Display name').'</label>
		                        <div class="col-sm-3">                        
		                            <span class="switch prestashop-switch fixed-width-lg" id="item-display-name">
		                                <input type="radio" value="1" class="item_display_name" id="item_display_name_off" name="item_display_name" />
		            					<label for="item_display_name_off">Yes</label>
		            				    <input type="radio" value="0" class="item_display_name" checked="checked" id="item_display_name_on" name="item_display_name" />
		            					<label for="item_display_name_on">No</label>
		                                <a class="slide-button btn"></a>
		            				</span>
		                        </div>                                                
		                    </div>				    
		                </div>';
		}
		
		$html .= '<div class="form-group clearfix">
                    <label class="control-label col-sm-2">'.$this->l('Select Link').'</label>
                    <div class="col-sm-10">
                        <div class="col-sm-5">                        
                            <select name="link_type" class="form-control" onchange="changeLinkType_MenuItem(this.value)">'.$this->generateAllLinkOptions($item['link_type']).'</select>                        
                        </div> 
                        <label class="control-label col-sm-2 ">'.$this->l('Menu type').'</label>	                    
                        <div class="col-sm-5">                        
                            <select name="menu_type" id="menu-item-type" class="form-control" onchange="showItemContentByType(this.value)">'.$this->generateMenuTypeOption($item['menu_type']).'</select>                   
                        </div>                        
	                                        
                    </div>  
                </div>';
		$html .= '<div class="menu-item-link-type-custom" style="display:'.($item['link_type'] == 'CUSTOMLINK|0' ? 'block' : 'none').'">
                  	<div class="form-group clearfix">
	                    <label class="control-label col-sm-2 ">'.$this->l('Url').'</label>
	                    <div class="col-sm-10">
	                        <div class="col-sm-10">'.$inputLinks.'</div>
	                        <div class="col-sm-2">
	                            <select class="menu-item-lang" onchange="menuItemChangeLanguage(this.value)">'.$langOptions.'</select>
	                        </div>
	                    </div>  
	                </div>
                </div>';
		$html .= '<div class="menu-item-link-type-product" style="display:'.($item['link_type'] == 'PRODUCT|0' ? 'block' : 'none').'">
                  	<div class="form-group clearfix">
	                    <label class="control-label col-sm-2 ">'.$this->l('Product Id').'</label>
	                    <div class="col-sm-10">
	                        <div class="col-sm-7">                        
	                            <input name="product_id" type="text" id="menu-item-product-id" value="'.$item['product_id'].'" class="form-control" />                   
	                        </div>
	                    </div>  
	                </div>
                </div>';
		$html .= '<div class="item-type-module" style="display:'.($item['menu_type'] == 'module' ? 'block' : 'none').'">
                  	<div class="form-group clearfix">
	                    <label class="control-label col-sm-2">'.$this->l('Select module').'</label>
	                    <div class="col-sm-10">
	                        <div class="col-sm-7">                        
	                            <select name="module_name" id="item-menu-module" onchange="loadModuleHooks(this.value, \'item-menu-hook\')" class="form-control">'.'<option value="">['.$this->l('Select module').']</option>'.$this->generateModuleOption($item['module_name']).'</select>                       
	                        </div>
	                        <label class="control-label col-sm-2">'.$this->l('Select hook').'</label>
	                        <div class="col-sm-3">                        
	                            <select name = "hook_name" id="item-menu-hook" class="form-control">'.'<option value="">['.$this->l('Select hook').']</option>'.$this->generateHookModuleOption($item['module_name'], $item['hook_name']).'</select>                        
	                        </div>
	                    </div>  
	                </div>
                </div>';
		$html .= '<div class="item-type-image" style="display:'.($item['menu_type'] == 'image' ? 'block' : 'none').'">
                    <div class="form-group clearfix">
                        <label class="control-label col-sm-2 ">'.$this->l('Image').'</label>
                        <div class="col-sm-10">
                            <div class="col-sm-10"> 
                                <div class="input-group">
                                    '.$inputImage.'
                                    <span class="input-group-btn">
                                        <button id="menu-item-image-uploader" type="button" class="btn btn-default"><i class="icon-folder-open"></i></button>
                                    </span>
                                </div>
                            </div> 
                            <div class="col-sm-2">
                                <select class="menu-item-lang" onchange="menuItemChangeLanguage(this.value)">'.$langOptions.'</select>
                            </div>             
                        </div>  
                    </div>
                    <div class="form-group clearfix">
                        <label class="control-label col-sm-2">'.$this->l('Image Alt').'</label>
                        <div class="col-sm-10">    
                            <div class="col-sm-10">
                                '.$inputImageAlt.'
                            </div>
                            <div class="col-sm-2">
                                <select class="menu-item-lang" onchange="menuItemChangeLanguage(this.value)">'.$langOptions.'</select>
                            </div>
                        </div>  
                    </div>
                </div>';
			$html .= '<div class="item-type-html" style="display:'.($item['menu_type'] == 'html' ? 'block' : 'none').'">
                    <div class="form-group clearfix">
                        <label class="control-label col-sm-2 ">'.$this->l('Custom HTML').'</label>
                        <div class="col-sm-10">
                            <div class="col-sm-10">
                                '.$inputHtml.'
                            </div>
                            <div class="col-sm-2">
                                <select class="menu-item-lang" onchange="menuItemChangeLanguage(this.value)">'.$langOptions.'</select>
                            </div>
                        </div>  
                    </div>
                    
                </div>';			
		return $html;
	}
	protected function generateFormSubMenuItem($id = 0){
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."megamenus_menuitem Where id = $id");		
		if(!$item) 
			$item = array(
				'id'			=>	0,
				'parent_id'		=>	0, 
				'module_id'		=>	0, 
				'menu_id'		=>	0, 
				'row_id'		=>	0, 
				'group_id'		=>	0, 
				'menu_type'		=>	'link', 
				'link_type'		=>	'CUSTOMLINK|0', 
				'link'			=>	'', 
				'module_name'	=>	'', 
				'hook_name'		=>	'', 
				'product_id'	=>	0, 
				'display_name'	=>	1, 
				'status'		=>	1, 
				'custom_class'	=>	'',
				'icon'			=>	'',
				'icon_active'	=>	'', 
				'ordering'		=>	1,
			);		
		$langActive = '<input type="hidden" id="subMenuItemLanguageActive" value="0" />';
		$languages = $this->getAllLanguage();
		$inputTitle = '';
		$inputLinks = '';
		$inputImage = '';
		$inputImageAlt = '';
		$inputHtml = '';
		if($languages){
			foreach ($languages as $key => $language) {				
				$itemLang = $this->getMenuItemByLanguage($id, $language->id);
				if($language->active == '1'){
					$langActive = '<input type="hidden" id="subMenuItemLanguageActive" value="'.$language->id.'" />';
					$inputTitle .= '<input type="text" value="'.$itemLang['name'].'" name="names[]"  class="form-control submenu-item-lang-'.$language->id.'" />';
					$inputLinks .= '<input type="text" value="'.$itemLang['link'].'" name="links[]"  class="form-control submenu-item-lang-'.$language->id.'" />';					
				}else{
					$inputTitle .= '<input type="text" value="'.$itemLang['name'].'" name="names[]"  class="form-control submenu-item-lang-'.$language->id.'" style="display:none" />';
					$inputLinks .= '<input type="text" value="'.$itemLang['link'].'" name="links[]"  class="form-control submenu-item-lang-'.$language->id.'" style="display:none" />';									
				}				
			}
		}
		$langOptions = $this->generateLanguageOption();
		$html = '';
		$html .= '<input type="hidden" name="id" value="'.$item['id'].'" />';		
		$html .= $langActive;
		$html .= '<input type="hidden" name="action" value="saveSubMenuItem" />';	
		$html .= '<input type="hidden" name="secure_key" value="'.$this->secure_key.'" />';
		$html .= '<div class="form-group">
                    <label class="control-label col-sm-2">'.$this->l('Name').'</label>
				    <div class="col-sm-10">
                        <div class="col-sm-10">'.$inputTitle.'</div>
                        <div class="col-sm-2">
                            <select class="submenu-item-lang" onchange="subMenuItemChangeLanguage(this.value)">'.$langOptions.'</select>
                        </div>                                                                        
                    </div>
                </div> ';
		$html .= 	'<div class="form-group">
	                    <label class="control-label col-sm-2">'.$this->l('Icon').'</label>
					    <div class="col-sm-10">
	                        <div class="col-sm-5">
	                        	<div class="input-group">
									<input type="text" class="form-control" value="'.$item['icon'].'" name="icon" id="sub-menuitem-icon" />
									<span class="input-group-btn">
										<button id="sub-menuitem-icon-uploader" type="button" class="btn btn-default">
											<i class="icon-folder-open"></i>
										</button>
									</span>
								</div>
	                        </div>
	                    	<label class="control-label col-sm-2">'.$this->l('Icon active').'</label>    
	                        <div class="col-sm-5">
	                        	<div class="input-group">
									<input type="text" class="form-control" value="'.$item['icon_active'].'" name="icon_active" id="sub-menuitem-icon-active" />
									<span class="input-group-btn">
										<button id="sub-menuitem-icon-active-uploader" type="button" class="btn btn-default">
											<i class="icon-folder-open"></i>
										</button>
									</span>
								</div>
	                        </div>
	                    </div>
	                </div> ';
		
		$html .= '<div class="form-group">
				<label class="control-label col-sm-2 ">'.$this->l('Custom class').'</label>                    
                <div class="col-sm-10">
                	<div class="col-sm-5">                        
                        <input name="custom_class" type="text" value="'.$item['custom_class'].'" class="form-control" />
                    </div>                        
                    <label class="control-label col-sm-2">'.$this->l('Select Link').'</label>
                    <div class="col-sm-5">
                    	<select name="link_type" class="form-control" onchange="changeLinkType_SubMenuItem(this.value)">'.$this->generateAllLinkOptions($item['link_type']).'</select>
                    </div>                                        
                </div>				    
            </div>';				
		$html .= '<div class="submenu-item-link-type-custom" style="display:'.($item['link_type'] == 'CUSTOMLINK|0' ? 'block' : 'none').'">
                  	<div class="form-group clearfix">
	                    <label class="control-label col-sm-2 ">'.$this->l('Url').'</label>
	                    <div class="col-sm-10">
	                        <div class="col-sm-10">'.$inputLinks.'</div>
	                        <div class="col-sm-2">
	                            <select class="menu-item-lang" onchange="menuItemChangeLanguage(this.value)">'.$langOptions.'</select>
	                        </div>
	                    </div>  
	                </div>
                </div>';
		$html .= '<div class="submenu-item-link-type-product" style="display:'.($item['link_type'] == 'PRODUCT|0' ? 'block' : 'none').'">
                  	<div class="form-group clearfix">
	                    <label class="control-label col-sm-2 ">'.$this->l('Product Id').'</label>
	                    <div class="col-sm-10">
	                        <div class="col-sm-7">                        
	                            <input name="product_id" type="text" id="menu-item-product-id" value="'.$item['product_id'].'" class="form-control" />                   
	                        </div>
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
	
	public function getContent(){
				
		// foreach($this->arrHook as $hook)
			// $this->registerHook($hook);
		//$this->registerHook('displayMegamenuLeft');
		//$this->registerHook('displayMegamenuRight');
						
		$action = Tools::getValue('action', 'view');
		if($action == 'view'){
			$this->context->controller->addJquery();
			$this->context->controller->addJQueryUI('ui.sortable');
			$this->context->controller->addjQueryPlugin(array('tablednd','colorpicker', 'chosen'));
			$this->context->controller->addJS(array(
				$this->_path.'js/admin/common.js',
				$this->_path.'js/admin/ajaxupload.3.5.js',
				$this->_path.'js/admin/jquery.serialize-object.min.js',				
				$this->_path.'js/admin/tinymce.inc.js',
				_PS_JS_DIR_.'tiny_mce/tiny_mce.js',
			));
	        $this->context->controller->addCSS(($this->_path).'css/admin/style.css');	       
	        $langId = $this->context->language->id;
	        $shopId = $this->context->shop->id;
			$sql = "Select m.*, ml.name 
				From "._DB_PREFIX_."megamenus_module AS m 
				Left Join "._DB_PREFIX_."megamenus_module_lang AS ml 
					On ml.module_id = m.id 
				Where 
					m.id_shop = ".$shopId." AND 
					ml.id_lang = ".$langId." Order By m.ordering";				
	        $items = Db::getInstance()->executeS($sql);			
	        $listModule = '';
	        if($items){
	            foreach($items as &$item){	            	
	            	$item['layout_value'] = $this->arrLayout[$item['layout']];	                
	            }
	        }
	        $this->context->smarty->assign(array(
	            'baseModuleUrl'		=> 	__PS_BASE_URI__.'modules/'.$this->name,
	            'currentUrl'		=>	$this->getCurrentUrl(),
	            'moduleId'			=>	$this->id,
	            'langId'			=>	$langId,
	            'iso'				=>	$this->context->language->iso_code,
	            'ad'				=>	$ad = dirname($_SERVER["PHP_SELF"]),
	            'listModule'		=>	$listModule,	            
	            'secure_key'		=>	$this->secure_key,
	            'formMegamenu' 		=> 	$this->generateFormMegamenu(),
	            'formMenu' 			=> 	$this->generateFormMenu(),
	            'formSubMenu' 		=> 	$this->generateFormSubMenu(),
	            'formRow' 			=> 	$this->generateFormRow(),
	            'formGroup'			=>	$this->generateFormGroup(),
	            'formMenuItem'		=>	$this->generateFormMenuItem(),
	            'formSubMenuItem'	=>	$this->generateFormSubMenuItem(),	            
				'items'				=>	$items, 
                'dialog_product'    =>  dirname(__FILE__).'/views/templates/admin/dialog.product.tpl',
	        ));
			return $this->display(__FILE__, 'views/templates/admin/megamenus.tpl');            
        }else if($action == 'data-export'){
        	$this->exportSameData();			
			echo "export OK";
			die;
		}elseif($action == 'data-import'){
			$this->importSameData();
			echo "import OK";
			die; 	
		}else{
			if(method_exists ($this, $action)){			 
				$this->$action();
			}else{
				$response = new stdClass();
				if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
		            $response->status = 0;
            		$response->msg = $this->l("Method ".$action."() not found!.");
					die(Tools::jsonEncode($response));
		        }else{
		        	die($this->l("Method ".$action."() not found!."));
		        }
			}			
		}
		
	}


	public function loadModuleHooks(){
		$response = '';
		$moduleName = Tools::getValue('moduleName', '');		
		if($moduleName == '') 
            $response = '<option value="">['.$this->l('Select hook').']</option>';
		else{
			
			
			$response = '<option value="">['.$this->l('Select hook').']</option>'.$this->generateHookModuleOption($moduleName);
		}
			
        
        //if(!$response) $response = '<option value="">['.$this->l('Select hook').']</option>';
		die(Tools::jsonEncode($response));
	}
    public function saveMegamenu(){    	
        $response = new stdClass();
        $shopId = Context::getContext()->shop->id;
		$languages = $this->getAllLanguage();
        $itemId = intval($_POST['id']);
		$names = $_POST['names'];
		$position_name = Tools::getValue('position_name', 'displayVerticalMenu');		
        $layout = Tools::getValue('layout', 'vertical_left');
        $show_count = Tools::getValue('show_count', 10);
		$display_name = Tools::getValue('module_display_name', 1);
		$custom_class = Tools::getValue('custom_class', '');
		$params = '';       
		$themeId = (int)$this->context->shop->id_theme;
		$theme = new Theme($themeId);
		$optionDirectory = Configuration::get('CURRENT_OPTION_DIR') ?  Configuration::get('CURRENT_OPTION_DIR') : '';
        		
        if($itemId == 0){
        	$sql = "Select MAX(ordering) 
        		From "._DB_PREFIX_."megamenus_module 
        		Where 
        			`theme_directory` = '".$theme->directory."' AND 
        			`option_directory` = '".$optionDirectory."' AND 
        			`position_name`='".$position_name."'";
            
			$maxOrdering = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
		   	if($maxOrdering >0) $maxOrdering++;
		   	else $maxOrdering = 1;
			$insertData = array(
				'id_shop'			=>	$shopId,
				'theme_directory'	=> 	$theme->directory,
				'option_directory'	=> 	$optionDirectory,
				'position_name'		=> 	$position_name,
				'layout'			=>	$layout,
				'display_name'		=>	$display_name,
				'show_count'		=>	$show_count,
				'ordering'			=>	$maxOrdering,
				'status'			=>	1,
				'params'			=>	$params,
				'custom_class'		=>	$custom_class,				
			);
            if(Db::getInstance()->insert('megamenus_module', $insertData)){
                $insertId = Db::getInstance()->Insert_ID();
				if($languages){
                	$insertLanguageDatas = array();
                	foreach($languages as $index=>$language){
						$insertLanguageDatas[] = array('module_id'=>$insertId, 'id_lang'=>$language->id, 'name'=>pSQL($names[$index], true));                   		                
                	}
					if($insertLanguageDatas) Db::getInstance()->insert('megamenus_module_lang', $insertLanguageDatas);
                }                
                $response->status = '1';
                $response->msg = $this->l('Add new megamenu success!');
				$this->clearCache();
            }else{
                $response->status = '0';
                $response->msg = $this->l('Add new megamenu not Success!');
            }
        }else{
            $item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."megamenus_module Where id = ".$itemId);
			//Db::getInstance()->update($table, $data)
			$updateData = array(
				'position_name'	=>$position_name,
				'layout'		=>$layout,
				'display_name'	=>$display_name,
				'show_count'	=>$show_count,
				'params'		=>$params,
				'custom_class'	=>$custom_class,
			);
			Db::getInstance()->update('megamenus_module', $updateData, "id='$itemId'");
            /*
            Db::getInstance()->execute("Update "._DB_PREFIX_."megamenus_module 
            	Set 
            		`layout`='".$layout."', 
            		`show_count`='".$show_count."', 
            		`display_name`='".$display_name."', 
            		`custom_class`='".$custom_class."', 
            		`params` = '".$params."' 
            	Where 
            		id = ".$itemId);
			
            Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_module_position Where `module_id` = ".$itemId);
			if($positions){
				$insertModuleHook = array();
				foreach($positions as $position){						
					$insertModuleHook[] = array('module_id'=>$itemId, 'position_id'=>$position, 'position_name'=>Hook::getNameById($position));
				}
				if($insertModuleHook) Db::getInstance()->insert('megamenus_module_position', $insertModuleHook);
			}
            */
            $defaultName = '';            
			if($languages){			    
				$insertDatas = array();            	
            	foreach($languages as $index=>$language){
            		$name = pSQL($names[$index]);
            		if(!$defaultName) $defaultName = $name;
            		if(!$name) $name = $defaultName;
            		$check = Db::getInstance()->getValue("Select module_id From "._DB_PREFIX_."megamenus_module_lang Where module_id = $itemId AND id_lang = ".$language->id);
            		if($check){
            			Db::getInstance()->execute("Update "._DB_PREFIX_."megamenus_module_lang Set `name` = '".$name."' Where `module_id` = ".$itemId." AND `id_lang` = ".$language->id);	
            		}else{
            			$insertDatas[] = array('module_id'=>$itemId, 'id_lang'=>$language->id, 'name'=>$name);
            		}
					
            	}
            	if($insertDatas) Db::getInstance()->insert('megamenus_module_lang', $insertDatas);
            }            
            $response->status = '1';
            $response->msg = $this->l('Update megamenu success!');
			$this->clearCache();
        }
        die(Tools::jsonEncode($response));
    }
	public function saveMenu(){
		$languages = $this->getAllLanguage();
		$megamenuId = intval($_POST['megamenuId']);
        $itemId = intval($_POST['id']);    
		$names = Tools::getValue('names', array());	
		$links = Tools::getValue('links', array());	
		$custom_class = Tools::getValue('custom_class', '');
		$display_name = Tools::getValue('menu_display_name', 1);		
		$linkType = Tools::getValue('link_type', 'CUSTOMLINK|0');
		$product_id = Tools::getValue('product_id', 0);
		$icon = Tools::getValue('icon', '');//$_POST['icon'];
		$icon_active = Tools::getValue('icon_active', '');//$_POST['icon_active'];
		$background = Tools::getValue('background', '');
		$parent_id = Tools::getValue('parent_id', 0);
		$width = Tools::getValue('width', 0);
		$response = new stdClass();
		
        if($megamenuId >0){
        	$defaultName = '';            
            if($itemId == 0){				
				$maxOrdering = Db::getInstance()->getValue("Select MAX(ordering) From "._DB_PREFIX_."megamenus_menu Where `module_id` = ".$megamenuId);
		   		if($maxOrdering >0) $maxOrdering++;
		   		else $maxOrdering = 1;
				$arrInsert = array(
					'parent_id'		=>	$parent_id,
					'module_id'		=>	$megamenuId,
					'display_name'	=>	$display_name,
					'link_type'		=>	$linkType,
					'custom_class'	=>	$custom_class,
					'product_id'	=>	$product_id,
					'width'			=>	$width,
					'status'		=>	1,
					'icon'			=>	'',
					'icon_active'	=>	'',
					'ordering'		=>	$maxOrdering,
					
				);				
				if($background){
					if(strpos($background, '.') === false){
						$arrInsert['background'] = $background;
					}else{
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
				}
				if($icon){
					if(strpos($icon, '.') === false){
						$arrInsert['icon'] = $icon;
					}else{
						if(strpos($icon, 'http') !== false){
							$arrInsert['icon'] = $icon;
						}else{
							if(file_exists($this->pathImage.'temps/'.$icon)){
								if(copy($this->pathImage.'temps/'.$icon, $this->pathImage.'icons/'.$icon)){
									$arrInsert['icon'] = $icon;
								}
								unlink($this->pathImage.'temps/'.$icon);
							}	
						}	
					}
				}				
                if($icon_active){
                	if(strpos($icon_active, '.') === false){
                		$arrInsert['icon_active'] = $icon_active;
					}else{
						if(strpos($icon_active, 'http') !== false){
							$arrInsert['icon_active'] = $icon_active;
						}else{
							if(file_exists($this->pathImage.'temps/'.$icon_active)){
								if(copy($this->pathImage.'temps/'.$icon_active, $this->pathImage.'icons/'.$icon_active)){
									$arrInsert['icon_active'] = $icon_active;
								}
								unlink($this->pathImage.'temps/'.$icon_active);
							}		
						}	
					}
                	
                }
				//if(Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("Insert Into "._DB_PREFIX_."megamenus_menu (".$fields.") Values (".$values.")")){				
                if(Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_menu', $arrInsert)){
                    $insertId = Db::getInstance(_PS_USE_SQL_SLAVE_)->Insert_ID();
					if($languages){
	                	$insertDatas = array();						
	                	foreach($languages as $index=>$language){
	                		if(!$defaultName) $defaultName = pSQL($names[$index]);
							$name = pSQL($names[$index]);
							if(!$name) $name = $defaultName; 
			                $insertDatas[] = array('menu_id'=>$insertId, 'id_lang'=>$language->id, 'name'=>$name, 'link'=>pSQL($links[$index]));
	                	}
						if($insertDatas) Db::getInstance()->insert('megamenus_menu_lang', $insertDatas);
	                }
                    $response->status = '1';
                    $response->msg = $this->l("Add new Menu Success!");
                }else{
                    $response->status = '0';
                    $response->msg = $this->l("Add new Menu not Success!");
                }
            }else{
                $item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."megamenus_menu Where id = ".$itemId);
                //$fields = "`link_type` = '".$linkType."', `custom_class`='".$custom_class."', `display_name`='".$display_name."', `width`='".$width."', `product_id` = '".$product_id."'";
                $arrUpdate = array(
                	'background'	=>	$item['background'],
					'link_type'		=> 	$linkType,
					'custom_class'	=>	$custom_class,
					'product_id'	=>	$product_id,
					'width'			=>	$width,
					'display_name'	=>	$display_name,
					'icon'			=>	$item['icon'],
					'icon_active'	=>	$item['icon_active'],
				);
				if($background){
					if(strpos($background, '.') === false){
						$arrUpdate['background'] = $background;
						if($item['background'] && file_exists($this->pathImage.$item['background'])) unlink($this->pathImage.$item['background']);
					}else{
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
					}					
				}else{
					$arrUpdate['background'] = '';
					if($item['background'] && file_exists($this->pathImage.$item['background'])) unlink($this->pathImage.$item['background']);
				}
				if($icon){
					if(strpos($icon, '.') === false){
						$arrUpdate['icon'] = $icon;
						if($item['icon'] && file_exists($this->pathImage.'icons/'.$item['icon'])) unlink($this->pathImage.'icons/'.$item['icon']);
					}else{
						if(strpos($icon, 'http') !== false){
							$arrUpdate['icon'] = $icon;
							if($item['icon'] && file_exists($this->pathImage.'icons/'.$item['icon'])) unlink($this->pathImage.'icons/'.$item['icon']);
						}else{
							if(file_exists($this->pathImage.'temps/'.$icon)){
								if(copy($this->pathImage.'temps/'.$icon, $this->pathImage.'icons/'.$icon)){
									$arrUpdate['icon'] = $icon;
									if($item['icon'] && file_exists($this->pathImage.'icons/'.$item['icon'])) unlink($this->pathImage.'icons/'.$item['icon']);
								}
								unlink($this->pathImage.'temps/'.$icon);
							}
						}	
					}					
				}else{
					$arrUpdate['icon'] = '';
					if($item['icon'] && file_exists($this->pathImage.'icons/'.$item['icon'])) unlink($this->pathImage.'icons/'.$item['icon']);
				}
				
				if($icon_active){
					if(strpos($icon_active, '.') === false){
						$arrUpdate['icon_active'] = $icon_active;
						//$fields .= ", `icon_active`='".$icon_active."'";
						if($item['icon_active'] && file_exists($this->pathImage.'icons/'.$item['icon_active'])) unlink($this->pathImage.'icons/'.$item['icon_active']);
					}else{
						if(strpos($icon_active, 'http') !== false){
							//$fields .= ", `icon_active`='".$icon_active."'";
							$arrUpdate['icon_active'] = $icon_active;
							if($item['icon_active'] && file_exists($this->pathImage.'icons/'.$item['icon_active'])) unlink($this->pathImage.'icons/'.$item['icon_active']);
						}else{
							if(file_exists($this->pathImage.'temps/'.$icon_active)){
								if(copy($this->pathImage.'temps/'.$icon_active, $this->pathImage.'icons/'.$icon_active)){
									//$fields .= ", `icon_active`='".$icon_active."'";
									$arrUpdate['icon_active'] = $icon_active;
									if($item['icon_active'] && file_exists($this->pathImage.'icons/'.$item['icon_active'])) unlink($this->pathImage.'icons/'.$item['icon_active']);
								}
								unlink($this->pathImage.'temps/'.$icon_active);
							}	
						}	
					}
					
				}else{
					//$fields .= ", `icon_active`=''";
					$arrUpdate['icon_active'] = '';
					if($item['icon_active'] && file_exists($this->pathImage.'icons/'.$item['icon_active'])) unlink($this->pathImage.'icons/'.$item['icon_active']);
				}
                //Db::getInstance()->execute("Update "._DB_PREFIX_."megamenus_menu Set ".$fields." Where id = ".$itemId);
                Db::getInstance(_PS_USE_SQL_SLAVE_)->update('megamenus_menu', $arrUpdate, '`id`='.$itemId);                
				if($languages){
					$insertDatas = array();
                	foreach($languages as $index=>$language){
                		if(!$defaultName) $defaultName = pSQL($names[$index]);
						$name = pSQL($names[$index]);
						if(!$name) $name = $defaultName;						
						$check = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("Select * From "._DB_PREFIX_."megamenus_menu_lang Where menu_id = ".$itemId." AND `id_lang` = ".$language->id);
	                	if($check){
	                    	Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("Update "._DB_PREFIX_."megamenus_menu_lang Set `name` = '".$name."', `link` = '".pSQL($links[$index])."' Where `menu_id` = $itemId AND `id_lang` = ".$language->id);	
	                    }else{
	                    	$insertDatas[] = array('menu_id'=>$itemId, 'id_lang'=>$language->id, 'name'=>$name, 'link'=>pSQL($links[$index])) ;
	                    }
						if($insertDatas) Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_menu', $insertDatas);
                	}
                }
				$response->status = 1;
            	$response->msg = $this->l("Update menu success!");
            }			  
        }else{
            $response->status = '0';
            $response->msg = $this->l('Module not found');
        }
        die(Tools::jsonEncode($response));
    }
	public function saveSubMenu(){
		$languages = $this->getAllLanguage();
		$megamenuId = Tools::getValue('megamenuId', 0);
		$parentId = Tools::getValue('parent_id', 0);
        $itemId = Tools::getValue('id', 0);    
		$names = Tools::getValue('names', array());	
		$links = Tools::getValue('links', array());	
		$custom_class = Tools::getValue('custom_class', '');
		$display_name = 1;
		$linkType = Tools::getValue('link_type', 'CUSTOMLINK|0');
		$product_id = Tools::getValue('product_id', 0);
		$icon = Tools::getValue('icon', '');
		$icon_active = Tools::getValue('icon_active', '');
		$background = '';
		$width = 0;
		$response = new stdClass();		
        if($megamenuId >0){
        	$defaultName = '';            
            if($itemId == 0){				
				$maxOrdering = Db::getInstance()->getValue("Select MAX(ordering) From "._DB_PREFIX_."megamenus_menu Where `parent_id` = ".$parentId);
		   		if($maxOrdering >0) $maxOrdering++;
		   		else $maxOrdering = 1;
				$arrInsert = array(
					'parent_id'		=>	$parentId,
					'module_id'		=>	$megamenuId,
					'display_name'	=>	1,
					'link_type'		=>	$linkType,
					'custom_class'	=>	$custom_class,
					'product_id'	=>	$product_id,
					'width'			=>	0,
					'status'		=>	1,
					'icon'			=>	'',
					'icon_active'	=>	'',
					'ordering'		=>	$maxOrdering,					
				);								
				if($icon){
					if(strpos($icon, '.') === false){
						$arrInsert['icon'] = $icon;						
					}else{
						if(strpos($icon, 'http') !== false){
							$arrInsert['icon'] = $icon;							
						}else{
							if(file_exists($this->pathImage.'temps/'.$icon)){
								if(copy($this->pathImage.'temps/'.$icon, $this->pathImage.'icons/'.$icon)){
									$arrInsert['icon'] = $icon;									
								}
								unlink($this->pathImage.'temps/'.$icon);
							}	
						}	
					}
				}				
                if($icon_active){
                	if(strpos($icon_active, '.') === false){
                		$arrInsert['icon_active'] = $icon_active;
					}else{
						if(strpos($icon_active, 'http') !== false){
							$arrInsert['icon_active'] = $icon_active;
						}else{
							if(file_exists($this->pathImage.'temps/'.$icon_active)){
								if(copy($this->pathImage.'temps/'.$icon_active, $this->pathImage.'icons/'.$icon_active)){
									$arrInsert['icon_active'] = $icon_active;
								}
								unlink($this->pathImage.'temps/'.$icon_active);
							}
						}	
					}
                }				
                if(Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_menu', $arrInsert)){
                    $insertId = Db::getInstance(_PS_USE_SQL_SLAVE_)->Insert_ID();
					if($languages){
	                	$insertDatas = array();						
	                	foreach($languages as $index=>$language){
	                		if(!$defaultName) $defaultName = pSQL($names[$index]);
							$name = pSQL($names[$index]);
							if(!$name) $name = $defaultName; 
			                $insertDatas[] = array('menu_id'=>$insertId, 'id_lang'=>$language->id, 'name'=>$name, 'link'=>pSQL($links[$index]));
	                	}
						if($insertDatas) Db::getInstance()->insert('megamenus_menu_lang', $insertDatas);
	                }
                    $response->status = '1';
                    $response->msg = $this->l("Add new Menu Success!");
                }else{
                    $response->status = '0';
                    $response->msg = $this->l("Add new Menu not Success!");
                }
            }else{
                $item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."megamenus_menu Where id = ".$itemId);
                $fields = "`link_type` = '".$linkType."', `custom_class`='".$custom_class."', `display_name`='".$display_name."', `width`='".$width."', `product_id` = '".$product_id."'";
                $arrUpdate = array(
                	'background'	=>	'',
					'link_type'		=> 	$linkType,
					'custom_class'	=>	$custom_class,
					'product_id'	=>	$product_id,
					'width'			=>	0,
					'display_name'	=>	1,
					'icon'			=>	$item['icon'],
					'icon_active'	=>	$item['icon_active'],
				);				
				if($icon){
					if(strpos($icon, '.') === false){
						$arrUpdate['icon'] = $icon;
						if($item['icon'] && file_exists($this->pathImage.'icons/'.$item['icon'])) unlink($this->pathImage.'icons/'.$item['icon']);
					}else{
						if(strpos($icon, 'http') !== false){
							$arrUpdate['icon'] = $icon;
							if($item['icon'] && file_exists($this->pathImage.'icons/'.$item['icon'])) unlink($this->pathImage.'icons/'.$item['icon']);
						}else{
							if(file_exists($this->pathImage.'temps/'.$icon)){
								if(copy($this->pathImage.'temps/'.$icon, $this->pathImage.'icons/'.$icon)){
									$arrUpdate['icon'] = $icon;
									if($item['icon'] && file_exists($this->pathImage.'icons/'.$item['icon'])) unlink($this->pathImage.'icons/'.$item['icon']);
								}
								unlink($this->pathImage.'temps/'.$icon);
							}
						}	
					}					
				}else{
					$arrUpdate['icon'] = '';
					if($item['icon'] && file_exists($this->pathImage.'icons/'.$item['icon'])) unlink($this->pathImage.'icons/'.$item['icon']);
				}				
				if($icon_active){
					if(strpos($icon_active, '.') === false){
						$arrUpdate['icon_active'] = $icon_active;
						if($item['icon_active'] && file_exists($this->pathImage.'icons/'.$item['icon_active'])) unlink($this->pathImage.'icons/'.$item['icon_active']);
					}else{
						if(strpos($icon_active, 'http') !== false){
							$arrUpdate['icon_active'] = $icon_active;
							if($item['icon_active'] && file_exists($this->pathImage.'icons/'.$item['icon_active'])) unlink($this->pathImage.'icons/'.$item['icon_active']);
						}else{
							if(file_exists($this->pathImage.'temps/'.$icon_active)){
								if(copy($this->pathImage.'temps/'.$icon_active, $this->pathImage.'icons/'.$icon_active)){
									$arrUpdate['icon_active'] = $icon_active;
									if($item['icon_active'] && file_exists($this->pathImage.'icons/'.$item['icon_active'])) unlink($this->pathImage.'icons/'.$item['icon_active']);
								}
								unlink($this->pathImage.'temps/'.$icon_active);
							}	
						}	
					}
				}else{
					$arrUpdate['icon_active'] = '';
					if($item['icon_active'] && file_exists($this->pathImage.'icons/'.$item['icon_active'])) unlink($this->pathImage.'icons/'.$item['icon_active']);
				}
                Db::getInstance(_PS_USE_SQL_SLAVE_)->update('megamenus_menu', $arrUpdate, '`id`='.$itemId);                
				if($languages){
					$insertDatas = array();
                	foreach($languages as $index=>$language){
                		if(!$defaultName) $defaultName = pSQL($names[$index]);
						$name = pSQL($names[$index]);
						if(!$name) $name = $defaultName;						
						$check = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("Select * From "._DB_PREFIX_."megamenus_menu_lang Where menu_id = ".$itemId." AND `id_lang` = ".$language->id);
	                	if($check){
	                    	Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("Update "._DB_PREFIX_."megamenus_menu_lang Set `name` = '".$name."', `link` = '".pSQL($links[$index])."' Where `menu_id` = $itemId AND `id_lang` = ".$language->id);	
	                    }else{
	                    	$insertDatas[] = array('menu_id'=>$itemId, 'id_lang'=>$language->id, 'name'=>$name, 'link'=>pSQL($links[$index])) ;
	                    }
						if($insertDatas) Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_menu', $insertDatas);
                	}
                }
				$response->status = 1;
            	$response->msg = $this->l("Update menu success!");
            }			  
        }else{
            $response->status = '0';
            $response->msg = $this->l('Module not found');
        }
        die(Tools::jsonEncode($response));
    }
	public function saveRow(){
		$languages = $this->getAllLanguage();
        $response = new stdClass();
        $itemId = intval($_POST['id']);
		$megamenuId = intval($_POST['megamenuId']);
		$menuId = intval($_POST['menuId']);
		$names = $_POST['names'];
        $width = intval($_POST['width']);
		$custom_class = Tools::getValue('custom_class', '');
		$background = Tools::getValue('background', '');
		$display_name = Tools::getValue('display_name', 0);
		$defaultValues = new stdClass(); 
        if($itemId == 0){
			$maxOrdering = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue("Select MAX(ordering) From "._DB_PREFIX_."megamenus_row Where `module_id` = ".$megamenuId);
		   	if($maxOrdering >0) $maxOrdering++;
		   	else $maxOrdering = 1;
			$arrInsert = array(
					'module_id'		=>	$megamenuId,
					'menu_id'		=>	$menuId,
					'width'			=>	$width,
					'ordering'		=>	$maxOrdering,
					'status'		=>	1,
					'custom_class'	=>	$custom_class,	
					'display_name'	=>	$display_name,				
				);
			if($background){
				if(strpos($background, '.') === false){
					$arrInsert['background'] = $background;
				}else{
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
			}
            if(Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_row', $arrInsert)){            	
                $insertId = Db::getInstance(_PS_USE_SQL_SLAVE_)->Insert_ID();
				if($languages){
                	$insertDatas = array();
                	foreach($languages as $index=>$language){
                		$name = pSQL($names[$index]);
                		if(!$defaultValues->name) $defaultValues->name = $name;
						if(!$name) $name = $defaultValues->name;
						$insertDatas[] = array('row_id'=>$insertId, 'id_lang'=>$language->id, 'name'=>$name);                   		                
                	}
					if($insertDatas) Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_row_lang', $insertDatas);
                }                
                $response->status = '1';
                $response->msg = $this->l('Add new row Success!');
				$this->clearCache();
            }else{
                $response->status = '0';
                $response->msg = $this->l('Add new row not Success!');
            }
        }else{
            $item = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("Select * From "._DB_PREFIX_."megamenus_row Where id = ".$itemId);
			$arrUpdate = array(
            	'background'	=>	$item['background'],				
				'custom_class'	=>	$custom_class,				
				'width'			=>	$width,
				'display_name'	=>	$display_name,				
			);
			if($background){
				if(strpos($background, '.') === false){
					$arrUpdate['background'] = $background;
					if($item['background'] && file_exists($this->pathImage.$item['background'])) unlink($this->pathImage.$item['background']);
				}else{
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
				}					
			}else{
				$arrUpdate['background'] = '';
				if($item['background'] && file_exists($this->pathImage.$item['background'])) unlink($this->pathImage.$item['background']);
			}
			Db::getInstance(_PS_USE_SQL_SLAVE_)->update('megamenus_row', $arrUpdate, '`id`='.$itemId);    	
            //Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("Update "._DB_PREFIX_."megamenus_row Set `width` = '".$width."', `custom_class`='$custom_class' Where id = ".$itemId);            
			if($languages){
				$insertDatas = array();            	
            	foreach($languages as $index=>$language){
            		$name = pSQL($names[$index]);
            		if(!$defaultValues->name) $defaultValues->name = $name;
					if(!$name) $name = $defaultValues->name;					
            		$check = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue("Select row_id From "._DB_PREFIX_."megamenus_row_lang Where row_id = $itemId AND id_lang = ".$language->id);
            		if($check){
            			Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("Update "._DB_PREFIX_."megamenus_row_lang Set `name` = '".$name."' Where `row_id` = ".$itemId." AND `id_lang` = ".$language->id);	
            		}else{
            			$insertDatas[] = array('row_id'=>$itemId, 'id_lang'=>$language->id, 'name'=>$name);
            		}					
            	}
            	if($insertDatas) Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_row_lang', $insertDatas);
            }            
            $response->status = '1';
            $response->msg = $this->l('Update row Success!');
			$this->clearCache();
        }
        die(Tools::jsonEncode($response));
	}
	public function saveGroup(){
		
		$languages = $this->getAllLanguage();  
        $itemId = Tools::getValue('id', 0);
		$names = Tools::getValue('names', array());
		$descriptions = Tools::getValue('descriptions', array());
		$custom_class = Tools::getValue('custom_class', '');
		$display_title = Tools::getValue('group_display_title', 1);
		$width = Tools::getValue('width', 3);
		$type = Tools::getValue('groupType', 'link');
		$params = new stdClass();
        $params->product = new stdClass();
        $params->product->ids = array();
        $params->module = new stdClass();
        $params->product->category = Tools::getValue('groupProductCategory', 0);
        $params->product->type = Tools::getValue('groupProductType', 'auto');
        $params->product->orderBy = Tools::getValue('order_by', 'position');
        $params->product->orderWay = Tools::getValue('order_way', 'asc');
        $params->product->onCondition = Tools::getValue('on_condition', 2);
        $params->product->onSale = Tools::getValue('on_sale', 2);
        $params->product->onNew = Tools::getValue('on_new', 2);
        $params->product->onDiscount = Tools::getValue('on_discount', 2);
        $params->product->maxCount = Tools::getValue('maxItem', 3);
        $params->product->width = Tools::getValue('groupProductWidth', 4);
        $params->product->customWidth = 12;
        $params->product->ids = Tools::getValue('product_ids', array());
        
        $params->module->name = Tools::getValue('module', '');
        $params->module->hook = Tools::getValue('hook', '');
        
        
		
		$moduleId = intval($_POST['megamenuId']);
		$menuId = intval($_POST['menuId']);		
		$rowId = intval($_POST['rowId']);
		$response = new stdClass();
        $defaultName = '';
		$defaultDescription = '';
		if($moduleId >0 && $menuId >0 && $rowId >0){				
            if($itemId <=0){
            	$maxOrdering = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue("Select MAX(ordering) From "._DB_PREFIX_."megamenus_group Where `module_id` = ".$moduleId." AND `row_id` = ".$rowId);
		   		if($maxOrdering >0) $maxOrdering++;
		   		else $maxOrdering = 1;
                $arrInsert = array(
                    'module_id'     =>  $moduleId,
                    'menu_id'       =>  $menuId,
                    'row_id'        =>  $rowId,
                    'display_title' =>  $display_title,
                    'custom_class'  =>  $custom_class,
                    'type'          =>  $type,
                    'params'        =>  Tools::jsonEncode($params),
                    'width'         =>  $width,
                    'status'        =>  1,
                    'ordering'      =>  $maxOrdering,
                );
                if(Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_group', $arrInsert)){
                    $insertId = Db::getInstance(_PS_USE_SQL_SLAVE_)->Insert_ID();
					if($languages){
	                	$insertDatas = array();
	                	foreach($languages as $index=>$language){
                            $name = pSQL($names[$index]);
							$description = Db::getInstance(_PS_USE_SQL_SLAVE_)->escape($descriptions[$index], true);							
                            if(!$defaultName) $defaultName = $name;
                            if(!$name) $name=$defaultName;							
							if(!$defaultDescription) $defaultDescription = $description;
                            if(!$description) $description=$defaultDescription;
			                $insertDatas[] = array(
                                'group_id'  	=>  $insertId, 
                                'id_lang'   	=>  $language->id, 
                                'name'      	=>  $name,
                                'description'	=>	$description,
                            ) ;			                
	                	}
						if($insertDatas) Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_group_lang', $insertDatas);
	                }
                    $response->status ='1';
                    $response->msg = 'Add new Group Success.';
                }else{
                    $response->status ='0';
                    $response->msg = 'Add new Group not success.';
                }
            } else{
                $item = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("Select * From "._DB_PREFIX_."megamenus_group Where id = ".$itemId);
				Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("Update "._DB_PREFIX_."megamenus_group Set `type` = '".$type."', `display_title`='".$display_title."', `custom_class`='".$custom_class."', `params` = '".Tools::jsonEncode($params)."', `width`='".$width."' Where id = ".$itemId);				
                if($languages){                	
                	$insertDatas = array();          	
                	foreach($languages as $index=>$language){
                        $name = pSQL($names[$index]);
						$description = Db::getInstance(_PS_USE_SQL_SLAVE_)->escape($descriptions[$index], true);
                        if(!$defaultName) $defaultName = $name;
                        if(!$name) $name=$defaultName;
                        if(!$defaultDescription) $defaultDescription = $description;
                        if(!$description) $description=$defaultDescription;
                		$check = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue("Select group_id From "._DB_PREFIX_."megamenus_group_lang Where group_id = '".$itemId."' AND `id_lang` = ".$language->id);
						if($check){
							Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("Update "._DB_PREFIX_."megamenus_group_lang Set name = '".$name."', `description`='$description' Where `group_id` = ".$itemId." AND `id_lang` = ".$language->id);
						}else {
							$insertDatas[] = array(
                                'group_id'  	=>  $itemId, 
                                'id_lang'   	=>  $language->id, 
                                'name'      	=>  $name,
                                'description'	=>	$description,
                            ) ;
						}	                			                			                					                
                	}
					if($insertDatas) Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_group_lang', $insertDatas);
                }                
                $response->status ='1';
                $response->msg = 'Update Group success.';
            }
		}else{
			$response->status ='1';
	        $response->msg = 'Module or Row not found!';
		}
        die(Tools::jsonEncode($response));
    }
	public function saveMenuItem(){
		$languages = $this->getAllLanguage();
		$moduleId = intval($_POST['moduleId']);
		$menuId = intval($_POST['menuId']);
		$rowId = intval($_POST['rowId']);		
        $groupId = intval($_POST['groupId']);
        $itemId = intval($_POST['id']);        
		$names = Tools::getValue('names', array());
		$custom_class = Tools::getValue('custom_class', '');
		$display_name = Tools::getValue('item_display_name', 1);
		$link_type = Tools::getValue('link_type', 'CUSTOMLINK|0');
		$product_id = Tools::getValue('product_id', 0);
		$links = Tools::getValue('links', array());
		$menu_type = Tools::getValue('menu_type', 'link');
		$module_name = Tools::getValue('module_name', '');
		$hook_name = Tools::getValue('hook_name', '');
		$images = Tools::getValue('images', array());
		$alts = Tools::getValue('alts', array());
		$htmls = Tools::getValue('htmls', array());		
		$icon = Tools::getValue('icon', '');//$_POST['icon'];
		$icon_active = Tools::getValue('icon_active', '');//$_POST['icon_active'];
		$response = new stdClass();
        $defaultName = '';
        $defaultAlt = '';
        $defaultHtml = '';
        $defaultLink = '';
        if($moduleId >0 && $rowId >0 && $groupId >0){            
            if($itemId == 0){				
				$maxOrdering = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue("Select MAX(ordering) From "._DB_PREFIX_."megamenus_menuitem Where `module_id` = ".$moduleId." AND `row_id` = ".$rowId." AND `group_id` = ".$groupId);
		   		if($maxOrdering >0) $maxOrdering++;
		   		else $maxOrdering = 1;	
                $arrInsert = array(
                	'parent_id'		=>	0,
                    'module_id'     =>  $moduleId,
                    'menu_id'       =>  $menuId,
                    'row_id'        =>  $rowId,
                    'group_id'      =>  $groupId,
                    'menu_type'     =>  $menu_type,
                    'link_type'     =>  $link_type,
                    'custom_class'  =>  $custom_class,
                    'display_name'  =>  $display_name,
                    'status'        =>  1,
                    'module_name'   =>  $module_name,
                    'hook_name'     =>  $hook_name,
                    'product_id'    =>  $product_id,
                    'icon'    		=>  '',
                    'icon_active'   =>  '',
                    'ordering'      =>  $maxOrdering,
                );			
                if($icon){
					if(strpos($icon, '.') === false){
						$arrInsert['icon'] = $icon;
					}else{
						if(strpos($icon, 'http') !== false){
							$arrInsert['icon'] = $icon;
						}else{
							if(file_exists($this->pathImage.'temps/'.$icon)){
								if(copy($this->pathImage.'temps/'.$icon, $this->pathImage.'icons/'.$icon)){
									$arrInsert['icon'] = $icon;
								}
								unlink($this->pathImage.'temps/'.$icon);
							}	
						}	
					}
				}				
                if($icon_active){
                	if(strpos($icon_active, '.') === false){
                		$arrInsert['icon_active'] = $icon_active;
					}else{
						if(strpos($icon_active, 'http') !== false){
							$arrInsert['icon_active'] = $icon_active;
						}else{
							if(file_exists($this->pathImage.'temps/'.$icon_active)){
								if(copy($this->pathImage.'temps/'.$icon_active, $this->pathImage.'icons/'.$icon_active)){
									$arrInsert['icon_active'] = $icon_active;
								}
								unlink($this->pathImage.'temps/'.$icon_active);
							}		
						}	
					}
                	
                }
                if(Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_menuitem', $arrInsert)){
                    $insertId = Db::getInstance(_PS_USE_SQL_SLAVE_)->Insert_ID();										
					if($languages){
	                	$insertDatas = array();
	                	foreach($languages as $index=>$language){
                            $name = pSQL($names[$index]);
                            if(!$defaultName) $defaultName = $name;
                            if(!$name) $name = $defaultName;
                            $alt = pSQL($names[$index]);
                            if(!$defaultAlt) $defaultAlt = $alt;
                            if(!$name) $name = $defaultAlt;
                            
                            $html = Db::getInstance(_PS_USE_SQL_SLAVE_)->escape($htmls[$index], true);
                            if(!$defaultHtml) $defaultHtml = $html;
                            if(!$html) $html = $defaultHtml;
                            
                            $link = pSQL($links[$index]);
                            if(!$defaultLink) $defaultLink = $link;
                            if(!$link) $link = $defaultLink;
                            
                            $image = pSQL($images[$index]);
	                		if($images[$index]){
                                if(strpos($image, 'http') !== false){
                                    $insertDatas[] = array(
                                            'menuitem_id'   =>  $insertId, 
                                            'id_lang'       =>  $language->id, 
                                            'name'          =>  $name, 
                                            'link'          =>  $link, 
                                            'image'         =>  $image, 
                                            'imageAlt'      =>  $alt, 
                                            'html'          =>  $html,
                                        ) ;
                                }else{
                                    if(file_exists($this->pathImage.'temps/'.$image)){
        			                    if(copy($this->pathImage.'temps/'.$image, $this->pathImage.$image)){
        			                    	unlink($this->pathImage.'temps/'.$image);
        			                    	$insertDatas[] = array(
                                                'menuitem_id'   =>  $insertId, 
                                                'id_lang'       =>  $language->id, 
                                                'name'          =>  $name, 
                                                'link'          =>  $link, 
                                                'image'         =>  $image, 
                                                'imageAlt'      =>  $alt, 
                                                'html'          =>  $html,
                                            ) ;	
        			                    }else{
        			                    	$insertDatas[] = array(
                                                'menuitem_id'   =>  $insertId, 
                                                'id_lang'       =>  $language->id, 
                                                'name'          =>  $name, 
                                                'link'          =>  $link, 
                                                'image'         =>  '', 
                                                'imageAlt'      =>  $alt, 
                                                'html'          =>  $html,
                                            );
        			                    }
        			                }else{
        			                	$insertDatas[] = array(
                                            'menuitem_id'   =>  $insertId, 
                                            'id_lang'       =>  $language->id, 
                                            'name'          =>  $name, 
                                            'link'          =>  $link, 
                                            'image'         =>  '', 
                                            'imageAlt'      =>  $alt, 
                                            'html'          =>  $html,
                                        ) ;
        			                }
                                }
	                		}else{
                                $insertDatas[] = array(
                                    'menuitem_id'   =>  $insertId, 
                                    'id_lang'       =>  $language->id, 
                                    'name'          =>  $name, 
                                    'link'          =>  $link, 
                                    'image'         =>  '', 
                                    'imageAlt'      =>  $alt, 
                                    'html'          =>  $html,
                                ) ;
	                		}
                            
                            
	                	}
						if($insertDatas) Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_menuitem_lang', $insertDatas);
	                }                    
                    $response->status = '1';
                    $response->msg = $this->l("Add new menu item Success!");
                }else{
                    $response->status = '0';
                    $response->msg = $this->l("Add new menu item not Success!");
                }
            }else{
                $item = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("Select * From "._DB_PREFIX_."megamenus_menuitem Where id = ".$itemId);
				//Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("Update "._DB_PREFIX_."megamenus_menuitem Set `menu_type` = '".$menu_type."', `link_type` = '".$link_type."', `custom_class`='".$custom_class."', `display_name` = '".$display_name."', `module_name`='".$module_name."', `hook_name`='".$hook_name."', `product_id` = '".$product_id."' Where id = ".$itemId);                
                $arrUpdate = array(
					'menu_type'		=> 	$menu_type,
					'link_type'		=>	$link_type,
					'custom_class'	=>	$custom_class,
					'display_name'	=>	$display_name,
					'module_name'	=>	$module_name,
					'hook_name'		=>	$hook_name,
					'product_id'	=>	$product_id,
					'icon'			=>	$item['icon'],
					'icon_active'	=>	$item['icon_active'],
				);
				if($icon){
					if(strpos($icon, '.') === false){
						$arrUpdate['icon'] = $icon;
						if($item['icon'] && file_exists($this->pathImage.'icons/'.$item['icon'])) unlink($this->pathImage.'icons/'.$item['icon']);
					}else{
						if(strpos($icon, 'http') !== false){
							$arrUpdate['icon'] = $icon;
							if($item['icon'] && file_exists($this->pathImage.'icons/'.$item['icon'])) unlink($this->pathImage.'icons/'.$item['icon']);
						}else{
							if(file_exists($this->pathImage.'temps/'.$icon)){
								if(copy($this->pathImage.'temps/'.$icon, $this->pathImage.'icons/'.$icon)){
									$arrUpdate['icon'] = $icon;
									if($item['icon'] && file_exists($this->pathImage.'icons/'.$item['icon'])) unlink($this->pathImage.'icons/'.$item['icon']);
								}
								unlink($this->pathImage.'temps/'.$icon);
							}
						}	
					}					
				}else{
					$arrUpdate['icon'] = '';
					if($item['icon'] && file_exists($this->pathImage.'icons/'.$item['icon'])) unlink($this->pathImage.'icons/'.$item['icon']);
				}
				
				if($icon_active){
					if(strpos($icon_active, '.') === false){
						$arrUpdate['icon_active'] = $icon_active;
						if($item['icon_active'] && file_exists($this->pathImage.'icons/'.$item['icon_active'])) unlink($this->pathImage.'icons/'.$item['icon_active']);
					}else{
						if(strpos($icon_active, 'http') !== false){
							$arrUpdate['icon_active'] = $icon_active;
							if($item['icon_active'] && file_exists($this->pathImage.'icons/'.$item['icon_active'])) unlink($this->pathImage.'icons/'.$item['icon_active']);
						}else{
							if(file_exists($this->pathImage.'temps/'.$icon_active)){
								if(copy($this->pathImage.'temps/'.$icon_active, $this->pathImage.'icons/'.$icon_active)){
									$arrUpdate['icon_active'] = $icon_active;
									if($item['icon_active'] && file_exists($this->pathImage.'icons/'.$item['icon_active'])) unlink($this->pathImage.'icons/'.$item['icon_active']);
								}
								unlink($this->pathImage.'temps/'.$icon_active);
							}	
						}	
					}
					
				}else{
					$arrUpdate['icon_active'] = '';
					if($item['icon_active'] && file_exists($this->pathImage.'icons/'.$item['icon_active'])) unlink($this->pathImage.'icons/'.$item['icon_active']);
				}
				
				Db::getInstance(_PS_USE_SQL_SLAVE_)->update('megamenus_menuitem', $arrUpdate, "`id`='$itemId'");
                                
				if($languages){
					$insertDatas = array();
                	foreach($languages as $index=>$language){
						$name = pSQL($names[$index]);
                        if(!$defaultName) $defaultName = $name;
                        if(!$name) $name = $defaultName;
                        
                        $alt = pSQL($names[$index]);
                        if(!$defaultAlt) $defaultAlt = $alt;
                        if(!$name) $name = $defaultAlt;
                        
                        $html = Db::getInstance(_PS_USE_SQL_SLAVE_)->escape($htmls[$index], true);
                        if(!$defaultHtml) $defaultHtml = $html;
                        if(!$html) $html = $defaultHtml;
                        
                        $link = pSQL($links[$index]);
                        if(!$defaultLink) $defaultLink = $link;
                        if(!$link) $link = $defaultLink;
                        $check = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("Select * From "._DB_PREFIX_."megamenus_menuitem_lang Where menuitem_id = ".$itemId." AND `id_lang` = ".$language->id);
                        $image = pSQL($images[$index]);
                        if($image){
                            if(strpos($image, 'http') !== false){
                                if($check){                                    
    		                    	Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("Update "._DB_PREFIX_."megamenus_menuitem_lang Set `name` = '".$name."', `link` = '".$link."', `image` = '".$image."', `imageAlt` = '".$alt."', `html` = '".$html."'  Where `menuitem_id` = $itemId AND `id_lang` = ".$language->id);	
    		                    }else{
    		                    	$insertDatas[] = array(
                                        'menuitem_id'   =>  $itemId, 
                                        'id_lang'       =>  $language->id, 
                                        'name'          =>  $name, 
                                        'link'          =>  $link, 
                                        'image'         =>  $image, 
                                        'imageAlt'      =>  $alt, 
                                        'html'          =>  $html,
                                    ) ;
    		                    }      
                            }else{
                                if(file_exists($this->pathImage.'temps/'.$image)){                    		                    
        		                    if(copy($this->pathImage.'temps/'.$image, $this->pathImage.$image)){
      		                            unlink($this->pathImage.'temps/'.$image);		                    
            		                    if($check){
            		                    	if($check['image'] && file_exists($this->pathImage.$check['image'])) unlink($this->pathImage.$check['image']);
            		                    	Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("Update "._DB_PREFIX_."megamenus_menuitem_lang Set `name` = '".$name."', `link` = '".$link."', `image` = '".$image."', `imageAlt` = '".$alt."', `html` = '".$html."' Where `menuitem_id` = $itemId AND `id_lang` = ".$language->id);	
            		                    }else{
            		                    	$insertDatas[] = array(
                                                'menuitem_id'   =>  $itemId, 
                                                'id_lang'       =>  $language->id, 
                                                'name'          =>  $name, 
                                                'link'          =>  $link, 
                                                'image'         =>  $image, 
                                                'imageAlt'      =>  $alt, 
                                                'html'          =>  $html,
                                            ) ;
            		                    }
        		                    }else{
      		                            if($check){
            		                    	Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("Update "._DB_PREFIX_."megamenus_menuitem_lang Set `name` = '".$name."', `link` = '".$link."', `imageAlt` = '".$alt."', `html` = '".$html."'  Where `menuitem_id` = $itemId AND `id_lang` = ".$language->id);	
            		                    }else{
            		                    	$insertDatas[] = array(
                                                'menuitem_id'   =>  $itemId, 
                                                'id_lang'       =>  $language->id, 
                                                'name'          =>  $name, 
                                                'link'          =>  $link, 
                                                'image'         =>  '', 
                                                'imageAlt'      =>  $alt, 
                                                'html'          =>  $html,
                                            ) ;
            		                    }
        		                    }                            		                    
        		                }else{
        		                	if($check){
        		                    	Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("Update "._DB_PREFIX_."megamenus_menuitem_lang Set `name` = '".$name."', `link` = '".$link."', `imageAlt` = '".$alt."', `html` = '".$html."'  Where `menuitem_id` = $itemId AND `id_lang` = ".$language->id);	
        		                    }else{
        		                    	$insertDatas[] = array(
                                            'menuitem_id'   =>  $itemId, 
                                            'id_lang'       =>  $language->id, 
                                            'name'          =>  $name, 
                                            'link'          =>  $link, 
                                            'image'         =>  '', 
                                            'imageAlt'      =>  $alt, 
                                            'html'          =>  $html,
                                        ) ;
        		                    }        		                	
        		                }    
                            }                            
                        }else{
                            if($check){                                
		                    	Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("Update "._DB_PREFIX_."megamenus_menuitem_lang Set `name` = '".$name."', `link` = '".$link."', `image` = '', `imageAlt` = '".$alt."', `html` = '".$html."'  Where `menuitem_id` = $itemId AND `id_lang` = ".$language->id);	
		                    }else{
		                    	$insertDatas[] = array(
                                    'menuitem_id'=>$itemId, 
                                    'id_lang'=>$language->id, 
                                    'name'=>$name, 
                                    'link'=>$link, 
                                    'image'=>'', 
                                    'imageAlt'=>$alt, 
                                    'html'=>$html,
                                ) ;
		                    }
                        }                		
						if($insertDatas) Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_menuitem', $insertDatas);
                	}
                }
				$response->status = 1;
            	$response->msg = $this->l("Update menu item success!");
            }
        }else{
            $response->status = '0';
            $response->msg = $this->l('Module or Row or Group not found');
        }
        die(Tools::jsonEncode($response));
    }
	public function saveSubMenuItem(){
		
		$languages 		=	$this->getAllLanguage();
		$moduleId 		=	Tools::getValue('moduleId', 0);
		$menuId 		= 	Tools::getValue('menuId', 0);
		$rowId 			=	Tools::getValue('rowId', 0);		
        $groupId 		=	Tools::getValue('groupId', 0);
		$parentId 		= 	Tools::getValue('parentId', 0);
        $itemId 		= 	Tools::getValue('id', 0);        
		$names 			= 	Tools::getValue('names', array());
		$custom_class 	= 	Tools::getValue('custom_class', '');
		$display_name 	= 	Tools::getValue('item_display_name', 1);
		$link_type 		= 	Tools::getValue('link_type', 'CUSTOMLINK|0');
		$product_id 	= 	Tools::getValue('product_id', 0);
		$links 			= 	Tools::getValue('links', array());
		$menu_type 		= 	Tools::getValue('menu_type', 'link');
		$module_name 	= 	'';
		$hook_name 		= 	'';
		$images 		= 	'';
		$alts 			= 	'';
		$htmls 			= 	'';		
		$icon 			= 	Tools::getValue('icon', '');//$_POST['icon'];
		$icon_active 	= 	Tools::getValue('icon_active', '');//$_POST['icon_active'];
		$response 		= 	new stdClass();
        $defaultName 	=	 '';
        $defaultAlt 	= 	'';
        $defaultHtml 	= 	'';
        $defaultLink 	= 	'';
        if($moduleId >0 && $rowId >0 && $groupId >0 & $parentId > 0){            
            if($itemId == 0){				
				$maxOrdering = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue("Select MAX(ordering) From "._DB_PREFIX_."megamenus_menuitem Where `parent_id` = ".$parentId);
		   		if($maxOrdering >0) $maxOrdering++;
		   		else $maxOrdering = 1;	
                $arrInsert = array(
                	'parent_id'		=>	$parentId,
                    'module_id'     =>  $moduleId,
                    'menu_id'       =>  $menuId,
                    'row_id'        =>  $rowId,
                    'group_id'      =>  $groupId,
                    'menu_type'     =>  $menu_type,
                    'link_type'     =>  $link_type,
                    'custom_class'  =>  $custom_class,
                    'display_name'  =>  $display_name,
                    'status'        =>  1,
                    'module_name'   =>  $module_name,
                    'hook_name'     =>  $hook_name,
                    'product_id'    =>  $product_id,
                    'icon'    		=>  $icon,
                    'icon_active'   =>  $icon_active,
                    'ordering'      =>  $maxOrdering,
                );			
                if($icon){
					if(strpos($icon, '.') === false){
						$arrInsert['icon'] = $icon;
					}else{
						if(strpos($icon, 'http') !== false){
							$arrInsert['icon'] = $icon;
						}else{
							if(file_exists($this->pathImage.'temps/'.$icon)){
								if(copy($this->pathImage.'temps/'.$icon, $this->pathImage.'icons/'.$icon)){
									$arrInsert['icon'] = $icon;
								}
								unlink($this->pathImage.'temps/'.$icon);
							}	
						}	
					}
				}				
                if($icon_active){
                	if(strpos($icon_active, '.') === false){
                		$arrInsert['icon_active'] = $icon_active;
					}else{
						if(strpos($icon_active, 'http') !== false){
							$arrInsert['icon_active'] = $icon_active;
						}else{
							if(file_exists($this->pathImage.'temps/'.$icon_active)){
								if(copy($this->pathImage.'temps/'.$icon_active, $this->pathImage.'icons/'.$icon_active)){
									$arrInsert['icon_active'] = $icon_active;
								}
								unlink($this->pathImage.'temps/'.$icon_active);
							}		
						}	
					}
                	
                }
                if(Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_menuitem', $arrInsert)){
                    $insertId = Db::getInstance(_PS_USE_SQL_SLAVE_)->Insert_ID();										
					if($languages){
	                	$insertDatas = array();
	                	foreach($languages as $index=>$language){
                            $name = pSQL($names[$index]);
                            if(!$defaultName) $defaultName = $name;
                            if(!$name) $name = $defaultName;
                            $alt = pSQL($names[$index]);
                            if(!$defaultAlt) $defaultAlt = $alt;
                            if(!$name) $name = $defaultAlt;
                            
                            $html = Db::getInstance(_PS_USE_SQL_SLAVE_)->escape($htmls[$index], true);
                            if(!$defaultHtml) $defaultHtml = $html;
                            if(!$html) $html = $defaultHtml;
                            
                            $link = pSQL($links[$index]);
                            if(!$defaultLink) $defaultLink = $link;
                            if(!$link) $link = $defaultLink;
                            
                            $image = pSQL($images[$index]);
	                		if($images[$index]){
                                if(strpos($image, 'http') !== false){
                                    $insertDatas[] = array(
                                            'menuitem_id'   =>  $insertId, 
                                            'id_lang'       =>  $language->id, 
                                            'name'          =>  $name, 
                                            'link'          =>  $link, 
                                            'image'         =>  $image, 
                                            'imageAlt'      =>  $alt, 
                                            'html'          =>  $html,
                                        ) ;
                                }else{
                                    if(file_exists($this->pathImage.'temps/'.$image)){
        			                    if(copy($this->pathImage.'temps/'.$image, $this->pathImage.$image)){
        			                    	unlink($this->pathImage.'temps/'.$image);
        			                    	$insertDatas[] = array(
                                                'menuitem_id'   =>  $insertId, 
                                                'id_lang'       =>  $language->id, 
                                                'name'          =>  $name, 
                                                'link'          =>  $link, 
                                                'image'         =>  $image, 
                                                'imageAlt'      =>  $alt, 
                                                'html'          =>  $html,
                                            ) ;	
        			                    }else{
        			                    	$insertDatas[] = array(
                                                'menuitem_id'   =>  $insertId, 
                                                'id_lang'       =>  $language->id, 
                                                'name'          =>  $name, 
                                                'link'          =>  $link, 
                                                'image'         =>  '', 
                                                'imageAlt'      =>  $alt, 
                                                'html'          =>  $html,
                                            );
        			                    }
        			                }else{
        			                	$insertDatas[] = array(
                                            'menuitem_id'   =>  $insertId, 
                                            'id_lang'       =>  $language->id, 
                                            'name'          =>  $name, 
                                            'link'          =>  $link, 
                                            'image'         =>  '', 
                                            'imageAlt'      =>  $alt, 
                                            'html'          =>  $html,
                                        ) ;
        			                }
                                }
	                		}else{
                                $insertDatas[] = array(
                                    'menuitem_id'   =>  $insertId, 
                                    'id_lang'       =>  $language->id, 
                                    'name'          =>  $name, 
                                    'link'          =>  $link, 
                                    'image'         =>  '', 
                                    'imageAlt'      =>  $alt, 
                                    'html'          =>  $html,
                                ) ;
	                		}
                            
                            
	                	}
						if($insertDatas) Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_menuitem_lang', $insertDatas);
	                }                    
                    $response->status = '1';
                    $response->msg = $this->l("Add new menu item Success!");
                }else{
                    $response->status = '0';
                    $response->msg = $this->l("Add new menu item not Success!");
                }
            }else{
                $item = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("Select * From "._DB_PREFIX_."megamenus_menuitem Where id = ".$itemId);
				//Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("Update "._DB_PREFIX_."megamenus_menuitem Set `menu_type` = '".$menu_type."', `link_type` = '".$link_type."', `custom_class`='".$custom_class."', `display_name` = '".$display_name."', `module_name`='".$module_name."', `hook_name`='".$hook_name."', `product_id` = '".$product_id."' Where id = ".$itemId);                
                $arrUpdate = array(
					'menu_type'		=> 	$menu_type,
					'link_type'		=>	$link_type,
					'custom_class'	=>	$custom_class,
					'display_name'	=>	$display_name,
					'module_name'	=>	$module_name,
					'hook_name'		=>	$hook_name,
					'product_id'	=>	$product_id,
					'icon'			=>	$item['icon'],
					'icon_active'	=>	$item['icon_active'],
				);
				if($icon){
					if(strpos($icon, '.') === false){
						$arrUpdate['icon'] = $icon;
						if($item['icon'] && file_exists($this->pathImage.'icons/'.$item['icon'])) unlink($this->pathImage.'icons/'.$item['icon']);
					}else{
						if(strpos($icon, 'http') !== false){
							$arrUpdate['icon'] = $icon;
							if($item['icon'] && file_exists($this->pathImage.'icons/'.$item['icon'])) unlink($this->pathImage.'icons/'.$item['icon']);
						}else{
							if(file_exists($this->pathImage.'temps/'.$icon)){
								if(copy($this->pathImage.'temps/'.$icon, $this->pathImage.'icons/'.$icon)){
									$arrUpdate['icon'] = $icon;
									if($item['icon'] && file_exists($this->pathImage.'icons/'.$item['icon'])) unlink($this->pathImage.'icons/'.$item['icon']);
								}
								unlink($this->pathImage.'temps/'.$icon);
							}
						}	
					}					
				}else{
					$arrUpdate['icon'] = '';
					if($item['icon'] && file_exists($this->pathImage.'icons/'.$item['icon'])) unlink($this->pathImage.'icons/'.$item['icon']);
				}
				
				if($icon_active){
					if(strpos($icon_active, '.') === false){
						$arrUpdate['icon_active'] = $icon_active;
						if($item['icon_active'] && file_exists($this->pathImage.'icons/'.$item['icon_active'])) unlink($this->pathImage.'icons/'.$item['icon_active']);
					}else{
						if(strpos($icon_active, 'http') !== false){
							$arrUpdate['icon_active'] = $icon_active;
							if($item['icon_active'] && file_exists($this->pathImage.'icons/'.$item['icon_active'])) unlink($this->pathImage.'icons/'.$item['icon_active']);
						}else{
							if(file_exists($this->pathImage.'temps/'.$icon_active)){
								if(copy($this->pathImage.'temps/'.$icon_active, $this->pathImage.'icons/'.$icon_active)){
									$arrUpdate['icon_active'] = $icon_active;
									if($item['icon_active'] && file_exists($this->pathImage.'icons/'.$item['icon_active'])) unlink($this->pathImage.'icons/'.$item['icon_active']);
								}
								unlink($this->pathImage.'temps/'.$icon_active);
							}	
						}	
					}
					
				}else{
					$arrUpdate['icon_active'] = '';
					if($item['icon_active'] && file_exists($this->pathImage.'icons/'.$item['icon_active'])) unlink($this->pathImage.'icons/'.$item['icon_active']);
				}
				
				Db::getInstance(_PS_USE_SQL_SLAVE_)->update('megamenus_menuitem', $arrUpdate, "`id`='$itemId'");
                                
				if($languages){
					$insertDatas = array();
                	foreach($languages as $index=>$language){
						$name = pSQL($names[$index]);
                        if(!$defaultName) $defaultName = $name;
                        if(!$name) $name = $defaultName;
                        
                        $alt = pSQL($names[$index]);
                        if(!$defaultAlt) $defaultAlt = $alt;
                        if(!$name) $name = $defaultAlt;
                        
                        $html = Db::getInstance(_PS_USE_SQL_SLAVE_)->escape($htmls[$index], true);
                        if(!$defaultHtml) $defaultHtml = $html;
                        if(!$html) $html = $defaultHtml;
                        
                        $link = pSQL($links[$index]);
                        if(!$defaultLink) $defaultLink = $link;
                        if(!$link) $link = $defaultLink;
                        $check = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("Select * From "._DB_PREFIX_."megamenus_menuitem_lang Where menuitem_id = ".$itemId." AND `id_lang` = ".$language->id);
                        $image = pSQL($images[$index]);
                        if($image){
                            if(strpos($image, 'http') !== false){
                                if($check){                                    
    		                    	Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("Update "._DB_PREFIX_."megamenus_menuitem_lang Set `name` = '".$name."', `link` = '".$link."', `image` = '".$image."', `imageAlt` = '".$alt."', `html` = '".$html."'  Where `menuitem_id` = $itemId AND `id_lang` = ".$language->id);	
    		                    }else{
    		                    	$insertDatas[] = array(
                                        'menuitem_id'   =>  $itemId, 
                                        'id_lang'       =>  $language->id, 
                                        'name'          =>  $name, 
                                        'link'          =>  $link, 
                                        'image'         =>  $image, 
                                        'imageAlt'      =>  $alt, 
                                        'html'          =>  $html,
                                    ) ;
    		                    }      
                            }else{
                                if(file_exists($this->pathImage.'temps/'.$image)){                    		                    
        		                    if(copy($this->pathImage.'temps/'.$image, $this->pathImage.$image)){
      		                            unlink($this->pathImage.'temps/'.$image);		                    
            		                    if($check){
            		                    	if($check['image'] && file_exists($this->pathImage.$check['image'])) unlink($this->pathImage.$check['image']);
            		                    	Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("Update "._DB_PREFIX_."megamenus_menuitem_lang Set `name` = '".$name."', `link` = '".$link."', `image` = '".$image."', `imageAlt` = '".$alt."', `html` = '".$html."' Where `menuitem_id` = $itemId AND `id_lang` = ".$language->id);	
            		                    }else{
            		                    	$insertDatas[] = array(
                                                'menuitem_id'   =>  $itemId, 
                                                'id_lang'       =>  $language->id, 
                                                'name'          =>  $name, 
                                                'link'          =>  $link, 
                                                'image'         =>  $image, 
                                                'imageAlt'      =>  $alt, 
                                                'html'          =>  $html,
                                            ) ;
            		                    }
        		                    }else{
      		                            if($check){
            		                    	Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("Update "._DB_PREFIX_."megamenus_menuitem_lang Set `name` = '".$name."', `link` = '".$link."', `imageAlt` = '".$alt."', `html` = '".$html."'  Where `menuitem_id` = $itemId AND `id_lang` = ".$language->id);	
            		                    }else{
            		                    	$insertDatas[] = array(
                                                'menuitem_id'   =>  $itemId, 
                                                'id_lang'       =>  $language->id, 
                                                'name'          =>  $name, 
                                                'link'          =>  $link, 
                                                'image'         =>  '', 
                                                'imageAlt'      =>  $alt, 
                                                'html'          =>  $html,
                                            ) ;
            		                    }
        		                    }                            		                    
        		                }else{
        		                	if($check){
        		                    	Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("Update "._DB_PREFIX_."megamenus_menuitem_lang Set `name` = '".$name."', `link` = '".$link."', `imageAlt` = '".$alt."', `html` = '".$html."'  Where `menuitem_id` = $itemId AND `id_lang` = ".$language->id);	
        		                    }else{
        		                    	$insertDatas[] = array(
                                            'menuitem_id'   =>  $itemId, 
                                            'id_lang'       =>  $language->id, 
                                            'name'          =>  $name, 
                                            'link'          =>  $link, 
                                            'image'         =>  '', 
                                            'imageAlt'      =>  $alt, 
                                            'html'          =>  $html,
                                        ) ;
        		                    }        		                	
        		                }    
                            }                            
                        }else{
                            if($check){                                
		                    	Db::getInstance(_PS_USE_SQL_SLAVE_)->execute("Update "._DB_PREFIX_."megamenus_menuitem_lang Set `name` = '".$name."', `link` = '".$link."', `image` = '', `imageAlt` = '".$alt."', `html` = '".$html."'  Where `menuitem_id` = $itemId AND `id_lang` = ".$language->id);	
		                    }else{
		                    	$insertDatas[] = array(
                                    'menuitem_id'=>$itemId, 
                                    'id_lang'=>$language->id, 
                                    'name'=>$name, 
                                    'link'=>$link, 
                                    'image'=>'', 
                                    'imageAlt'=>$alt, 
                                    'html'=>$html,
                                ) ;
		                    }
                        }                		
						if($insertDatas) Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_menuitem', $insertDatas);
                	}
                }
				$response->status = 1;
            	$response->msg = $this->l("Update menu item success!");
            }
        }else{
            $response->status = '0';
            $response->msg = $this->l('Module or Row or Group not found');
        }
        die(Tools::jsonEncode($response));
    }
	//=========================================================================================================================================================
	//																		PROSESS COPY
	//=========================================================================================================================================================
	// copy megamenu
	public function copyMegamenu($sourceId=0, $ajax = true){
				
		if(!$sourceId) $sourceId = Tools::getValue('id', 0);
		$response = new stdClass();
		if($sourceId >0){
			$item = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("Select * From "._DB_PREFIX_."megamenus_module Where id = $sourceId");			
			if($item){
				$shopId = Context::getContext()->shop->id;
				$themeId = (int)$this->context->shop->id_theme;
				$theme = new Theme($themeId);
				$optionDirectory = Configuration::get('CURRENT_OPTION_DIR') ?  Configuration::get('CURRENT_OPTION_DIR') : '';		
				$sourceItemLanguages = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select * From "._DB_PREFIX_."megamenus_module_lang Where `module_id`='$sourceId'");
				$maxOrdering = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue("Select MAX(ordering) From "._DB_PREFIX_."megamenus_module Where `position_name` = '".$item['position_name']."'");
		   		if($maxOrdering >0) $maxOrdering++;
		   		else $maxOrdering = 1;				
				$arrInsert = array(
					'id_shop'			=>	$shopId,
					'theme_directory'	=>	$theme->directory,
					'option_directory'	=>	$optionDirectory,
					'position_name'		=>	$item['position_name'],
					'layout'			=>	$item['layout'],
					'display_name'		=>	$item['display_name'],
					'show_count'		=>	$item['show_count'],
					'custom_class'		=>	$item['custom_class'],					
					'status'			=>	$item['status'],
					'ordering'			=>	$maxOrdering,
				);
				if(Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_module', $arrInsert)){
					$insertId = Db::getInstance(_PS_USE_SQL_SLAVE_)->Insert_ID();
					$arrInserts = array();
					foreach($sourceItemLanguages as $i=>$sourceItemLanguage){
						$arrInserts[] = array(
							'module_id'	=>	$insertId,
							'id_lang'	=>	$sourceItemLanguage['id_lang'],
							'name'		=>	$this->l('Copy ').$sourceItemLanguage['name'],
						); 
					}
					if($arrInserts) Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_module_lang', $arrInserts);
					$rows = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select id From "._DB_PREFIX_."megamenus_menu Where module_id = ".$sourceId);
					if($rows)
						foreach($rows as $row)
							$this->copyMenu($row['id'], false, $insertId);
				}				
				if($ajax === false) return true;
				$response->status = '1';
            	$response->msg = $this->l('Copy menu successful');
			}else{
				if($ajax === false) return false;
				$response->status = '0';
            	$response->msg = $this->l('Menu not found');
			}
		}else{
			if($ajax === false) return false;
			$response->status = '0';
            $response->msg = $this->l('Menu not found');
		}
		die(Tools::jsonEncode($response));
	}
	// Copy menu
	public function copyMenu($sourceId=0, $ajax = true, $moduleId=0){		
		if(!$sourceId) $sourceId = Tools::getValue('id', 0);
		$response = new stdClass();
		if($sourceId >0){
			$item = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("Select * From "._DB_PREFIX_."megamenus_menu Where id = $sourceId");			
			if($item){
				if(!$moduleId) $moduleId = $item['module_id'];
				$sourceItemLanguages = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select * From "._DB_PREFIX_."megamenus_menu_lang Where `menu_id`='$sourceId'");
				$maxOrdering = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue("Select MAX(ordering) From "._DB_PREFIX_."megamenus_menu Where `module_id` = ".$item['module_id']);
		   		if($maxOrdering >0) $maxOrdering++;
		   		else $maxOrdering = 1;				
				$arrInsert = array(
					'parent_id'		=>	$item['parent_id'],
					'module_id'		=>	$moduleId,
					'display_name'	=>	$item['display_name'],
					'background'	=>	$this->copyFile($item['background'], 0),
					'icon'			=>	$this->copyFile($item['icon'], 0),
					'icon_active'	=>	$this->copyFile($item['icon_active'], 0),
					'link_type'		=>	$item['link_type'],
					'custom_class'	=>	$item['custom_class'],
					'product_id'	=>	$item['product_id'],
					'width'			=>	$item['width'],					
					'status'		=>	$item['status'],
					'ordering'		=>	$maxOrdering,
				);
				if(Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_menu', $arrInsert)){
					$insertId = Db::getInstance(_PS_USE_SQL_SLAVE_)->Insert_ID();
					$arrInserts = array();
					foreach($sourceItemLanguages as $i=>$sourceItemLanguage){
						$arrInserts[] = array(
							'menu_id'	=>	$insertId,
							'id_lang'	=>	$sourceItemLanguage['id_lang'],
							'name'		=>	$this->l('Copy ').$sourceItemLanguage['name'],
							'link'		=>	$sourceItemLanguage['link'],
						); 
					}
					if($arrInserts) Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_menu_lang', $arrInserts);
					$rows = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select id From "._DB_PREFIX_."megamenus_row Where menu_id = ".$sourceId);
					if($rows)
						foreach($rows as $row)
							$this->copyRow($row['id'], false, $moduleId, $insertId);
					
					$submenus_1 = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select id From "._DB_PREFIX_."megamenus_menu Where parent_id = $sourceId");
					if($submenus_1){
						foreach($submenus_1 as $submenu_1){
							$submenu_1_insert = $this->copySubMenu($submenu_1['id'], $insertId);
							if($submenu_1_insert){
								$submenus_2 = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select id From "._DB_PREFIX_."megamenus_menu Where parent_id = '".$submenu_1['id']."'");
								if($submenus_2){
									foreach($submenus_2 as $submenu_2){
										$submenu_2_insert = $this->copySubMenu($submenu_2['id'], $submenu_1_insert);
										if($submenu_2_insert){
											$submenus_3 = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select id From "._DB_PREFIX_."megamenus_menu Where parent_id = '".$submenu_2['id']."'");
											if($submenus_3){
												foreach($submenus_3 as $submenu_3){
													$submenu_3_insert = $this->copySubMenu($submenu_3['id'], $submenu_2_insert);
													if($submenu_3_insert){
														$submenus_4 = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select id From "._DB_PREFIX_."megamenus_menu Where parent_id = '".$submenu_3['id']."'");
														if($submenus_4){
															foreach($submenus_4 as $submenu_4){
																$submenu_4_insert = $this->copySubMenu($submenu_4['id'], $submenu_3_insert);
																if($submenu_4_insert){
																	$submenus_5 = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select id From "._DB_PREFIX_."megamenus_menu Where parent_id = '".$submenu_4['id']."'");
																	if($submenus_5){
																		foreach($submenus_5 as $submenu_5){
																			$this->copySubMenu($submenu_5['id'], $submenu_4_insert);
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}				
				if($ajax === false) return true;
				$response->status = '1';
            	$response->msg = $this->l('Copy menu successful');
			}else{
				if($ajax === false) return false;
				$response->status = '0';
            	$response->msg = $this->l('Menu not found');
			}
		}else{
			if($ajax === false) return false;
			$response->status = '0';
            $response->msg = $this->l('Menu not found');
		}
		die(Tools::jsonEncode($response));
	}
	/**
	 * copySubMenu function
	 *
	 * @return void
	 * @author  
	 */
	public function copySubMenu($sourceId=0, $parentId=0){		
		if(!$sourceId) $sourceId = Tools::getValue('id', 0);
		$response = new stdClass();
		if($sourceId >0){
			$item = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("Select * From "._DB_PREFIX_."megamenus_menu Where id = $sourceId");			
			if($item){
				if(!$parentId) $parentId = $item['parent_id'];
				$sourceItemLanguages = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select * From "._DB_PREFIX_."megamenus_menu_lang Where `menu_id`='$sourceId'");
				$maxOrdering = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue("Select MAX(ordering) From "._DB_PREFIX_."megamenus_menu Where `module_id` = ".$item['module_id']);
		   		if($maxOrdering >0) $maxOrdering++;
		   		else $maxOrdering = 1;				
				$arrInsert = array(
					'parent_id'		=>	$parentId,
					'module_id'		=>	$item['module_id'],
					'display_name'	=>	$item['display_name'],
					'background'	=>	$this->copyFile($item['background'], 0),
					'icon'			=>	$this->copyFile($item['icon'], 0),
					'icon_active'	=>	$this->copyFile($item['icon_active'], 0),
					'link_type'		=>	$item['link_type'],
					'custom_class'	=>	$item['custom_class'],
					'product_id'	=>	$item['product_id'],
					'width'			=>	$item['width'],					
					'status'		=>	$item['status'],
					'ordering'		=>	$maxOrdering,
				);
				if(Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_menu', $arrInsert)){
					$insertId = Db::getInstance(_PS_USE_SQL_SLAVE_)->Insert_ID();
					$arrInserts = array();
					foreach($sourceItemLanguages as $i=>$sourceItemLanguage){
						$arrInserts[] = array(
							'menu_id'	=>	$insertId,
							'id_lang'	=>	$sourceItemLanguage['id_lang'],
							'name'		=>	$this->l('Copy ').$sourceItemLanguage['name'],
							'link'		=>	$sourceItemLanguage['link'],
						); 
					}
					if($arrInserts) Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_menu_lang', $arrInserts);
					$rows = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select id From "._DB_PREFIX_."megamenus_row Where menu_id = ".$sourceId);
					if($rows)
						foreach($rows as $row)
							$this->copyRow($row['id'], false, $moduleId, $insertId);
					return $insertId;
				}				
				return false;
			}else{
				return false;
			}
		}else{
			return false;
		}
		return false;
	}
	// Copy row	
	public function copyRow($sourceId=0, $ajax = true, $moduleId=0, $menuId=0){		
		if(!$sourceId) $sourceId = Tools::getValue('id', 0);
		$response = new stdClass();
		if($sourceId >0){
			$item = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("Select * From "._DB_PREFIX_."megamenus_row Where id = $sourceId");			
			if($item){
				if(!$moduleId) $moduleId = $item['module_id'];
				if(!$menuId) $menuId = $item['menu_id'];
				$sourceItemLanguages = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select * From "._DB_PREFIX_."megamenus_row_lang Where `row_id`='$sourceId'");
				$maxOrdering = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue("Select MAX(ordering) From "._DB_PREFIX_."megamenus_row Where `module_id` = ".$item['module_id']." AND `menu_id`=".$item['menu_id']);
		   		if($maxOrdering >0) $maxOrdering++;
		   		else $maxOrdering = 1;				
				$arrInsert = array(
					'module_id'		=>	$moduleId,
					'menu_id'		=>	$menuId,
					'width'			=>	$item['width'],
					'display_name'	=>	$item['display_name'],
					'custom_class'	=>	$item['custom_class'],					
					'status'		=>	$item['status'],
					'ordering'		=>	$maxOrdering,
				);
				if(Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_row', $arrInsert)){
					$insertId = Db::getInstance(_PS_USE_SQL_SLAVE_)->Insert_ID();
					$arrInserts = array();
					foreach($sourceItemLanguages as $i=>$sourceItemLanguage){
						$arrInserts[] = array(
							'row_id'	=>	$insertId,
							'id_lang'		=>	$sourceItemLanguage['id_lang'],
							'name'			=>	$this->l('Copy ').$sourceItemLanguage['name'],
						); 
					}
					if($arrInserts) Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_row_lang', $arrInserts);
					$rows = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select id From "._DB_PREFIX_."megamenus_group Where row_id = ".$sourceId);
					if($rows)
						foreach($rows as $row)
							$this->copyGroup($row['id'], false, $moduleId, $menuId, $insertId);
				}				
				if($ajax === false) return true;
				$response->status = '1';
            	$response->msg = $this->l('Copy row successful');
			}else{
				if($ajax === false) return false;
				$response->status = '0';
            	$response->msg = $this->l('Megamenu row not found');
			}
		}else{
			if($ajax === false) return false;
			$response->status = '0';
            $response->msg = $this->l('Megamenu row not found');
		}
		die(Tools::jsonEncode($response));
	}
	// Copy group
	public function copyGroup($sourceId=0, $ajax = true, $moduleId=0, $menuId=0, $rowId = 0){		
		if(!$sourceId) $sourceId = Tools::getValue('id', 0);
		$response = new stdClass();
		if($sourceId >0){
			$item = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("Select * From "._DB_PREFIX_."megamenus_group Where id = $sourceId");			
			if($item){
				if(!$moduleId) $moduleId = $item['module_id'];
				if(!$menuId) $menuId = $item['menu_id'];
				if(!$rowId) $rowId = $item['row_id'];
				
				$sourceItemLanguages = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select * From "._DB_PREFIX_."megamenus_group_lang Where `group_id`='$sourceId'");
				$maxOrdering = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue("Select MAX(ordering) From "._DB_PREFIX_."megamenus_group Where `module_id` = ".$item['module_id']." AND `row_id` = ".$item['row_id']);
		   		if($maxOrdering >0) $maxOrdering++;
		   		else $maxOrdering = 1;				
				$arrInsert = array(
					'module_id'			=>	$moduleId,
					'menu_id'			=>	$menuId,
					'row_id'			=>	$rowId,
					'display_title'		=>	$item['display_title'],
					'custom_class'		=>	$item['custom_class'],
					'type'				=>	$item['type'],
					'params'			=>	$item['params'],
					'width'				=>	$item['width'],
					'status'			=>	$item['status'],
					'ordering'			=>	$maxOrdering,
				);
				
				if(Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_group', $arrInsert)){
					$insertId = Db::getInstance(_PS_USE_SQL_SLAVE_)->Insert_ID();
					$arrInserts = array();
					foreach($sourceItemLanguages as $i=>$sourceItemLanguage){
						$arrInserts[] = array(
							'group_id'	=>	$insertId,
							'id_lang'		=>	$sourceItemLanguage['id_lang'],
							'name'			=>	$this->l('Copy ').$sourceItemLanguage['name'],
						); 
					}
					if($arrInserts) Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_group_lang', $arrInserts);
					$rows = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select id From "._DB_PREFIX_."megamenus_menuitem Where group_id = ".$sourceId);
					if($rows)
						foreach($rows as $row)
							$this->copyMenuItem($row['id'], false, $moduleId, $menuId, $rowId, $insertId);
				}				
				if($ajax === false) return true;
				$response->status = '1';
            	$response->msg = $this->l('Copy group successful');
			}else{
				if($ajax === false) return false;
				$response->status = '0';
            	$response->msg = $this->l('Megamenu group not found');
			}
		}else{
			if($ajax === false) return false;
			$response->status = '0';
            $response->msg = $this->l('Megamenu group not found');
		}
		die(Tools::jsonEncode($response));
	}
	// Copy menuitem
	public function copyMenuItem($sourceId=0, $ajax = true, $moduleId=0, $menuId=0, $rowId=0, $groupId=0){		
		if(!$sourceId) $sourceId = Tools::getValue('id', 0);
		$response = new stdClass();
		if($sourceId >0){
			$item = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("Select * From "._DB_PREFIX_."megamenus_menuitem Where id = $sourceId");
			if($item){
				if(!$moduleId) $moduleId = $item['module_id'];
				if(!$menuId) $menuId = $item['menu_id'];
				if(!$rowId) $rowId = $item['row_id'];
				if(!$groupId){
					$groupId = $item['group_id'];
					$parentId = $item['parent_id'];
				}else{
					$parentId = 0;
				} 				
				$sourceItemLanguages = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select * From "._DB_PREFIX_."megamenus_menuitem_lang Where `menuitem_id`='$sourceId'");
				$maxOrdering = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue("Select MAX(ordering) From "._DB_PREFIX_."megamenus_menuitem Where `module_id` = ".$item['module_id']." AND `row_id` = ".$item['row_id']." AND `group_id` = ".$item['group_id']);
		   		if($maxOrdering >0) $maxOrdering++;
		   		else $maxOrdering = 1;				
				$arrInsert = array(
					'module_id'		=>	$moduleId,
					'menu_id'		=>	$menuId,
					'row_id'		=>	$rowId,
					'group_id'		=>	$groupId,
					'parent_id'		=>	$parentId,
					'menu_type'		=>	$item['menu_type'],
					'link_type'		=>	$item['link_type'],
					'link'			=>	$item['link'],
					'custom_class'	=>	$item['custom_class'],
					'display_name'	=>	$item['display_name'],
					'status'		=>	$item['status'],
					'module_name'	=>	$item['module_name'],
					'hook_name'		=>	$item['hook_name'],
					'product_id'	=>	$item['product_id'],
					'icon'			=>	$this->copyFile($item['icon'], 0),
					'icon_active'	=>	$this->copyFile($item['icon_active'], 0),	
					'ordering'		=>	$maxOrdering,
				);
				if(Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_menuitem', $arrInsert)){
					$insertId = Db::getInstance(_PS_USE_SQL_SLAVE_)->Insert_ID();
					$arrInserts = array();
					foreach($sourceItemLanguages as $i=>$sourceItemLanguage){
						$arrInserts[] = array(
							'menuitem_id'	=>	$insertId,
							'id_lang'		=>	$sourceItemLanguage['id_lang'],
							'name'			=>	$this->l('Copy ').$sourceItemLanguage['name'],
							'link'			=>	$sourceItemLanguage['link'],
							'image'			=>	$this->copyFile($sourceItemLanguage['image'], $insertId),
							'imageAlt'		=>	$sourceItemLanguage['imageAlt'],
							'html'			=>	$sourceItemLanguage['html'],
						); 
					}
					if($arrInserts) Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_menuitem_lang', $arrInserts);
					
					$submenus_1 = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select id From "._DB_PREFIX_."megamenus_menuitem Where parent_id = '$sourceId'");
					if($submenus_1){
						foreach($submenus_1 as $submenu_1){
							$submenu_1_insert = $this->copySubMenuItem($submenu_1['id'], $insertId);
							if($submenu_1_insert){
								$submenus_2 = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select id From "._DB_PREFIX_."megamenus_menuitem Where parent_id = '".$submenu_1['id']."'");
								if($submenus_2){
									foreach($submenus_2 as $submenu_2){
										$submenu_2_insert = $this->copySubMenuItem($submenu_2['id'], $submenu_1_insert);
										if($submenu_2_insert){
											$submenus_3 = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select id From "._DB_PREFIX_."megamenus_menuitem Where parent_id = '".$submenu_2['id']."'");
											if($submenus_3){
												foreach($submenus_3 as $submenu_3){
													$submenu_3_insert = $this->copySubMenuItem($submenu_3['id'], $submenu_2_insert);
													if($submenu_3_insert){
														$submenus_4 = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select id From "._DB_PREFIX_."megamenus_menuitem Where parent_id = '".$submenu_3['id']."'");
														if($submenus_4){
															foreach($submenus_4 as $submenu_4){
																$submenu_4_insert = $this->copySubMenuItem($submenu_4['id'], $submenu_3_insert);
																if($submenu_4_insert){
																	$submenus_5 = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select id From "._DB_PREFIX_."megamenus_menuitem Where parent_id = '".$submenu_4['id']."'");
																	if($submenus_5){
																		foreach($submenus_5 as $submenu_5){
																			$this->copySubMenuItem($submenu_5['id'], $submenu_4_insert);
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}

				}
				if($ajax === false) return true;
				$response->status = '1';
            	$response->msg = $this->l('Copy menuitem successful');
			}else{
				if($ajax === false) return false;
				$response->status = '0';
            	$response->msg = $this->l('Menuitem not found');
			}
		}else{
			if($ajax === false) return false;
			$response->status = '0';
            $response->msg = $this->l('Menuitem not found');
		}
		die(Tools::jsonEncode($response));
	}
	protected function copySubMenuItem($sourceId=0, $parentId=0){		
		if(!$sourceId) $sourceId = Tools::getValue('id', 0);
		$response = new stdClass();
		if($sourceId >0){
			$item = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("Select * From "._DB_PREFIX_."megamenus_menuitem Where id = $sourceId");
			if($item){
				if(!$parentId) $parentId = $item['parent_id'];				
				$sourceItemLanguages = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select * From "._DB_PREFIX_."megamenus_menuitem_lang Where `menuitem_id`='$sourceId'");
				$maxOrdering = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue("Select MAX(ordering) From "._DB_PREFIX_."megamenus_menuitem Where `module_id` = ".$item['module_id']." AND `row_id` = ".$item['row_id']." AND `group_id` = ".$item['group_id']);
		   		if($maxOrdering >0) $maxOrdering++;
		   		else $maxOrdering = 1;				
				$arrInsert = array(
					'module_id'		=>	$item['module_id'],
					'menu_id'		=>	$item['menu_id'],
					'row_id'		=>	$item['row_id'],
					'group_id'		=>	$item['group_id'],
					'parent_id'		=>	$parentId,
					'menu_type'		=>	$item['menu_type'],
					'link_type'		=>	$item['link_type'],
					'link'			=>	$item['link'],
					'custom_class'	=>	$item['custom_class'],
					'display_name'	=>	$item['display_name'],
					'status'		=>	$item['status'],
					'module_name'	=>	$item['module_name'],
					'hook_name'		=>	$item['hook_name'],
					'product_id'	=>	$item['product_id'],
					'icon'			=>	$this->copyFile($item['icon'], 0),
					'icon_active'	=>	$this->copyFile($item['icon_active'], 0),	
					'ordering'		=>	$maxOrdering,
				);
				if(Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_menuitem', $arrInsert)){
					$insertId = Db::getInstance(_PS_USE_SQL_SLAVE_)->Insert_ID();
					$arrInserts = array();
					foreach($sourceItemLanguages as $i=>$sourceItemLanguage){
						$arrInserts[] = array(
							'menuitem_id'	=>	$insertId,
							'id_lang'		=>	$sourceItemLanguage['id_lang'],
							'name'			=>	$this->l('Copy ').$sourceItemLanguage['name'],
							'link'			=>	$sourceItemLanguage['link'],
							'image'			=>	$this->copyFile($sourceItemLanguage['image'], $insertId),
							'imageAlt'		=>	$sourceItemLanguage['imageAlt'],
							'html'			=>	$sourceItemLanguage['html'],
						); 
					}
					if($arrInserts) Db::getInstance(_PS_USE_SQL_SLAVE_)->insert('megamenus_menuitem_lang', $arrInserts);
					return $insertId;
				}
				return false;
			}else{
				return false;				
			}
		}else{
			return false;			
		}
	}
	// copy file
	protected function copyFile($source='', $newId=0){		
		if($source){
			if(strpos($source, '.') === false){
				return $source;
			}else{
				if(strpos($source, 'http') !== false){
					return $source;	
				}else{
					if(file_exists($this->pathImage.$source)){
						$arr = explode('_', $source);
						$arr[0]=Tools::encrypt($newId.$arr[0]);
						$destination = implode('', $arr);
						if(copy($this->pathImage.$source, $this->pathImage.$destination)){
							return $destination;						
						}else{
							return '';
						}
					}else{
						return '';
					}
				}	
			}
			
		}
		return '';
	}
	//=========================================================================================================================================================
	//																			END PROSESS COPY
	//=========================================================================================================================================================
	public function changeMegamenuStatus(){
		$itemId		=	intval($_POST['itemId']);
		$value 		= 	intval($_POST['value']);		
		$response	=	new stdClass();
		if($value == '1'){
			Db::getInstance()->execute("Update "._DB_PREFIX_."megamenus_module Set `status` = 0 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}else{
			Db::getInstance()->execute("Update "._DB_PREFIX_."megamenus_module Set `status` = 1 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}
		die(Tools::jsonEncode($response));
	}
	public function changMenuStatus(){
		$itemId = intval($_POST['id']);
		$value = intval($_POST['value']);		
		$response = new stdClass();
		if($value == '1'){
			Db::getInstance()->execute("Update "._DB_PREFIX_."megamenus_menu Set `status` = 0 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}else{
			Db::getInstance()->execute("Update "._DB_PREFIX_."megamenus_menu Set `status` = 1 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}
		die(Tools::jsonEncode($response));
	}
	public function changRowStatus(){
		$itemId = intval($_POST['itemId']);
		$value = intval($_POST['value']);		
		$response = new stdClass();
		if($value == '1'){
			Db::getInstance()->execute("Update "._DB_PREFIX_."megamenus_row Set `status` = 0 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}else{
			Db::getInstance()->execute("Update "._DB_PREFIX_."megamenus_row Set `status` = 1 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}
		die(Tools::jsonEncode($response));
	}
	public function changGroupStatus(){
		$itemId = intval($_POST['itemId']);
		$value = intval($_POST['value']);		
		$response = new stdClass();
		if($value == '1'){
			Db::getInstance()->execute("Update "._DB_PREFIX_."megamenus_group Set `status` = 0 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}else{
			Db::getInstance()->execute("Update "._DB_PREFIX_."megamenus_group Set `status` = 1 Where id = ".$itemId);
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
			Db::getInstance()->execute("Update "._DB_PREFIX_."megamenus_menuitem Set `status` = 0 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}else{
			Db::getInstance()->execute("Update "._DB_PREFIX_."megamenus_menuitem Set `status` = 1 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}
		die(Tools::jsonEncode($response));
	}
	
	
	public function getMegamenuItem(){		
        $response = new stdClass();
        $itemId = intval($_POST['itemId']);
        if($itemId){
        	$response->form = $this->generateFormMegamenu($itemId);		       
            $response->status = '1';
            $response->msg = '';
        }else{
            $response->status = '0';
            $response->msg = $this->l('Item not found!');
        }		
        die(Tools::jsonEncode($response));
	}
	/**
	 * getSubMenuItem function
	 *
	 * @return void
	 * @author  
	 */
	public function getSubMenuItem() {
		$response = new stdClass();
        $itemId = Tools::getValue('id', 0);
        if($itemId){
        	$response->form = $this->generateFormSubMenu($itemId);		       
            $response->status = '1';
            $response->msg = '';
        }else{
            $response->status = '0';
            $response->msg = $this->l('Item not found!');
        }		
        die(Tools::jsonEncode($response));
	}
	public function getMenuItem(){		
        $response = new stdClass();
        $itemId = Tools::getValue('id', 0);
        if($itemId){
        	$response->form = $this->generateFormMenu($itemId);		       
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
        	$response->form = $this->generateFormRow($itemId);			       
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
        	$form = $this->generateFormGroup($itemId);
        	$response->config = $form['config'];
			$response->description = $form['description'];			       
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
        $itemId = Tools::getValue('id', 0);// intval($_POST['itemId']);
        if($itemId){
        	$response->form = $this->generateFormMenuItem($itemId);// renderMenuItemForm($itemId);
            $response->status = '1';
            $response->msg = '';
        }else{
            $response->status = '0';
            $response->msg = $this->l('Item not found!');
        }		
        die(Tools::jsonEncode($response));
	}
	/**
	 * deleteMegamenuItem function
	 *	ajax function
	 * 	Xóa megamenu item
	 * @return void
	 * @author  
	 */	
	public function deleteMegamenuItem($itemId=0, $ajax=true){
		if(!$itemId) $itemId = Tools::getValue('id', 0);		
        $response = new stdClass();        
		if($itemId){
			if(Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_module Where id = ".$itemId)){
	        	// delete module language
	            Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_module_lang Where module_id = ".$itemId);			
				// delete menu language
				Db::getInstance()->execute("Delete ml From "._DB_PREFIX_."megamenus_menu_lang AS ml Inner Join "._DB_PREFIX_."megamenus_menu AS m On ml.menu_id = m.id Where m.module_id = ".$itemId);			
				// delete menu
				Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_menu Where module_id = ".$itemId);			
				// delete row language
				Db::getInstance()->execute("Delete rl From "._DB_PREFIX_."megamenus_row_lang AS rl Inner Join "._DB_PREFIX_."megamenus_row AS r On rl.row_id = r.id Where r.module_id = ".$itemId);
				// delete row
				Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_row Where module_id = ".$itemId);
				// delete group language
				Db::getInstance()->execute("Delete gl From "._DB_PREFIX_."megamenus_group_lang AS gl Inner Join "._DB_PREFIX_."megamenus_group AS g On gl.group_id = g.id Where g.module_id = ".$itemId);
				// delete group
				Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_group Where module_id = ".$itemId);
				// delete menu item language
				Db::getInstance()->execute("Delete ml From "._DB_PREFIX_."megamenus_menuitem_lang AS ml Inner Join "._DB_PREFIX_."megamenus_menuitem AS m On ml.menuitem_id = m.id Where m.module_id = ".$itemId);
				// delete menu item
				Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_menuitem Where module_id = ".$itemId);						
	            if($ajax === false) return true;
	            $response->status = '1';
	            $response->msg = $this->l('Delete Module Success!');
	        }else{
	        	if($ajax === false) return false;
	            $response->status = '0';
	            $response->msg = $this->l('Delete Module not Success!');
	        }
		}else{
			if($ajax === false) return false;
			$response->status = '0';
	        $response->msg = $this->l('Delete Module not Success!');
		}        
        die(Tools::jsonEncode($response));
	}
	protected function _getAllSubmenuId($parentId, $arr = null){
		if($arr == null) $arr = array();
		$items = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select id From "._DB_PREFIX_."megamenus_menu Where parent_id = '$parentId'");
		if($items){
			foreach($items as $item){
				$arr[] = $item['id'];
				$arr = $this->_getAllSubmenuId($item['id'], $arr);
			}
		}
		return $arr;
	}
	protected function _getAllSubmenuitemId($parentId, $arr = null){
		if($arr == null) $arr = array();
		$items = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select id From "._DB_PREFIX_."megamenus_menuitem Where parent_id = '$parentId'");
		if($items){
			foreach($items as $item){
				$arr[] = $item['id'];
				$arr = $this->_getAllSubmenuitemId($item['id'], $arr);
			}
		}
		return $arr;
	}
	public function deleteMenu($itemId=0, $ajax=true){
        if(!$itemId) $itemId = Tools::getValue('id', 0);
        $response = new stdClass(); 		
        if($itemId){
        	$subMenuIds = $this->_getAllSubmenuId($itemId, null);
            if(Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_menu Where `id` = ".$itemId)){
                // delete menu language
                Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_menu_lang Where `menu_id` = ".$itemId);
				// delete subs
				if($subMenuIds){
					$strSubmenuIds = implode(', ', $subMenuIds);
					Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_menu Where id In ($strSubmenuIds)");
					Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_menu_lang Where `menu_id` In ($strSubmenuIds)");
				}
                // delete row language
    			Db::getInstance()->execute("Delete rl.* From "._DB_PREFIX_."megamenus_row_lang AS rl Inner Join "._DB_PREFIX_."megamenus_row AS r On rl.row_id = r.id Where r.menu_id = ".$itemId);
                // delete row
    			Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_row Where menu_id = ".$itemId);
                // delete group language
    			Db::getInstance()->execute("Delete gl.* From "._DB_PREFIX_."megamenus_group_lang AS gl Inner Join "._DB_PREFIX_."megamenus_group AS g On gl.group_id = g.id Where g.menu_id = ".$itemId);
                // delete group
    			Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_group Where menu_id = ".$itemId);
                // delete menu item language
    			Db::getInstance()->execute("Delete ml.* From "._DB_PREFIX_."megamenus_menuitem_lang AS ml Inner Join "._DB_PREFIX_."megamenus_menuitem AS m On ml.menuitem_id = m.id Where m.menu_id = ".$itemId);
                // delete menu item
    			Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_menuitem Where menu_id = ".$itemId);
                if($ajax === false) return true;						
                $response->status = '1';
                $response->msg = $this->l('Delete Menu Success!');
            }else{
                if($ajax === false) return false;
                $response->status = '0';
                $response->msg = $this->l('Delete Menu not Success!');
            }   
        }        
        die(Tools::jsonEncode($response));
	}	
	public function deleteRow(){
		$itemId = intval($_POST['itemId']);
        $response = new stdClass();        
        if(Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_row Where id = ".$itemId)){
            // delete row language
            Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_row_lang Where row_id = ".$itemId);
            // delete group language
			Db::getInstance()->execute("Delete gl.* From "._DB_PREFIX_."megamenus_group_lang AS gl Inner Join "._DB_PREFIX_."megamenus_group AS g On gl.group_id = g.id Where g.row_id = ".$itemId);
            // delete group
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_group Where row_id = ".$itemId);
            // delete menu item language
			Db::getInstance()->execute("Delete ml.* From "._DB_PREFIX_."megamenus_menuitem_lang AS ml Inner Join "._DB_PREFIX_."megamenus_menuitem AS m On ml.menuitem_id = m.id Where m.row_id = ".$itemId);
            // delete menu item
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_menuitem Where row_id = ".$itemId);            						
            $response->status = '1';
            $response->msg = $this->l('Delete row Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Delete row not Success!');
        }
        die(Tools::jsonEncode($response));
	}
	public function deleteGroup(){
		$itemId = intval($_POST['itemId']);
        $response = new stdClass();        
        if(Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_group Where id = ".$itemId)){
           	// delete group language
            Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_group_lang Where group_id = ".$itemId);
            // delete menu item language
			Db::getInstance()->execute("Delete ml.* From "._DB_PREFIX_."megamenus_menuitem_lang AS ml Inner Join "._DB_PREFIX_."megamenus_menuitem AS m On ml.menuitem_id = m.id Where m.group_id = ".$itemId);
            // delete menu item
			Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_menuitem Where group_id = ".$itemId);						
            $response->status = '1';
            $response->msg = $this->l('Delete group Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Delete group not Success!');
        }
        die(Tools::jsonEncode($response));
	}
	public function deleteMenuItem(){
		$itemId = intval($_POST['itemId']);
        $response = new stdClass();
		$subMenuitemIds = $this->_getAllSubmenuId($itemId);        
        if(Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_menuitem Where id = ".$itemId)){
            Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_menuitem_lang Where menuitem_id = ".$itemId);
			// delete submenus
			if($subMenuitemIds){
				$strIds = implode(', ', $subMenuitemIds);
				Db::getInstance()->execute("Delete ml.* From "._DB_PREFIX_."megamenus_menuitem_lang AS ml Inner Join "._DB_PREFIX_."megamenus_menuitem AS m On ml.menuitem_id = m.id Where m.parent_id = ".$itemId);
				Db::getInstance()->execute("Delete From "._DB_PREFIX_."megamenus_menuitem Where parent_id = ".$itemId);
			}	
            $response->status = '1';
            $response->msg = $this->l('Delete menu item Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Delete menu item not Success!');
        }
        die(Tools::jsonEncode($response));
	}	
	public function updateMenuOrdering(){
        $response = new stdClass();
        $ids = $_POST['ids'];        
        if($ids){            
            foreach($ids as $i=>$id){
                Db::getInstance()->query("Update "._DB_PREFIX_."megamenus_menu Set ordering=".($i+1)." Where id = ".$id);                
            }
            $response->status = '1';
            $response->msg = $this->l('Update Menu Ordering Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Update Menu Ordering not Success!');
        }
        die(Tools::jsonEncode($response));
	}
	public function updateModuleOrdering(){
        $response = new stdClass();
        $ids = $_POST['ids'];        
        if($ids){
            $strIds = implode(', ', $ids);            
            $minOrder = Db::getInstance()->getValue("Select Min(ordering) From "._DB_PREFIX_."megamenus_module Where id IN ($strIds)");            
            foreach($ids as $i=>$id){
                Db::getInstance()->query("Update "._DB_PREFIX_."megamenus_module Set ordering=".($minOrder + $i)." Where id = ".$id);                
            }
            $response->status = '1';
            $response->msg = $this->l('Update Module Ordering Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Update Module Ordering not Success!');
        }
        die(Tools::jsonEncode($response));
	}
	public function updateRowOrdering(){
        $response = new stdClass();
        $ids = $_POST['ids'];        
        if($ids){        	
        	foreach($ids as $index=>$id){
        		Db::getInstance()->execute("Update "._DB_PREFIX_."megamenus_row Set `ordering` = '".(1 + $index)."' Where id = ".$id);
        	}			
            $response->status = '1';
            $response->msg = $this->l('Update Row Ordering Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Update Row Ordering not Success!');
        }
        die(Tools::jsonEncode($response));
	}
	public function updateGroupOrdering(){
        $response = new stdClass();
        $ids = $_POST['ids'];
		$moduleId = intval($_POST['moduleId']);
		$menuId = intval($_POST['menuId']);
		$rowId = intval($_POST['rowId']);
        if($ids){
        	foreach($ids as $index=>$id){
        		Db::getInstance()->execute("Update "._DB_PREFIX_."megamenus_group Set `ordering` = '".(1 + $index)."' Where id = ".$id." AND `row_id` = '$rowId'");
        	}			
            $response->status = '1';
            $response->msg = $this->l('Update Group Ordering Success!');
        }else{
            $response->status = '0';
            $response->msg = $this->l('Update Group Ordering not Success!');
        }
        die(Tools::jsonEncode($response));
	}
	
	public function updateMenuItemOrdering(){
        $response = new stdClass();
        $ids = $_POST['ids'];
		$moduleId = intval($_POST['moduleId']);
		$rowId = intval($_POST['rowId']);
		$groupId = intval($_POST['groupId']);
        if($ids){
        	foreach($ids as $index=>$id){
        		Db::getInstance()->execute("Update "._DB_PREFIX_."megamenus_menuitem Set `ordering` = '".(1 + $index)."' Where id = ".$id." AND `module_id` = '$moduleId' AND `row_id` = '$rowId' AND `group_id`='".$groupId."'");
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
		$menuId = intval($_POST['menuId']);
		$rowId = intval($_POST['rowId']);		
        $response = $this->getRowContent($moduleId, $menuId, $rowId);
        die(Tools::jsonEncode($response));
	}
	public function loadGroupContent(){
		$moduleId = intval($_POST['moduleId']);
		$menuId = intval($_POST['menuId']);
		$rowId = intval($_POST['rowId']);
		$groupId = intval($_POST['groupId']);		
        $response = $this->getGroupContent($moduleId, $menuId, $rowId, $groupId);
        die(Tools::jsonEncode($response));
	}
	
	public function loadMegamenuContent(){
		$megamenuId = intval($_POST['id']);
		$response = new stdClass();
		if($megamenuId >0){
			$langId = $this->context->language->id;
    		$shopId = $this->context->shop->id;			
			$items = Db::getInstance()->executeS("Select m.*, ml.name, ml.link 
				From "._DB_PREFIX_."megamenus_menu AS m 
				Left Join "._DB_PREFIX_."megamenus_menu_lang AS ml 
					On ml.menu_id = m.id 
				Where 
					m.module_id = ".$megamenuId." AND 
					m.parent_id = 0 AND  
					ml.`id_lang` = $langId 
				Order By m.ordering");			
            if($items){
            	$response->content = '';
                foreach($items as $item){
					if($item['link_type'] == 'PRODUCT|0'){
						$item['link'] = $this->generateUrl('PRD|'.$item['product_id'], $item['link'], '');
					}else{
						$item['link'] = $this->generateUrl($item['link_type'], $item['link'], '');	
					}					
                    if($item['status'] == "1"){
                        $status = '<a title="Enabled" class="link-active link-status-menu" data-megamenu='.$megamenuId.' data-id="'.$item['id'].'" data-value="'.$item['status'].'">&nbsp;'.$this->l('Status').'</a>';
                    }else{
                        $status = '<a title="Disabled" class="link-deactive link-status-menu c-org" data-megamenu='.$megamenuId.' data-id="'.$item['id'].'" data-value="'.$item['status'].'">&nbsp;'.$this->l('Status').'</a>';
                    }
                    $response->content .=	'<div data-id="'.$item['id'].'" data-megamenu="'.$megamenuId.'" class="list-menu parent-0">		                                        	
		                                        	<div class="clearfix menu-header">
			                                        	<div class="pull-left">
			                                        		<a href="javascript:void(0)" class="c-org link-open-this" data-status="1" data-el="submenu-'.$item['id'].'" ><i class="fa fa-minus-square-o"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" data-megamenu='.$megamenuId.' data-id="'.$item['id'].'" title="'.$item['name'].'" class="link-menu">'.$item['name'].' - '.$item['link'].'</a>
			                                        	</div>			                                        			                                        	
			                                        	<div class="pull-right dts-control actions">			                                        		
							                        		<a href="javascript:void(0)" data-megamenu="'.$megamenuId.'" data-id="'.$item['id'].'" class="link-add link-addsub-menu" title="'.$this->l('Add submenu').'">&nbsp;'.$this->l('Add sub').'</a>
							                        		'.$status.'
							                        		<a href="javascript:void(0)" data-megamenu="'.$megamenuId.'" data-id="'.$item['id'].'" class="link-edit link-edit-menu" title="'.$this->l('Edit menu').'">&nbsp;'.$this->l('Edit').'</a>                        	
								                        	<a href="javascript:void(0)" data-megamenu="'.$megamenuId.'" data-id="'.$item['id'].'" class="link-copy link-copy-menu" title="'.$this->l('Copy menu').'">&nbsp;'.$this->l('Copy').'</a>
								                        	<a href="javascript:void(0)" data-megamenu="'.$megamenuId.'" data-id="'.$item['id'].'" class="link-trash link-trash-menu c-red" title="'.$this->l('Delete menu').'">&nbsp;'.$this->l('Delete').'</a>									                        	
			                                        	</div>
			                                        </div>		                                        	
													<div class="list-menu-level-1 menu-sortable" data-parent="'.$item['id'].'" id="submenu-'.$item['id'].'">'.$this->loadMenuLevel1Content($langId ,$megamenuId, $item['id']).'</div>
		                                    </div>';
                }
				$response->status = 1;				
				$response->msg = $this->l("Load menu success!");
            }else{
            	$response->status = 1;
				$response->content = '';
				$response->msg = $this->l("Load menu success!");	
            }
		}else{
			$response->status = 0;
			$response->content = '';
			$response->msg = $this->l("Module not found!");
		}
		die(Tools::jsonEncode($response));
	}
	public function loadSubmenu(){
		$langId = $this->context->language->id;
    	$shopId = $this->context->shop->id;
		$megamenuId = Tools::getValue('megamenu_id', 0);
		$parentId = Tools::getValue('parent_id', 0);
		$level = $this->_getMenuLevel($parentId);
		$response = new stdClass();
		if($level >0){
			$response->status = 1;
			if($level == 1)
				$response->content = $this->loadMenuLevel1Content($langId, $megamenuId, $parentId);
			elseif($level == 2)
				$response->content = $this->loadMenuLevel2Content($langId, $megamenuId, $parentId);
			elseif($level == 3)
				$response->content = $this->loadMenuLevel3Content($langId, $megamenuId, $parentId);
			else $response = '';
		}else{
			$response->status = 0;
			$response->msg = $this->l('Menu not found');
		}
		die(Tools::jsonEncode($response));
	}
	/**
	 * _getMenuLevel function
	 * @var 
	 * 		int menuId = 0
	 * @return 
	 * 		int level
	 * @author
	 * 		SonNC  
	 */	
	protected function _getMenuLevel($menuId=0){
		if(!$menuId) return 0;
		$level = 1;
		$ok = true;
		while($ok){
			$menuId = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue("Select parent_id From "._DB_PREFIX_."megamenus_menu Where id = $menuId");
			if($menuId >0){
				$level++;
			}else $ok = false;
		}
		return $level;
	}
	protected function loadMenuLevel1Content($langId, $megamenuId=0, $parentId=0){
		if(!$parentId || !$megamenuId) return '';
		$items = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select m.*, ml.name, ml.link 
			From "._DB_PREFIX_."megamenus_menu AS m 
			Left Join "._DB_PREFIX_."megamenus_menu_lang AS ml 
				On ml.menu_id = m.id 
			Where 
				m.module_id = ".$megamenuId." AND 
				m.parent_id = $parentId AND  
				ml.`id_lang` = $langId 
			Order By m.ordering");
		$html = '';
		if($items){
			foreach($items as $item){
				
				if($item['link_type'] == 'PRODUCT|0'){
					$item['link'] = $this->generateUrl('PRD|'.$item['product_id'], $item['link'], '');
				}else{
					$item['link'] = $this->generateUrl($item['link_type'], $item['link'], '');	
				}
								
                if($item['status'] == "1"){
                    $status = '<a title="Enabled" class="link-active link-status-menu" data-parent="'.$parentId.'" data-megamenu='.$megamenuId.' data-id="'.$item['id'].'" data-value="'.$item['status'].'">&nbsp;'.$this->l('Status').'</a>';
                }else{
                    $status = '<a title="Disabled" class="link-deactive link-status-menu c-org" data-megamenu='.$megamenuId.' data-id="'.$item['id'].'" data-value="'.$item['status'].'">&nbsp;'.$this->l('Status').'</a>';
                }                                   
                $html .=	'<div data-id="'.$item['id'].'" data-megamenu="'.$megamenuId.'" data-parent="'.$parentId.'" class="menu-level-1-item parent-'.$parentId.'">		                                        	
                                	<div class="clearfix menu-header">
                                    	<div class="pull-left"><a href="javascript:void(0)" class="c-org link-open-this" data-status="1" data-el="submenu-'.$item['id'].'" ><i class="fa fa-minus-square-o"></i></a>&nbsp;&nbsp;'.$item['name'].' - '.$item['link'].'</div>
                                		<div class="pull-right dts-control actions">
			                        		<a href="javascript:void(0)" data-megamenu="'.$megamenuId.'" data-parent="'.$parentId.'" data-id="'.$item['id'].'" class="link-add link-addsub-menu" title="'.$this->l('Add submenu').'">&nbsp;'.$this->l('Add sub').'</a>
			                        		'.$status.'
			                        		<a href="javascript:void(0)" data-megamenu="'.$megamenuId.'" data-parent="'.$parentId.'" data-id="'.$item['id'].'" class="link-edit link-edit-submenu" title="'.$this->l('Edit menu').'">&nbsp;'.$this->l('Edit').'</a>                        	
				                        	<a href="javascript:void(0)" data-megamenu="'.$megamenuId.'" data-parent="'.$parentId.'" data-id="'.$item['id'].'" class="link-copy link-copy-menu" title="'.$this->l('Copy menu').'">&nbsp;'.$this->l('Copy').'</a>
				                        	<a href="javascript:void(0)" data-megamenu="'.$megamenuId.'" data-parent="'.$parentId.'" data-id="'.$item['id'].'" class="link-trash link-trash-menu c-red" title="'.$this->l('Delete menu').'">&nbsp;'.$this->l('Delete').'</a>	
			                        	</div>		                                        	
                                    </div>		                                        	
									<div class="list-menu-level-2 menu-sortable" data-parent="'.$item['id'].'" id="submenu-'.$item['id'].'">'.$this->loadMenuLevel2Content($langId ,$megamenuId, $item['id']).'</div>
                            </div>';
			}
		}
		return $html;
	}
	protected function loadMenuLevel2Content($langId, $megamenuId=0, $parentId=0){
		if(!$parentId || !$megamenuId) return '';
		$items = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select m.*, ml.name, ml.link 
			From "._DB_PREFIX_."megamenus_menu AS m 
			Left Join "._DB_PREFIX_."megamenus_menu_lang AS ml 
				On ml.menu_id = m.id 
			Where 
				m.module_id = ".$megamenuId." AND 
				m.parent_id = $parentId AND  
				ml.`id_lang` = $langId 
			Order By m.ordering");
		$html = '';
		if($items){
			foreach($items as $item){
				
				if($item['link_type'] == 'PRODUCT|0'){
					$item['link'] = $this->generateUrl('PRD|'.$item['product_id'], $item['link'], '');
				}else{
					$item['link'] = $this->generateUrl($item['link_type'], $item['link'], '');	
				}
								
                if($item['status'] == "1"){
                    $status = '<a title="Enabled" class="link-active link-status-menu" data-parent="'.$parentId.'" data-megamenu='.$megamenuId.' data-id="'.$item['id'].'" data-value="'.$item['status'].'">&nbsp;'.$this->l('Status').'</a>';
                }else{
                    $status = '<a title="Disabled" class="link-deactive link-status-menu c-org" data-megamenu='.$megamenuId.' data-id="'.$item['id'].'" data-value="'.$item['status'].'">&nbsp;'.$this->l('Status').'</a>';
                }                                   
                $html .=	'<div data-id="'.$item['id'].'" data-megamenu="'.$megamenuId.'" data-parent="'.$parentId.'" class="menu-level-2-item parent-'.$parentId.'">		                                        	
	                                        	<div class="clearfix menu-header">
		                                        	<div class="pull-left"><a href="javascript:void(0)" class="c-org link-open-this" data-status="1" data-el="submenu-'.$item['id'].'" ><i class="fa fa-minus-square-o"></i></a>&nbsp;&nbsp;'.$item['name'].' - '.$item['link'].'</div>
		                                        	<div class="pull-right dts-control actions">
						                        		<a href="javascript:void(0)" data-megamenu="'.$megamenuId.'" data-parent="'.$parentId.'" data-id="'.$item['id'].'" class="link-add link-addsub-menu" title="'.$this->l('Add submenu').'">&nbsp;'.$this->l('Add sub').'</a>
						                        		'.$status.'
						                        		<a href="javascript:void(0)" data-megamenu="'.$megamenuId.'" data-parent="'.$parentId.'" data-id="'.$item['id'].'" class="link-edit link-edit-submenu" title="'.$this->l('Edit menu').'">&nbsp;'.$this->l('Edit').'</a>                        	
							                        	<a href="javascript:void(0)" data-megamenu="'.$megamenuId.'" data-parent="'.$parentId.'" data-id="'.$item['id'].'" class="link-copy link-copy-menu" title="'.$this->l('Copy menu').'">&nbsp;'.$this->l('Copy').'</a>
							                        	<a href="javascript:void(0)" data-megamenu="'.$megamenuId.'" data-parent="'.$parentId.'" data-id="'.$item['id'].'" class="link-trash link-trash-menu c-red" title="'.$this->l('Delete menu').'">&nbsp;'.$this->l('Delete').'</a>							                        	
		                                        	</div>
		                                        </div>		                                        	
												<div class="list-menu-level-3 menu-sortable" data-parent="'.$item['id'].'" id="submenu-'.$item['id'].'">'.$this->loadMenuLevel3Content($langId ,$megamenuId, $item['id']).'</div>
	                                    </div>';
			}
		}
		return $html;
	}
	protected function loadMenuLevel3Content($langId, $megamenuId=0, $parentId=0){
		if(!$parentId || !$megamenuId) return '';
		$items = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select m.*, ml.name, ml.link 
			From "._DB_PREFIX_."megamenus_menu AS m 
			Left Join "._DB_PREFIX_."megamenus_menu_lang AS ml 
				On ml.menu_id = m.id 
			Where 
				m.module_id = ".$megamenuId." AND 
				m.parent_id = $parentId AND  
				ml.`id_lang` = $langId 
			Order By m.ordering");
		$html = '';
		if($items){
			foreach($items as $item){
				
				if($item['link_type'] == 'PRODUCT|0'){
					$item['link'] = $this->generateUrl('PRD|'.$item['product_id'], $item['link'], '');
				}else{
					$item['link'] = $this->generateUrl($item['link_type'], $item['link'], '');	
				}
								
                if($item['status'] == "1"){
                    $status = '<a title="Enabled" class="link-active link-status-menu" data-parent="'.$parentId.'" data-megamenu='.$megamenuId.' data-id="'.$item['id'].'" data-value="'.$item['status'].'">&nbsp;'.$this->l('Status').'</a>';
                }else{
                    $status = '<a title="Disabled" class="link-deactive link-status-menu c-org" data-megamenu='.$megamenuId.' data-id="'.$item['id'].'" data-value="'.$item['status'].'">&nbsp;'.$this->l('Status').'</a>';
                }                                   
                $html .=	'<div data-id="'.$item['id'].'" data-megamenu="'.$megamenuId.'" data-parent="'.$parentId.'" class="menu-level-3-item parent-'.$parentId.'">		                                        	
                                    	<div class="clearfix menu-header">
                                        	<div class="pull-left">'.$item['name'].' - '.$item['link'].'</div>
                                        	<div class="pull-right dts-control actions">
												'.$status.'
				                        		<a href="javascript:void(0)" data-megamenu="'.$megamenuId.'" data-parent="'.$parentId.'" data-id="'.$item['id'].'" class="link-edit link-edit-submenu" title="'.$this->l('Edit menu').'">&nbsp;'.$this->l('Edit').'</a>                        	
					                        	<a href="javascript:void(0)" data-megamenu="'.$megamenuId.'" data-parent="'.$parentId.'" data-id="'.$item['id'].'" class="link-copy link-copy-menu" title="'.$this->l('Copy menu').'">&nbsp;'.$this->l('Copy').'</a>
					                        	<a href="javascript:void(0)" data-megamenu="'.$megamenuId.'" data-parent="'.$parentId.'" data-id="'.$item['id'].'" class="link-trash link-trash-menu c-red" title="'.$this->l('Delete menu').'">&nbsp;'.$this->l('Delete').'</a>								                        	
                                        	</div>
                                        </div>		                                        	
                                </div>';
			}
		}
		return $html;
	}
	public function loadMenuContent(){
		$langId = Context::getContext()->language->id;
	    $shopId = Context::getContext()->shop->id;
		$megamenuId = intval($_POST['megamenuId']);
		$menuId = intval($_POST['menuId']);
		$response = new stdClass();
		$html = '';
		if($megamenuId >0 && $menuId > 0){
			$sql = "Select r.*, rl.name 
				From "._DB_PREFIX_."megamenus_row AS r 
				Left Join "._DB_PREFIX_."megamenus_row_lang AS rl 
					On rl.row_id = r.id 
				Where 
					r.module_id = '$megamenuId' AND 
					r.menu_id = '$menuId' AND 
					rl.id_lang='$langId'  
				Order By 
					r.ordering";
			$rows = Db::getInstance()->executeS($sql);
			if($rows){
				$html .= '<div class="row-sortable" data-megamenu="'.$megamenuId.'" data-menu="'.$menuId.'">';
				foreach($rows as $row){
					if($row['status'] == '0')
						$status = '<i class="icon-square-o"></i> '.$this->l('Disable').'</a>';
					else
						$status = '<i class="icon-check-square-o"></i> '.$this->l('Enable').'</a>';
					
					$html .= '<div class="panel panel-sup module-'.$megamenuId.' menu-'.$menuId.' col-sm-'.$row['width'].' '.($row['status'] == 1 ? 'enable' : 'disable').'" id="panel-row-'.$row['id'].'" data-id="'.$row['id'].'">    
								            <div class="panel-heading">
								                <a href="javascript:void(0)" class="c-org link-open-this" data-status="1" data-el="row-'.$row['id'].'-body" ><i class="fa fa-minus-square-o"></i></a>&nbsp;<span class="panel-sup-title '.($row['status'] == 1 ? 'enable' : 'disable').'">'.$row['name'].'</span>
								                <span class="panel-heading-action panel-item-group pull-right"> 
								                    <a data-toggle="dropdown" class="list-toolbar-btn dropdown-toggle" href="javascript:void(0)"><i class="icon-caret-down"></i></a>           
								                    <ul class="dropdown-menu">
								                        <li><a class="link-status-row" title="'.$this->l('Change item status').'" data-module="'.$megamenuId.'" data-menu="'.$menuId.'" data-id="'.$row['id'].'" data-value="'.$row['status'].'" href="javascript:void(0)">'.$status.'</li>                                        
								                        <li><a class="link-edit-row" title="'.$this->l('Edit item').'" data-module="'.$megamenuId.'" data-menu="'.$menuId.'" data-id="'.$row['id'].'" href="javascript:void(0)"><i class="icon-edit"></i> '.$this->l('Edit').'</a></li>                                        								                        
								                        <li><a class="link-copy-row" title="'.$this->l('Copy').'"  data-module="'.$megamenuId.'" data-menu="'.$menuId.'" data-id="'.$row['id'].'" href="javascript:void(0)"><i class="icon-copy"></i> '.$this->l('Copy').'</a></li>								                        
								                        <li><a class="link-delete-row" title="'.$this->l('Delete item').'" data-module="'.$megamenuId.'" data-menu="'.$menuId.'"  data-id="'.$row['id'].'" href="javascript:void(0)"><i class="icon-trash"></i> '.$this->l('Delete').'</a></li>
								                        <li class="divider"></li>
								                        <li><a class="link-add-group" title="'.$this->l('Add new group').'" data-module="'.$megamenuId.'" data-menu="'.$menuId.'" data-id="'.$row['id'].'" href="javascript:void(0)"><i class="icon-addnew"></i> '.$this->l('Add new group').'</a></li>
								                    </ul>
								                </span>
								            </div>
								            <div class="panel-body" id="row-'.$row['id'].'-body" style="padding:0;">                              
								                <div class="group-sortable" id="row-'.$row['id'].'-content" data-row="'.$row['id'].'" data-module="'.$megamenuId.'" data-menu="'.$menuId.'">
								                    '.$this->getRowContent($megamenuId, $menuId, $row['id']).'
								                </div>
								            </div>
								             
								        </div>';
				}
				$html .= '</div>';
			}
		}
		die(Tools::jsonEncode($html));
	}
	
	protected function getRowContent($megamenuId, $menuId, $rowId){
		$langId = Context::getContext()->language->id;
	    $shopId = Context::getContext()->shop->id;
		$groups = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select g.*, gl.name From "._DB_PREFIX_."megamenus_group AS g Left Join "._DB_PREFIX_."megamenus_group_lang AS gl On gl.group_id = g.id Where g.row_id = $rowId AND gl.id_lang = $langId Order By g.ordering");		
		$html = '';
		if($groups){
			$col12 = 0;			
			foreach ($groups as $group) {
				
				if($group['status'] == '0')
					$status = '<i class="icon-square-o"></i> '.$this->l('Disable').'</a>';
				else
					$status = '<i class="icon-check-square-o"></i> '.$this->l('Enable').'</a>';
				$col12 += $group['width'];
				if($col12 > 12){
					$html .= '<div class="clearfix"></div>';
					$col12 = 0;
				}
				$addItem = '';
                $groupContent = '';
                $params = Tools::jsonDecode($group['params']);
				if($group['type'] == 'link'){
					$addItem = '<li><a class="link-group-additem" title="'.$this->l('Add item').'" data-id="'.$group['id'].'" data-module="'.$megamenuId.'" data-menu="'.$menuId.'" data-row="'.$rowId.'" href="javascript:void(0)"><i class="icon-addnew"></i> '.$this->l('Add item').'</a></li>';
				}elseif($group['type'] == 'module'){				    
				    $groupContent = '<div>
                                        <div><label class="control-label">'.$this->l('Module name').'</label>: <strong>'.$params->module->name.'</strong></div>
                                        <div><label class="control-label">'.$this->l('Hook name').'</label>: <strong>'.$params->module->hook.'</strong></div>
                                    </div>';
				}elseif($group['type'] == 'product'){
				    if($params->product->type == 'auto'){
				        $onSale = $this->l('All');
				        if($params->product->onSale == '0')
                            $onSale = $this->l('No');
                        elseif($params->product->onSale == '1')
                            $onSale = $this->l('Yes');
                        $onNew = $this->l('All');
				        if($params->product->onNew == '0')
                            $onNew = $this->l('No');
                        elseif($params->product->onNew == '1')
                            $onNew = $this->l('Yes');
                        $onDiscount = $this->l('All');
				        if($params->product->onDiscount == '0')
                            $onDiscount = $this->l('No');
                        elseif($params->product->onNew == '1')
                            $onDiscount = $this->l('Yes');                        
				        $groupContent = '<div>                    
                                            <div><label class="control-label">'.$this->l('Type').'</label>: <strong>'.$params->product->type.'</strong></div>
                                            <div><label class="control-label">'.$this->l('Category name').'</label>: <strong>'.$this->getCategoryNameById($params->product->category).'</strong></div>
                                            <div><label class="control-label">'.$this->l('Only condition').'</label>: <strong>'.$params->product->onCondition.'</strong></div>
                                            <div><label class="control-label">'.$this->l('Only sale').'</label>: <strong>'.$onSale.'</strong></div>
                                            <div><label class="control-label">'.$this->l('Only new').'</label>: <strong>'.$onNew.'</strong></div>
                                            <div><label class="control-label">'.$this->l('Only discount').'</label>: <strong>'.$onDiscount.'</strong></div>
                                            <div><label class="control-label">'.$this->l('Order by').'</label>: <strong>'.$params->product->orderBy.'</strong></div>
                                            <div><label class="control-label">'.$this->l('Order way').'</label>: <strong>'.$params->product->orderWay.'</strong></div>
                                            <div><label class="control-label">'.$this->l('Count').'</label>: <strong>'.$params->product->maxCount.'</strong></div>
                                            <div><label class="control-label">'.$this->l('Item width').'</label>: <strong> col-'.$params->product->width.'</strong></div>
                                        </div>';
				    }else{
    				    $groupContent = '<div>                        
                                            <div><label class="control-label">'.$this->l('Type').'</label>: <strong>'.$params->product->type.'</strong></div>
                                            <div><label class="control-label">'.$this->l('Ids').'</label>: <strong>'.implode(', ', $params->product->ids).'</strong></div>
                                        </div>';    
				    }
                    
				}
				$html .= '<div class="group-item col-sm-'.$group['width'].' row-'.$rowId.'" data-id="'.$group['id'].'">
							<div class="panel '.($group['status'] == '1' ? 'enable' : 'disable').'" id="panel-group-'.$group['id'].'">    
								<div class="panel-heading clearfix">
									<div class="pull-left group-name"><a href="javascript:void(0)" class="c-org link-open-this" data-status="1" data-el="group-'.$group['id'].'-body" ><i class="fa fa-minus-square-o"></i></a>&nbsp;<span>'.$group['name'].'</span></div>
									<span class="panel-heading-action panel-item-group pull-right"> 
										<a data-toggle="dropdown" class="list-toolbar-btn dropdown-toggle" href="javascript:void(0)"><i class="icon-caret-down"></i></a>           
										<ul class="dropdown-menu">
											<li><a class="link-group-status" title="'.$this->l('Change item status').'" data-id="'.$group['id'].'" data-module="'.$megamenuId.'" data-menu="'.$menuId.'" data-row="'.$rowId.'" data-value="'.$group['status'].'" href="javascript:void(0)">'.$status.'</li>                                        
					                        <li><a class="link-group-edit" title="'.$this->l('Edit item').'" data-id="'.$group['id'].'" data-module="'.$megamenuId.'" data-menu="'.$menuId.'" data-row="'.$rowId.'" href="javascript:void(0)"><i class="icon-edit"></i> '.$this->l('Edit').'</a></li>                                        					                        
					                        <li><a class="link-group-copy" title="'.$this->l('Copy').'" data-id="'.$group['id'].'" data-module="'.$megamenuId.'" data-menu="'.$menuId.'" data-row="'.$rowId.'" href="javascript:void(0)"><i class="icon-copy"></i> '.$this->l('Copy').'</a></li>
					                        '.$addItem.'
					                        <li class="divider"></li>
					                        <li><a class="link-group-delete" title="'.$this->l('Delete item').'" data-id="'.$group['id'].'" data-module="'.$megamenuId.'" data-menu="'.$menuId.'" data-row="'.$rowId.'" href="javascript:void(0)"><i class="icon-trash"></i> '.$this->l('Delete').'</a></li>
										</ul>
									</span>									
								</div>
								<div class="panel-body" style="padding:0;" id="group-'.$group['id'].'-body">
									<div class="menuitem-sortable" data-module="'.$megamenuId.'" data-menu="'.$menuId.'" data-row="'.$rowId.'" data-group="'.$group['id'].'" id="group-'.$group['id'].'-content">
										'.($groupContent ? $groupContent : $this->getGroupContent($megamenuId, $menuId, $rowId, $group['id'])).'
									</div>
								</div> 
							</div>						
						</div>';
			}
		}
		return $html;
	}
	protected function getGroupContent($megamenuId, $menuId, $rowId, $groupId){
		$html = '';
		$langId = Context::getContext()->language->id;        
            $items = Db::getInstance()->executeS("Select mi.*, mil.name From "._DB_PREFIX_."megamenus_menuitem AS mi Left Join "._DB_PREFIX_."megamenus_menuitem_lang AS mil On mil.menuitem_id = mi.id Where mi.parent_id = 0 AND mi.group_id = $groupId AND mil.id_lang = $langId Order By mi.ordering");
    		if($items){
    			foreach($items as $item){
    				if($item['status'] == '0')
    					$status = '<i class="icon-square-o"></i> '.$this->l('Disable').'</a>';
    				else
    					$status = '<i class="icon-check-square-o"></i> '.$this->l('Enable').'</a>';
    					$html .= '<div id="div-menu-item-'.$item['id'].'" class="menu-item col-sm-12 group-'.$groupId.' '.($item['status'] == '1' ? 'enable' : 'disable').'" data-id="'.$item['id'].'">
                                    <div class="clearfix menu-header">
	                                    <div class="menu-item-name pull-left"><a href="javascript:void(0)" class="c-org link-open-this" data-status="1" data-el="submenuitem-'.$item['id'].'" ><i class="fa fa-minus-square-o"></i></a>&nbsp;&nbsp;'.$item['name'].'</div>
	                                    <span class="pull-right"> 
	                                        <a data-toggle="dropdown" class="list-toolbar-btn dropdown-toggle" href="javascript:void(0)"><i class="icon-caret-down"></i></a>           
	                                        <ul class="dropdown-menu">
	                                            <li><a class="link-menu-item-status" title="'.$this->l('Change item status').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-menu="'.$menuId.'" data-module="'.$megamenuId.'" data-id="'.$item['id'].'" data-value="'.$item['status'].'" href="javascript:void(0)">'.$status.'</li>
	                                            <li><a class="link-menu-item-edit" title="'.$this->l('Edit item').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-menu="'.$menuId.'" data-module="'.$megamenuId.'" data-id="'.$item['id'].'" href="javascript:void(0)"><i class="icon-edit"></i> '.$this->l('Edit').'</a></li>
	    				                        <li><a class="link-menu-item-copy" title="'.$this->l('Copy').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-menu="'.$menuId.'" data-module="'.$megamenuId.'" data-id="'.$item['id'].'" href="javascript:void(0)"><i class="icon-copy"></i> '.$this->l('Copy').'</a></li>
	    				                        <li><a class="link-addsub-menuitem" title="'.$this->l('Add sub').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-menu="'.$menuId.'" data-module="'.$megamenuId.'" data-id="'.$item['id'].'" href="javascript:void(0)"><i class="icon-addnew"></i> '.$this->l('Add sub').'</a></li>    				                        
	    				                        <li class="divider"></li>
	    				                        <li><a class="link-menu-item-delete" title="'.$this->l('Delete item').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-menu="'.$menuId.'" data-module="'.$megamenuId.'" data-id="'.$item['id'].'" href="javascript:void(0)"><i class="icon-trash"></i> '.$this->l('Delete').'</a></li>
	                                        </ul>
	                                    </span>
                                    </div>
                                    <div class="list-menu-level-1 menuitem-sortable" data-parent="'.$item['id'].'" id="submenuitem-'.$item['id'].'">'.$this->getMenuitemLevel1Content($langId, $megamenuId, $menuId, $rowId, $groupId, $item['id']).'</div>
                                </div>';
    			}
    		}    
        
		
		return $html;
	}
	
	protected function getMenuitemLevel1Content($langId, $megamenuId=0, $menuId=0, $rowId=0, $groupId=0, $parentId=0){
		if(!$parentId) return '';
		$items = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select m.*, ml.name, ml.link 
			From "._DB_PREFIX_."megamenus_menuitem AS m 
			Left Join "._DB_PREFIX_."megamenus_menuitem_lang AS ml 
				On ml.menuitem_id = m.id 
			Where 
				m.parent_id = $parentId AND  
				ml.`id_lang` = $langId 
			Order By m.ordering");
		$html = '';
		if($items){
			foreach($items as $item){
				if($item['status'] == '0')
					$status = '<i class="icon-square-o"></i> '.$this->l('Disable').'</a>';
				else
					$status = '<i class="icon-check-square-o"></i> '.$this->l('Enable').'</a>';
				
				$html .= '<div id="div-menu-item-'.$item['id'].'" class="menu-item col-sm-12 group-'.$groupId.' '.($item['status'] == '1' ? 'enable' : 'disable').'" data-id="'.$item['id'].'">
                                    <div class="clearfix menu-header">
	                                    <div class="menu-item-name pull-left"><a href="javascript:void(0)" class="c-org link-open-this" data-status="1" data-el="submenuitem-'.$item['id'].'" ><i class="fa fa-minus-square-o"></i></a>&nbsp;&nbsp;'.$item['name'].'</div>
	                                    <span class="pull-right"> 
	                                        <a data-toggle="dropdown" class="list-toolbar-btn dropdown-toggle" href="javascript:void(0)"><i class="icon-caret-down"></i></a>           
	                                        <ul class="dropdown-menu">
	                                            <li><a class="link-menu-item-status" title="'.$this->l('Change item status').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-menu="'.$menuId.'" data-module="'.$megamenuId.'" data-id="'.$item['id'].'" data-value="'.$item['status'].'" href="javascript:void(0)">'.$status.'</li>
	                                            <li><a class="link-menu-item-edit" title="'.$this->l('Edit item').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-menu="'.$menuId.'" data-module="'.$megamenuId.'" data-id="'.$item['id'].'" href="javascript:void(0)"><i class="icon-edit"></i> '.$this->l('Edit').'</a></li>
	    				                        <li><a class="link-menu-item-copy" title="'.$this->l('Copy').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-menu="'.$menuId.'" data-module="'.$megamenuId.'" data-id="'.$item['id'].'" href="javascript:void(0)"><i class="icon-copy"></i> '.$this->l('Copy').'</a></li>
	    				                        <li><a class="link-addsub-menuitem" title="'.$this->l('Add sub').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-menu="'.$menuId.'" data-module="'.$megamenuId.'" data-id="'.$item['id'].'" href="javascript:void(0)"><i class="icon-addnew"></i> '.$this->l('Add sub').'</a></li>    				                        
	    				                        <li class="divider"></li>
	    				                        <li><a class="link-menu-item-delete" title="'.$this->l('Delete item').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-menu="'.$menuId.'" data-module="'.$megamenuId.'" data-id="'.$item['id'].'" href="javascript:void(0)"><i class="icon-trash"></i> '.$this->l('Delete').'</a></li>
	                                        </ul>
	                                    </span>
                                    </div>
                                    <div  class="list-menu-level-2 menuitem-sortable" data-parent="'.$item['id'].'" id="submenuitem-'.$item['id'].'">'.$this->getMenuitemLevel2Content($langId, $megamenuId, $menuId, $rowId, $groupId, $item['id']).'</div>
                                </div>';
			}
		}
		return $html;
	}
	protected function getMenuitemLevel2Content($langId, $megamenuId=0, $menuId=0, $rowId=0, $groupId=0, $parentId=0){
		if(!$parentId) return '';
		$items = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select m.*, ml.name, ml.link 
			From "._DB_PREFIX_."megamenus_menuitem AS m 
			Left Join "._DB_PREFIX_."megamenus_menuitem_lang AS ml 
				On ml.menuitem_id = m.id 
			Where 
				m.parent_id = $parentId AND  
				ml.`id_lang` = $langId 
			Order By m.ordering");
		$html = '';
		if($items){
			foreach($items as $item){
				if($item['status'] == '0')
					$status = '<i class="icon-square-o"></i> '.$this->l('Disable').'</a>';
				else
					$status = '<i class="icon-check-square-o"></i> '.$this->l('Enable').'</a>';
				
				$html .= '<div id="div-menu-item-'.$item['id'].'" class="menu-item col-sm-12 group-'.$groupId.' '.($item['status'] == '1' ? 'enable' : 'disable').'" data-id="'.$item['id'].'">
                                    <div class="clearfix menu-header">
	                                    <div class="menu-item-name pull-left"><a href="javascript:void(0)" class="c-org link-open-this" data-status="1" data-el="submenuitem-'.$item['id'].'" ><i class="fa fa-minus-square-o"></i></a>&nbsp;&nbsp;'.$item['name'].'</div>
	                                    <span class="pull-right"> 
	                                        <a data-toggle="dropdown" class="list-toolbar-btn dropdown-toggle" href="javascript:void(0)"><i class="icon-caret-down"></i></a>           
	                                        <ul class="dropdown-menu">
	                                            <li><a class="link-menu-item-status" title="'.$this->l('Change item status').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-menu="'.$menuId.'" data-module="'.$megamenuId.'" data-id="'.$item['id'].'" data-value="'.$item['status'].'" href="javascript:void(0)">'.$status.'</li>
	                                            <li><a class="link-menu-item-edit" title="'.$this->l('Edit item').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-menu="'.$menuId.'" data-module="'.$megamenuId.'" data-id="'.$item['id'].'" href="javascript:void(0)"><i class="icon-edit"></i> '.$this->l('Edit').'</a></li>
	    				                        <li><a class="link-menu-item-copy" title="'.$this->l('Copy').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-menu="'.$menuId.'" data-module="'.$megamenuId.'" data-id="'.$item['id'].'" href="javascript:void(0)"><i class="icon-copy"></i> '.$this->l('Copy').'</a></li>
	    				                        <li><a class="link-addsub-menuitem" title="'.$this->l('Add sub').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-menu="'.$menuId.'" data-module="'.$megamenuId.'" data-id="'.$item['id'].'" href="javascript:void(0)"><i class="icon-addnew"></i> '.$this->l('Add sub').'</a></li>    				                        
	    				                        <li class="divider"></li>
	    				                        <li><a class="link-menu-item-delete" title="'.$this->l('Delete item').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-menu="'.$menuId.'" data-module="'.$megamenuId.'" data-id="'.$item['id'].'" href="javascript:void(0)"><i class="icon-trash"></i> '.$this->l('Delete').'</a></li>
	                                        </ul>
	                                    </span>
                                    </div>
                                    <div class="list-menu-level-3 menuitem-sortable" data-parent="'.$item['id'].'" id="submenuitem-'.$item['id'].'">'.$this->getMenuitemLevel3Content($langId, $megamenuId, $menuId, $rowId, $groupId, $item['id']).'</div>
                                </div>';
			}
		}
		return $html;
	}
	protected function getMenuitemLevel3Content($langId, $megamenuId=0, $menuId=0, $rowId=0, $groupId=0, $parentId=0){
		if(!$parentId) return '';
		$items = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("Select m.*, ml.name, ml.link 
			From "._DB_PREFIX_."megamenus_menuitem AS m 
			Left Join "._DB_PREFIX_."megamenus_menuitem_lang AS ml 
				On ml.menuitem_id = m.id 
			Where 
				m.parent_id = $parentId AND  
				ml.`id_lang` = $langId 
			Order By m.ordering");
		$html = '';
		if($items){
			foreach($items as $item){
				if($item['status'] == '0')
					$status = '<i class="icon-square-o"></i> '.$this->l('Disable').'</a>';
				else
					$status = '<i class="icon-check-square-o"></i> '.$this->l('Enable').'</a>';
				
				$html .= '<div id="div-menu-item-'.$item['id'].'" class="menu-item col-sm-12 group-'.$groupId.' '.($item['status'] == '1' ? 'enable' : 'disable').'" data-id="'.$item['id'].'">
                                    <div class="clearfix menu-header">
	                                    <div class="menu-item-name pull-left">'.$item['name'].'</div>
	                                    <span class="pull-right"> 
	                                        <a data-toggle="dropdown" class="list-toolbar-btn dropdown-toggle" href="javascript:void(0)"><i class="icon-caret-down"></i></a>           
	                                        <ul class="dropdown-menu">
	                                            <li><a class="link-menu-item-status" title="'.$this->l('Change item status').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-menu="'.$menuId.'" data-module="'.$megamenuId.'" data-id="'.$item['id'].'" data-value="'.$item['status'].'" href="javascript:void(0)">'.$status.'</li>
	                                            <li><a class="link-menu-item-edit" title="'.$this->l('Edit item').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-menu="'.$menuId.'" data-module="'.$megamenuId.'" data-id="'.$item['id'].'" href="javascript:void(0)"><i class="icon-edit"></i> '.$this->l('Edit').'</a></li>
	    				                        <li><a class="link-menu-item-copy" title="'.$this->l('Copy').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-menu="'.$menuId.'" data-module="'.$megamenuId.'" data-id="'.$item['id'].'" href="javascript:void(0)"><i class="icon-copy"></i> '.$this->l('Copy').'</a></li>    				                        
	    				                        <li class="divider"></li>
	    				                        <li><a class="link-menu-item-delete" title="'.$this->l('Delete item').'" data-group="'.$groupId.'" data-row="'.$rowId.'" data-menu="'.$menuId.'" data-module="'.$megamenuId.'" data-id="'.$item['id'].'" href="javascript:void(0)"><i class="icon-trash"></i> '.$this->l('Delete').'</a></li>
	                                        </ul>
	                                    </span>
                                    </div>
                                </div>';
			}
		}
		return $html;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    public function hookdisplayHeader()
	{        
        $this->context->controller->addJS(array(
			$this->_path.'js/hook/megamenus.js',
			$this->_path.'jquery.actual.min.js',
		));
		$this->context->controller->addCSS(($this->_path).'css/hook/megamenus.css');        
		$this->context->smarty->assign(array(            
            'moduleUrl'		=>	__PS_BASE_URI__.'modules/'.$this->name,
            'imageHomeSize'	=>	Image::getSize(ImageType::getFormatedName('home')),
        ));
	}
    
	public function hookdisplayTopColumn($params){
        return $this->DTSHooks('hookdisplayTopColumn', $params);
    }
    public function hookdisplayLeftColumn($params){
    	
        return $this->DTSHooks('hookdisplayLeftColumn', $params);
    }	    
    public function hookdisplayVerticalMenu($params){	
        return $this->DTSHooks('hookdisplayVerticalMenu', $params);	
    }	    
    public function hookdisplayhorizontalMenu($params){
    	
        return $this->DTSHooks('hookdisplayhorizontalMenu', $params);	
    }
	public function hookdisplayMegamenuLeft($params){
    	
        return $this->DTSHooks('hookdisplayMegamenuLeft', $params);	
    }
	public function hookdisplayMegamenuRight($params){
    	
        return $this->DTSHooks('hookdisplayMegamenuRight', $params);	
    }	
    public function DTSHooks($hookName, $param){        
        $page_name = Dispatcher::getInstance()->getController();
		$page_name = (preg_match('/^[0-9]/', $page_name) ? 'page_'.$page_name : $page_name);		
        $this->context->smarty->assign('page_name', $page_name);
		$langId = $this->context->language->id;
	    $shopId = $this->context->shop->id;        
        $hookName = strtolower(str_replace('hook','', $hookName));		
        $hookId = intval(Hook::getIdByName($hookName));
		if($hookId <=0) return false;
		$cacheKey = 'megamenus|'.$langId.'|'.$hookName.'|'.$page_name;
		if (!$this->isCached('megamenus.tpl', Tools::encrypt($cacheKey))){
			$sql = "Select DISTINCT m.*, ml.`name` 
					From "._DB_PREFIX_."megamenus_module AS m 
					INNER JOIN "._DB_PREFIX_."megamenus_module_lang AS ml 
						On m.id = ml.module_id 
					Where 
						LOWER(m.position_name) = '".$hookName."' 
						AND m.status = 1 
						AND m.id_shop = ".$shopId." 
						AND ml.id_lang = ".$langId." 
					Order 
						By ordering";
	        $items = Db::getInstance()->executeS($sql);		
			$modules = array();		
	        if($items){      
	            foreach($items as $i=>$item){
	            	$content = $this->_buildMenuContents($item);
	            	$modules[] = array('name'=>$item['name'], 'content'=>$this->_buildMenuContents($item, $cacheKey.'|'.$item['id']));				
	            }
	            $this->context->smarty->assign('megamenus', $modules);            
				
	        }else return '';
		}
		return $this->display(__FILE__, 'megamenus.tpl', Tools::encrypt($cacheKey));            
    }
    protected function _buildMenuContents($module, $cacheKey='') {
    	if (!$this->isCached('megamenus.'.$module['layout'].'.tpl', Tools::encrypt($cacheKey))){
    		$contents = array();
			$langId = $this->context->language->id;
		    $shopId = $this->context->shop->id;
			$sql = "Select m.*, ml.name, ml.link 
					From "._DB_PREFIX_."megamenus_menu AS m 
					Inner Join "._DB_PREFIX_."megamenus_menu_lang AS ml 
						On m.id = ml.menu_id 
					Where 
						m.module_id = ".$module['id']." 
						AND m.status = 1 
						AND m.parent_id = 0  
						AND ml.id_lang = ".$langId." 
					Order By 
						m.ordering";
			$items = Db::getInstance()->executeS($sql);
			if($items){
				foreach($items as &$item){
					if($item['link_type'] == 'CUSTOMLINK|0'){
						
					}elseif($item['link_type'] == 'PRODUCT|0'){
						$item['link'] = $this->generateUrl('PRD|'.$item['product_id'], $item['link']);//  $this->frontGenerationUrl('PRD-'.$item['product_id'], $item['link']);
					}else{
						$item['link'] = $this->generateUrl($item['link_type'], $item['link']);
					}
					$item['icon'] = $this->getIconSrc($item['icon']);
					$item['background'] = $this->getImageSrc($item['background']);
					$item['rows'] = $this->_buildRowContents($module['id'], $item['id'], $module['layout'], $cacheKey.'|'.$item['id']);
					$item['subs'] = $this->_getMenuLevel2($module['id'], $item['id']);
					
				}
			}
			$this->context->smarty->assign(array(			 
				'module_name'	=>	$module['name'], 
				'module_id'		=>	$module['id'], 
				'module_layout'	=>	$module['layout'],
				'display_name'	=>	$module['display_name'],
				'show_count'	=>	$module['show_count'],
				'custom_class'	=>	$module['custom_class'],
				'liveImage'		=>	_PS_BASE_URL_.__PS_BASE_URI__.'modules/megamenus/images/',
				'megamenus_menus'	=>	$items,			
			));		
    	}
    		
		
		return $this->display(__FILE__, 'megamenus.'.$module['layout'].'.tpl', Tools::encrypt($cacheKey));
    }
	protected function _getMenuLevel2($moduleId, $parentId){
		$contents = array();
		$langId = $this->context->language->id;
	    $shopId = $this->context->shop->id;
		$sql = "Select m.*, ml.name, ml.link 
				From "._DB_PREFIX_."megamenus_menu AS m 
				Inner Join "._DB_PREFIX_."megamenus_menu_lang AS ml 
					On m.id = ml.menu_id 
				Where 
					m.module_id = ".$moduleId." 
					AND m.status = 1 
					AND m.parent_id = $parentId   
					AND ml.id_lang = ".$langId." 
				Order By 
					m.ordering";
		$items = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		//$this->s_print($items);
		$contents = array();
		if($items){
			foreach($items as &$item){				
				if($item['link_type'] == 'CUSTOMLINK|0'){
					
				}elseif($item['link_type'] == 'PRODUCT|0'){
					$item['link'] = $this->generateUrl('PRD|'.$item['product_id'], $item['link']);
				}else{
					$item['link'] = $this->generateUrl($item['link_type'], $item['link']);
				}
				$item['icon'] = $this->getIconSrc($item['icon']);		
				$item['subs'] = $this->_getMenuLevel3($moduleId, $item['id']);
			}
		}
		return $items;
	}
	protected function _getMenuLevel3($moduleId, $parentId){
		$contents = array();
		$langId = $this->context->language->id;
	    $shopId = $this->context->shop->id;
		$sql = "Select m.*, ml.name, ml.link 
				From "._DB_PREFIX_."megamenus_menu AS m 
				Inner Join "._DB_PREFIX_."megamenus_menu_lang AS ml 
					On m.id = ml.menu_id 
				Where 
					m.module_id = ".$moduleId." 
					AND m.status = 1 
					AND m.parent_id = $parentId   
					AND ml.id_lang = ".$langId." 
				Order By 
					m.ordering";
		$items = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		$contents = array();
		if($items){
			foreach($items as &$item){				
				if($item['link_type'] == 'CUSTOMLINK|0'){
					
				}elseif($item['link_type'] == 'PRODUCT|0'){
					$item['link'] = $this->generateUrl('PRD|'.$item['product_id'], $item['link']);//  $this->frontGenerationUrl('PRD-'.$item['product_id'], $item['link']);
				}else{
					$item['link'] = $this->generateUrl($item['link_type'], $item['link']);
				}
				$item['icon'] = $this->getIconSrc($item['icon']);		
				//$item['subs'] = $this->_getMenuLevel4($moduleId, $item['id']);
			}
		}
		return $items;
	}
	protected function _getMenuLevel4($moduleId, $parentId){
		$contents = array();
		$langId = $this->context->language->id;
	    $shopId = $this->context->shop->id;
		$sql = "Select m.*, ml.name, ml.link 
				From "._DB_PREFIX_."megamenus_menu AS m 
				Inner Join "._DB_PREFIX_."megamenus_menu_lang AS ml 
					On m.id = ml.menu_id 
				Where 
					m.module_id = ".$moduleId." 
					AND m.status = 1 
					AND m.parent_id = $parentId   
					AND ml.id_lang = ".$langId." 
				Order By 
					m.ordering";
		$items = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		$contents = array();
		if($items){
			foreach($items as &$item){				
				if($item['link_type'] == 'CUSTOMLINK|0'){
					
				}elseif($item['link_type'] == 'PRODUCT|0'){
					$item['link'] = $this->generateUrl('PRD|'.$item['product_id'], $item['link']);//  $this->frontGenerationUrl('PRD-'.$item['product_id'], $item['link']);
				}else{
					$item['link'] = $this->generateUrl($item['link_type'], $item['link']);
				}		
				$item['subs'] = $this->_getMenuLevel5($moduleId, $item['id']);
			}
		}
		return $items;
	}
	protected function _getMenuLevel5($moduleId, $parentId){
		$contents = array();
		$langId = $this->context->language->id;
	    $shopId = $this->context->shop->id;
		$sql = "Select m.*, ml.name, ml.link 
				From "._DB_PREFIX_."megamenus_menu AS m 
				Inner Join "._DB_PREFIX_."megamenus_menu_lang AS ml 
					On m.id = ml.menu_id 
				Where 
					m.module_id = ".$moduleId." 
					AND m.status = 1 
					AND m.parent_id = $parentId   
					AND ml.id_lang = ".$langId." 
				Order By 
					m.ordering";
		$items = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		$contents = array();
		if($items){
			foreach($items as &$item){				
				if($item['link_type'] == 'CUSTOMLINK|0'){
					
				}elseif($item['link_type'] == 'PRODUCT|0'){
					$item['link'] = $this->generateUrl('PRD|'.$item['product_id'], $item['link']);//  $this->frontGenerationUrl('PRD-'.$item['product_id'], $item['link']);
				}else{
					$item['link'] = $this->generateUrl($item['link_type'], $item['link']);
				}
			}
		}
		return $items;
	}
    protected function _buildRowContents($moduleId, $menuId, $layout, $cacheKey=''){
    	if (!$this->isCached('megamenus.'.$layout.'.rows.tpl', Tools::encrypt($cacheKey))){
    		$contents = array();		
			$langId = $this->context->language->id;
		    $shopId = $this->context->shop->id;
	        $sql = "Select r.*, rl.name 
	                From "._DB_PREFIX_."megamenus_row AS r 
	                Inner Join "._DB_PREFIX_."megamenus_row_lang AS rl 
	                    On r.id = rl.row_id 
	                Where 
	                    r.module_id = ".$moduleId."  
	                    AND r.menu_id = ".$menuId." 
	                    AND r.status = 1 
	                    AND rl.id_lang = ".$langId." 
	                Order By 
	                    r.ordering";
			
			$items = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);		
			if($items){			
				foreach($items as &$item){
					$item['background'] = $this->getImageSrc($item['background']);
					$item['groups'] = $this->_buildGroupContents($moduleId, $menuId, $item['id'], $layout, $cacheKey.'|'.$item['id']);
				}			
	            $this->context->smarty->assign(array(
	            	'megamenus_rows'   =>  $items,			
	    		));
			}else return "";
    	}
		return $this->display(__FILE__, 'megamenus.'.$layout.'.rows.tpl', Tools::encrypt($cacheKey));
    }
	public function s_print($data){
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		die;
	}
    protected function _buildGroupContents($moduleId=0, $menuId=0, $rowId=0, $layout='default', $cacheKey=''){    	    		
		$contents = array();
		$langId = $this->context->language->id;
	    $shopId = $this->context->shop->id;
        $sql = "Select g.*, gl.name, gl.description 
                From "._DB_PREFIX_."megamenus_group AS g 
                Inner Join "._DB_PREFIX_."megamenus_group_lang AS gl 
                    On g.id = gl.group_id 
                Where 
                    g.row_id = ".$rowId." 
                    AND g.status = 1 
                    AND gl.id_lang = ".$langId." 
                Order By 
                    g.ordering";
		$items = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		$results = '';
			
		if($items){
			foreach($items as $item){
				if ($item['type'] == 'product'){
					if(!$this->isCached('megamenus.'.$layout.'.groups.products.tpl', Tools::encrypt($cacheKey))){
						$params = json_decode($item['params']);				
						if($item['type'] == 'product'){
							$categoryIds = $this->_getAllCategoryIds($params->product->category);					
							$categoryIds[] = $params->product->category;
							$products = array();
							if($params->product->type == 'auto'){
								if (!Cache::isStored($cache_id)){							
									Cache::store($cache_id, $this->_getProducts($categoryIds, $params->product->onCondition, $params->product->onSale, $params->product->onNew, $params->product->onDiscount, $langId, 0, $params->product->maxCount, $params->product->orderBy, $params->product->orderWay));
								}	
								$products = Cache::retrieve($cache_id);						
							}else{
								if (!Cache::isStored($cache_id)){							
									if(count($params->product->ids) >0){
										foreach($params->product->ids as $productId)
											$products[] = $this->_getProductById($products, $langId, true, $this->context);
									}							
								}	
								$products = Cache::retrieve($cache_id);
							}
							$this->context->smarty->assign(array(			 
				    			'id'					=>  $item['id'], 		    			
				    			'display_title'			=>  $item['display_title'],
				    			'name'					=>  $item['name'],
				    			'custom_class'			=>  $item['custom_class'],
				    			'description'			=>	$item['description'],
				    			'width'					=>	$item['width'],
				    			'item_width'			=>  $params->product->width,
				    			'liveImage'				=>  _PS_BASE_URL_.__PS_BASE_URI__.'modules/megaboxs/images/',
				    			'megamenus_products'	=>  $products,			
				    		));
	    				}	
					}    				
					$results .= $this->display(__FILE__, 'megamenus.'.$layout.'.groups.products.tpl', Tools::encrypt($cacheKey));
				}elseif($item['type'] == 'module'){
					if (!$this->isCached('megamenus.'.$layout.'.groups.module.tpl', Tools::encrypt($cacheKey))){
						$content = '';
						$module = @Module::getInstanceByName($params->module->name);
						if($module){
							if (Validate::isLoadedObject($module) && $module->id){
								if (Validate::isHookName($params->module->hook)){
									$hookArgs = array();
									$content = Module::hookExec($params->module->hook, $hookArgs, $module->id);								
								}
							}
						}
						$this->context->smarty->assign(array(			 
			    			'id'				=>  $item['id'], 		    			
			    			'display_title'		=>  $item['display_title'],
			    			'name'				=>  $item['name'],
			    			'description'		=>	$item['description'],
			    			'custom_class'		=>  $item['custom_class'],
			    			'width'				=>	$item['width'],		    			
			    			'liveImage'			=>  _PS_BASE_URL_.__PS_BASE_URI__.'modules/megamenus/images/',
			    			'megamenus_module'  =>  $content,			
			    		));	
					}
					
					$results .= $this->display(__FILE__, 'megamenus.'.$layout.'.groups.module.tpl', Tools::encrypt($cacheKey));					
				}else{
					if (!$this->isCached('megamenus.'.$layout.'.groups.links.tpl', Tools::encrypt($cacheKey))){
						$this->context->smarty->assign(array(			 
			    			'id'					=>  $item['id'], 		    			
			    			'display_title'			=>  $item['display_title'],
			    			'name'					=>  $item['name'],
			    			'description'			=>	$item['description'],
			    			'custom_class'			=>  $item['custom_class'],
			    			'width'					=>	$item['width'],
			    			'liveImage'				=>  _PS_BASE_URL_.__PS_BASE_URI__.'modules/megamenus/images/',
			    			'megamenus_menuitems'	=>  $this->_getMenuItemLevel1($moduleId, $menuId, $rowId, $item['id']),			
			    		));		
					}
						
					$results .= $this->display(__FILE__, 'megamenus.'.$layout.'.groups.links.tpl', Tools::encrypt($cacheKey));
				}				
			}			
		}
		return $results;
    }
    
	protected function _getMenuItemLevel1($moduleId, $menuId, $rowId, $groupId){
		$contents = array();
		$langId = $this->context->language->id;
	    $shopId = $this->context->shop->id;
		$sql = "Select m.*, ml.name, ml.link, ml.image, ml.imageAlt, ml.html 
			From "._DB_PREFIX_."megamenus_menuitem AS m 
			Inner Join "._DB_PREFIX_."megamenus_menuitem_lang AS ml 
				On m.id = ml.menuitem_id 
			Where
				m.parent_id = 0  
				AND m.group_id = ".$groupId." 
				AND m.status = 1 
				AND ml.id_lang = ".$langId." 
			Order By 
				m.ordering";
		$items = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		$contents = array();
		if($items){
			foreach($items as &$item){
				$item['html'] = $item['html'];				
				if($item['link_type'] == 'CUSTOMLINK|0'){
					
				}elseif($item['link_type'] == 'PRODUCT|0'){
					$item['link'] = $this->generateUrl('PRD|'.$item['product_id'], $item['link']);
				}else{
					$item['link'] = $this->generateUrl($item['link_type'], $item['link']);
				}
				$item['icon'] = $this->getIconSrc($item['icon']);		
				$item['content'] = '';
				if($item['menu_type'] == 'module'){
					$module = @Module::getInstanceByName($item['module_name']);
					
					if($module){
						if (Validate::isLoadedObject($module) && $module->id){
							if (Validate::isHookName($params->module->hook)){
								$functionName = 'hook'.$params->module->hook;					
								$hookArgs = array();
								$hookArgs['cookie'] = $this->context->cookie;
								$hookArgs['cart'] = $this->context->cart;								
								$item['content'] = $module->$functionName($hookArgs);//Module::hookExec($params->module->hook, $hookArgs, $module->id);
					
							}else{
								$item['content'] = '';
							}
						}
					}
				}elseif($item['menu_type'] =='html'){
					$item['content'] = $item['html'];
				}elseif($item['menu_type'] == 'image'){					
					$item['content'] = $this->getImageSrc($item['image']);
				}		
				$item['submenus'] = $this->_getMenuItemLevel2($moduleId, $menuId, $rowId, $groupId, $item['id']);
				
			}
		}
		return $items;
	}
	protected function _getMenuItemLevel2($moduleId, $menuId, $rowId, $groupId, $parent_id=0){
		$contents = array();
		$langId = $this->context->language->id;
	    $shopId = $this->context->shop->id;
		$sql = "Select m.*, ml.name, ml.link, ml.image, ml.imageAlt, ml.html 
			From "._DB_PREFIX_."megamenus_menuitem AS m 
			Inner Join "._DB_PREFIX_."megamenus_menuitem_lang AS ml 
				On m.id = ml.menuitem_id 
			Where
				m.parent_id = ".$parent_id."   
				AND m.group_id = ".$groupId." 
				AND m.status = 1 
				AND ml.id_lang = ".$langId." 
			Order By 
				m.ordering";
		$items = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		$contents = array();
		if($items){
			foreach($items as &$item){				
				if($item['link_type'] == 'CUSTOMLINK|0'){
					
				}elseif($item['link_type'] == 'PRODUCT|0'){
					$item['link'] = $this->generateUrl('PRD|'.$item['product_id'], $item['link']);//  $this->frontGenerationUrl('PRD-'.$item['product_id'], $item['link']);
				}else{
					$item['link'] = $this->generateUrl($item['link_type'], $item['link']);
				}
				$item['icon'] = $this->getIconSrc($item['icon']);				
				$item['submenus'] = $this->_getMenuItemLevel3($moduleId, $menuId, $rowId, $groupId, $item['id']);
			}
		}
		return $items;
	}
	protected function _getMenuItemLevel3($moduleId, $menuId, $rowId, $groupId, $parent_id=0){
		$contents = array();
		$langId = $this->context->language->id;
	    $shopId = $this->context->shop->id;
		$sql = "Select m.*, ml.name, ml.link, ml.image, ml.imageAlt, ml.html 
			From "._DB_PREFIX_."megamenus_menuitem AS m 
			Inner Join "._DB_PREFIX_."megamenus_menuitem_lang AS ml 
				On m.id = ml.menuitem_id 
			Where
				m.parent_id = ".$parent_id."   
				AND m.group_id = ".$groupId." 
				AND m.status = 1 
				AND ml.id_lang = ".$langId." 
			Order By 
				m.ordering";
		$items = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		$contents = array();
		if($items){
			foreach($items as &$item){				
				if($item['link_type'] == 'CUSTOMLINK|0'){
					
				}elseif($item['link_type'] == 'PRODUCT|0'){
					$item['link'] = $this->generateUrl('PRD|'.$item['product_id'], $item['link']);//  $this->frontGenerationUrl('PRD-'.$item['product_id'], $item['link']);
				}else{
					$item['link'] = $this->generateUrl($item['link_type'], $item['link']);
				}
				$item['icon'] = $this->getIconSrc($item['icon']);				
				//$item['submenus'] = $this->_getMenuItemLevel4($moduleId, $menuId, $rowId, $groupId, $item['id']);
			}
		}
		return $items;
	}
	protected function _getMenuItemLevel4($moduleId, $menuId, $rowId, $groupId, $parent_id=0){
		$contents = array();
		$langId = $this->context->language->id;
	    $shopId = $this->context->shop->id;
		$sql = "Select m.*, ml.name, ml.link, ml.image, ml.imageAlt, ml.html 
			From "._DB_PREFIX_."megaboxs_menuitem AS m 
			Inner Join "._DB_PREFIX_."megaboxs_menuitem_lang AS ml 
				On m.id = ml.menuitem_id 
			Where
				m.parent_id = ".$parent_id."   
				AND m.group_id = ".$groupId." 
				AND m.status = 1 
				AND ml.id_lang = ".$langId." 
			Order By 
				m.ordering";
		$items = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		$contents = array();
		if($items){
			foreach($items as &$item){				
				if($item['link_type'] == 'CUSTOMLINK|0'){
					
				}elseif($item['link_type'] == 'PRODUCT|0'){
					$item['link'] = $this->generateUrl('PRD|'.$item['product_id'], $item['link']);//  $this->frontGenerationUrl('PRD-'.$item['product_id'], $item['link']);
				}else{
					$item['link'] = $this->generateUrl($item['link_type'], $item['link']);
				}				
				$item['submenus'] = array();
			}
		}
		return $items;
	}
	protected function _getProductIdByDate($beginning, $ending, Context $context = null, $with_combination_id = false, $id_customer=0, $deal=false)
	{
		if (!$context)
			$context = Context::getContext();
		$id_address = $context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')};
		$ids = Address::getCountryAndState($id_address);
		$id_country = $ids['id_country'] ? (int)$ids['id_country'] : (int)Configuration::get('PS_COUNTRY_DEFAULT');
		if (!SpecificPrice::isFeatureActive())
			return array();
		if($deal == true){
			$where = '(`from` = \'0000-00-00 00:00:00\' OR \''.pSQL($beginning).'\' >= `from`) AND (`to` != \'0000-00-00 00:00:00\' AND \''.pSQL($ending).'\' <= `to`)';
		}else{
			$where = '(`from` = \'0000-00-00 00:00:00\' OR \''.pSQL($beginning).'\' >= `from`) AND (`to` = \'0000-00-00 00:00:00\' OR \''.pSQL($ending).'\' <= `to`)';
		}		
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT `id_product`, `id_product_attribute`
			FROM `'._DB_PREFIX_.'specific_price`
			WHERE	`id_shop` IN(0, '.(int)$context->shop->id.') AND
					`id_currency` IN(0, '.(int)$context->currency->id.') AND
					`id_country` IN(0, '.(int)$id_country.') AND
					`id_group` IN(0, '.(int)$context->customer->id_default_group.') AND
					`id_customer` IN(0, '.(int)$id_customer.') AND
					`from_quantity` = 1 AND
					('.$where.') 
					AND
					`reduction` > 0
		', false);
		$ids_product = array();
		while ($row = Db::getInstance()->nextRow($result))
			$ids_product[] = $with_combination_id ? array('id_product' => (int)$row['id_product'], 'id_product_attribute' => (int)$row['id_product_attribute']) : (int)$row['id_product'];
		return $ids_product;		
	}
	protected function _getProductById($productId = 0, $id_lang, $active = true, Context $context = null){
		if(!$productId) return array();
		if (!$context) $context = Context::getContext();
		//if($check_access && !$this->frontCheckAccess($context->customer->id)) return array();
		$front = true;
		if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) $front = false;		
		
		
		if (!Validate::isBool($active)) die (Tools::displayError());
		$id_supplier = (int)Tools::getValue('id_supplier');		
		$sql = 'SELECT
				p.id_product,  MAX(product_attribute_shop.id_product_attribute) id_product_attribute, pl.`link_rewrite`, pl.`name`, pl.`description_short`, product_shop.`id_category_default`,
				MAX(image_shop.`id_image`) id_image, il.`legend`, p.`ean13`, p.`upc`, cl.`link_rewrite` AS category, p.show_price, p.available_for_order, IFNULL(stock.quantity, 0) as quantity, p.customizable,
				IFNULL(pa.minimal_quantity, p.minimal_quantity) as minimal_quantity, stock.out_of_stock,
				product_shop.`date_add` > "'.date('Y-m-d', strtotime('-'.(Configuration::get('PS_NB_DAYS_NEW_PRODUCT') ? (int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY')).'" as new,
				product_shop.`on_sale`, MAX(product_attribute_shop.minimal_quantity) AS product_attribute_minimal_quantity, product_shop.price AS orderprice 
				FROM `'._DB_PREFIX_.'category_product` cp
				LEFT JOIN `'._DB_PREFIX_.'product` p
					ON p.`id_product` = cp.`id_product`
				'.Shop::addSqlAssociation('product', 'p').
				(Combination::isFeatureActive() ? 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa
				ON (p.`id_product` = pa.`id_product`)
				'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'
				'.Product::sqlStock('p', 'product_attribute_shop', false, $context->shop) :  Product::sqlStock('p', 'product', false, Context::getContext()->shop)).'
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
					ON (product_shop.`id_category_default` = cl.`id_category`
					AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').')
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
					ON (p.`id_product` = pl.`id_product`
					AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').')
				LEFT JOIN `'._DB_PREFIX_.'image` i
					ON (i.`id_product` = p.`id_product`)'.
				Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il
					ON (image_shop.`id_image` = il.`id_image`
					AND il.`id_lang` = '.(int)$id_lang.')
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m
					ON m.`id_manufacturer` = p.`id_manufacturer`
				WHERE product_shop.`id_shop` = '.(int)$context->shop->id.'
					AND product_shop.id_product =  '.$productId.
					' AND product_shop.`active` = 1'.
					' AND product_shop.`visibility` IN ("both", "catalog")'.
					($id_supplier ? ' AND p.id_supplier = '.(int)$id_supplier : '').
					' GROUP BY product_shop.id_product';
		
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql);		
		if (!$result) return array();		
		return Product::getProductProperties($id_lang, $result);
	}
	protected function _getProducts($categoryIds = array(), $on_condition='all', $on_sale=2, $on_new=2, $on_discount=2, $id_lang, $p, $n, $order_by = null, $order_way = null, $beginning=null, $ending=null, $deal=false, $get_total = false, $active = true, $random = false, $random_number_products = 1, Context $context = null){
		if(!$categoryIds) return array();
		
		$where = "";
		if($on_condition != 'all'){
             $where .= " AND p.condition = '".$on_condition."' ";                
        }
		if($on_sale != 2){
			$where .= " AND p.on_sale = '".$on_sale."' ";
		}
        Configuration::get('PS_NB_DAYS_NEW_PRODUCT') ? $PS_NB_DAYS_NEW_PRODUCT = (int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : $PS_NB_DAYS_NEW_PRODUCT = 20;
		if($on_new == 0){
			$where .= " AND product_shop.`date_add` <= '".date('Y-m-d', strtotime('-'.$PS_NB_DAYS_NEW_PRODUCT.' DAY'))."' ";
		}elseif($on_new == 1){
			$where .= " AND product_shop.`date_add` > '".date('Y-m-d', strtotime('-'.$PS_NB_DAYS_NEW_PRODUCT.' DAY'))."' ";
		}
		$ids_product = '';
		if($on_discount == 0){
			$current_date = date('Y-m-d H:i:s');
			$product_reductions = $this->_getProductIdByDate((!$beginning ? $current_date : $beginning), (!$ending ? $current_date : $ending), $context, true, 0, $deal);		
			if ($product_reductions){
				$ids_product = ' AND (';
				foreach ($product_reductions as $product_reduction)
					$ids_product .= '( product_shop.`id_product` != '.(int)$product_reduction['id_product'].($product_reduction['id_product_attribute'] ? ' OR product_attribute_shop.`id_product_attribute`='.(int)$product_reduction['id_product_attribute'] :'').') AND';
				$ids_product = rtrim($ids_product, 'AND').')';
			}
		}elseif($on_discount == 1){
			$current_date = date('Y-m-d H:i:s');
			$product_reductions = $this->_getProductIdByDate((!$beginning ? $current_date : $beginning), (!$ending ? $current_date : $ending), $context, true, 0, $deal);            		
			if ($product_reductions)
			{
				$ids_product = ' AND (';
				foreach ($product_reductions as $product_reduction)
					$ids_product .= '( product_shop.`id_product` = '.(int)$product_reduction['id_product'].($product_reduction['id_product_attribute'] ? ' AND product_attribute_shop.`id_product_attribute`='.(int)$product_reduction['id_product_attribute'] :'').') OR';
				$ids_product = rtrim($ids_product, 'OR').')';
			}else{
		      if($deal == true) return array();
			}
		}else{
			if($order_by == 'discount'){
				$current_date = date('Y-m-d H:i:s');
				$product_reductions = $this->_getProductIdByDate((!$beginning ? $current_date : $beginning), (!$ending ? $current_date : $ending), $context, true, 0, $deal);		
				if ($product_reductions){
					$ids_product = ' AND (';
					foreach ($product_reductions as $product_reduction)
						$ids_product .= '( product_shop.`id_product` = '.(int)$product_reduction['id_product'].($product_reduction['id_product_attribute'] ? ' AND product_attribute_shop.`id_product_attribute`='.(int)$product_reduction['id_product_attribute'] :'').') OR';
					$ids_product = rtrim($ids_product, 'OR').')';
				}				
			}
		}		
		if($ids_product) $where .= $ids_product;
		if (!$context) $context = Context::getContext();
		$front = true;
		if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) $front = false;		
		if ($p < 1) $p = 1;
		
		if (empty($order_by)){
			$order_by = 'position';
		}else{
			$order_by = strtolower($order_by);
		}			
		if (empty($order_way)) $order_way = 'ASC';		
		$order_by_prefix = false;
		
		$addJoin = '';
		$addSelect = '';	
		if ($order_by == 'id_product' || $order_by == 'date_add' || $order_by == 'date_upd'){
			$order_by_prefix = 'p';
		}elseif ($order_by == 'name'){
			$order_by_prefix = 'pl';
		}elseif ($order_by == 'manufacturer' || $order_by == 'manufacturer_name'){
			$order_by_prefix = 'm';
			$order_by = 'name';
		}elseif ($order_by == 'position'){
			$order_by_prefix = 'cp';
		}elseif($order_by == 'discount'){
			$order_by_prefix = 'sp';
			$order_by = 'reduction';
			$addJoin = ' LEFT JOIN `'._DB_PREFIX_.'specific_price` sp On p.`id_product` = sp.`id_product` ';
			$addSelect = ', sp.reduction, sp.`from`, sp.`to`';
		}elseif($order_by == 'review'){
			$order_by_prefix = '';
			$order_by = 'total_review';
			$addJoin = ' LEFT JOIN `'._DB_PREFIX_.'product_comment` pr ON pr.`id_product` = p.`id_product` ';
			$addSelect = ', COUNT(pr.grade) as total_review';
		}elseif($order_by == 'view'){
			$order_by_prefix = '';
			$order_by = 'total_view';
			$addJoin = ' LEFT JOIN '._DB_PREFIX_.'simplecategory_product_view as pv ON pv.`product_id` = p.`id_product` ';
			$addSelect = ', pv.total as total_view';
		}elseif($order_by == 'rate'){
			$order_by_prefix = '';
			$order_by = 'total_avg';
			$addJoin = ' LEFT JOIN `'._DB_PREFIX_.'product_comment` pr ON pr.`id_product` = p.`id_product` ';
			$addSelect = ', (SUM(pr.`grade`) / COUNT(pr.`grade`)) AS total_avg';
		}elseif($order_by == 'seller'){
			$order_by_prefix = '';
			$order_by = 'sales';
			$addJoin = ' LEFT JOIN `'._DB_PREFIX_.'product_sale` ps ON ps.`id_product` = p.`id_product` ';
			$addSelect = ', ps.`quantity` AS sales';
		} 
		if($order_by != 'reduction' && $on_discount != 2){
			$addJoin = ' LEFT JOIN `'._DB_PREFIX_.'specific_price` sp On p.`id_product` = sp.`id_product` ';
			$addSelect = ', sp.reduction, sp.`from`, sp.`to`';
		}
		if ($order_by == 'price') $order_by = 'orderprice';
		if (!Validate::isBool($active) || !Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) die (Tools::displayError());
		$id_supplier = (int)Tools::getValue('id_supplier');
		
		if ($get_total)
		{
			$sql = 'SELECT COUNT(cp.`id_product`) AS total
					FROM `'._DB_PREFIX_.'product` p 					
					'.Shop::addSqlAssociation('product', 'p').' '.$addJoin.'
					LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON p.`id_product` = cp.`id_product`
					WHERE cp.`id_category` IN ('.implode(', ', $categoryIds).') '.$where. 
					($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '').
					($active ? ' AND product_shop.`active` = 1' : '').
					(($ids_product) ? $ids_product : '').
					($id_supplier ? 'AND p.id_supplier = '.(int)$id_supplier : '');
			return (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
		}
        
		$sql = 'SELECT DISTINCT 
				p.id_product,  MAX(product_attribute_shop.id_product_attribute) id_product_attribute, pl.`link_rewrite`, pl.`name`, pl.`description_short`, product_shop.`id_category_default`,
				MAX(image_shop.`id_image`) id_image, il.`legend`, p.`ean13`, p.`upc`, cl.`link_rewrite` AS category, p.show_price, p.available_for_order, IFNULL(stock.quantity, 0) as quantity, p.customizable,
				IFNULL(pa.minimal_quantity, p.minimal_quantity) as minimal_quantity, stock.out_of_stock,
				product_shop.`date_add` > "'.date('Y-m-d', strtotime('-'.$PS_NB_DAYS_NEW_PRODUCT.' DAY')).'" as `new`,
				product_shop.`on_sale`, MAX(product_attribute_shop.minimal_quantity) AS product_attribute_minimal_quantity, product_shop.price AS orderprice '.$addSelect.'
				FROM `'._DB_PREFIX_.'category_product` cp 
				LEFT JOIN `'._DB_PREFIX_.'product` p 
					ON p.`id_product` = cp.`id_product` 
				'.Shop::addSqlAssociation('product', 'p').
				$addJoin.
				(Combination::isFeatureActive() ? 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa 
				ON (p.`id_product` = pa.`id_product`) 
				'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').' 
				'.Product::sqlStock('p', 'product_attribute_shop', false, $context->shop) :  Product::sqlStock('p', 'product', false, Context::getContext()->shop)).' 
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl 
					ON (product_shop.`id_category_default` = cl.`id_category` 
					AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').')
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl 
					ON (p.`id_product` = pl.`id_product` 
					AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').')
				LEFT JOIN `'._DB_PREFIX_.'image` i 
					ON (i.`id_product` = p.`id_product`) '.
				Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').' 
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il 
					ON (image_shop.`id_image` = il.`id_image` 
					AND il.`id_lang` = '.(int)$id_lang.')
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m 
					ON m.`id_manufacturer` = p.`id_manufacturer` 
				WHERE product_shop.`id_shop` = '.(int)$context->shop->id.' 
					AND cp.`id_category` IN ('.implode(', ', $categoryIds).') '
					.$where 
					.($active ? ' AND product_shop.`active` = 1' : '')
					.($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '')
					.($id_supplier ? ' AND p.id_supplier = '.(int)$id_supplier : '')
					.' GROUP BY product_shop.id_product';
		if ($random === true) $sql .= ' ORDER BY RAND() LIMIT '.(int)$random_number_products;
		else $sql .= ' ORDER BY '.(!empty($order_by_prefix) ? $order_by_prefix.'.' : '').'`'.bqSQL($order_by).'` '.pSQL($order_way).' LIMIT '.(((int)$p - 1) * (int)$n).','.(int)$n;
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		if ($order_by == 'orderprice') Tools::orderbyPrice($result, $order_way);
		if (!$result) return array();
		return Product::getProductsProperties($id_lang, $result);
	}
	
	
	
	
    
	
	
	
	public function frontCheckAccess($id_customer)
	{
		$cache_id = 'Category::checkAccess_'.(int)$this->id.'-'.$id_customer.(!$id_customer ? '-'.(int)Group::getCurrent()->id : '');
		if (!Cache::isStored($cache_id))
		{
			if (!$id_customer)
				$result = (bool)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
				SELECT ctg.`id_group`
				FROM '._DB_PREFIX_.'category_group ctg
				WHERE ctg.`id_category` = '.(int)$this->id.' AND ctg.`id_group` = '.(int)Group::getCurrent()->id);
			else
				$result = (bool)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
				SELECT ctg.`id_group`
				FROM '._DB_PREFIX_.'category_group ctg
				INNER JOIN '._DB_PREFIX_.'customer_group cg on (cg.`id_group` = ctg.`id_group` AND cg.`id_customer` = '.(int)$id_customer.')
				WHERE ctg.`id_category` = '.(int)$this->id);
			Cache::store($cache_id, $result);
		}
		return Cache::retrieve($cache_id);
	}
	public function frontGetProducts($categoryIds = 0, $params=null, $id_lang, $p, $n, $order_by = null, $order_way = null, $get_total = false, $active = true, $random = false, $random_number_products = 1, Context $context = null){
		if(!$categoryIds) return array();
		$where = "";
		if($params){
            if($params->displayOnly == 'condition-new') $where .= " AND p.condition = 'new'";
            elseif($params->displayOnly == 'condition-used') $where .= " AND p.condition = 'used'";
            elseif($params->displayOnly == 'condition-refurbished') $where .= " AND p.condition = 'refurbished'";    
        }
		if (!$context) $context = Context::getContext();
		$front = true;
		if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) $front = false;		
		if ($p < 1) $p = 1;
		if (empty($order_by)) $order_by = 'position';
		else $order_by = strtolower($order_by);
		if (empty($order_way)) $order_way = 'ASC';
		$order_by_prefix = false;
		if ($order_by == 'id_product' || $order_by == 'date_add' || $order_by == 'date_upd') $order_by_prefix = 'p';
		elseif ($order_by == 'name') $order_by_prefix = 'pl';
		elseif ($order_by == 'manufacturer' || $order_by == 'manufacturer_name'){
			$order_by_prefix = 'm';
			$order_by = 'name';
		}elseif ($order_by == 'position') $order_by_prefix = 'cp';
		if ($order_by == 'price') $order_by = 'orderprice';
		if (!Validate::isBool($active) || !Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) die (Tools::displayError());
		$id_supplier = (int)Tools::getValue('id_supplier');
		if ($get_total)
		{
			$sql = 'SELECT COUNT(cp.`id_product`) AS total
					FROM `'._DB_PREFIX_.'product` p
					'.Shop::addSqlAssociation('product', 'p').'
					LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON p.`id_product` = cp.`id_product`
					WHERE cp.`id_category` IN ('.implode(', ', $categoryIds).') '.$where. 
					($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '').
					($active ? ' AND product_shop.`active` = 1' : '').
					($id_supplier ? 'AND p.id_supplier = '.(int)$id_supplier : '');
			return (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
		}
		/*
		 * 
		 * 
				SELECT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity'.(Combination::isFeatureActive() ? ', MAX(product_attribute_shop.id_product_attribute) id_product_attribute, MAX(product_attribute_shop.minimal_quantity) AS product_attribute_minimal_quantity' : '').', pl.`description`, pl.`description_short`, pl.`available_now`,
					pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, MAX(image_shop.`id_image`) id_image,
					MAX(il.`legend`) as legend, m.`name` AS manufacturer_name, cl.`name` AS category_default,
					DATEDIFF(product_shop.`date_add`, DATE_SUB(NOW(),
					INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).'
						DAY)) > 0 AS new, product_shop.price AS orderprice
		 */
		$sql = 'SELECT
				p.id_product,  MAX(product_attribute_shop.id_product_attribute) id_product_attribute, pl.`link_rewrite`, pl.`name`, pl.`description_short`, product_shop.`id_category_default`,
				MAX(image_shop.`id_image`) id_image, il.`legend`, p.`ean13`, p.`upc`, cl.`link_rewrite` AS category, p.show_price, p.available_for_order, IFNULL(stock.quantity, 0) as quantity, p.customizable,
				IFNULL(pa.minimal_quantity, p.minimal_quantity) as minimal_quantity, stock.out_of_stock,
				product_shop.`date_add` > "'.date('Y-m-d', strtotime('-'.(Configuration::get('PS_NB_DAYS_NEW_PRODUCT') ? (int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY')).'" as new,
				product_shop.`on_sale`, MAX(product_attribute_shop.minimal_quantity) AS product_attribute_minimal_quantity, product_shop.price AS orderprice 
				FROM `'._DB_PREFIX_.'category_product` cp
				LEFT JOIN `'._DB_PREFIX_.'product` p
					ON p.`id_product` = cp.`id_product`
				'.Shop::addSqlAssociation('product', 'p').
				(Combination::isFeatureActive() ? 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa
				ON (p.`id_product` = pa.`id_product`)
				'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'
				'.Product::sqlStock('p', 'product_attribute_shop', false, $context->shop) :  Product::sqlStock('p', 'product', false, Context::getContext()->shop)).'
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
					ON (product_shop.`id_category_default` = cl.`id_category`
					AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').')
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
					ON (p.`id_product` = pl.`id_product`
					AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').')
				LEFT JOIN `'._DB_PREFIX_.'image` i
					ON (i.`id_product` = p.`id_product`)'.
				Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il
					ON (image_shop.`id_image` = il.`id_image`
					AND il.`id_lang` = '.(int)$id_lang.')
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m
					ON m.`id_manufacturer` = p.`id_manufacturer`
				WHERE product_shop.`id_shop` = '.(int)$context->shop->id.'
					AND cp.`id_category` IN ('.implode(', ', $categoryIds).')'
					.($active ? ' AND product_shop.`active` = 1' : '')
					.($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '')
					.($id_supplier ? ' AND p.id_supplier = '.(int)$id_supplier : '')
					.' GROUP BY product_shop.id_product';
		if ($random === true) $sql .= ' ORDER BY RAND() LIMIT '.(int)$random_number_products;
		else $sql .= ' ORDER BY '.(!empty($order_by_prefix) ? $order_by_prefix.'.' : '').'`'.bqSQL($order_by).'` '.pSQL($order_way).' LIMIT '.(((int)$p - 1) * (int)$n).','.(int)$n;		
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		if ($order_by == 'orderprice') Tools::orderbyPrice($result, $order_way);
		if (!$result) return array();
		return Product::getProductsProperties($id_lang, $result);
	}
	public function frontGetSpecialProducts($categoryIds = 0, $params=null, $id_lang, $p, $n, $beginning=null, $ending=null, $get_total = false, $active = true, Context $context = null){
		if(!$categoryIds) return array();
		if (!$context) $context = Context::getContext();
		$where = "";
		if($params){
            if($params->displayOnly == 'condition-new') $where .= " AND p.condition = 'new'";
            elseif($params->displayOnly == 'condition-used') $where .= " AND p.condition = 'used'";
            elseif($params->displayOnly == 'condition-refurbished') $where .= " AND p.condition = 'refurbished'";    
        }
		$current_date = date('Y-m-d H:i:s');
		$product_reductions = Product::_getProductIdByDate((!$beginning ? $current_date : $beginning), (!$ending ? $current_date : $ending), $context, true);		
		if ($product_reductions)
		{
			$ids_product = ' AND (';
			foreach ($product_reductions as $product_reduction)
				$ids_product .= '( product_shop.`id_product` = '.(int)$product_reduction['id_product'].($product_reduction['id_product_attribute'] ? ' AND product_attribute_shop.`id_product_attribute`='.(int)$product_reduction['id_product_attribute'] :'').') OR';
			$ids_product = rtrim($ids_product, 'OR').')';
		}	
				
		$front = true;
		if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) $front = false;		
		if ($p < 1) $p = 1;
		$order_by = 'sp.reduction';
		$order_way = 'DESC';
		
		if (!Validate::isBool($active) || !Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) die (Tools::displayError());
		$id_supplier = (int)Tools::getValue('id_supplier');
		if ($get_total)
		{
			$sql = 'SELECT COUNT(cp.`id_product`) AS total
					FROM (`'._DB_PREFIX_.'product` p INNER JOIN `'._DB_PREFIX_.'specific_price` sp On p.id_product = sp.id_product)
					'.Shop::addSqlAssociation('product', 'p').'
					LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON p.`id_product` = cp.`id_product`
					WHERE cp.`id_category` IN ('.implode(', ', $categoryIds).') '.$where. 
					' AND product_shop.`visibility` IN ("both", "catalog")'.
					' AND product_shop.`active` = 1'.
					(($ids_product) ? $ids_product : '').
					($id_supplier ? 'AND p.id_supplier = '.(int)$id_supplier : '');
			return (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
		}
		$sql = 'SELECT
				p.id_product,  MAX(product_attribute_shop.id_product_attribute) id_product_attribute, pl.`link_rewrite`, pl.`name`, pl.`description_short`, product_shop.`id_category_default`,
				MAX(image_shop.`id_image`) id_image, il.`legend`, p.`ean13`, p.`upc`, cl.`link_rewrite` AS category, p.show_price, p.available_for_order, IFNULL(stock.quantity, 0) as quantity, p.customizable,
				IFNULL(pa.minimal_quantity, p.minimal_quantity) as minimal_quantity, stock.out_of_stock,
				product_shop.`date_add` > "'.date('Y-m-d', strtotime('-'.(Configuration::get('PS_NB_DAYS_NEW_PRODUCT') ? (int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY')).'" as new,
				product_shop.`on_sale`, MAX(product_attribute_shop.minimal_quantity) AS product_attribute_minimal_quantity, product_shop.price AS orderprice, sp.reduction 
				FROM `'._DB_PREFIX_.'category_product` cp
				LEFT JOIN (`'._DB_PREFIX_.'product` p INNER JOIN `'._DB_PREFIX_.'specific_price` sp On p.id_product = sp.id_product)
					ON p.`id_product` = cp.`id_product`
				'.Shop::addSqlAssociation('product', 'p').
				(Combination::isFeatureActive() ? 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa
				ON (p.`id_product` = pa.`id_product`)
				'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'
				'.Product::sqlStock('p', 'product_attribute_shop', false, $context->shop) :  Product::sqlStock('p', 'product', false, Context::getContext()->shop)).'
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
					ON (product_shop.`id_category_default` = cl.`id_category`
					AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').')
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
					ON (p.`id_product` = pl.`id_product`
					AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').')
				LEFT JOIN `'._DB_PREFIX_.'image` i
					ON (i.`id_product` = p.`id_product`)'.
				Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il
					ON (image_shop.`id_image` = il.`id_image`
					AND il.`id_lang` = '.(int)$id_lang.')
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m
					ON m.`id_manufacturer` = p.`id_manufacturer`
				WHERE product_shop.`id_shop` = '.(int)$context->shop->id.(($ids_product) ? $ids_product : '').
					' AND cp.`id_category` IN ('.implode(', ', $categoryIds).')'. $where .					
					' AND product_shop.`active` = 1'.
					(($ids_product) ? $ids_product : '').
					' AND product_shop.`visibility` IN ("both", "catalog")'.
					($id_supplier ? ' AND p.id_supplier = '.(int)$id_supplier : '').
					' GROUP BY product_shop.id_product'.
					' ORDER BY `'.bqSQL($order_by).'` '.pSQL($order_way).' LIMIT '.(((int)$p - 1) * (int)$n).','.(int)$n;		
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		if (!$result) return array();
		return Product::getProductsProperties($id_lang, $result);
	}
	public function frontGetProductByIds($ids = array(), $id_lang, $order_by = null, $order_way = null, $active = true, Context $context = null){
		if(!$ids) return array();
		if (!$context) $context = Context::getContext();
		//if($check_access && !$this->frontCheckAccess($context->customer->id)) return array();
		$front = true;
		if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) $front = false;		
		
		if (empty($order_by)) $order_by = 'position';
		else $order_by = strtolower($order_by);
		if (empty($order_way)) $order_way = 'ASC';		
		$order_by_prefix = false;
		if ($order_by == 'id_product' || $order_by == 'date_add' || $order_by == 'date_upd') $order_by_prefix = 'p';
		elseif ($order_by == 'name') $order_by_prefix = 'pl';
		elseif ($order_by == 'manufacturer' || $order_by == 'manufacturer_name'){
			$order_by_prefix = 'm';
			$order_by = 'name';
		}elseif ($order_by == 'position') $order_by_prefix = 'cp';
		if ($order_by == 'price') $order_by = 'orderprice';
		if (!Validate::isBool($active) || !Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) die (Tools::displayError());
		$id_supplier = (int)Tools::getValue('id_supplier');		
		$sql = 'SELECT
				p.id_product,  MAX(product_attribute_shop.id_product_attribute) id_product_attribute, pl.`link_rewrite`, pl.`name`, pl.`description_short`, product_shop.`id_category_default`,
				MAX(image_shop.`id_image`) id_image, il.`legend`, p.`ean13`, p.`upc`, cl.`link_rewrite` AS category, p.show_price, p.available_for_order, IFNULL(stock.quantity, 0) as quantity, p.customizable,
				IFNULL(pa.minimal_quantity, p.minimal_quantity) as minimal_quantity, stock.out_of_stock,
				product_shop.`date_add` > "'.date('Y-m-d', strtotime('-'.(Configuration::get('PS_NB_DAYS_NEW_PRODUCT') ? (int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY')).'" as new,
				product_shop.`on_sale`, MAX(product_attribute_shop.minimal_quantity) AS product_attribute_minimal_quantity, product_shop.price AS orderprice 
				FROM `'._DB_PREFIX_.'category_product` cp
				LEFT JOIN `'._DB_PREFIX_.'product` p
					ON p.`id_product` = cp.`id_product`
				'.Shop::addSqlAssociation('product', 'p').
				(Combination::isFeatureActive() ? 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa
				ON (p.`id_product` = pa.`id_product`)
				'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'
				'.Product::sqlStock('p', 'product_attribute_shop', false, $context->shop) :  Product::sqlStock('p', 'product', false, Context::getContext()->shop)).'
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
					ON (product_shop.`id_category_default` = cl.`id_category`
					AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').')
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
					ON (p.`id_product` = pl.`id_product`
					AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').')
				LEFT JOIN `'._DB_PREFIX_.'image` i
					ON (i.`id_product` = p.`id_product`)'.
				Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il
					ON (image_shop.`id_image` = il.`id_image`
					AND il.`id_lang` = '.(int)$id_lang.')
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m
					ON m.`id_manufacturer` = p.`id_manufacturer`
				WHERE product_shop.`id_shop` = '.(int)$context->shop->id.'
					AND product_shop.id_product IN ('.implode(', ', $ids).') '.
					' AND product_shop.`active` = 1'.
					' AND product_shop.`visibility` IN ("both", "catalog")'.
					($id_supplier ? ' AND p.id_supplier = '.(int)$id_supplier : '').
					' GROUP BY product_shop.id_product';
		$sql .= ' ORDER BY '.(!empty($order_by_prefix) ? $order_by_prefix.'.' : '').'`'.bqSQL($order_by).'` '.pSQL($order_way);
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		if ($order_by == 'orderprice') Tools::orderbyPrice($result, $order_way);
		if (!$result) return array();
		return Product::getProductsProperties($id_lang, $result);
	}
	public function frontGetBestSales($categoryId, $id_lang, $page_number = 0, $nb_products = 10, Context $context = null)
	{
		if (!$context) $context = Context::getContext();
		if ($page_number < 0) $page_number = 0;
		if ($nb_products < 1) $nb_products = 10;
		//FROM `'._DB_PREFIX_.'category_product` cp
		$sql = '
		SELECT
			p.id_product,  MAX(product_attribute_shop.id_product_attribute) id_product_attribute, pl.`link_rewrite`, pl.`name`, pl.`description_short`, product_shop.`id_category_default`,
			MAX(image_shop.`id_image`) id_image, il.`legend`,
			ps.`quantity` AS sales, p.`ean13`, p.`upc`, cl.`link_rewrite` AS category, p.show_price, p.available_for_order, IFNULL(stock.quantity, 0) as quantity, p.customizable,
			IFNULL(pa.minimal_quantity, p.minimal_quantity) as minimal_quantity, stock.out_of_stock,
			product_shop.`date_add` > "'.date('Y-m-d', strtotime('-'.(Configuration::get('PS_NB_DAYS_NEW_PRODUCT') ? (int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY')).'" as new,
			product_shop.`on_sale`, MAX(product_attribute_shop.minimal_quantity) AS product_attribute_minimal_quantity
		FROM `'._DB_PREFIX_.'product_sale` ps
		LEFT JOIN `'._DB_PREFIX_.'product` p ON ps.`id_product` = p.`id_product`
		'.Shop::addSqlAssociation('product', 'p').'
		LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa
			ON (p.`id_product` = pa.`id_product`)
		'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'
		'.Product::sqlStock('p', 'product_attribute_shop', false, $context->shop).'
		LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
			ON p.`id_product` = pl.`id_product`
			AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').'
		LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product`)'.
		Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
		LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
			ON cl.`id_category` = product_shop.`id_category_default`
			AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl');
				
		if (Group::isFeatureActive())
		{
			$groups = FrontController::getCurrentCustomerGroups();
			$sql .= '
				JOIN `'._DB_PREFIX_.'category_product` cp ON (cp.`id_product` = p.`id_product`)
				JOIN `'._DB_PREFIX_.'category_group` cg ON (cp.id_category = cg.id_category AND cg.`id_group` '.(count($groups) ? 'IN ('.implode(',', $groups).')' : '= 1').')';
		}else{
			$sql .= ' JOIN `'._DB_PREFIX_.'category_product` cp ON (cp.`id_product` = p.`id_product`)';
		}

		$sql.= '
		WHERE product_shop.`active` = 1
		AND cp.`id_category` = '.(int)$categoryId.' 
		AND p.`visibility` != \'none\'
		GROUP BY product_shop.id_product
		ORDER BY sales DESC
		LIMIT '.(int)($page_number * $nb_products).', '.(int)$nb_products;

		if (!$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql))
			return false;

		return Product::getProductsProperties($id_lang, $result);
	}
	
	

    function clearCache($cacheKey){		
		if(!$cacheKey){			
			parent::_clearCache('megamenus.tpl');
			if($this->arrLayout)
				foreach ($this->arrLayout as $key => $value){
					parent::_clearCache('megamenus.'.$key.'.tpl');
					parent::_clearCache('megamenus.'.$key.'.rows.tpl');
					parent::_clearCache('megamenus.'.$key.'.groups.products.tpl');
					parent::_clearCache('megamenus.'.$key.'.groups.module.tpl');
					parent::_clearCache('megamenus.'.$key.'.groups.links.tpl');
				} 
					
		}else{
			parent::_clearCache('megamenus.tpl', $cacheKey);
			if($this->arrLayout)
				foreach ($this->arrLayout as $key => $value){
					parent::_clearCache('megamenus.'.$key.'.tpl', $cacheKey);
					parent::_clearCache('megamenus.'.$key.'.rows.tpl', $cacheKey);
					parent::_clearCache('megamenus.'.$key.'.groups.products.tpl', $cacheKey);
					parent::_clearCache('megamenus.'.$key.'.groups.module.tpl', $cacheKey);
					parent::_clearCache('megamenus.'.$key.'.groups.links.tpl', $cacheKey);
				} 			
		} 		
       return true;
	}
    
    public function getTotalViewed($id_product){
		$view = Db::getInstance()->getRow('
		SELECT SUM(pv.`counter`) AS total
		FROM `'._DB_PREFIX_.'page_viewed` pv
		LEFT JOIN `'._DB_PREFIX_.'date_range` dr ON pv.`id_date_range` = dr.`id_date_range`
		LEFT JOIN `'._DB_PREFIX_.'page` p ON pv.`id_page` = p.`id_page`
		LEFT JOIN `'._DB_PREFIX_.'page_type` pt ON pt.`id_page_type` = p.`id_page_type`
		WHERE pt.`name` = \'product.php\'
		AND p.`id_object` = '.intval($id_product).'');
		return isset($view['total']) ? $view['total'] : 0;
	}
    
	public function getProductRatings($id_product){
		$validate = Configuration::get('PRODUCT_COMMENTS_MODERATE');
		$sql = 'SELECT (SUM(pc.`grade`) / COUNT(pc.`grade`)) AS avg,
				MIN(pc.`grade`) AS min,
				MAX(pc.`grade`) AS max,
                COUNT(pc.`grade`) AS total
			FROM `'._DB_PREFIX_.'product_comment` pc
			WHERE pc.`id_product` = '.(int)$id_product.'
			AND pc.`deleted` = 0'.
			($validate == '1' ? ' AND pc.`validate` = 1' : '');
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql);
	}
	public static function _getLayoutName($layoutKey){
		$thisModule = new MegaMenus();
		return $thisModule->arrLayout[$layoutKey];
	}
    
    // load product list (add manual product)
    function loadProductList(){		
        $link = $this->context->link;
        $langId = $this->context->language->id;
        $shopId = $this->context->shop->id;        
        $pageSize = 10;
        $page = Tools::getValue('page', 0);// intval($_POST['page']);        
        $categoryId =  Tools::getValue('categoryId', Configuration::get('PS_HOME_CATEGORY')); // Db::getInstance()->getValue("Select category_id From "._DB_PREFIX_."simplecategory_module Where id = ".$moduleId);
        $keyword = Tools::getValue('keyword', '');
		$productIds = Tools::getValue('productIds', array());		
        $arrSubCategory = $this->_getAllCategoryIds($categoryId);
        $arrSubCategory[] = $categoryId;
        $offset=($page - 1) * $pageSize;
        $total = $this->getManualProducts($langId, $arrSubCategory, $keyword, true);
		
		$response = new stdClass();
        $response->pagination = '';
        $response->list = '';
        if($total >0){            
            $response->pagination = $this->paginationAjax($total, $pageSize, $page, 6, 'loadProductList');
            $items = $this->getManualProducts($langId, $arrSubCategory, $keyword, false, $offset, $pageSize);
            if($items){
                if($items){
                	if($productIds){
                		foreach($items as $item){
	                        $imagePath = $link->getImageLink($item['link_rewrite'], $item['id_image'], 'cart_default');
							if(in_array($item['id_product'], $productIds)){
								$response->list .= '<tr id="pListTr_'.$item['id_product'].'">
	                                                <td>'.$item['id_product'].'</td>
                                                    <td class="center"><img src="'.$imagePath.'" height="32" /></td>
	                                                <td>'.$item['name'].'</td>	                                                
	                                                <td class="center"><div><a href="javascript:void(0)" id="manual-product-'.$item['id_product'].'" data-id="'.$item['id_product'].'" data-name="'.$item['name'].'" class="link-add-manual-product-off"><i class="icon-check-square-o"></i></a></div></td>
	                                            </tr>';
							}else{
								$response->list .= '<tr id="pListTr_'.$item['id_product'].'">
                                                        <td>'.$item['id_product'].'</td>		                                                
		                                                <td class="center"><img src="'.$imagePath.'" height="32" /></td>
		                                                <td>'.$item['name'].'</td>                                                        
		                                                <td class="center"><div><a href="javascript:void(0)" id="manual-product-'.$item['id_product'].'" data-id="'.$item['id_product'].'" data-name="'.$item['name'].'" class="link-add-manual-product"><i class="icon-plus"></i></a></div></td>
		                                            </tr>';	
							}
	                        
	                    }
                	}else{
	                	foreach($items as $item){
	                        $imagePath = $link->getImageLink($item['link_rewrite'], $item['id_image'], 'cart_default');							
	                        $response->list .= '<tr id="pListTr_'.$item['id_product'].'">
	                                                <td>'.$item['id_product'].'</td>
	                                                <td class="center"><img src="'.$imagePath.'" height="32" /></td>
	                                                <td>'.$item['name'].'</td>	                                                
	                                                <td class="center"><div><a href="javascript:void(0)" id="manual-product-'.$item['id_product'].'" data-id="'.$item['id_product'].'" data-name="'.$item['name'].'" class="link-add-manual-product"><i class="icon-plus"></i></a></div></td>
	                                            </tr>';
	                    }	
                	}
                    
                }
            }   
        }
        die(Tools::jsonEncode($response));
    }
    
    function getManualProducts($id_lang, $arrCategory = array(), $keyword = '', $getTotal = false, $offset=0, $limit=10){        
        $where = "";
        if($arrCategory){
            $catIds = implode(', ', $arrCategory);
        }        
        $where .= ' AND p.`id_product` IN (
			SELECT cp.`id_product`
			FROM `'._DB_PREFIX_.'category_product` cp 
			WHERE cp.id_category IN ('.$catIds.'))';
            		
        if($keyword != '') $where .= " AND (p.id_product) LIKE '%".$keyword."%' OR pl.name LIKE '%".$keyword."%'";
        if($getTotal == true){
            $sqlTotal = 'SELECT COUNT(p.`id_product`) AS nb 
    					FROM `'._DB_PREFIX_.'product` p 
    					'.Shop::addSqlAssociation('product', 'p').'  
                        LEFT JOIN `'._DB_PREFIX_.'product_lang` pl 
    					   ON p.`id_product` = pl.`id_product` 
    					   AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').' 
    					WHERE product_shop.`active` = 1 
                            AND product_shop.`active` = 1 
                            AND p.`visibility` != \'none\' '.$where;
            $total = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sqlTotal);
            if($getTotal == true) return $total;    
        }                            
        $sql = 'Select p.id_product, pl.`name`,  pl.`link_rewrite`, MAX(image_shop.`id_image`) id_image 
                FROM  `'._DB_PREFIX_.'product` p 
                '.Shop::addSqlAssociation('product', 'p', false).'				
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl 
					ON p.`id_product` = pl.`id_product` 
					AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').' 
				LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product`)'.
				Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').' 
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')				
				WHERE product_shop.`active` = 1 
					AND p.`visibility` != \'none\'  '.$where.'			
				GROUP BY product_shop.id_product Limit '.$offset.', '.$limit;
                return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);            
    }
    protected function paginationAjax($total, $page_size, $current = 1, $index_limit = 10, $func='loadPage'){
		$total_pages=ceil($total/$page_size);
		$start=max($current-intval($index_limit/2), 1);
		$end=$start+$index_limit-1;
		$output = '';                       
		$output = '<ul class="pagination">';
		if($current==1) {
			$output .= '<li><span>Prev</span></li>';
		}else{
			$i = $current-1;
			$output .= '<li><a href="javascript:void(0)" onclick="'.$func.'(\''.$i.'\')">Prev</a></li>';
		}
		if($start>1){
			$i = 1;
			$output .= '<li><a href="javascript:void(0)" onclick="'.$func.'(\''.$i.'\')">'.$i.'</a></li>';
			$output .= '<li><span>...</span></li>';
		}	
		for ($i=$start;$i<=$end && $i<= $total_pages;$i++) {
			if($i==$current) 
				$output .= '<li class="active"><span >'.$i.'</span></li>';
			else 
				$output .= '<li><a  href="javascript:void(0)" onclick="'.$func.'(\''.$i.'\')">'.$i.'</a></li>';
		}		
		if($total_pages>$end) {
			$i = $total_pages;
			$output .= '<li><span>...</span></li>';
			$output .= '<li><a href="javascript:void(0)" onclick="'.$func.'(\''.$i.'\')">'.$i.'</a></li>';
		}		
		if($current<$total_pages) {
			$i = $current+1;
			$output .= '<li><a href="javascript:void(0)" onclick="'.$func.'(\''.$i.'\')">Next</a></li>';
		} else {
			$output .= '<li><span>Next</span></li>';
		}
		$output .= '</ul>';		
		return $output;		
	}
}
