<?php
/*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;

class BrandsSlider extends Module
{
    public function __construct()
    {
        $this->name = 'brandsslider';
        $this->tab = 'front_office_features';
        $this->version = 1.0;
		$this->author = 'OVIC-SOFT';
		$this->need_instance = 0;

        parent::__construct();

		$this->displayName = $this->l('Ovic - Brands slider block');
        $this->description = $this->l('Displays a block listing product manufacturers and/or brands.');
    }

	public function install()
	{
		return parent::install() && $this->registerHook('displayHeader') && $this->registerHook('displayFooter') && $this->registerHook('displayHome');
    }
	/*
	public function getContent()
	{
		$this->registerHook('displayHeader') ;
		echo "OK";
		die;	
	}
	 
	*/
	public function hookDisplayHome($params)
	{
		return $this->hookDisplayFooter($params);
	}
    
	public function hookDisplayFooter($params)
	{
		if (!$this->isCached('brandsslider.tpl', $this->getCacheId())){
		   $manufacturers = Manufacturer::getManufacturers();
            foreach ($manufacturers as $key => $item)
			foreach ($manufacturers as &$item)
				$item['image'] = $item['id_manufacturer'].'-manusize.jpg';
            $this->smarty->assign('manufacturers', $manufacturers);
		}
        
		return $this->display(__FILE__, 'brandsslider.tpl', $this->getCacheId());
	}
	public function hookHeader($params)
	{
        // CSS in global.css file
		//$this->context->controller->addCSS(($this->_path).'owl.carousel.css', 'all');
        //$this->context->controller->addCSS(($this->_path).'brandsslider.css', 'all');
        //$this->context->controller->addJS($this->_path.'brandsslider.js');
	}
}
