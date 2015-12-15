<?php if (!defined('_PS_VERSION_')) exit;
include_once (dirname(__file__) . '/class/Options.php');
include_once (dirname(__file__) . '/class/Hookmanager.php');
class OvicLayoutControl extends Module{
	const INSTALL_SQL_FILE = 'install.sql';
    public static $OptionHookAssign = array('displayNav','displayBeforeLogo','displayTop','displayTopColumn','displayHomeTopColumn','displayLeftColumn','displayRightColumn','displayHomeTopContent','displayHome','displayHomeTab','displayHomeTabContent','displayHomeBottomContent','displayHomeBottomColumn','displayBottomColumn','displayFooter');
    public static $OptionColors = array('main','button','button_text','button_hover','button_text_hover','second_button','second_button_text','second_button_hover','second_button_text_hover','text','text_hover');
    public static $OptionFonts = array('font1');
	public $arrVersions=array('1.4.3', '1.4.3');
    public function __construct()
    {
        $this->name = 'oviclayoutcontrol';
        $this->tab = 'administration';
        $this->version = '1.4.3';
        $this->author = 'OVIC-SOFT';
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l('Ovic - Layout control');
        $this->description = $this->l('select layout option.');
        $this->secure_key = Tools::encrypt($this->name);
		
    }
	public function updateVersions(){
		$module = Module::getInstanceByName($this->name);
		print_r($this->arrVersions);
		die;
	}
    public function install(){
        if (!parent::install() || !$this->installDB())
            return false;
        if (!$this->registerHook('displayHeader') || !$this->registerHook('displayBackOfficeHeader') || !$this->registerHook('displayProductListReviews'))
            return false;
        if (!$this->backupAllModulesHook('hook_module','ovic_backup_hook_module'))
            return false;
        $result =true;
        foreach (self::$OptionHookAssign as $hookname)
            if (!$this->registerHook($hookname)){
                $result &= false;
                break;
            }
        if (!$result || !$this->registerHook('actionModuleRegisterHookAfter'))
            return false;
        if (!$this->installSampleData())
            return false;
        $langs = Language::getLanguages();
        $tab = new Tab();
        $tab->class_name = "AdminThemeConfig";
        foreach ($langs as $l) 
            $tab->name[$l['id_lang']] = $this->l('Ovic Theme config');
        $tab->module = '';
        $tab->id_parent = 0;  //Root tab
        $tab->save();
        $tab_id = $tab->id;
        $newtab = new Tab();
        $newtab->class_name = "AdminLayoutSetting";
        foreach ($langs as $l) 
            $newtab->name[$l['id_lang']] = $this->l('Layout Control');
        $newtab->module = $this->name;
        $newtab->id_parent = $tab_id;
        $newtab->add();
        $newtab = new Tab();
        $newtab->class_name = "AdminLayoutBuilder";
        foreach ($langs as $l) 
            $newtab->name[$l['id_lang']] = $this->l('Layout Builder');
        $newtab->module = $this->name;
        $newtab->id_parent = $tab_id;
        $newtab->add();
        //Theme::getThemeInfo($this->context->shop->id_theme)
        return true;
    }
    private function installDB()
    {
		if (!file_exists(dirname(__FILE__).'/'.self::INSTALL_SQL_FILE))
				return false;
			else if (!$sql = file_get_contents(dirname(__FILE__).'/'.self::INSTALL_SQL_FILE))
				return false;
			$sql = str_replace(array('PREFIX_', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $sql);
			$sql = preg_split("/;\s*[\r\n]+/", trim($sql));
			foreach ($sql as $query)
				if (!Db::getInstance()->execute(trim($query))) return false;
		return true;
		
        $results = Db::getInstance()->execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ovic_backup_hook_module`(
            `id_module` int(10) unsigned NOT NULL,
            `id_shop` int(11) unsigned NOT NULL DEFAULT 1,
            `id_hook` int(10) unsigned NOT NULL,
            `position` tinyint(2) unsigned NOT NULL,
            PRIMARY KEY (`id_module`,`id_hook`,`id_shop`),
            KEY `id_hook` (`id_hook`),
            KEY `id_module` (`id_module`),
            KEY `position` (`id_shop`,`position`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8');
        $results &= Db::getInstance()->execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ovic_options` (
            `id_option` int(6) NOT NULL AUTO_INCREMENT,
            `image` varchar(254),
            `name` varchar(255) ,
            `theme` varchar(50) NOT NULL,
            `alias` varchar(50) NOT NULL,
            `column` varchar(10) NOT NULL,
            `active` TINYINT(1) unsigned DEFAULT 1,
            PRIMARY KEY(`id_option`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' default CHARSET=utf8');
        $results &= Db::getInstance()->execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ovic_options_hook_module` (
            `theme` varchar(50) NOT NULL,
            `alias` varchar(50) NOT NULL,
            `hookname` varchar(64) NOT NULL,
            `modules` text NOT NULL,
            PRIMARY KEY(`theme`,`alias`,`hookname`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;');
        $results &= Db::getInstance()->execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ovic_options_sidebar` (
            `theme` varchar(50) NOT NULL,
            `page` varchar(50) NOT NULL,
            `left` TEXT,
            `right` TEXT,
            `id_shop` int(6) NOT NULL,
            PRIMARY KEY(`theme`,`page`,`id_shop`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8');        
        $results &= Db::getInstance()->execute('
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ovic_options_style` (
            `theme` varchar(50) NOT NULL,
            `alias` varchar(50) NOT NULL,
            `font` TEXT,
            `color` TEXT,
            PRIMARY KEY(`theme`,`alias`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8');        
        return $results;
    }
    private function installSampleData(){
        return true;
        /*
        $sql = "INSERT INTO `" . _DB_PREFIX_ .
            "ovic_options` (`image`, `name`, `theme`, `alias`, `column`, `active`) VALUES
                ('1426213629preview.jpg',	'BankTheme', 'BlankTheme v1.4',	'blanktheme1',	'3',	1);";
        $result = Db::getInstance()->execute($sql);
        $sql = "INSERT INTO `" . _DB_PREFIX_ .
            "ovic_options_hook_module` (`theme`, `alias`, `hookname`, `modules`) VALUES
                ('Milano', 'option1', 'displayNav', '[[\"blockcurrencies\",\"displayNav\"],[\"blocklanguages\",\"displayNav\"],[\"blockcontact\",\"displayNav\"],[\"flexsimplemenus\",\"displayNav\"]]'),
        		('Milano', 'option1', 'displayTop', '[[\"advancetopmenu\",\"displayTop\"],[\"blockcart\",\"displayTop\"],[\"imagesearchblock\",\"displayTop\"],[\"blockwishlist\",\"displayTop\"],[\"pagesnotfound\",\"displayTop\"],[\"sekeywords\",\"displayTop\"]]'),
        		('Milano', 'option1', 'displayTopColumn', '[[\"homeslider\",\"displayTopColumn\"]]'),
        		('Milano', 'option1', 'displayHome', '[[\"flexbanner\",\"displayHome\"],[\"flexsinglecategory\",\"displayHomeTopColumn\"],[\"smartbloghomelatestnews\",\"displayHome\"],[\"flexgroupmenus\",\"displayHome\"],[\"blockhtml\",\"displayHome\"]]'),
        		('Milano', 'option1', 'displayHomeTab', '[]'),
        		('Milano', 'option1', 'displayHomeTabContent', '[]'),
        		('Milano', 'option1', 'displayFooter', '[[\"statsdata\",\"displayFooter\"],[\"advancefooter\",\"displayFooter\"]]'),
        		('Milano', 'option1', 'displayHomeBottomColumn', '[]'),
        		('Milano', 'option1', 'displayHomeTopColumn', '[[\"flexgroupbanners\",\"displayHomeTopColumn\"],[\"flexsimplegroup\",\"displayHomeTopColumn\"],[\"flexsinglecategory\",\"displayHome\"]]');";        
        		$result &= Db::getInstance()->execute($sql);
        $sql = "INSERT INTO `" . _DB_PREFIX_ .
            "ovic_options_sidebar` (`theme`, `page`, `left`, `right`, `id_shop`) VALUES 
                ('Milano', 'best-sales', '[[\"blocklayered\",\"displayLeftColumn\"],[\"flexbanner\",\"displayLeftColumn\"]]', NULL, 1),
                ('Milano', 'category', '[[\"blocklayered\",\"displayLeftColumn\"],[\"flexbanner\",\"displayLeftColumn\"]]', NULL, 1),
                ('Milano', 'discount', '[[\"blocklayered\",\"displayLeftColumn\"],[\"flexbanner\",\"displayLeftColumn\"]]', NULL, 1),
                ('Milano', 'manufacturer', '[[\"blocklayered\",\"displayLeftColumn\"],[\"flexbanner\",\"displayLeftColumn\"]]', NULL, 1),
                ('Milano', 'new-products','[[\"blocklayered\",\"displayLeftColumn\"],[\"flexbanner\",\"displayLeftColumn\"]]', NULL, 1),
                ('Milano', 'prices-drop', '[[\"blocklayered\",\"displayLeftColumn\"],[\"flexbanner\",\"displayLeftColumn\"]]', NULL, 1),
                ('Milano', 'product', NULL, NULL, 1),
                ('Milano', 'search', '[[\"blocklayered\",\"displayLeftColumn\"],[\"flexbanner\",\"displayLeftColumn\"]]', NULL, 1),
                ('Milano', 'supplier', '[[\"flexbanner\",\"displayLeftColumn\"]]', NULL, 1);";
        $result &= Db::getInstance()->execute($sql);
        */
        //return $result;
    }
    public function uninstall(){
        if (!$this->backupAllModulesHook('ovic_backup_hook_module','hook_module'))
            return false;
        if (!parent::uninstall() || !$this->uninstallDB())
            return false;
        $classNames = array('AdminThemeConfig','AdminLayoutSetting');
        foreach ($classNames as $className){
            $idTab = Tab::getIdFromClassName($className);
            if ($idTab != 0){
                $tab = new Tab($idTab);
                $tab->delete();
            }
        }
        return true;
    }
    private function uninstallDB(){
        $results = Db::getInstance()->execute('DROP TABLE `' . _DB_PREFIX_ . 'ovic_backup_hook_module`');
        $results = Db::getInstance()->execute('DROP TABLE `' . _DB_PREFIX_ . 'ovic_options`');        
        $results = Db::getInstance()->execute('DROP TABLE `' . _DB_PREFIX_ . 'ovic_options_hook_module`');
        $results = Db::getInstance()->execute('DROP TABLE `' . _DB_PREFIX_ . 'ovic_options_sidebar`');
        return $results;
    }
    public function getContent(){ 
        $output ='';
        $errors = array();
        if (Tools::isSubmit('submitImportData')){
            $type = strtolower(substr(strrchr($_FILES['sqldata']['name'], '.'), 1));
            if (isset($_FILES['sqldata']) && $type =='sql'){ 
                $sql = file_get_contents($_FILES["sqldata"]["tmp_name"]); 
                $sql = str_replace(array('PREFIX_', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $sql);
    			$sql = preg_split("/;\s*[\r\n]+/", trim($sql));
    			foreach ($sql as $query)
    			     if (strpos(strtoupper($query),'INSERT INTO') !== false)
    			         if (!Db::getInstance()->execute(trim($query)))
                            $errors[] = Tools::displayError('Error while insert data.');            
            }
            if (count($errors) > 0){
                if (isset($errors) && count($errors)) $output .= $this->displayError(implode('<br />', $errors));
            }
            else
                $output .= $this->displayConfirmation($this->l('Import sucsess'));
        }elseif (Tools::isSubmit('processRefresh')){
            $shop_list = Shop::getShops();
            foreach ($shop_list as $id_shop => $shop_info){
                $shop_theme = Theme::getThemeInfo($shop_info['id_theme']);
                if ($this->IsOvicThemes($shop_theme['theme_name'])){
                    //echo $shop_theme['theme_name'].' is in ovic theme';
                    if (!$this->backupAllModulesHook('hook_module','ovic_backup_hook_module',$id_shop))
                        $errors[] = Tools::displayError('Error while refresh data.');
                }else
                    if (!$this->HookedModuleByThemeXml($shop_theme['theme_name'],$id_shop))
                        $errors[] = Tools::displayError('Error while refresh data from xml.');
                    //echo $shop_theme['theme_name'].' isn\'t in ovic theme';
            }
            if (count($errors) > 0){
                if (isset($errors) && count($errors)) $output .= $this->displayError(implode('<br />', $errors));
            }else
                $output .= $this->displayConfirmation($this->l('Refresh sucsess'));
        }elseif(Tools::getValue('data-export')){
            $this->exportSameDatas();
			echo $this->l('Export data success!');
			die;
        }elseif(Tools::getValue('data-import')){
            $this->importSameDatas();
			echo $this->l('Import data success!');
			die;
        }
        if (Tools::isSubmit('displayImport'))
            $output .= $this->displayForm();
        else{
            $output .='<p><a href="'.$this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&token=' . Tools::getAdminTokenLite('AdminModules').'&displayImport" class="btn btn-default btn-lg">'.$this->l('Import option data').'</a></p>';
            $output .='<p><a href="'.$this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&token=' . Tools::getAdminTokenLite('AdminModules').'&processRefresh" class="btn btn-default btn-lg">'.$this->l('Refresh hooked module').'</a></p>';
        }
        return $output;
    }
    public function exportSameDatas(){
        $arrModules = array(
            'bannerslider'=>'BannerSlider',
            'blockhtml'=>'BlockHtml',
            'flexbanner'=>'FlexBanner',
            'flexgroupbanners'=>'FlexGroupBanners',
            'flexsimplemenus'=>'FlexSimpleMenus',
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
                $moduleClass->exportSameData(_PS_MODULE_DIR_.'oviclayoutcontrol/samedatas/');
                if($module == 'bannerslider') $moduleClass->exportHomeSliderSameData(_PS_MODULE_DIR_.'oviclayoutcontrol/samedatas/');
            }
        }
        return true;
    }
    public function importSameDatas(){
        $arrModules = array(
            'bannerslider'=>'BannerSlider',
            'blockhtml'=>'BlockHtml',
            'flexbanner'=>'FlexBanner',
            'flexgroupbanners'=>'FlexGroupBanners',
            'flexsimplemenus'=>'FlexSimpleMenus',
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
        /*
        // import data bannerslider 
        if( Module::isInstalled('bannerslider') == 1){
            include_once(_PS_MODULE_DIR_.'bannerslider/bannerslider.php');
            $bannerslider = new BannerSlider();
            $bannerslider->importSameData();
            $bannerslider->importHomeSliderSameData();
        }
        
        // import data blockhtml 
        if( Module::isInstalled('blockhtml') == 1){
            include_once(_PS_MODULE_DIR_.'blockhtml/blockhtml.php');
            $blockhtml = new BlockHtml();
            $blockhtml->importSameData();
        }
        
        // import data flexbanner 
        if( Module::isInstalled('flexbanner') == 1){
            include_once(_PS_MODULE_DIR_.'flexbanner/flexbanner.php');
            $flexbanner = new FlexBanner();
            $flexbanner->importSameData();
        }
        
        // import data flexgroupbanners 
        if( Module::isInstalled('flexgroupbanners') == 1){
            include_once(_PS_MODULE_DIR_.'flexgroupbanners/flexgroupbanners.php');
            $flexgroupbanners = new FlexGroupBanners();
            $flexgroupbanners->importSameData();
        }
        
        // import data flexsimplemenus 
        if( Module::isInstalled('flexsimplemenus') == 1){
            include_once(_PS_MODULE_DIR_.'flexsimplemenus/flexsimplemenus.php');
            $flexsimplemenus = new FlexSimpleMenus();
            $flexsimplemenus->importSameData();
        }
        
        // import data pagelink 
        if( Module::isInstalled('pagelink') == 1){
            include_once(_PS_MODULE_DIR_.'pagelink/pagelink.php');
            $pagelink = new PageLink();
            $pagelink->importSameData();
        }
        
        // import data ovicparallaxblock 
        if( Module::isInstalled('ovicparallaxblock') == 1){
            include_once(_PS_MODULE_DIR_.'ovicparallaxblock/ovicparallaxblock.php');
            $ovicparallaxblock = new OvicParallaxBlock();
            $ovicparallaxblock->importSameData();
        }
        
        // import data simplecategory 
        if( Module::isInstalled('simplecategory') == 1){
            include_once(_PS_MODULE_DIR_.'simplecategory/simplecategory.php');
            $simplecategory = new SimpleCategory();
            $simplecategory->importSameData();
        }
        
        // import data verticalmegamenus 
        if( Module::isInstalled('verticalmegamenus') == 1){
            include_once(_PS_MODULE_DIR_.'verticalmegamenus/verticalmegamenus.php');
            $verticalmegamenus = new VerticalMegaMenus();
            $verticalmegamenus->importSameData();
        }
        
        // import data advancetopmenu 
        if( Module::isInstalled('advancetopmenu') == 1){
            include_once(_PS_MODULE_DIR_.'advancetopmenu/advancetopmenu.php');
            $advancetopmenu = new AdvanceTopMenu();
            $advancetopmenu->importSameData();
        }
        
        // import data advancefooter 
        if( Module::isInstalled('advancefooter') == 1){
            include_once(_PS_MODULE_DIR_.'advancefooter/advancefooter.php');
            $advancefooter = new AdvanceFooter();
            $advancefooter->importSameData();
        }
        */
    }
    private function IsOvicThemes($theme_name){
        $sql = "SELECT DISTINCT `theme` FROM `" . _DB_PREFIX_ . "ovic_options`";
        $results = Db::getInstance()->executeS($sql);
        $check = false;
        if ($results && is_array($results) && sizeof($results)>0){
            $ovic_theme = array(); 
            foreach ($results as $row){
                if (strtolower($row['theme']) == strtolower($theme_name)){
                     $check = true;
                     break;
                }            
            }
        }
        return $check;
    }
    private function HookedModuleByThemeXml($theme,$id_shop = null){
        //$theme['theme_directory']
        if (is_null($id_shop))
            $id_shop = $this->context->shop->id;
        $xml = false;
		if (file_exists(_PS_ROOT_DIR_.'/config/xml/themes/'.$theme['theme_directory'].'.xml'))
			$xml = simplexml_load_file(_PS_ROOT_DIR_.'/config/xml/themes/'.$theme['theme_directory'].'.xml');
		elseif (file_exists(_PS_ROOT_DIR_.'/config/xml/themes/default.xml'))
			$xml = simplexml_load_file(_PS_ROOT_DIR_.'/config/xml/themes/default.xml');
        echo  $id_shop."<br/>";
        if ($xml)
		{
            $module_hook = array();
            $return = true;
			foreach ($xml->modules->hooks->hook as $row)
			{ 
				$name = strval($row['module']);
				$exceptions = (isset($row['exceptions']) ? explode(',', strval($row['exceptions'])) : array());
					$module_hook[$name]['hook'][] = array(
						'hook' => strval($row['hook']),
						'position' => strval($row['position']),
						'exceptions' => $exceptions
					);
			}
            foreach ($module_hook as $module_name => $hookarr){
                $moduleObj = Module::getInstanceByName($module_name);
                $return &= $this->hookModule($moduleObj->id,$hookarr,$id_shop);
            }
        }else
            $return = false;
        return $return;
    }
    private function hookModule($id_module, $module_hooks, $shop)
	{
		Db::getInstance()->execute('INSERT IGNORE INTO '._DB_PREFIX_.'module_shop (id_module, id_shop) VALUES('.(int)$id_module.', '.(int)$shop.')');
		Db::getInstance()->execute($sql = 'DELETE FROM `'._DB_PREFIX_.'hook_module` WHERE `id_module` = '.(int)$id_module.' AND id_shop = '.(int)$shop);
        $return = true;
		foreach ($module_hooks as $hooks)
			foreach ($hooks as $hook)
			{
				$sql_hook_module = 'INSERT INTO `'._DB_PREFIX_.'hook_module` (`id_module`, `id_shop`, `id_hook`, `position`)
									VALUES ('.(int)$id_module.', '.(int)$shop.', '.(int)Hook::getIdByName($hook['hook']).', '.(int)$hook['position'].')';
				if (count($hook['exceptions']) > 0)
					foreach ($hook['exceptions'] as $exception){
						$sql_hook_module_except = 'INSERT INTO `'._DB_PREFIX_.'hook_module_exceptions` (`id_module`, `id_hook`, `file_name`) VALUES ('.(int)$id_module.', '.(int)Hook::getIdByName($hook['hook']).', "'.pSQL($exception).'")';
						Db::getInstance()->execute($sql_hook_module_except);
					}
				$return &= Db::getInstance()->execute($sql_hook_module);
			}
        return $return;
	}
    public function displayForm(){
        $fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Settings'),
					'icon' => 'icon-cogs'
				),
				'description' => $this->l('To import option data.'),
				'input' => array(
					array(
						'type' => 'file',
						'label' => $this->l('Options Data file'),
						'name' => 'sqldata',
						'class' => 'fixed-width-xs',
						'desc' => $this->l('(.sql extension only)'),
					),
				),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),
		);
		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->id = (int)Tools::getValue('id_carrier');
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitImportData';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => array(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);
		return $helper->generateForm(array($fields_form));
	}
    /**
     * get all hookexecute from tbl hook
     * */
    public static function getHookexecuteList(){
        $sql='SELECT name FROM `' . _DB_PREFIX_ . 'hook` WHERE LOWER(name) NOT LIKE \'action%\' AND LOWER(name) NOT LIKE \'dashboard%\'
                AND LOWER(name) NOT LIKE \'displayadmin%\' AND LOWER(name) NOT LIKE \'displayattribute%\' AND LOWER(name) NOT LIKE \'displaybackoffice%\'
                AND LOWER(name) NOT LIKE \'displaybefore%\' AND LOWER(name) NOT LIKE \'displaycarrier%\' AND LOWER(name) NOT LIKE \'displaycompare%\'
                AND LOWER(name) NOT LIKE \'displaycustomer%\' AND LOWER(name) NOT LIKE \'displayfeature%\' AND LOWER(name) NOT LIKE \'display%product\'
                AND LOWER(name) NOT LIKE \'displayheader%\' AND LOWER(name) NOT LIKE \'header%\' AND LOWER(name) NOT LIKE \'displayInvoice%\' 
                AND LOWER(name) NOT LIKE \'displaymaintenance%\' AND LOWER(name) NOT LIKE \'displaymobile%\' AND LOWER(name) NOT LIKE \'displaymyaccount%\' 
                AND LOWER(name) NOT LIKE \'displayorder%\' AND LOWER(name) NOT LIKE \'displayoverride%\' AND LOWER(name) NOT LIKE \'displaypayment%\' 
                AND LOWER(name) NOT LIKE \'displaypdf%\' AND LOWER(name) NOT LIKE \'displayproduct%\' AND LOWER(name) NOT LIKE \'displayshopping%\'';
        $results = Db::getInstance()->executeS($sql);
        $hooklist = array();
        if ($results && is_array($results) && sizeof($results))
            foreach ($results as $result)
                $hooklist[] = $result['name'];
        return array_values($hooklist);
    }
    public static function isAvailablebyId($id_option){
        $sql = 'SELECT COUNT(`id_option`) FROM `' . _DB_PREFIX_ . 'ovic_options` WHERE `id_option` = '.(int)$id_option;
        return Db::getInstance()->getValue($sql);
    }
    public static function isAvailablebyAlias($alias){
        $sql = 'SELECT COUNT(`alias`) FROM `' . _DB_PREFIX_ . 'ovic_options` WHERE `alias` = \''.$alias.'\'';
        return Db::getInstance()->getValue($sql);
    }
    /**
	 * Copy hookmodule from source option to destionation option
	 */
    public static function copyHookModule($source_option,$destination_option){
        //$source_option = new Options($source_option);
         if ($source_option && Validate::isLoadedObject($source_option) && $destination_option && Validate::isLoadedObject($destination_option)){
            $return = true;
            $displayLeft = false;
            $displayRight = false;
            if (substr_count($destination_option->column,'1')>0 || substr_count($destination_option->column,'0')>0)
                $displayLeft = true;
            if (substr_count($destination_option->column,'2')>0 || substr_count($destination_option->column,'0')>0)
                $displayRight = true;
            foreach (OvicLayoutControl::$OptionHookAssign as $hookname){
                if ($hookname == 'displayLeftColumn' && !$displayLeft)
                    continue;
                if ($hookname == 'displayRightColumn' && !$displayRight)
                    continue;
                $sourceoptionModules = OvicLayoutControl::getModulesHook($source_option->theme, $source_option->alias, $hookname);
                if ($sourceoptionModules && is_array($sourceoptionModules) && count($sourceoptionModules)>0){
                    $return &= Db::getInstance()->insert('ovic_options_hook_module', array(
                        'theme' => $destination_option->theme,
                        'alias' => $destination_option->alias,
                        'hookname' => $sourceoptionModules['hookname'],
            			'modules' => $sourceoptionModules['modules'],
            		));
                }
            }
         }else
            $return = false;
         return $return;
    }
    public static function copyOptionStyle($source_option,$destination_option){
        if ($source_option && Validate::isLoadedObject($source_option) && $destination_option && Validate::isLoadedObject($destination_option)){
            $result = true;
            if ($source_style = self::getOptionStyle($source_option->theme,$source_option->alias)){
                $where = "`theme` = '".$destination_option->theme. "' AND `alias` = '".$destination_option->alias."'";
                $sql = 'SELECT `alias`
            			FROM `'._DB_PREFIX_.'ovic_options_style` 
            			 WHERE '.$where;
        		if (Db::getInstance()->getRow($sql)){
                    $result = Db::getInstance()->update('ovic_options_style',array(
                        'color' => Tools::jsonEncode($source_style['color']),
                        'font' => Tools::jsonEncode($source_style['font']),
                    ),$where);
        		}else{
                    // Register module in hook
            		$result = Db::getInstance()->insert('ovic_options_style', array(
                        'theme' => $destination_option->theme,
                        'alias' => $destination_option->alias,
                        'color' => Tools::jsonEncode($source_style['color']),
                        'font' => Tools::jsonEncode($source_style['font']),
            		));
        		}
            }
        }else
            $result = false;
        return $result;
    }
    private function backupModuleHook($idHook = 0,$source, $destination, $removeSource = true, $id_shop = null){
        if (!Validate::isUnsignedId($idHook)){
            return false;
        }
        if (is_null($id_shop))
            $id_shop = (int)$this->context->shop->id;
        $modules = Db::getInstance()->ExecuteS('
            SELECT *
            FROM `' . _DB_PREFIX_ . $source.'`
            WHERE `id_hook` = ' . (int)$idHook.' AND `id_shop` = ' .$id_shop);
        $return = true;
        if ($modules && count($modules)>0)
            foreach ($modules as $module){
                $moduleObject = Module::getInstanceById($module['id_module']);
                if ($moduleObject && Validate::isModuleName($moduleObject->name) && $moduleObject->name != $this->name){
                    if ($removeSource == true){
                        // remove from default hook_module table
                        $where ="`id_module` = ".(int)$module['id_module']. " AND `id_hook` = ".(int)$idHook." AND `id_shop` = ".(int)$module['id_shop'];
                        $return &= Db::getInstance()->delete($source,$where);
                    }
                    // Check if already register
    				$sql = 'SELECT bhm.`id_module`
    					FROM `'._DB_PREFIX_.$destination.'` bhm, `'._DB_PREFIX_.'hook` h
    					WHERE bhm.`id_module` = '.(int)($module['id_module']).' AND h.`id_hook` = '.$idHook.'
    					AND h.`id_hook` = bhm.`id_hook` AND `id_shop` = '.(int)$module['id_shop'];
    				if (Db::getInstance()->getRow($sql))
                        continue;
                    // Get module position in hook
    				$sql = 'SELECT MAX(`position`) AS position
    					FROM `'._DB_PREFIX_.$destination.'`
    					WHERE `id_hook` = '.(int)$idHook.' AND `id_shop` = '.(int)$module['id_shop'];
    				if (!$position = Db::getInstance()->getValue($sql))
    					$position = 0;
    				// Register module in hook
    				$return &= Db::getInstance()->insert($destination, array(
    					'id_module' => (int)$module['id_module'],
    					'id_hook' => (int)$idHook,
    					'id_shop' => (int)$module['id_shop'],
    					'position' => (int)($position + 1),
    				));
                }
            }
        return $return;
    }
    public static function getModuleArrFromBackuptbl($id_hook,$getshop = false){
        $modulesArr = array();
        $modules = Db::getInstance()->ExecuteS('
                SELECT *
                FROM `' . _DB_PREFIX_ .'ovic_backup_hook_module`
                WHERE `id_hook` = ' .(int)$id_hook);
        $hookname = Hook::getNameById($id_hook);
         if ($modules && count($modules)>0)
            foreach ($modules as $module)
                {
                    $moduleObject = Module::getInstanceById((int)$module['id_module']);
                    if (!is_object($moduleObject) || !Validate::isModuleName($moduleObject->name))
                        continue;
                    $moduleHook = array();
                    $moduleHook[] = $moduleObject->name;
                    $moduleHook[] = $hookname;
                    if ($getshop)
                        $modulesArr[$module['id_shop']][] = $moduleHook;
                    else
                        $modulesArr[] = $moduleHook;
                }
        return $modulesArr;
    }
    /**
	 * insert all default prestashop hook in to option database
	 */
    public static function registerDefaultHookModule($id_option){
        $option = new Options($id_option);
        if ($option && Validate::isLoadedObject($option)){
            $return = true;
            $displayLeft = false;
            $displayRight = false;
            if (substr_count($option->column,'1')>0 || substr_count($option->column,'0')>0)
                $displayLeft = true;
            if (substr_count($option->column,'2')>0 || substr_count($option->column,'0')>0)
                $displayRight = true;
            foreach (self::$OptionHookAssign as $hookname){
                if ($hookname == 'displayLeftColumn' && !$displayLeft)
                    continue;
                if ($hookname == 'displayRightColumn' && !$displayRight)
                    continue;
                $idHook = (int)Hook::getIdByName($hookname);
                $modulesHook = self::getModuleArrFromBackuptbl($idHook,true);
                if ($modulesHook && count($modulesHook)>0)
                    foreach ($modulesHook as $key => $moduleHook)
                        $return &= OvicLayoutControl::registerHookModule($option,$hookname,Tools::jsonEncode($moduleHook),$key);
            }
        }else
            $return =false;
        return $return;
    }
    public function backupAllModulesHook($source = '', $destination ='',$id_shop = null){
        if (strlen($source) == 0 || strlen($destination) == 0)
            return false;
        $return = true;
        foreach (self::getHookexecuteList() as $hookname){
            $idHook = Hook::getIdByName($hookname);
            if ($hookname && Validate::isHookName($hookname)){
                if (in_array($hookname,self::$OptionHookAssign))
                    $return &= $this->backupModuleHook($idHook,$source,$destination,true,$id_shop);
                else
                    $return &= $this->backupModuleHook($idHook,$source,$destination,false,$id_shop);
            }
        }
        return $return;
    }
    /**
     * get sidebar modules if not isset sidebar
     * */
    public static function getDefaultSidebarModule($column){
        $context = Context::getContext();
        $id_shop = (int)$context->shop->id;
        $curent_id_option = Configuration::get('OVIC_CURRENT_OPTION',null,null,$id_shop);
        $curent_option = new Options($curent_id_option);
        $hookname = 'display'.ucfirst(trim($column)).'Column';
        $idHook = Hook::getIdByName($hookname);
        $sidebarModules = array();
        if ($hookname && Validate::isHookName($hookname)&& $curent_option && Validate::isLoadedObject($curent_option)){
            $sidebarModule = self::getModulesHook($curent_option->theme, $curent_option->alias,$hookname);
            if (!is_null($sidebarModule['modules']))
                $sidebarModules = Tools::jsonDecode($sidebarModule['modules'],true);
            else
                $sidebarModules = self::getModuleArrFromBackuptbl($idHook);
        }
        return $sidebarModules;
    }
    /**
     * get sidebar modules by page
     * */
    public static function getSideBarModulesByPage($pagename, $column, $full = true ){
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $current_theme = Theme::getThemeInfo($context->shop->id_theme);
        $curent_id_option = Configuration::get('OVIC_CURRENT_OPTION',null,null,$id_shop);
        $sql ="SELECT `".$column."` FROM `"._DB_PREFIX_."ovic_options_sidebar` WHERE LCASE(`theme`) = '".strtolower($current_theme['theme_name'])."' AND `page` ='".$pagename."' AND `id_shop`=".(int)$id_shop;
        $sidebarModule = Db::getInstance()->getRow($sql);
        if ($sidebarModule == false || !count($sidebarModule) || empty($sidebarModule) === true){
            $sidebarModules = self::getDefaultSidebarModule($column);
            self::registerSidebarModule($pagename,$column,Tools::jsonEncode($sidebarModules),$id_shop);
        }else
            $sidebarModules = Tools::jsonDecode($sidebarModule[$column],true);
        if ($sidebarModules && is_array($sidebarModules) && sizeof($sidebarModules)>0){
            if (!$full)
                return $sidebarModules;
            $results = array();
            foreach ($sidebarModules as $sidebarModule)
                if ($sidebarModule[1] == 'displayLeftColumn' || $sidebarModule[1] == 'displayRightColumn'){
                    $moduleObject = Module::getInstanceByName($sidebarModule[0]);
                    $id_hookexecute = (int)Hook::getIdByName($sidebarModule[1]);
                    $module = array();
                    $module['id'] = $moduleObject->id;
                    $module['version'] = $moduleObject->version;
                    $module['name'] = $moduleObject->name;
                    $module['displayName'] = $moduleObject->displayName;
                    $module['description'] = $moduleObject->description;
                    $module['id_hookexecute'] = $id_hookexecute;
                    $module['hookexec_name'] = $sidebarModule[1];
                    $module['tab'] = $moduleObject->tab;
                    $module['active'] = $moduleObject->active;
                    $results[] = $module;
                }
            return $results;
        }else
            return false;
    }
    /**
    * insert or update list module of column
    */
    public static function registerSidebarModule($pagename,$column,$moduleHook,$idshop){
        // Check if already register
        //SELECT * FROM `ps_ovic_options_sidebar` WHERE `page` ='' AND `id_shop` =1
        $context = Context::getContext();
        $current_theme = Theme::getThemeInfo($context->shop->id_theme);
        $where = "LCASE(`theme`) = '".strtolower($current_theme['theme_name'])."' AND `page` ='".$pagename."' AND `id_shop` = ".(int)$idshop;
        $sql ="SELECT * FROM `"._DB_PREFIX_."ovic_options_sidebar` WHERE ".$where;
		if (Db::getInstance()->getRow($sql)){
            $setArr[$column] = $moduleHook;
            return Db::getInstance()->update('ovic_options_sidebar',$setArr,$where);
		}else{
            // Register module in hook
            $insertArr['theme'] = strtolower($current_theme['theme_name']);
            $insertArr['page'] = $pagename;
            $insertArr[$column] = $moduleHook;
            $insertArr['id_shop'] = (int)$idshop;
    		return Db::getInstance()->insert('ovic_options_sidebar', $insertArr);
		}
    }
    /**
	 * get all module hooked into hookname
	 */
    public static function getModulesHook($theme, $alias, $hookname){
        if ($hookname && Validate::isHookName($hookname)){
            $context = Context::getContext();
            $idshop = $context->shop->id;
            $sql = 'SELECT *
			         FROM `'._DB_PREFIX_.'ovic_options_hook_module` ohm
                     WHERE ohm.`theme` = \''.$theme.'\' AND ohm.`alias` =\''.$alias.'\' AND ohm.`hookname` = \''.$hookname.'\'';
            $result = Db::getInstance()->getRow($sql);
            if ($result == false || !count($result) || empty($result) === true)
    			return false;
            return $result;
        }else
            return false;
    }
    public function getAliasById($id_option){
        $sql = 'SELECT DISTINCT(`alias`)  FROM `'._DB_PREFIX_.'ovic_options WHERE `id_option` = '.(int)($id_option);
        return Db::getInstance()->getValue($sql);
    }
    /**
	 * get all hook off modules. return hook <option> string
	 */
    public static function getHookOptionByModule($selectedModule, $hookName, $moduleObject,$selected=null, $sideBar = false)
    {
        $html = '';
        $hooks = self::getHooksByModule($moduleObject);
        if (count($hooks) > 0)
            foreach ($hooks as $h){
                $moduleHook = array();
                $moduleHook[] = $moduleObject->name;
                $moduleHook[] = $h['name'];
                $disableOption = false;
                $key = array_search($moduleHook,$selectedModule);
                if ($key && array_key_exists($key,$selectedModule))
                   $disableOption = true;
                if ($hookName == 'displayHomeTab'){
                    if ($h['name'] == $hookName){
                        $html .= '<option '. ($disableOption? 'disabled':''). ($selected == $h['id_hook'] ? 'selected="selected"' : '') . ' value="' . $h['id_hook'] .
                    '">' . $h['name'] . '</option>';
                        break;
                    }
                }elseif ($hookName == 'displayHomeTabContent'){
                    if ($h['name'] == $hookName){
                        $html .= '<option '. ($disableOption? 'disabled':''). ($selected == $h['id_hook'] ? 'selected="selected"' : '') . ' value="' . $h['id_hook'] .
                    '">' . $h['name'] . '</option>';
                        break;
                    }
                }else{
                    if ($sideBar){
                        if ($h['name'] == 'displayLeftColumn' || $h['name'] == 'displayRightColumn' || $h['name'] == 'displaySmartBlogLeft' || $h['name'] == 'displaySmartBlogRight'){
                            $html .= '<option '. ($disableOption? 'disabled':''). ($selected == $h['id_hook'] ? ' selected="selected"' : '') . ' value="' . $h['id_hook'] .
                            '">' . $h['name'] . '</option>';
                        }
                    }else{
                        if ($h['name'] != 'displayHomeTab' && $h['name'] != 'displayHomeTabContent')
                            $html .= '<option '. ($disableOption? 'disabled':''). ($selected == $h['id_hook'] ? ' selected="selected"' : '') . ' value="' . $h['id_hook'] .
                            '">' . $h['name'] . '</option>';
                    }
                }
            }
        return $html;
    }
    public static function getOptionStyle($theme, $alias){
        $sql = 'SELECT os.`color`,os.`font`
    	         FROM `'._DB_PREFIX_.'ovic_options_style` os
                 WHERE os.`theme` = \''.$theme.'\' AND os.`alias` =\''.$alias.'\'';
        $result = Db::getInstance()->getRow($sql);
        if ($result == false || !count($result) || empty($result) === true)
    		return false;
        $results['color'] =  Tools::jsonDecode($result['color'],true);
        $results['font'] =  Tools::jsonDecode($result['font'],true);
        return $results;
    }
    private function echoArr($array,$die = false){
        echo "<pre>";
        print_r($array);
        echo "</pre>";
        if ($die)
            die();
    }
    /************* get modules hooked in all hooks for an option ***************/
    public static function getOptionModulesHook($option){
        if ($option && Validate::isLoadedObject($option)){
             $optionModulesHook = array();
             foreach (self::$OptionHookAssign as $hookname){
                $idHook = (int)Hook::getIdByName($hookname);
                $optionModules = self::getModulesHook($option->theme, $option->alias, $hookname);
                if (!is_null($optionModules['modules']))
                    $optionModules = Tools::jsonDecode($optionModules['modules'],true);
                else
                    $optionModules = array();
                $moduleObjects = array();
                if ($optionModules && is_array($optionModules) && sizeof($optionModules)>0){
                    foreach ($optionModules as $optionModule){
                        $moduleObject = Module::getInstanceByName($optionModule[0]);
                        if ($moduleObject && Validate::isModuleName($moduleObject->name)){
                        $id_hookexecute = (int)Hook::getIdByName($optionModule[1]);
                        $module = array();
                        $module['id'] = $moduleObject->id;
                        $module['version'] = $moduleObject->version;
                        $module['name'] = $moduleObject->name;
                        $module['displayName'] = $moduleObject->displayName;
                        $module['description'] = $moduleObject->description;
                        $module['id_hookexecute'] = $id_hookexecute;
                        $module['hookexec_name'] = $optionModule[1];
                        $module['tab'] = $moduleObject->tab;
                        $module['active'] = $moduleObject->active;
                        $moduleObjects[] = $module;
                        }
                    }
                }
                $ModulesHook = array();
                $ModulesHook['id_hook'] = $idHook;
                $ModulesHook['modules'] =  $moduleObjects;
                $optionModulesHook[$hookname] = $ModulesHook;
            }
            return $optionModulesHook;
        }else{
            return false;
        }
    }
    /********************** get all module can execusive ***********************/
    public static function getModuleExecList($hookname = null){
        $ModuleExecList = array();
        if (is_null($hookname)){
            $hookArr =self::getHookexecuteList() ;
        }elseif (is_array($hookname)){
            $hookArr = $hookname;
        }elseif (strlen($hookname) > 0){
            $hookArr = array($hookname);
        }
        $moduleArr = array();
        foreach ($hookArr as $hookname){
            $ModuleList = HookManager::getHookModuleExecList($hookname);
            if ($ModuleList && count($ModuleList)>0)
                foreach ($ModuleList as $moduleObj){
                    if (array_key_exists($moduleObj['id_module'],$moduleArr))
                        continue;
                    $moduleArr[$moduleObj['id_module']] = 1;
                    $ModuleExecList[] = $moduleObj;
                }
        }
        return $ModuleExecList;
    }
    public static function getHooksByModule($moduleObject)
    {
        $hooks = array();
        $hookArr = self::getHookexecuteList();
        if ($hookArr)
            foreach ($hookArr as $hook)
                if (_PS_VERSION_ < "1.5"){
                    if (is_callable(array($moduleObject, 'hook' . $hook)))
                        $hooks[] = $hook;
                }else{
                    $retro_hook_name = Hook::getRetroHookName($hook);
                    if (is_callable(array($moduleObject, 'hook' . $hook)) || is_callable(array($moduleObject, 'hook' .
                            $retro_hook_name)))
                        $hooks[] = $hook;
                }
        $results = self::getHookByArrName($hooks);
        return $results;
    }
    /**
    * insert or update list module hook
    */
    public static function registerHookModule($option,$hookname,$moduleHook,$idshop){
        // Check if already register
        $where = "`theme` = '".$option->theme. "' AND `alias` = '".$option->alias."' AND `hookname` ='".$hookname."'";
		$sql = 'SELECT `hookname`
			FROM `'._DB_PREFIX_.'ovic_options_hook_module` 
			 WHERE '.$where;
		if (Db::getInstance()->getRow($sql))
            return Db::getInstance()->update('ovic_options_hook_module',array(
                'modules' => $moduleHook
            ),$where);
		else
            // Register module in hook
    		return Db::getInstance()->insert('ovic_options_hook_module', array(
                'theme' => $option->theme,
                'alias' => $option->alias,
                'hookname' => $hookname,
    			'modules' => $moduleHook,
    		));
    }
    private function getHookByArrName($arrName)
    {
        $result = Db::getInstance()->ExecuteS('
            SELECT `id_hook`, `name`
            FROM `' . _DB_PREFIX_ . 'hook`
            WHERE `name` IN (\'' . implode("','", $arrName) . '\')');
        return $result;
    }
    public function hookDisplayBackOfficeHeader()
    {
        $this->context->controller->addCSS($this->_path . 'css/themeconfig.css');
    }
    private function generalHook($hookname)
    {
        if (!Validate::isHookName($hookname))
            return '';
        $html = '';
        $id_shop = (int)$this->context->shop->id;
        $layoutColumn = (int)Configuration::get('OVIC_LAYOUT_COLUMN',null,null,$id_shop);
        $curent_id_option = Configuration::get('OVIC_CURRENT_OPTION',null,null,$id_shop);
        $current_theme = Theme::getThemeInfo($this->context->shop->id_theme);
        $curent_option = new Options($curent_id_option);
        if (strtolower($curent_option->theme) != strtolower($current_theme['theme_name']))
            return '';
        if ($curent_option && Validate::isLoadedObject($curent_option)){
            if ($hookname == 'displayLeftColumn' || $hookname == 'displayRightColumn'){
                $module_name = '';
        		if (Validate::isModuleName(Tools::getValue('module')))
        			$module_name = Tools::getValue('module');
                if (!empty($this->context->controller->page_name))
                    $page_name =$this->context->controller->page_name;
                elseif (!empty($this->context->controller->php_self))
                    $page_name = $this->context->controller->php_self;
                elseif (Tools::getValue('fc') == 'module' && $module_name != '' && (Module::getInstanceByName($module_name) instanceof PaymentModule))
                    $page_name = 'module-payment-submit';
                elseif (preg_match('#^' . preg_quote($this->context->shop->physical_uri, '#') .
                    'modules/([a-zA-Z0-9_-]+?)/(.*)$#', $_SERVER['REQUEST_URI'], $m))
                        $page_name = 'module-' . $m[1] . '-' . str_replace(array('.php', '/'), array('',
                            '-'), $m[2]);
                else {
                    $page_name = Dispatcher::getInstance()->getController();
                    $page_name = (preg_match('/^[0-9]/', $page_name) ? 'page_' . $page_name : $page_name);
                }
                if (strlen($page_name) <= 0)
                    return '';
            }
            if ($hookname == 'displayLeftColumn')
            {
                if ($page_name == 'index' && $layoutColumn>1)
                    return '';
                if ($page_name == 'index'){
                    $optionModules = self::getModulesHook($curent_option->theme, $curent_option->alias, $hookname);
                    if (!is_null($optionModules['modules']))
                        $optionModules = Tools::jsonDecode($optionModules['modules'],true);
                    else
                        $optionModules = array();
                }else
                    $optionModules = self::getSideBarModulesByPage($page_name,'left',false);
                if ($optionModules && is_array($optionModules) && sizeof($optionModules)>0)
                    foreach ($optionModules as $optionModule){
                        $moduleObject = Module::getInstanceByName($optionModule[0]);
                        $html .= $this->ModuleHookExec($moduleObject, $optionModule[1]);
                    }
                return $html;
            }
            if ($hookname == 'displayRightColumn'){
                if ($page_name == 'index' && $layoutColumn !== 0 && $layoutColumn !==2)
                    return '';
                if ($page_name == 'index'){
                    $optionModules = self::getModulesHook($curent_option->theme, $curent_option->alias, $hookname);
                    if (!is_null($optionModules['modules']))
                        $optionModules = Tools::jsonDecode($optionModules['modules'],true);
                    else
                        $optionModules = array();
                }else
                    $optionModules = self::getSideBarModulesByPage($page_name,'right',false);
                if ($optionModules && is_array($optionModules) && sizeof($optionModules)>0)
                    foreach ($optionModules as $optionModule){
                        $moduleObject = Module::getInstanceByName($optionModule[0]);
                        $html .= $this->ModuleHookExec($moduleObject, $optionModule[1]);
                    }
                return $html;
            }
            $optionModules = self::getModulesHook($curent_option->theme, $curent_option->alias, $hookname);
            if (!is_null($optionModules['modules']))
                $optionModules = Tools::jsonDecode($optionModules['modules'],true);
            else
                $optionModules = array();
            if ($optionModules && is_array($optionModules) && sizeof($optionModules)>0)
                foreach ($optionModules as $optionModule){
                    $moduleObject = Module::getInstanceByName($optionModule[0]);
                    $html .= $this->ModuleHookExec($moduleObject, $optionModule[1]);
                }
        }
        return $html;
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
        }else
            if ($layoutColumn === 0 || $layoutColumn === 1)
                $this->processLeftMeta($id_theme_meta);
        if ($theme->hasRightColumn('index')){
            if ($layoutColumn === 1 || $layoutColumn === 3)
                $this->processRightMeta($id_theme_meta);
        }else
            if ($layoutColumn === 0 || $layoutColumn === 2)
                $this->processRightMeta($id_theme_meta);
        Tools::clearCache();
    }
    private function processLeftMeta($id_theme_meta)
	{
		$theme_meta = Db::getInstance()->getRow('SELECT * FROM '._DB_PREFIX_.'theme_meta WHERE id_theme_meta = '.(int)$id_theme_meta);
		$result = false;
		if ($theme_meta){
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
		if ($theme_meta){
			$sql = 'UPDATE '._DB_PREFIX_.'theme_meta SET right_column='.(int)!(bool)$theme_meta['right_column'].' WHERE id_theme_meta='.(int)$id_theme_meta;
			$result = Db::getInstance()->execute($sql);
		}
        return $result;
    }
    /**
	 * Execute modules for specified hook
	 * @param module $moduleInstance Execute hook for this module only
	 * @param string $hook_name Hook Name
	 * @return string modules output
	 */
     private function ModuleHookExec($moduleInstance, $hook_name){
        $output ='';
        if (Validate::isLoadedObject($moduleInstance) && $moduleInstance->id) {
            $altern = 0;
            $id_hook = Hook::getIdByName($hook_name);
            $retro_hook_name = Hook::getRetroHookName($hook_name);
            $disable_non_native_modules = (bool)Configuration::get('PS_DISABLE_NON_NATIVE_MODULE');
            if ($disable_non_native_modules && Hook::$native_module && count(Hook::$native_module) && !in_array($moduleInstance->name, self::$native_module))
				return '';
            //check disable module
            $device = (int)$this->context->getDevice();
           if (Db::getInstance()->getValue('
			SELECT COUNT(`id_module`) FROM '._DB_PREFIX_.'module_shop
			WHERE enable_device & '.(int)$device.' AND id_module='.(int)$moduleInstance->id.
			Shop::addSqlRestriction()) == 0)
                return '';
            // Check permissions
			$exceptions = $moduleInstance->getExceptions($id_hook);
			$controller = Dispatcher::getInstance()->getController();
			$controller_obj = Context::getContext()->controller;
			//check if current controller is a module controller
			if (isset($controller_obj->module) && Validate::isLoadedObject($controller_obj->module))
				$controller = 'module-'.$controller_obj->module->name.'-'.$controller;
			if (in_array($controller, $exceptions))
				return '';
			//retro compat of controller names
			$matching_name = array(
				'authentication' => 'auth',
				'productscomparison' => 'compare'
			);
			if (isset($matching_name[$controller]) && in_array($matching_name[$controller], $exceptions))
				return '';
			if (Validate::isLoadedObject($this->context->employee) && !$moduleInstance->getPermission('view', $this->context->employee))
				return '';
            if (!isset($hook_args['cookie']) or !$hook_args['cookie'])
                $hook_args['cookie'] = $this->context->cookie;
            if (!isset($hook_args['cart']) or !$hook_args['cart'])
                $hook_args['cart'] = $this->context->cart;
            $hook_callable = is_callable(array($moduleInstance, 'hook'.$hook_name));
			$hook_retro_callable = is_callable(array($moduleInstance, 'hook'.$retro_hook_name));
            if (($hook_callable || $hook_retro_callable) && Module::preCall($moduleInstance->name))
			{
				$hook_args['altern'] = ++$altern;
				// Call hook method
				if ($hook_callable)
					$display = $moduleInstance->{'hook'.$hook_name}($hook_args);
				elseif ($hook_retro_callable)
					$display = $moduleInstance->{'hook'.$retro_hook_name}($hook_args);
                $output .= $display;
			}
        }
        return $output;
     }
    public static function getTemplateFile($template, $moduleName = ''){
        $context = Context::getContext();
        $templatedir = trim(Configuration::get('OVIC_CURRENT_DIR',null,null,$context->shop->id));
        if ($moduleName && $moduleName !=''){
            if (Tools::file_exists_cache(_PS_THEME_DIR_.'modules/'.$moduleName.'/views/templates/front/'.$templatedir.'/'.$template))
                return _PS_THEME_DIR_.'modules/'.$moduleName.'/views/templates/front/'.$templatedir.'/'.$template;
            elseif (Tools::file_exists_cache(_PS_THEME_DIR_.'modules/'.$moduleName.'/views/templates/hook/'.$templatedir.'/'.$template))
                return _PS_THEME_DIR_.'modules/'.$moduleName.'/views/templates/hook/'.$templatedir.'/'.$template;
            elseif (Tools::file_exists_cache(_PS_THEME_DIR_.'modules/'.$moduleName.'/'.$templatedir.'/'.$template))
                return _PS_THEME_DIR_.'modules/'.$moduleName.'/'.$templatedir.'/'.$template;
        }else
            if (Tools::file_exists_cache(_PS_THEME_DIR_.$templatedir.'_'.$template))
                return _PS_THEME_DIR_.$templatedir.'_'.$template;
        return null;
    }
    private function hex2rgba($hex) {
       $hex = str_replace("#", "", $hex);
       if(strlen($hex) == 3) {
          $r = hexdec(substr($hex,0,1).substr($hex,0,1));
          $g = hexdec(substr($hex,1,1).substr($hex,1,1));
          $b = hexdec(substr($hex,2,1).substr($hex,2,1));
       } else {
          $r = hexdec(substr($hex,0,2));
          $g = hexdec(substr($hex,2,2));
          $b = hexdec(substr($hex,4,2));
       }
       $rgba = 'rgba('.$r.','.$g.','.$b.',0.8)';
       return $rgba;
    }
    public function hookactionModuleRegisterHookAfter($params){
        $module = $params['object'];
        $current_theme = Theme::getThemeInfo($this->context->shop->id_theme);
        if (!$this->IsOvicThemes($current_theme['theme_name']))
            return;
        if ($module->name != $this->name){
            $hook_name = $params['hook_name'];
            if ($hook_name && Validate::isHookName($hook_name)){
                $id_hook = Hook::getIdByName($hook_name);
				$hook_name = Hook::getNameById($id_hook);// get full hookname
                //order possition hook                 
                $id_hook_header = Hook::getIdByName('Header');
                if ($id_hook && $id_hook === $id_hook_header)
                    $this->changeHeaderPosition();
                if (in_array($hook_name,self::$OptionHookAssign))
                    $this->backupModuleHook($id_hook,'hook_module','ovic_backup_hook_module',true);
                elseif (in_array($hook_name,self::getHookexecuteList()))
                    $this->backupModuleHook($id_hook,'hook_module','ovic_backup_hook_module',false);
                else
                    return; 
                $id_shop = (int)$this->context->shop->id;
                $current_id_option = Configuration::get('OVIC_CURRENT_OPTION',null,null,$id_shop);
                $current_option =  new Options($current_id_option);
                $moduleHook = array();
                $moduleHook[] = $module->name;
                $moduleHook[] = $hook_name;
                if ($current_option && Validate::isLoadedObject($current_option)){
                    //insert module to current option
                    $HookedModulesArr = self::getModulesHook($current_option->theme, $current_option->alias, $hook_name);
                    $HookedModulesArr = Tools::jsonDecode($HookedModulesArr['modules'],true);
                    if (!is_array($HookedModulesArr))
                        $HookedModulesArr = array();
                    $key = array_search($moduleHook,$HookedModulesArr);
                    if ($key && !array_key_exists($key,$HookedModulesArr)){
                        $HookedModulesArr[] = $moduleHook;
                        self::registerHookModule($current_option,$hook_name,Tools::jsonEncode($HookedModulesArr),$id_shop);
                    }
                }
                $pagelist = Meta::getMetas();
                $sidebarPages = array();
                $theme = new Theme((int)$this->context->shop->id_theme);
                if ($hook_name == 'displayLeftColumn' || $hook_name == 'displayRightColumn')
                    foreach ($pagelist as $page){
                        if ($hook_name == 'displayLeftColumn' && $theme->hasLeftColumn($page['page'])){
                                $HookedModulesArr = self::getSideBarModulesByPage($page['page'],'left',false);
                                if (!is_array($HookedModulesArr))
                                    $HookedModulesArr = array();
                                $key = array_search($moduleHook,$HookedModulesArr);
                                if ($key && !array_key_exists($key,$HookedModulesArr)){
                                    $HookedModulesArr[] = $moduleHook;
                                    self::registerSidebarModule($page['page'],'left',Tools::jsonEncode($HookedModulesArr),$id_shop);
                                }
                            }
                            if ($hook_name == 'displayRightColumn' && $theme->hasRightColumn($page['page'])){
                                $HookedModulesArr = self::getSideBarModulesByPage($page['page'],'right',false);
                                if (!is_array($HookedModulesArr))
                                    $HookedModulesArr = array();
                                $key = array_search($moduleHook,$HookedModulesArr);
                                if ($key && !array_key_exists($key,$HookedModulesArr)){
                                    $HookedModulesArr[] = $moduleHook;
                                    self::registerSidebarModule($page['page'],'right',Tools::jsonEncode($HookedModulesArr),$id_shop);
                                }
                            }
                    }
            }
        }
    }
    private function changeHeaderPosition(){
        $id_shop = (int)$this->context->shop->id;
        $id_hook_header = Hook::getIdByName('Header');
        $sql = "SELECT MAX(`position`) FROM `" . _DB_PREFIX_ . "hook_module` WHERE id_shop = ".(int)$id_shop." AND id_hook =" .(int)$id_hook_header;
        $max_pos = Db::getInstance()->getValue($sql);
        $sql = 'UPDATE `' . _DB_PREFIX_ . 'hook_module` SET position='.($max_pos+1).' WHERE id_module = '.(int)$this->id. ' AND id_shop = '.(int)$id_shop.' AND id_hook =' .(int)$id_hook_header;
        Db::getInstance()->execute($sql);
    }
    public function hookDisplayHeader($params)
	{
		
	   $this->context->controller->removeJS('/granada/js/jquery/plugins/jqzoom/jquery.jqzoom.js');
	   $id_shop = (int)$this->context->shop->id;
	   $current_id_option = Configuration::get('OVIC_CURRENT_OPTION',null,null,$id_shop);
       $current_option = new Options($current_id_option);
       $current_theme = Theme::getThemeInfo($this->context->shop->id_theme);
       if (strtolower($current_option->theme)!= strtolower($current_theme['theme_name'])){
        Configuration::deleteByName('OVIC_CURRENT_OPTION');
        Configuration::deleteByName('OVIC_LAYOUT_COLUMN'); 
        Configuration::deleteByName('OVIC_CURRENT_DIR'); 
        $current_id_option = null;          
       }
       $emptyOption = false;
       if (!$current_id_option || !Validate::isUnsignedId($current_id_option) || !OvicLayoutControl::isAvailablebyId($current_id_option)){
            $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
            $sql = 'SELECT * FROM `' . _DB_PREFIX_ . 'ovic_options` o
                   WHERE LCASE(o.`theme`) =\''.strtolower($current_theme['theme_name']).'\'';
            $options = Db::getInstance()->executeS($sql);
            if ($options && is_array($options) && sizeof($options)>0)
                foreach ($options as $option){
                    $current_option = new Options($option['id_option']);
                    Configuration::updateValue('OVIC_CURRENT_OPTION',$option['id_option'],false,null,$id_shop);
                    Configuration::updateValue('OVIC_CURRENT_DIR',str_replace(' ','_',$current_option->alias),false,null,$id_shop);
                    $current_id_option = $option['id_option'];
                    break;
                }
            else
                $emptyOption = true;
       }
       if (!$emptyOption){
            $current_option = new Options($current_id_option);
            if (strtolower($current_option->theme) == strtolower($current_theme['theme_name'])){
                $selected_layout = Configuration::get('OVIC_LAYOUT_COLUMN',null,null,$id_shop);
                if (!$selected_layout || substr_count($current_option->column,$selected_layout)<1)
                    if (strlen($current_option->column)>0){
                        $selected_layout = (int)substr($current_option->column,0,1);
                        Configuration::updateValue('OVIC_LAYOUT_COLUMN',$selected_layout,false,null,$id_shop);
                        $this->ProcessLayoutColumn();
                    }
            }else
                $emptyOption = true;
        }
        if ($emptyOption){
            $this->context->smarty->assign(array('emptyOption' => Tools::displayError('There is no Option, please add new Option from Layout Builder menu.')));
            return '';
        }
	   $output = '';
       global $smarty;
       $optionStyle = $this->getOptionStyle($current_option->theme,$current_option->alias);
       $fonts = array();
       if ($optionStyle['font'] && is_array($optionStyle['font']) && sizeof($optionStyle['font'])>0)
            foreach ($optionStyle['font'] as $key => $font){
                $start = strpos($font,'family');
                $fontName = substr_replace($font,'',0,$start+7);
                $start = strpos($fontName,"'");
                $fontName = substr_replace($fontName,'',$start,strlen($fontName));
                if (strpos($fontName,":")>0){
                    $start = strpos($fontName,":");
                    $fontName = substr_replace($fontName,'',$start,strlen($fontName));
               }
               $fontName = str_replace('+',' ',$fontName);
               if (strlen($font)>0){
                   $start = strpos($font,'http');
                   $substr = substr_replace($font,'',$start,strlen($font)-$start);
                   $start = strpos($font,':');
                   $font = substr_replace($font,'',0,$start);
                   $font = $substr.(empty( $_SERVER['HTTPS'] ) ? 'http' : 'https') .$font;
               }
               $fonts[] = array('fontname'=> $fontName, 'linkfont'=> $font);
            }
        if ($optionStyle['color'] && is_array($optionStyle['color']) && sizeof($optionStyle['color'])>0){
            $grbacolor = $this->hex2rgba($optionStyle['color']['main']);
        }
            
        $current_id_option = Configuration::get('OVIC_CURRENT_OPTION',null,null,$id_shop);
        $current_dir = trim(Configuration::get('OVIC_CURRENT_DIR',null,null,$id_shop));
        
        if( Dispatcher::getInstance()->getController() == 'contact'){
            $default_country = new Country((int)Tools::getCountry());
            //$a = 'http'.((Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE')) ? 's' : '').'://maps.google.com/maps/api/js?sensor=true&region='.substr($default_country->iso_code, 0, 2);
            
			$this->context->controller->addJS('http'.((Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE')) ? 's' : '').'://maps.google.com/maps/api/js?sensor=true&region='.substr($default_country->iso_code, 0, 2));
            $this->context->controller->addJS(_THEME_JS_DIR_.'contact.js');
            $distanceUnit = Configuration::get('PS_DISTANCE_UNIT');
            if (!in_array($distanceUnit, array('km', 'mi')))
			$distanceUnit = 'km';
            $this->context->smarty->assign(array(
                'mediumSize' => Image::getSize(ImageType::getFormatedName('medium')),
    			'defaultLat' => (float)Configuration::get('PS_STORES_CENTER_LAT'),
    			'defaultLong' => (float)Configuration::get('PS_STORES_CENTER_LONG'),
    			'searchUrl' => $this->context->link->getPageLink('stores'),
    			'logo_store' => Configuration::get('PS_STORES_ICON'),
                'distanceUnit'=>$distanceUnit,
                'hasStoreIcon'=> file_exists(_PS_IMG_DIR_.Configuration::get('PS_STORES_ICON')),
            ));    
        }
        
        
        $smarty->assign(array(
            'grbacolor' => isset($grbacolor)? $grbacolor:'',
            'font' => $fonts,
            'color' => $optionStyle['color'],
            'current_id_option' => $current_id_option,
            'current_dir' => $current_dir,
            'BEFORE_LOGO' => Hook::exec('displayBeforeLogo'),
            'HOOK_HOME_TOP_COLUMN' => Hook::exec('displayHomeTopColumn'),
            'HOME_BOTTOM_CONTENT' => Hook::exec('displayHomeBottomContent'),
            'HOME_BOTTOM_COLUMN' => Hook::exec('displayHomeBottomColumn'),
            'HOME_TOP_CONTENT' => Hook::exec('displayHomeTopContent'),
            'BOTTOM_COLUMN' => Hook::exec('displayBottomColumn'),
       ));    
       return $this->display(__FILE__, 'multistyle.tpl');
	}
    public function hookDisplayNav($params){
        return $this->generalHook('displayNav');
    }
    public function hookDisplayTop($params){
        return $this->generalHook('displayTop');
    }
    public function hookdisplayTopColumn(){
        return $this->generalHook('displayTopColumn');
    }
    public function hookdisplayLeftColumn($params){
        return $this->generalHook('displayLeftColumn');
    }
    public function hookdisplayRightColumn($params){
        return $this->generalHook('displayRightColumn');
    }
    public function hookdisplayHome($params){
        return $this->generalHook('displayHome');
    }
    public function hookdisplayHomeTab($params){
        return $this->generalHook('displayHomeTab');
    }
    public function hookdisplayHomeTabContent(){
        return $this->generalHook('displayHomeTabContent');
    }
    public function hookdisplayFooter($params){
        return $this->generalHook('displayFooter');
    }
    /****************/
    public function hookdisplayBeforeLogo($params){
        return $this->generalHook('displayBeforeLogo');
    }
    public function hookdisplayHomeTopColumn($params){
        return $this->generalHook('displayHomeTopColumn');
    }
    public function hookdisplayHomeTopContent($params){
        return $this->generalHook('displayHomeTopContent');
    }
    public function hookdisplayHomeBottomContent($params){
        return $this->generalHook('displayHomeBottomContent');
    }
    public function hookdisplayHomeBottomColumn($params){
        return $this->generalHook('displayHomeBottomColumn');
    }
    public function hookdisplayBottomColumn($params){
        return $this->generalHook('displayBottomColumn');
    }
}