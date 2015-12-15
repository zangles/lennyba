<?php
require_once (dirname(__file__) . '/../../class/Options.php');
require_once(dirname(__FILE__).'/../../oviclayoutcontrol.php');
class AdminLayoutSettingController extends ModuleAdminController {
    public function __construct() {
        $this->module = 'oviclayoutcontrol';
        $this->lang = true;
        $this->context = Context::getContext();
        $this->bootstrap = true;
        parent::__construct();
    }
    public function renderList(){
        $view = Tools::getValue('view','default');
        $id_lang = $this->context->language->id;
        $id_shop = $this->context->shop->id;
        if ($view =='default'){
            $languages = Language::getLanguages(false);
            $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
            $tpl = $this->createTemplate('oviclayout.tpl');
            $id_tab = (int)Tools::getValue('id_tab',0);
            $current_id_option = Configuration::get('OVIC_CURRENT_OPTION',null,null,$id_shop);
            $check_option = new Options($current_id_option);
            $current_theme = Theme::getThemeInfo($this->context->shop->id_theme);
            if (strtolower($check_option->theme) != strtolower($current_theme['theme_name'])){
                Configuration::deleteByName('OVIC_CURRENT_OPTION');
                Configuration::deleteByName('OVIC_LAYOUT_COLUMN'); 
                Configuration::deleteByName('OVIC_CURRENT_DIR'); 
                $current_id_option = null;  
            }
            $emptyOption = false;
            $sql = 'SELECT * FROM `' . _DB_PREFIX_ . 'ovic_options` o
                WHERE LCASE(o.`theme`) =\''.strtolower($current_theme['theme_name']).'\'';
            $options = Db::getInstance()->executeS($sql);
            if ($options && is_array($options) && sizeof($options)>0){
                if (!$current_id_option || !Validate::isUnsignedId($current_id_option) || !OvicLayoutControl::isAvailablebyId($current_id_option))
                    foreach ($options as $option){
                        $current_option = new Options($option['id_option']);
                        Configuration::updateValue('OVIC_CURRENT_OPTION',$option['id_option'],false,null,$id_shop);
                        Configuration::updateValue('OVIC_CURRENT_DIR',str_replace(' ','_',$current_option->alias),false,null,$id_shop);
                        $current_id_option = $option['id_option'];
                        break;
                    }
            }else
                $emptyOption = true;
            if ($options && is_array($options) && sizeof($options)>0)
                $current_option = new Options($current_id_option);
            if (!$emptyOption){
                $selected_layout = Configuration::get('OVIC_LAYOUT_COLUMN',null,null,$id_shop);
                if (!$selected_layout || substr_count($current_option->column,$selected_layout)<1)
                    if (strlen($current_option->column)>0){
                        $selected_layout = (int)substr($current_option->column,0,1);
                        Configuration::updateValue('OVIC_LAYOUT_COLUMN',$selected_layout,false,null,$id_shop);
                        $this->ProcessLayoutColumn();
                    }
            }else
                $tpl->assign(array('emptyOption' => Tools::displayError('There is no Option, please add new Option from Layout Builder menu.')));
            //get sidebar infomation
            $pagelist = Meta::getMetas();
            $sidebarPages = array();
            if ($pagelist && is_array($pagelist) && sizeof($pagelist)>0){
                $theme = new Theme((int)$this->context->shop->id_theme);
                foreach ($pagelist as $page){
                    $sidebarPage = array();
                    $meta_object = New Meta($page['id_meta']);
        			$title = $page['page'];
        			if (isset($meta_object->title[(int)$id_lang]) && $meta_object->title[(int)$id_lang] != '')
        				$title = $meta_object->title[(int)$id_lang];
                    $sidebarPage['id_meta'] = $page['id_meta'];
                    $sidebarPage['title'] = $title;
                    $sidebarPage['page_name'] = $page['page'];
                    $sidebarPage['displayLeft'] = $theme->hasLeftColumn($page['page'])? 1:0;
                    $sidebarPage['displayRight'] = $theme->hasRightColumn($page['page'])? 1:0;
                    $sidebarPages[] = $sidebarPage;
                }
            }
            $tpl->assign( array(
                'postUrl' => self::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminLayoutSetting'),
                'absoluteUrl' => __PS_BASE_URI__.'modules/'.$this->module->name,
                'id_tab' => $id_tab,
                'options' => $options,
                'current_option' => isset($current_option)? $current_option:null,
                'selected_layout' => isset($selected_layout)? $selected_layout:null,
                'sidebarPages' => $sidebarPages
            ));
        }elseif ($view == 'detail'){
            $tpl = $this->createTemplate('sidebarmodule.tpl');
            $pagemeta = Tools::getValue('pagemeta');
            $meta = Meta::getMetaByPage($pagemeta,$id_lang);
            $theme = new Theme((int)$this->context->shop->id_theme);
            $LeftModules = array();
            $RightModules = array();
            if ($theme->hasLeftColumn($pagemeta))
                $LeftModules = OvicLayoutControl::getSideBarModulesByPage($pagemeta,'left');
            if ($theme->hasRightColumn($pagemeta))
                $RightModules = OvicLayoutControl::getSideBarModulesByPage($pagemeta,'right');
            $tpl->assign( array(
                'postUrl' => self::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminLayoutSetting'),
                'leftModule' => $LeftModules,
                'rightModule' => $RightModules,
                'pagemeta' => $pagemeta,
                'pagename' => $meta['title'],
                'displayLeft' => $theme->hasLeftColumn($pagemeta),
                'displayRight' => $theme->hasRightColumn($pagemeta),
                'templatePath' => $this->getTemplatePath(),
                'moduleDir' => _MODULE_DIR_,
            ));
        }
        return $tpl->fetch();
    }
    private function getHtmlValue($key, $default_value = false)
	{
		if (!isset($key) || empty($key) || !is_string($key))
			return false;
		$ret = (isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : $default_value));
        $ret = htmlentities($ret);
		if (is_string($ret) === true)
			$ret = urldecode(preg_replace('/((\%5C0+)|(\%00+))/i', '', urlencode($ret)));
		return !is_string($ret)? $ret : stripslashes($ret);
	}
    public function setMedia(){
        parent::setMedia();
        $this->addJqueryPlugin(array('fancybox', 'idTabs'));
		$this->addJqueryUi('ui.sortable');
        $this->addJS(_PS_MODULE_DIR_.$this->module->name.'/js/layoutsetting.js');
    }
    private function echoArr($arr){
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }
    private function getIdThemeMetaByPage($page=null){
        return Db::getInstance()->getValue(
			'SELECT id_theme_meta
				FROM '._DB_PREFIX_.'theme_meta tm
				LEFT JOIN '._DB_PREFIX_.'meta m ON ( m.id_meta = tm.id_meta )
				WHERE m.page = "'.pSQL($page).'" AND tm.id_theme='.(int)$this->context->shop->id_theme
		);
    }
    private function ProcessLayoutColumn(){
        $theme = new Theme((int)$this->context->shop->id_theme);
        $layoutColumn = (int)Configuration::get('OVIC_LAYOUT_COLUMN',null,null,$this->context->shop->id);
        $id_theme_meta = $this->getIdThemeMetaByPage('index');
        if ($theme->hasLeftColumn('index')){
            if ($layoutColumn === 2 || $layoutColumn === 3)
                $this->processLeftMeta($id_theme_meta);
        }else{
            if ($layoutColumn === 0 || $layoutColumn === 1)
                $this->processLeftMeta($id_theme_meta);
        }
        if ($theme->hasRightColumn('index')){
            if ($layoutColumn === 1 || $layoutColumn === 3)
                $this->processRightMeta($id_theme_meta);
        }else{
            if ($layoutColumn === 0 || $layoutColumn === 2)
                $this->processRightMeta($id_theme_meta);
        }
        Tools::clearCache();
    }
    private function processLeftMeta($id_theme_meta)
	{
		$theme_meta = Db::getInstance()->getRow(
			'SELECT * FROM '._DB_PREFIX_.'theme_meta WHERE id_theme_meta = '.(int)$id_theme_meta
		);
		$result = false;
		if ($theme_meta)
		{
			$sql = 'UPDATE '._DB_PREFIX_.'theme_meta SET left_column='.(int)!(bool)$theme_meta['left_column'].' WHERE id_theme_meta='.(int)$id_theme_meta;
			$result = Db::getInstance()->execute($sql);
		}
        return $result;
    }
    private function processRightMeta($id_theme_meta)
	{
		$theme_meta = Db::getInstance()->getRow(
			'SELECT * FROM '._DB_PREFIX_.'theme_meta WHERE id_theme_meta = '.(int)$id_theme_meta
		);
		$result = false;
		if ($theme_meta)
		{
			$sql = 'UPDATE '._DB_PREFIX_.'theme_meta SET right_column='.(int)!(bool)$theme_meta['right_column'].' WHERE id_theme_meta='.(int)$id_theme_meta;
			$result = Db::getInstance()->execute($sql);
		}
        return $result;
    }
    /**
	 * Process posting data
	 */
	public function postProcess() {
	   //$errors = array();
       $id_shop = (int)$this->context->shop->id;
	   $languages = Language::getLanguages(false);
        if (Tools::isSubmit('submitChangeLayout')){
            //Configuration::set('OVIC_CURRENT_OPTION',(int)Tools::getValue('id_option',Configuration::get('OVIC_CURRENT_OPTION')));
            Configuration::updateValue('OVIC_LAYOUT_COLUMN',(int)Tools::getValue('colsetting',Configuration::get('OVIC_LAYOUT_COLUMN',null,null,$id_shop)),false,null,$id_shop);
            $this->ProcessLayoutColumn();
            parent::postProcess();
            Tools::redirectAdmin(self::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminLayoutSetting'));
        }elseif (Tools::isSubmit('submitSelectOption')){
            $id_option = (int)Tools::getValue('id_option');
            Configuration::updateValue('OVIC_CURRENT_OPTION',$id_option,false,null,$id_shop);
            $optionObject = new Options($id_option);
            Configuration::updateValue('OVIC_CURRENT_DIR',str_replace(' ','_',$optionObject->alias),false,null,$id_shop);
            if (strlen($optionObject->column)>0)
                Configuration::updateValue('OVIC_LAYOUT_COLUMN',(int)substr($optionObject->column,0,1),false,null,$id_shop);
            $this->ProcessLayoutColumn();
            parent::postProcess();
            //$this->importDatas();
            Tools::redirectAdmin(self::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminLayoutSetting'));
        }elseif (Tools::isSubmit('changeleftactive')){
            $pagemeta = Tools::getValue('pagemeta');
            $id_theme_meta = $this->getIdThemeMetaByPage($pagemeta);
            $this->processLeftMeta($id_theme_meta);
        }elseif (Tools::isSubmit('changerightactive')){
            $pagemeta = Tools::getValue('pagemeta');
            $id_theme_meta = $this->getIdThemeMetaByPage($pagemeta);
            $this->processRightMeta($id_theme_meta);
        }
        Tools::clearCache();
        parent::postProcess();
	}
    /**
	 * remove a module from a column
	 */    
    public function importDatas(){
        $arrModules = array(
            'bannerslider'=>'BannerSlider',
            'blockhtml'=>'BlockHtml',
            'flexbanner'=>'FlexBanner',
            'flexgroupbanners'=>'FlexGroupBanners',
            'pagelink'=>'PageLink',
            'ovicparallaxblock'=>'OvicParallaxBlock',
            'simplecategory'=>'SimpleCategory',
            'verticalmegamenus'=>'VerticalMegaMenus',
            'advancetopmenu'=>'AdvanceTopMenu',
            'advancefooter'=>'AdvanceFooter',            
            );
        foreach($arrModules as $module=>$moduleClassName){
            if( Module::isInstalled($module) == 1){
                include_once(_PS_MODULE_DIR_.$module.'/'.$module.'.php');
                $moduleClass = new $moduleClassName();
                $moduleClass->importSameData(_PS_MODULE_DIR_.'oviclayoutcontrol/samedatas/');
                if($module == 'bannerslider') $moduleClass->importHomeSliderSameData(_PS_MODULE_DIR_.'oviclayoutcontrol/samedatas/');
            }
        }
        return true;        
    }
	public function ajaxProcessovicExportData(){
		$arrModules = array(
            'bannerslider'=>'BannerSlider',
            'flexbanner'=>'FlexBanner',
            'flexgroupbanners'=>'FlexGroupBanners',            
            'pagelink'=>'PageLink',
            'simplecategory'=>'SimpleCategory',
            'customcontent'=>'CustomContent',
            'customhtml'=>'CustomHtml',
            'customparallax'=>'CustomParallax',
            'megaboxs'=>'MegaBoxs',
            'megamenus'=>'MegaMenus',            
		);
        foreach($arrModules as $module=>$moduleClassName){
            if( Module::isInstalled($module) == 1){
                include_once(_PS_MODULE_DIR_.$module.'/'.$module.'.php');
                $moduleClass = new $moduleClassName();
                $moduleClass->exportSameData(_PS_MODULE_DIR_.'oviclayoutcontrol/samedatas/');
                if($module == 'bannerslider') $moduleClass->exportHomeSliderSameData(_PS_MODULE_DIR_.'oviclayoutcontrol/samedatas/');
            }
        }
        die(Tools::jsonEncode($this->l('Export data successful!')));
	}
	public function ajaxProcessovicImportData(){
		$arrModules = array(
            'bannerslider'=>'BannerSlider',
            'flexbanner'=>'FlexBanner',
            'flexgroupbanners'=>'FlexGroupBanners',            
            'pagelink'=>'PageLink',
            'simplecategory'=>'SimpleCategory',
            'customcontent'=>'CustomContent',
            'customhtml'=>'CustomHtml',
            'customparallax'=>'CustomParallax',
            'megaboxs'=>'MegaBoxs',
            'megamenus'=>'MegaMenus',          
		);
        foreach($arrModules as $module=>$moduleClassName){
            if( Module::isInstalled($module) == 1){
                include_once(_PS_MODULE_DIR_.$module.'/'.$module.'.php');
                $moduleClass = new $moduleClassName();
                $moduleClass->importSameData(_PS_MODULE_DIR_.'oviclayoutcontrol/samedatas/');
                if($module == 'bannerslider') $moduleClass->importHomeSliderSameData(_PS_MODULE_DIR_.'oviclayoutcontrol/samedatas/');
            }
        }
        die(Tools::jsonEncode($this->l('Import data successful!')));
	}
    public function ajaxProcessremoveSideBarModule(){
        $result = array();
        $pagemeta = Tools::getValue('pagemeta');
        $hookname = Tools::getValue('hookname');
        $hookexec_name = Tools::getValue('hookexec_name');
        $module_name = Tools::getValue('module_name');
        if ($module_name && Validate::isModuleName($module_name) && $hookexec_name && Validate::isHookName($hookexec_name)){
            $HookedModulesArr = OvicLayoutControl::getSideBarModulesByPage($pagemeta, $hookname, false);
            $moduleHook = array();
            $moduleHook[] = $module_name;
            $moduleHook[] = $hookexec_name;
            if ($HookedModulesArr && is_array($HookedModulesArr) && sizeof($HookedModulesArr)){
                $key = array_search($moduleHook,$HookedModulesArr);
                unset($HookedModulesArr[$key]);
            }
            $HookedModulesArr = array_values($HookedModulesArr);
            $result['status'] = OvicLayoutControl::registerSidebarModule($pagemeta, $hookname, Tools::jsonEncode($HookedModulesArr),$this->context->shop->id);
            $result['msg'] = $this->l('Successful deletion');
        }
        Tools::clearCache();
        die(Tools::jsonEncode($result));
    }
    /**
	 * Display add new module form
	 */
    public function ajaxProcessdisplayModulesHook(){
        $result = "";
        $hookColumn = Tools::getValue('hookname');
        $hookName = 'display'.ucfirst(trim($hookColumn)).'Column';
        $id_hook = Hook::getIdByName($hookName);
        $pagemeta = Tools::getValue('pagemeta');
        $optionModulesHook = OvicLayoutControl::getModuleExecList(array('displayLeftColumn','displayRightColumn', 'leftColumn', 'displaySmartBlogLeft', 'displaySmartBlogRight'));
        $moduleOption = '';
        $HookedModulesArr = OvicLayoutControl::getSideBarModulesByPage($pagemeta, $hookColumn,false);
        $HookedModules = array();
        $Hookedexecute = array();
        if ($HookedModulesArr && is_array($HookedModulesArr) && sizeof($HookedModulesArr))
            foreach ($HookedModulesArr as $key => $HookedModule){
                $HookedModules[] = (int)$HookedModule[0];
                $Hookedexecute[] = (int)$HookedModule[1];
            }
        $allmoduleDisable = true;
            $moduleArr = array();
        if ($optionModulesHook && count($optionModulesHook)>0){
            foreach ($optionModulesHook as $module){
                $disableModule = false;
                $moduleObject = Module::getInstanceById($module['id_module']);
                if (in_array($module['id_module'],$HookedModules)){
                    $moduleHookCallable = OvicLayoutControl::getHooksByModule($moduleObject);
                    if (count($moduleHookCallable)>1){
                        $disableModule = true;
                        foreach ($moduleHookCallable as $h)
                            if (!in_array($h['id_hook'],$Hookedexecute)){
                                $disableModule = false;
                                break;
                            }
                    }else
                        $disableModule = true;
                }
                if ($moduleObject->tab != 'analytics_stats'){
                    $moduleArr[$moduleObject->displayName]['id_module'] = $module['id_module'];
                    $moduleArr[$moduleObject->displayName]['disabled'] = $disableModule;
                //$moduleOption .='<option '.($disableModule? 'disabled':'').' value='.$module['id_module'].'>'.$moduleObject->displayName.'</option>';
                }
                if (!$disableModule)
                    $allmoduleDisable = false;
            }
            ksort($moduleArr);
            foreach ($moduleArr as $name => $moduleObj)
                $moduleOption .='<option '.($moduleObj['disabled']? 'disabled':'').' value='.$moduleObj['id_module'].'>'.$name.'</option>';
        }
        $tpl = $this->createTemplate('new_popup.tpl');
        $tpl->assign( array(
            'postUrl' => self::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminLayoutSetting'),
            'id_hook' => $id_hook,
            'hookname' => $hookName,
            'hookcolumn' => $hookColumn,
            'pagemeta' => $pagemeta,
            'moduleOption' => $moduleOption,
        ));
        $result .= $tpl->fetch();
        die(Tools::jsonEncode($result));
    }
    /**
	 * get all hook off module, return list option hook
	 */
    public function ajaxProcessgetModuleHookOption(){
        $html = '';
        $id_module = (int)Tools::getValue('id_module');
        $hookColumn = Tools::getValue('hookcolumn');
        $hookName = 'display'.ucfirst(trim($hookColumn)).'Column';
        $pagemeta = Tools::getValue('pagemeta');
        if ($id_module && Validate::isUnsignedId($id_module) && Validate::isHookName($hookName)){
            $moduleObject = Module::getInstanceById($id_module);
            $HookedModulesArr = OvicLayoutControl::getSideBarModulesByPage($pagemeta, $hookColumn,false);
            $html = OvicLayoutControl::getHookOptionByModule($HookedModulesArr, $hookName,$moduleObject,null,true);
        }
        echo $html;
    }
    /**
	 * insert new module to a hook
	 */
    public function ajaxProcessaddModuleHook(){
        $result = array();
        //$id_hook = (int)Tools::getValue('id_hook');
        //$id_option = (int)Tools::getValue('id_option');
        $context =  Context::getContext();
        $id_shop = $context->shop->id;
        $pagemeta = Tools::getValue('pagemeta');
        $hookcolumn = Tools::getValue('hookcolumn');
        $id_hookexec = (int)Tools::getValue('id_hookexec');
        $hookexec_name = Hook::getNameById($id_hookexec);
        $id_module = (int)Tools::getValue('id_module');
        if ($id_module && Validate::isUnsignedId($id_module) && $hookexec_name && Validate::isHookName($hookexec_name)){
            $moduleObject = Module::getInstanceById($id_module);
            $HookedModulesArr = OvicLayoutControl::getSideBarModulesByPage($pagemeta, $hookcolumn,false);
            if (!is_array($HookedModulesArr))
                $HookedModulesArr = array();
            $moduleHook = array();
            $moduleHook[] = $moduleObject->name;
            $moduleHook[] = $hookexec_name;
            $HookedModulesArr[] = $moduleHook;
            $result['status'] = OvicLayoutControl::registerSidebarModule($pagemeta,$hookcolumn,Tools::jsonEncode($HookedModulesArr),$id_shop); //registerHookModule($id_option, $id_hook, Tools::jsonEncode($HookedModulesArr),$this->context->shop->id);
            $result['msg'] = $this->l('Successful creation');
            $tpl = $this->createTemplate('module.tpl');
            $tpl->assign( array(
                'id_hookexec' => $id_hookexec,
                'hookexec_name' => $hookexec_name,
                'modulePosition' => count((array)$HookedModulesArr),
                'moduleDir' => _MODULE_DIR_,
                'moduleObject' => $moduleObject,
                'id_hook' => $id_hook,
                'hookcolumn' => $hookcolumn,
                'id_option' => $id_option,
                'pagemeta' => $pagemeta,
                'postUrl' => self::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminLayoutSetting'),
            ));
            $result['html'] = $tpl->fetch();
        }
        die(Tools::jsonEncode($result));
    }
    /**
	 * overide hook process
	 */
    public function ajaxProcessdisplayChangeHook(){
        $result = "";
        $pagemeta = Tools::getValue('pagemeta');
        $hookcolumn = Tools::getValue('hookcolumn');
        $hookName = 'display'.ucfirst(trim($hookColumn)).'Column';
        if (Validate::isHookName($hookName)){
            $id_module = (int)Tools::getValue('id_module');
            $id_hookexec = (int)Tools::getValue('id_hookexec');
            if ($id_module && Validate::isUnsignedId($id_module) && $id_hookexec && Validate::isUnsignedId($id_hookexec)){
                $moduleObject = Module::getInstanceById($id_module);
                $optionModules = OvicLayoutControl::getSideBarModulesByPage($pagemeta, $hookcolumn, false);
                //$this->echoArr($optionModules);
                $hookOptions =  OvicLayoutControl::getHookOptionByModule($optionModules, $hookName ,$moduleObject, $id_hookexec,true);
            }
            $tpl = $this->createTemplate('changehook.tpl');
            $tpl->assign( array(
                'postUrl' => self::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminLayoutSetting'),
                'hookcolumn' => $hookcolumn,
                'pagemeta' => $pagemeta,
                'old_hook' => $id_hookexec,
                'id_module' => $id_module,
                'hookOptions' => $hookOptions,
            ));
            $result .= $tpl->fetch();
        }
        die(Tools::jsonEncode($result));
    }
    /**
	 * Change hook execute off module
	 */
    public function ajaxProcessChangeModuleHook(){
        $result = array();
        $pagemeta = Tools::getValue('pagemeta');
        $hookcolumn = Tools::getValue('hookcolumn');
        $id_hookexec = (int)Tools::getValue('id_hookexec');
        $hookexec_name = Hook::getNameById($id_hookexec);
        $old_hook = (int)Tools::getValue('old_hook');
        $id_module = (int)Tools::getValue('id_module');
        if ($id_module && Validate::isUnsignedId($id_module) && $hookexec_name && Validate::isHookName($hookexec_name)){
            $result['status'] = true;
            $moduleObject = Module::getInstanceById($id_module);
            $HookedModulesArr = OvicLayoutControl::getSideBarModulesByPage($pagemeta, $hookcolumn,false);
            if (!is_array($HookedModulesArr))
                $result['status'] = false;
            if ($result['status']){
                $moduleHook = array();
                $moduleHook[] = $moduleObject->name;
                $moduleHook[] = Hook::getNameById($old_hook);
                $key = array_search($moduleHook,$HookedModulesArr);
                if (array_key_exists($key,$HookedModulesArr)){
                    $moduleHook[1] = $hookexec_name;
                    $HookedModulesArr[$key] = $moduleHook;
                    $result['status'] = OvicLayoutControl::registerSidebarModule($pagemeta, $hookcolumn, Tools::jsonEncode($HookedModulesArr),$this->context->shop->id);
                    $result['moduleinfo'] = $moduleObject->name.'-'.$hookexec_name;
                }
            }
        }
        Tools::clearCache();
        die(Tools::jsonEncode($result));
    }
    /**
	 * process update hook, sortable
	 */
    public function ajaxProcessupdateHook(){
        $result = array();
        $pagemeta = Tools::getValue('pagemeta');
        $datahooks = Tools::getValue('datahook');
        $datahooks = Tools::jsonDecode($datahooks,true);
        if ($datahooks && is_array($datahooks) && sizeof($datahooks)>0)
            foreach ($datahooks as $hookmodules){
                $res = array();
                $hookColumn = key($hookmodules);
                $hookName = 'display'.ucfirst(trim($hookColumn)).'Column';
                $res['status'] = OvicLayoutControl::registerSidebarModule($pagemeta, $hookColumn, Tools::jsonEncode($hookmodules[$hookColumn]),$this->context->shop->id);
                $res['hookname'] = $hookName;
                $result[] = $res;
            }
        Tools::clearCache();
        die(Tools::jsonEncode($result));
    }
}