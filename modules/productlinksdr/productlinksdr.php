<?php
/*
* 2014 Leo Ng
*/

if (!defined('_PS_VERSION_'))
	exit;

class ProductLinksDr extends Module
{

	public function __construct()
	{
		$this->name = 'productlinksdr';
		$this->tab = 'front_office_features';
		$this->version = '1.0';
		$this->author = 'OVIC-SOFT';
		$this->need_instance = 0;

		$this->bootstrap = true;
		parent::__construct();	

		$this->displayName = $this->l('Ovic - Product links');
		$this->description = $this->l('Adds links on the product page(go to next or previous products in the same category).');
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
	}

	public function install()
	{
		$success = parent::install() && $this->registerHook('OvicProductlinks') && $this->registerHook('RightColumn');

		if (!$success)
            return false;
            
		return $success;
	}

	public function hookDisplayFooterProduct($params)
	{
		return $this->hookOvicProductlinks($params);
	}
    public function hookRightColumn($params)
	{
		return $this->hookOvicProductlinks($params);
	}
    
	public function hookOvicProductlinks($params)
	{
        $id_product = (int)Tools::getValue('id_product');		
        $product = new Product((int)$id_product);
       
        $category = false;
		if (isset($params['category']->id_category))
			$category = $params['category'];
		else
		{
			if (isset($product->id_category_default) && $product->id_category_default > 1)
				$category = new Category((int)$product->id_category_default);
		}

		if (!Validate::isLoadedObject($category) || !$category->active)
			return false;
        
        // Get infos
		$category_products = $category->getProducts($this->context->language->id, 1, 100); /* 100 products max. */
        $nb_category_products = (int)count($category_products);
        
        // Get positions
        $product_position = 0;
        
        $product_position = $this->getCurrentProduct($category_products, (int)$id_product);
        
        
        
        if ($nb_category_products > 1)
        {
            $prevLink = NULL;
            $nextLink = NULL;
            $prevProduct = NULL;
            $nextProduct = NULL;
            
            if ($product_position == 1 && $nb_category_products == 2) 
            {
                $prevProduct = $category_products[$product_position - 1];
            }
            else if($product_position == 0){
                $nextProduct = $category_products[$product_position + 1];
            }
            else if($product_position > 1 && $product_position == ($nb_category_products -1))
            {
                $prevProduct = $category_products[$product_position - 1];
            }
            else
            {
                $prevProduct = $category_products[$product_position - 1];
                $nextProduct = $category_products[$product_position + 1];
            }
            
            //if (!empty($prevProduct)){
//                $prev = $this->context->link->getProductLink($prevProduct['id_product']);
//            }
//            if (!empty($nextProduct)){
//                $nextLink = $this->context->link->getProductLink($nextProduct['id_product']);    
//            }
            
            // Display tpl
            $this->smarty->assign(
                array(
                	'prevProduct' => $prevProduct,
                	'nextProduct' => $nextProduct
                )
            );
            
            return $this->display(__FILE__, 'productlinksdr.tpl');
        }
        else 
        {
            return;
        }
		
	}
    
    private function getCurrentProduct($products, $id_current)
	{
		if ($products)
		{
			foreach ($products as $key => $product)
			{
				if ($product['id_product'] == $id_current)
					return $key;
			}
		}

		return false;
	}

}
