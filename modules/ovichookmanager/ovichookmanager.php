<?php if (!defined('_PS_VERSION_')) exit;
class OvicHookManager extends Module
{
    public function __construct()
    {
        $this->name = 'ovichookmanager';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'OVIC-SOFT';
        parent::__construct();
        $this->displayName = $this->l('Ovic custom hook manager');
        $this->description = $this->l('Ovic custom hook manager.');
        $this->secure_key = Tools::encrypt($this->name);
        $this->bootstrap = true;
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }
    // this also works, and is more future-proof
    public function install()
    {
        if (!parent::install() || !$this->registerHook('displayHome')|| !$this->registerHook('displayHomeBottomContent')) return false;
        return true;
    }
    public function uninstall()
    {
        if (!parent::uninstall()) return false;
        return true;
    }
     private function ModuleHookExec($moduleName, $hook_name){

        $output ='';
        $moduleInstance = Module::getInstanceByName($moduleName);
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
   public function hookdisplayHomeBottomContent($params){
        if (!$this->isCached('bottomcontentmanagerhook.tpl', $this->getCacheId()))
		{
            $this->ModuleHookExec('blockbestsellers','displayHomeTab');
			$this->context->smarty->assign(
				array(
					'blockbestsellers' => $this->ModuleHookExec('blockbestsellers','displayHomeTabContent'),
				)
			);
		}
		return $this->display(__FILE__, 'bottomcontentmanagerhook.tpl', $this->getCacheId());
    }  
    public function hookDisplayHome($params){
        if (!$this->isCached('homemanagerhook.tpl', $this->getCacheId()))
		{
            $this->ModuleHookExec('blocknewproducts','displayHomeTab');
			$this->context->smarty->assign(
				array(
					'blocknewproducts' => $this->ModuleHookExec('blocknewproducts','displayHomeTabContent'),
				)
			);
		}
		return $this->display(__FILE__, 'homemanagerhook.tpl', $this->getCacheId());
    }  
} ?>