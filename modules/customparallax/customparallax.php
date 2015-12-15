<?php
/*
*  @author SonNC <nguyencaoson.zpt@gmail.com>
*/
class CustomParallax extends Module
{
    const INSTALL_SQL_FILE = 'install.sql';
	protected static $tables = array(	'customparallax_module'=>'', 
										'customparallax_module_lang'=>'lang', 										
										);
    public $arrLayout = array();
	public $arrType = array();
	public static $sameDatas = '';
	public $page_name = '';
	protected $arrHook = array(
		'displayHome', 
		'displayHomeTopColumn',
		'displayHomeTopContent',
		'displayHomeBottomContent',
		'displayHomeBottomColumn',
		'displayBottomColumn',
		'displayTop', 
		'displayTopColumn',
		'displayFooter', 
		'displayTopColumn', 
		'displayCustomParallax1', 		
		'displayCustomParallax2', 
		'displayCustomParallax3', 
		'displayCustomParallax4', 
		'displayCustomParallax5', 
	);
	public $pathImage = '';
    public $liveImage = '';
	public function __construct()
	{
		$this->name = 'customparallax';		
		$this->arrLayout = array('default'=>$this->l('Default layout'), 'newsletter'=>$this->l('Newsletter parallax'), 'section'=>$this->l('Section layout'));
		$this->arrType = array(
			'html'		=>	'Html', 
			'module'	=>	'Module',
		);
		$this->pathImage = dirname(__FILE__).'/images/';
        if(Tools::usingSecureMode())
			$this->liveImage = _PS_BASE_URL_SSL_.__PS_BASE_URI__.'modules/'.$this->name.'/images/'; 
		else
			$this->liveImage = _PS_BASE_URL_.__PS_BASE_URI__.'modules/'.$this->name.'/images/';
		$this->secure_key = Tools::encrypt('03f7f2dd252d299bca5180ac51ddddbf:'.$this->name);        
		self::$sameDatas = dirname(__FILE__).'/samedatas/';
		$this->tab = 'front_office_features';
		$this->version = '2.0';
		$this->author = 'OVIC-SOFT';		
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('Custom Parallax module');
		$this->description = $this->l('Custom Parallax module');
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
		if (!Configuration::updateGlobalValue('MOD_CUSTOM_PARALLAX', '1')) return false;
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
        if (!Configuration::deleteByName('MOD_CUSTOM_PARALLAX')) return false;
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
	protected function _getImageSrc($image = '', $check = false){
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
	private function getTypeOptions($selected=''){
		$options = '';		
		if($this->arrType){			
			foreach($this->arrType as $key=>$value){			
				if($key == $selected) $options .='<option selected="selected" value="'.$key.'">'.$value.'</option>';
				else $options .='<option value="'.$key.'">'.$value.'</option>';
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
		$itemLang = Db::getInstance()->getRow("Select name, content From "._DB_PREFIX_."customparallax_module_lang Where module_id = $id AND `id_lang` = '$langId'" );
		if(!$itemLang) $itemLang = array('name'=>'', 'content'=>'');
		return $itemLang;
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
        return $options;		
    }
	public function renderModuleForm($id=0){
		$langId = $this->context->language->id;
        $shopId = $this->context->shop->id;
		$item = Db::getInstance()->getRow("Select * From "._DB_PREFIX_."customparallax_module Where id = $id AND `id_shop` = ".$shopId);
		$params = new stdClass();		
		if(!$item){
			$item = array(
				'id'			=>	0, 
				'id_shop'		=>	$shopId,
				'position_name'	=>	'', 
				'display_name'	=>	0, 
				'layout'		=>	'default', 
				'ordering'		=>	1, 
				'status'		=>	1, 
				'content_type'	=>	'html',
				'module_name'	=>	'',
				'method_name'	=>	'',
				'custom_class'	=>	'', 
				'params'		=>	'',			
			);
			
			$params->module = new  stdClass();
			$params->module->name = '';
			$params->module->hook = '';
			$params->parallax = new stdClass();
			$params->parallax->image = '';
			$params->parallax->ratio = '0.5';
			$params->parallax->responsive = 0;
			$params->parallax->parallaxBackgrounds = 1;
			$params->parallax->parallaxElements = 1;
			$params->parallax->hideDistantElements = 1;
			$params->parallax->horizontalOffset = 0;
			$params->parallax->verticalOffset = 0;
			$params->parallax->horizontalScrolling = 1;
			$params->parallax->verticalScrolling = 1;
			$params->parallax->scrollProperty = 'scroll';// scroll, position, margin,transform
			$params->parallax->positionProperty = 'position';//position, transform
		}else{
			$params = Tools::jsonDecode($item['params']);
		} 
		
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
		$html = array();
		$html['parallax'] = '';
		$html['config'] = '';
		$html['config'] .= '<input type="hidden" name="moduleId" value="'.$item['id'].'" />';
		$html['config'] .= $langActive;
		$html['config'] .= '<input type="hidden" name="action" value="saveModule" />';
		$html['config'] .= '<input type="hidden" name="secure_key" value="'.$this->secure_key.'" />';
		$html['config'] .= '	<div class="form-group">
						<label class="control-label col-sm-2">'.$this->l('Name').'</label>
						<div class="col-sm-10">
							<div class="col-sm-10">'.$names.'</div>
							<div class="col-sm-2">
								<select class="module-lang" onchange="moduleChangeLanguage(this.value)">'.$langOptions.'</select>
							</div>
						</div>
					</div>';
		$html['config'] .= '<div class="form-group">
								<label class="control-label col-sm-2">'.$this->l('Position').'</label>
								<div class="col-sm-10">
									<div class="col-sm-5">
										<select  name="position_name">'.$this->getPositionOptions($item['position_name']).'</select>
									</div>
									<label class="control-label col-sm-2">'.$this->l('Display name').'</label>				                    
			                        <div class="col-sm-5">
			                            <span class="switch prestashop-switch fixed-width-lg" id="module-display-name">
			                                <input type="radio" value="1" class="display_name" '.($item['display_name'] == 1 ? 'checked="checked"' : '').' id="display_name_on" name="display_name" />
			            					<label for="display_name_on">Yes</label>
			            				    <input type="radio" value="0" class="display_name" '.($item['display_name'] == 0 ? 'checked="checked"' : '').' id="display_name_off" name="display_name" />
			            					<label for="display_name_off">No</label>
			                                <a class="slide-button btn"></a>
			            				</span>
			                        </div>                        
								</div>
							</div>';
		$html['config'] .= '<div class="form-group">
				<label class="control-label col-sm-2">'.$this->l('Layout').'</label>
				<div class="col-sm-10">
					<div class="col-sm-5">
						<select class="form-control" name="moduleLayout">'.$this->getLayoutOptions($item['layout']).'</select>
					</div>
					<label class="control-label col-sm-2">'.$this->l('Custom class').'</label>
					<div class="col-sm-5">						
						<input type="text" value="'.$item['custom_class'].'" name="custom_class"  class="form-control" />						
					</div>
				</div>
			</div>';
		$html['config'] .= '<div class="form-group clearfix">
			                    <label class="control-label col-sm-2">'.$this->l('Data type').'</label>
			                    <div class="col-sm-10">
			                    	<div class="col-sm-5">                        
			                            <select name = "content_type" id="content_type" class="form-control" onchange="showDataType(this.value)">'.$this->getTypeOptions($item['content_type']).'</select>                        
			                        </div>
			                    </div>
			                    		                         
			                </div>';
		$html['config'] .= '<div id="type-module" class="data-type" style="display:'.($item['content_type'] == 'module' ? 'block' : 'none').'">                    
			                  	<div class="form-group clearfix">
				                    <label class="control-label col-sm-2">'.$this->l('Select module').'</label>
				                    <div class="col-sm-10">
				                        <div class="col-sm-5">                        
				                            <select name="module_name" id="module_name" onchange="loadModuleHooks(this.value)" class="form-control">'.'<option value="">['.$this->l('Select module').']</option>'.$this->generateModuleOption($params->module->name).'</select>                       
				                        </div>
				                        <label class="control-label col-sm-2">'.$this->l('Select hook').'</label>
				                        <div class="col-sm-5">                        
				                            <select name = "module_hook" id="module_hook" class="form-control">'.'<option value="">['.$this->l('Select hook').']</option>'.$this->generateHookModuleOption($params->module->name, $params->module->hook).'</select>                        
				                        </div>
				                    </div>  
				                </div>
			                </div>';
		$html['config'] .= '<div id="type-html" class="data-type" style="display:'.($item['content_type'] == 'html' ? 'block' : 'none').'">                    
			                  	<div class="form-group clearfix">
									<label class="control-label col-sm-2 ">'.$this->l('Html content').'</label>
									<div class="col-sm-10">
										<div class="col-sm-10">'.$contents.'</div>
										<div class="col-sm-2">
											<select class="module-lang" onchange="moduleChangeLanguage(this.value)">'.$langOptions.'</select>
										</div>
									</div>
								</div>
			                </div>';
		
		
		$html['parallax'] .= '<div class="form-group clearfix">
                    			<label class="control-label col-sm-2 ">'.$this->l('Image').'</label>
                    			<div class="col-sm-10">
		                            <div class="col-sm-12"> 
		                                <div class="input-group">
		                                    <input type="text" value="'.$params->parallax->image.'" name="parallax_image"  id="parallax_image" class="form-control" />
		                                    <span class="input-group-btn">
		                                        <button id="image-uploader" type="button" class="btn btn-default"><i class="icon-folder-open"></i></button>
		                                    </span>
		                                </div>
		                            </div> 		                                       
	                        	</div>	                        	
		                    </div>';
		$html['parallax'] .= '<div class="form-group clearfix">
                    			<label class="control-label col-sm-2 ">'.$this->l('Backgroud ratio').'</label>
                    			<div class="col-sm-10">
		                            <div class="col-sm-5"> 		                                
										<input type="text" value="'.$params->parallax->ratio.'" name="parallax_ratio"  id="parallax_ratio" class="form-control" onkeypress="return handleEnterNumber(event);" />
		                            </div> 
	                        	</div>	                        	
		                    </div>';
		$html['parallax'] .= '<div class="form-group clearfix">
                    			<label class="control-label col-sm-2 ">'.$this->l('Responsive').'</label>
                    			<div class="col-sm-10">		                            
				                    <div class="col-sm-5">
				                        <div class="col-sm-12">
				                            <span class="switch prestashop-switch fixed-width-lg" id="responsive">
				                                <input type="radio" value="1" class="responsive" '.($params->parallax->responsive == 1 ? 'checked="checked"' : '').' id="responsive_on" name="responsive" />
				            					<label for="responsive_on">Yes</label>
				            				    <input type="radio" value="0" class="responsive" '.($params->parallax->responsive == 0 ? 'checked="checked"' : '').' id="responsive_off" name="responsive" />
				            					<label for="responsive_off">No</label>
				                                <a class="slide-button btn"></a>
				            				</span>
				                        </div>                        
				                    </div>		                                       
	                        	</div>	                        	
		                    </div>';
		$html['parallax'] .= '<div class="form-group clearfix">
                    			<label class="control-label col-sm-2">'.$this->l('Parallax elements').'</label>
                    			<div class="col-sm-10">		                            
				                    <div class="col-sm-5">
				                        <div class="col-sm-12">
				                            <span class="switch prestashop-switch fixed-width-lg" id="parallaxElements">
				                                <input type="radio" value="1" class="parallax_elements" '.($params->parallax->parallaxElements == 1 ? 'checked="checked"' : '').' id="parallax_elements_on" name="parallaxElements" />
				            					<label for="parallax_elements_on">Yes</label>
				            				    <input type="radio" value="0" class="parallax_elements" '.($params->parallax->parallaxElements == 0 ? 'checked="checked"' : '').' id="parallax_elements_off" name="parallaxElements" />
				            					<label for="parallax_elements_off">No</label>
				                                <a class="slide-button btn"></a>
				            				</span>
				                        </div>                        
				                    </div>		                                       
	                        	</div>	                        	
		                    </div>';
		$html['parallax'] .= '<div class="form-group clearfix">
                    			<label class="control-label col-sm-2 ">'.$this->l('Horizontal scrolling').'</label>
                    			<div class="col-sm-10">
		                            <div class="col-sm-5">
				                        <div class="col-sm-12">
				                            <span class="switch prestashop-switch fixed-width-lg" id="horizontalScrolling">
				                                <input type="radio" value="1" class="horizontal_scrolling" '.($params->parallax->horizontalScrolling == 1 ? 'checked="checked"' : '').' id="horizontal_scrolling_on" name="horizontalScrolling" />
				            					<label for="horizontal_scrolling_on">Yes</label>
				            				    <input type="radio" value="0" class="parallax_elements" '.($params->parallax->horizontalScrolling == 0 ? 'checked="checked"' : '').' id="horizontal_scrolling_off" name="horizontalScrolling" />
				            					<label for="horizontal_scrolling_off">No</label>
				                                <a class="slide-button btn"></a>
				            				</span>
				                        </div>                        
				                    </div> 
	                        	</div>	                        	
		                    </div>';
		$html['parallax'] .= '<div class="form-group clearfix">
                    			<label class="control-label col-sm-2 ">'.$this->l('Vertical scrolling').'</label>
                    			<div class="col-sm-10">		                            
				                    <div class="col-sm-5">
				                        <div class="col-sm-12">
				                            <span class="switch prestashop-switch fixed-width-lg" id="verticalScrolling">
				                                <input type="radio" value="1" class="vertical_scrolling" '.($params->parallax->verticalScrolling == 1 ? 'checked="checked"' : '').' id="vertical_scrolling_on" name="verticalScrolling" />
				            					<label for="vertical_scrolling_on">Yes</label>
				            				    <input type="radio" value="0" class="vertical_scrolling" '.($params->parallax->verticalScrolling == 0 ? 'checked="checked"' : '').' id="vertical_scrolling_off" name="verticalScrolling" />
				            					<label for="vertical_scrolling_off">No</label>
				                                <a class="slide-button btn"></a>
				            				</span>
				                        </div>                        
				                    </div>		                                       
	                        	</div>	                        	
		                    </div>';
							
		return $html;
	}
	public function loadModuleHooks(){
		$response = '';
		$moduleName = Tools::getValue('moduleName', '');		
		if($moduleName == '') 
            $response = '<option value="">['.$this->l('Select hook').']</option>';
		else{
			$response = '<option value="">['.$this->l('Select hook').']</option>'.$this->generateHookModuleOption($moduleName);
		}			
		die(Tools::jsonEncode($response));
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
		//$this->registerHook('displayHeader') ;
		
		$action = Tools::getValue('action', 'view');
		if($action == 'view'){
			$this->context->controller->addJquery();
			$this->context->controller->addjQueryPlugin('tablednd');						
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
	        $items = Db::getInstance()->executeS("Select m.*, ml.name 
	        	From "._DB_PREFIX_."customparallax_module AS m 
	        	Left Join "._DB_PREFIX_."customparallax_module_lang AS ml On ml.module_id = m.id 
	        	Where m.id_shop = '".$shopId."' AND ml.id_lang = ".$langId." 
	        	Order By m.position_name,  m.ordering");			
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
		$params = new stdClass();
		$params->module = new stdClass();
		$params->parallax = new stdClass();
		
        $shopId = Context::getContext()->shop->id;
		$languages = $this->getAllLanguage();        
        $response = new stdClass();		
        $itemId = intval($_POST['moduleId']);
		
		
		
		$names = Tools::getValue('names', array());
		$contents = Tools::getValue('contents', array());
		$position_name = Tools::getValue('position_name', '');
        $display_name = Tools::getValue('display_name', 1);
        $layout = Tools::getValue('moduleLayout', 'default');                
        $custom_class = Tools::getValue('custom_class', '');
		$content_type = Tools::getValue('content_type', 'html');
		$params->module->name = Tools::getValue('module_name','');
		$params->module->hook = Tools::getValue('module_hook', '');
		$parallax_image = Tools::getValue('parallax_image', '');		

		$params->parallax->ratio = floatval(Tools::getValue('parallax_ratio', 0.5));
		$params->parallax->responsive = intval(Tools::getValue('responsive', 0));
		$params->parallax->parallaxBackgrounds = 1;
		$params->parallax->parallaxElements = intval(Tools::getValue('parallaxElements', 1));
		$params->parallax->hideDistantElements = 1;
		$params->parallax->horizontalOffset = 0;
		$params->parallax->verticalOffset = 0;
		$params->parallax->horizontalScrolling = intval(Tools::getValue('horizontalScrolling', 1));
		$params->parallax->verticalScrolling = intval(Tools::getValue('verticalScrolling', 1));
		$params->parallax->scrollProperty = 'scroll';// scroll, position, margin,transform
		$params->parallax->positionProperty = 'position';//position, transform
		$nameDefault = '';
		$contentDefault = '';
		$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        if($itemId == 0){
			$maxOrdering = $db->getValue("Select MAX(ordering) From "._DB_PREFIX_."customparallax_module Where `position_name` = '$position_name'");
		   	if($maxOrdering >0) $maxOrdering++;
		   	else $maxOrdering = 1;
			$arrInsert = array(
				'id_shop'	=>	$shopId,
				'position_name'		=>	$position_name,
				'display_name'		=>	$display_name,
				'layout'			=>	$layout,
				'ordering'			=>	$maxOrdering,
				'content_type'		=>	$content_type,
				'status'			=>	1,
				'custom_class'		=>	$custom_class,
			);
			$params->parallax->image = '';
			if($parallax_image){				
				if(strpos($parallax_image, 'http') !== false){
					$params->parallax->image = $parallax_image;
				}else{
					if(file_exists($this->pathImage.'temps/'.$parallax_image)){
						if(copy($this->pathImage.'temps/'.$parallax_image, $this->pathImage.$parallax_image)){
							$params->parallax->image = $parallax_image;
						}
						unlink($this->pathImage.'temps/'.$parallax_image);
					}	
				}
			}	
			$arrInsert['params'] = Tools::jsonEncode($params);
			if($db->insert('customparallax_module', $arrInsert)){
                $insertId = $db->Insert_ID();				
				if($languages){
                	$insertDatas = array();
                	foreach($languages as $index=>$language){
                		$name = $db->escape($names[$index]);
						$content = $db->escape($contents[$index], true);
                		if(!$nameDefault) $nameDefault = $name;
						else
							if(!$name)	$name	=	$nameDefault;
						if(!$contentDefault)  $contentDefault = $content;
						else
							if(!$content) $content = $contentDefault;
						$insertDatas[] = array('module_id'=>$insertId, 'id_lang'=>$language->id, 'name'=>$name, 'content'=>$content);                   		                
                	}
					if($insertDatas) $db->insert('customparallax_module_lang', $insertDatas);
                }                
                $response->status = '1';
                $response->msg = $this->l('Add new Module Success!');
                $this->clearCache();  
            }else{
                $response->status = '0';
                $response->msg = $this->l('Add new Module not Success!');
            }
        }else{
        	$item = $db->getRow("Select * From "._DB_PREFIX_."customparallax_module Where id = ".$itemId);
			$itemParams = Tools::jsonDecode($item['params']);
			$params->parallax->image = $itemParams->parallax->image;
        	$arrUpdate = array(
				'position_name'		=> 	$position_name,
				'display_name'		=>	$display_name,
				'layout'	=>	$layout,
				'content_type'	=>	$content_type,
				'custom_class'	=>	$custom_class,
			);
			
			if($parallax_image){
				if(strpos($parallax_image, 'http') !== false){
					$params->parallax->image = $parallax_image;
					if($itemParams->parallax->image && file_exists($this->pathImage.$itemParams->parallax->image)) unlink($this->pathImage.$itemParams->parallax->image);
				}else{
					if(file_exists($this->pathImage.'temps/'.$parallax_image)){
						if(copy($this->pathImage.'temps/'.$parallax_image, $this->pathImage.$parallax_image)){							
							$params->parallax->image = $parallax_image;
							if($itemParams->parallax->image && file_exists($this->pathImage.$itemParams->parallax->image)) unlink($this->pathImage.$itemParams->parallax->image);
						}
						unlink($this->pathImage.'temps/'.$parallax_image);
					}
				}				
			}else{
				$params->parallax->image = '';
				if($itemParams->parallax->image && file_exists($this->pathImage.$itemParams->parallax->image)) unlink($this->pathImage.$itemParams->parallax->image);
			}
			$arrUpdate['params'] = Tools::jsonEncode($params);
            $db->update('customparallax_module', $arrUpdate, "`id`='$itemId'");            			
			if($languages){
				$insertDatas = array();            	
            	foreach($languages as $index=>$language){
            		$check = $db->getValue("Select module_id From "._DB_PREFIX_."customparallax_module_lang Where module_id = $itemId AND id_lang = ".$language->id);
					$name = $db->escape($names[$index]);
					$content = $db->escape($contents[$index], true);
            		if(!$nameDefault) $nameDefault = $name;
					else
						if(!$name)	$name	=	$nameDefault;
					if(!$contentDefault)  $contentDefault = $content;
					else
						if(!$content) $content = $contentDefault;
						
            		if($check){
            			$db->execute("Update "._DB_PREFIX_."customparallax_module_lang Set `name` = '".$name."', `content`='".$content."' Where `module_id` = ".$itemId." AND `id_lang` = ".$language->id);	
            		}else{
            			$insertDatas[] = array('module_id'=>$itemId, 'id_lang'=>$language->id, 'name'=>$name, 'content'=>$content);
            		}
            	}
            	if($insertDatas) $db->insert('customparallax_module_lang', $insertDatas);
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
			Db::getInstance()->execute("Update "._DB_PREFIX_."customparallax_module Set `status` = 0 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
			$this->clearCache();
		}else{
			Db::getInstance()->execute("Update "._DB_PREFIX_."customparallax_module Set `status` = 1 Where id = ".$itemId);
			$response->status = 1;
			$response->msg = $this->l('Update status success');
		}
		die(Tools::jsonEncode($response));
	}	
	
	public function getModuleItem(){		
        $response = new stdClass();
        $itemId = intval($_POST['itemId']);
        if($itemId){
        	$item = $this->renderModuleForm($itemId);
			$response->config = $item['config'];
			$response->parallax = $item['parallax'];		       
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
		$item = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("Select * From "._DB_PREFIX_."customparallax_module Where id = ".$itemId);
        $response = new stdClass();        
        if(Db::getInstance()->execute("Delete From "._DB_PREFIX_."customparallax_module Where id = ".$itemId)){
            Db::getInstance()->execute("Delete From "._DB_PREFIX_."customparallax_module_lang Where module_id = ".$itemId);
			$params = Tools::jsonDecode($item['params']);
			if($params->parallax->image)
				if(strpos($params->parallax->image, 'http') === false){
					if(file_exists($this->pathImage.$params->parallax->image)){
						unlink($this->pathImage.$params->parallax->image);
					}
				}else{
						
				}
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
                Db::getInstance()->query("Update "._DB_PREFIX_."customparallax_module Set ordering=".(1 + $i)." Where id = ".$id);                
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
			$this->_path.'js/hook/customparallax.js',
			$this->_path.'js/hook/jquery.stellar.min.js',
		));		
		$this->context->controller->addCSS(($this->_path).'css/hook/customparallax.css');        		
	}
		
	
	public function hookdisplayHome($params){	
		return $this->hooks('hookdisplayHome', $params);		
	}		
	public function hookdisplayHomeTopColumn($params){
		return $this->hooks('displayHomeTopColumn', $params);		
	}
	
	public function hookdisplayHomeBottomContent($params){
		return $this->hooks('hookdisplayHomeBottomContent', $params);		
	}	
	public function hookdisplayHomeTopContent($params){
		return $this->hooks('displayHomeTopContent', $params);		
	}	
	public function hookdisplayHomeBottomColumn($params){		
		return $this->hooks('displayHomeBottomColumn', $params);		
	}
	public function hookdisplayBottomColumn($params){		
		return $this->hooks('displayBottomColumn', $params);		
	}
	public function hookdisplayTop($params){		
		return $this->hooks('displayTop', $params);		
	}
	public function hookdisplayTopColumn($params){		
		return $this->hooks('displayTopColumn', $params);		
	}
	public function hookdisplayFooter($params){		
		return $this->hooks('displayFooter', $params);		
	}
	public function hookdisplayCustomParallax1($params){		
		return $this->hooks('displayCustomParallax1', $params);		
	}
	public function hookdisplayCustomParallax2($params){		
		return $this->hooks('displayCustomParallax2', $params);		
	}
	public function hookdisplayCustomParallax3($params){		
		return $this->hooks('displayCustomParallax3', $params);		
	}
	public function hookdisplayCustomParallax4($params){		
		return $this->hooks('displayCustomParallax4', $params);		
	}
	public function hookdisplayCustomParallax5($params){		
		return $this->hooks('displayCustomParallax5', $params);		
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
		if (!$this->isCached('customparallax.tpl', Tools::encrypt($cacheKey))){
			$sql = "Select DISTINCT m.*, ml.`name`, ml.`content`   
	    		From "._DB_PREFIX_."customparallax_module AS m 
	    		INNER JOIN "._DB_PREFIX_."customparallax_module_lang AS ml 
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
	            $this->context->smarty->assign('customparallax_modules', $modules);
				            
	        }else return "";	
		}
		return $this->display(__FILE__, 'customparallax.tpl', Tools::encrypt($cacheKey));
    }
	protected function buildContentWithLayout($item, $hookName, $shopId, $langId, $cacheKey=''){
		
		
		if (!$this->isCached('customparallax.'.$item['layout'].'.tpl', Tools::encrypt($cacheKey))){
			
			$params = Tools::jsonDecode($item['params']);
			$item['parallax_image'] = $this->_getImageSrc($params->parallax->image);
			$item['parallax_ratio'] = $params->parallax->ratio;
			$item['parallax_responsive'] = $params->parallax->responsive;
			$item['parallax_parallaxBackgrounds'] = $params->parallax->parallaxBackgrounds;
			$item['parallax_parallaxElements'] = $params->parallax->parallaxElements;
			$item['parallax_hideDistantElements'] = $params->parallax->hideDistantElements;
			$item['parallax_horizontalOffset'] = $params->parallax->horizontalOffset;
			$item['parallax_verticalOffset'] = $params->parallax->verticalOffset;
			$item['parallax_horizontalScrolling'] = $params->parallax->horizontalScrolling;
			$item['parallax_verticalScrolling'] = $params->parallax->verticalScrolling;
			$item['parallax_scrollProperty'] = $params->parallax->scrollProperty;
			$item['parallax_positionProperty'] = $params->parallax->positionProperty;						
			unset($item['params']);
			if($item['content_type'] == 'module'){
				$module = @Module::getInstanceByName($params->module->name);		
				if($module){
					if (Validate::isLoadedObject($module) && $module->id){
						if (Validate::isHookName($params->module->hook)){
							$functionName = 'hook'.$params->module->hook;					
							$hookArgs = array();
							$hookArgs['cookie'] = $this->context->cookie;
							$hookArgs['cart'] = $this->context->cart;								
							$item['content'] = $module->$functionName($hookArgs);				
						}else{
							$item['content'] = '';
						}
					}
				}else{
					$item['content']='';
				}
			}else{
				// short codes
				//if($item['content']) $item['content'] = Tools::htmlentitiesDecodeUTF8($item['content']);
		        $content = $item['content'];
				if($content){				
					// short code module
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

					$pattern = '/\{product\}(.*?)\{\/product\}/';
			        $check = preg_match_all($pattern, $item['content'], $match);
					
					if($check){
						$results = $match[1];
			            if($results){
			                foreach($results as $result){
			                	$module_content = '';                    
			                    $config = json_decode(str_replace(array('\\', '\''), array('', '"'), $result));                    
			                    if($config){
			                    	if(is_object($config)){
			                    		if(isset($config->id) && (int)$config->id >0 ){
			                    			$product = $this->buildProduct($config->id, $item['layout'], $cacheKey.'|'.$item['id']);
											
											$item['content'] = str_replace('{product}'.$result.'{/product}', $product, $item['content']);
											
			                    		}else{
			                    			$item['content'] = str_replace('{product}'.$result.'{/product}', '', $item['content']);
			                    		}
			                    			
			                    	}else{
			                    		$item['content'] = str_replace('{product}'.$result.'{/product}', '', $item['content']);	
			                    	}
									
			                    }else{
			                        $item['content'] = str_replace('{product}'.$result.'{/product}', '', $item['content']);
			                    }
			                    
			                }
			            }else{
			            	$item['content'] = preg_replace($pattern, '', $item['content']);
			            }
					}
				}	
			}
			$this->context->smarty->assign('customparallax', $item);		
		}
		
		return $this->display(__file__, 'customparallax.'.$item['layout'].'.tpl', Tools::encrypt($cacheKey));
	}
	
	function buildProduct($productId = 0, $layout, $cacheKey=''){
		if (!$this->isCached('customparallax.'.$layout.'.product.tpl', Tools::encrypt($cacheKey))){			
			if($productId){
				$langId = Context::getContext()->language->id;
	        	$shopId = Context::getContext()->shop->id;
				$product =  $this->getProductById($productId, $langId, true);
				if($product)				
					$this->context->smarty->assign('product', $product);
				else
					return "";
			}else return "";
		}		
		return $this->display(__file__, 'customparallax.'.$layout.'.product.tpl', Tools::encrypt($cacheKey));
	}
	public function getProductById($productId = 0, $id_lang, $active = true, Context $context = null){
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
	function clearCache($cacheKey=''){
		if(!$cacheKey){
			parent::_clearCache('customparallax.tpl');
			if($this->arrLayout)
				foreach($this->arrLayout as $key=>$value){
					parent::_clearCache('customparallax.'.$key.'.tpl');
					parent::_clearCache('customparallax.'.$key.'.product.tpl');
				}
					
		}else{
			parent::_clearCache('customparallax.tpl', Tools::encrypt($cacheKey));
			if($this->arrLayout)
				foreach($this->arrLayout as $key=>$value){
					parent::_clearCache('customparallax.'.$key.'.tpl', Tools::encrypt($cacheKey));
					parent::_clearCache('customparallax.'.$key.'.product.tpl', Tools::encrypt($cacheKey));
				}
					
		} 		
       return true;
	}
}