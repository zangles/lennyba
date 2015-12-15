<?php /* Smarty version Smarty-3.1.19, created on 2015-10-21 11:28:29
         compiled from "/home/u481889647/public_html/themes/granada/product-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3984452445627a10d6cdbe4-27711455%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '34ef3d8d94a7a488fe3adedacd3a197bc74d0623' => 
    array (
      0 => '/home/u481889647/public_html/themes/granada/product-list.tpl',
      1 => 1445437516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3984452445627a10d6cdbe4-27711455',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'products' => 0,
    'hide_left_column' => 0,
    'hide_right_column' => 0,
    'itemWidth' => 0,
    'productPerRow' => 0,
    'id' => 0,
    'product' => 0,
    'lang_iso' => 0,
    'imginfo' => 0,
    'imgitem' => 0,
    'PS_STOCK_MANAGEMENT' => 0,
    'restricted_country_mode' => 0,
    'topLeft' => 0,
    'link' => 0,
    'homeSize' => 0,
    'new_idimg' => 0,
    'add_prod_display' => 0,
    'PS_CATALOG_MODE' => 0,
    'static_token' => 0,
    'quick_view' => 0,
    'comparator_max_item' => 0,
    'over' => 0,
    'rate' => 0,
    'currency' => 0,
    'priceDisplay' => 0,
    'compared_products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5627a10d917f36_02598640',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5627a10d917f36_02598640')) {function content_5627a10d917f36_02598640($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['products']->value)&&$_smarty_tpl->tpl_vars['products']->value) {?>
	<!-- Products list -->
    <?php if ($_smarty_tpl->tpl_vars['hide_left_column']->value XOR $_smarty_tpl->tpl_vars['hide_right_column']->value) {?>
        <?php $_smarty_tpl->tpl_vars['ulwidth'] = new Smarty_variable("column3", null, 0);?>
    <?php } else { ?>
        <?php if ($_smarty_tpl->tpl_vars['hide_left_column']->value&&$_smarty_tpl->tpl_vars['hide_right_column']->value) {?>
            <?php $_smarty_tpl->tpl_vars['ulwidth'] = new Smarty_variable("column4", null, 0);?>
        <?php } else { ?>
            <?php $_smarty_tpl->tpl_vars['ulwidth'] = new Smarty_variable("column2", null, 0);?>
        <?php }?>
    <?php }?>
    <?php if (!isset($_smarty_tpl->tpl_vars['itemWidth']->value)) {?>
    	<?php $_smarty_tpl->tpl_vars['itemWidth'] = new Smarty_variable(4, null, 0);?>	
    <?php }?>
    <?php if (!isset($_smarty_tpl->tpl_vars['productPerRow']->value)) {?>
    	<?php $_smarty_tpl->tpl_vars['productPerRow'] = new Smarty_variable(3, null, 0);?>	
    <?php }?>
    <?php $_smarty_tpl->tpl_vars['group_count'] = new Smarty_variable(3, null, 0);?>    
    <div <?php if (isset($_smarty_tpl->tpl_vars['id']->value)&&$_smarty_tpl->tpl_vars['id']->value) {?> id="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
"<?php }?> class="product_list category-grid" data-item-width="<?php echo $_smarty_tpl->tpl_vars['itemWidth']->value;?>
" data-product-per-row="<?php echo $_smarty_tpl->tpl_vars['productPerRow']->value;?>
" >
    	<div class="row">
    		<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['product']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['product']->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
 $_smarty_tpl->tpl_vars['product']->iteration++;
 $_smarty_tpl->tpl_vars['product']->last = $_smarty_tpl->tpl_vars['product']->iteration === $_smarty_tpl->tpl_vars['product']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['index']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['last'] = $_smarty_tpl->tpl_vars['product']->last;
?>
    		<?php if ((bool)Configuration::get('PS_DISABLE_OVERRIDES')) {?>
    			<?php $_smarty_tpl->tpl_vars['over'] = new Smarty_variable(0, null, 0);?>
    		<?php } else { ?>
    			<?php $_smarty_tpl->tpl_vars['over'] = new Smarty_variable(1, null, 0);?>
    			<?php $_smarty_tpl->tpl_vars['rate'] = new Smarty_variable(Product::getRatings($_smarty_tpl->tpl_vars['product']->value['id_product']), null, 0);?>
    		<?php }?>
    		
    		<?php $_smarty_tpl->tpl_vars['imginfo'] = new Smarty_variable(Image::getImages(Language::getIdByIso($_smarty_tpl->tpl_vars['lang_iso']->value),$_smarty_tpl->tpl_vars['product']->value['id_product']), null, 0);?>
            <?php $_smarty_tpl->tpl_vars['new_idimg'] = new Smarty_variable('', null, 0);?>
            <?php  $_smarty_tpl->tpl_vars['imgitem'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['imgitem']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['imginfo']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['imgitem']->key => $_smarty_tpl->tpl_vars['imgitem']->value) {
$_smarty_tpl->tpl_vars['imgitem']->_loop = true;
?>
                <?php if (!$_smarty_tpl->tpl_vars['imgitem']->value['cover']) {?>
                    <?php $_smarty_tpl->tpl_vars['new_idimg'] = new Smarty_variable(((string)$_smarty_tpl->tpl_vars['imgitem']->value['id_product'])."-".((string)$_smarty_tpl->tpl_vars['imgitem']->value['id_image']), null, 0);?>
                    <?php break 1?>
                <?php }?>
            <?php } ?>
            <?php $_smarty_tpl->tpl_vars['topLeft'] = new Smarty_variable(false, null, 0);?>
            <?php $_smarty_tpl->tpl_vars['topRight'] = new Smarty_variable(false, null, 0);?>
    		<div class="col-sm-<?php echo $_smarty_tpl->tpl_vars['itemWidth']->value;?>
 md-margin2x" itemscope itemtype="http://schema.org/Product">
    			<div class="product">               
                  <div class="product-top">						
						<?php if ($_smarty_tpl->tpl_vars['PS_STOCK_MANAGEMENT']->value&&isset($_smarty_tpl->tpl_vars['product']->value['available_for_order'])&&$_smarty_tpl->tpl_vars['product']->value['available_for_order']&&!isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)) {?>
							<?php if ($_smarty_tpl->tpl_vars['product']->value['quantity']<=0) {?>
								<?php if ((isset($_smarty_tpl->tpl_vars['product']->value['quantity_all_versions'])&&$_smarty_tpl->tpl_vars['product']->value['quantity_all_versions']>0)) {?>
									<link itemprop="availability" href="http://schema.org/LimitedAvailability" />
									<span class="outofstock-box top-left"><?php echo smartyTranslate(array('s'=>'Not available','mod'=>'simplecategory'),$_smarty_tpl);?>
</span>
								<?php } else { ?>
									<link itemprop="availability" href="http://schema.org/OutOfStock" />
									<span class="outofstock-box top-left"><?php echo smartyTranslate(array('s'=>'Out of','mod'=>'simplecategory'),$_smarty_tpl);?>
<span><?php echo smartyTranslate(array('s'=>'Stock','mod'=>'simplecategory'),$_smarty_tpl);?>
</span></span>
								<?php }?>
							<?php } else { ?>
								<?php if (isset($_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction'])&&$_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction']) {?>
			                        <?php if ($_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction_type']=='percentage') {?>   
			                        	<?php $_smarty_tpl->tpl_vars['topLeft'] = new Smarty_variable(true, null, 0);?>
			                        	<span class="discount-box top-left">-<?php echo $_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction']*100;?>
%</span>
			                        <?php }?>
			                    <?php } else { ?>
			                        <?php if (isset($_smarty_tpl->tpl_vars['product']->value['on_sale'])&&$_smarty_tpl->tpl_vars['product']->value['on_sale']==1) {?>
			                        	<?php $_smarty_tpl->tpl_vars['topLeft'] = new Smarty_variable(true, null, 0);?>
			                        	<span class="discount-box top-left"><?php echo smartyTranslate(array('s'=>'Sale'),$_smarty_tpl);?>
</span>
			                        <?php }?>
			                    <?php }?>
			                    <?php if (isset($_smarty_tpl->tpl_vars['product']->value['new'])&&$_smarty_tpl->tpl_vars['product']->value['new']==1) {?>
			                        <span class="new-box <?php if ($_smarty_tpl->tpl_vars['topLeft']->value==true) {?>top-right<?php } else { ?>top-left<?php }?>"><?php echo smartyTranslate(array('s'=>'New'),$_smarty_tpl);?>
</span>
								<?php }?>
							<?php }?>
						<?php } else { ?>
							<?php if (isset($_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction'])&&$_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction']) {?>
		                        <?php if ($_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction_type']=='percentage') {?>   
		                        	<?php $_smarty_tpl->tpl_vars['topLeft'] = new Smarty_variable(true, null, 0);?>
		                        	<span class="discount-box top-left">-<?php echo $_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction']*100;?>
%</span>
		                        <?php }?>
		                    <?php } else { ?>
		                        <?php if (isset($_smarty_tpl->tpl_vars['product']->value['on_sale'])&&$_smarty_tpl->tpl_vars['product']->value['on_sale']==1) {?>
		                        	<?php $_smarty_tpl->tpl_vars['topLeft'] = new Smarty_variable(true, null, 0);?>
		                        	<span class="discount-box top-left"><?php echo smartyTranslate(array('s'=>'Sale'),$_smarty_tpl);?>
</span>
		                        <?php }?>
		                    <?php }?>
		                    <?php if (isset($_smarty_tpl->tpl_vars['product']->value['new'])&&$_smarty_tpl->tpl_vars['product']->value['new']==1) {?>
		                        <span class="new-box <?php if ($_smarty_tpl->tpl_vars['topLeft']->value==true) {?>top-right<?php } else { ?>top-left<?php }?>"><?php echo smartyTranslate(array('s'=>'New'),$_smarty_tpl);?>
</span>
							<?php }?>								
						<?php }?>
                     <figure class="product-image-container">
                     	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" itemprop="url">
			        		<img class="product-image" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['id_image'],'home_default'), ENT_QUOTES, 'UTF-8', true);?>
" alt="<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['legend'])) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['legend'], ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" title="<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['legend'])) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['legend'], ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" <?php if (isset($_smarty_tpl->tpl_vars['homeSize']->value)) {?> width="<?php echo $_smarty_tpl->tpl_vars['homeSize']->value['width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['homeSize']->value['height'];?>
"<?php }?> itemprop="image" />
			        		<?php if (!empty($_smarty_tpl->tpl_vars['new_idimg']->value)) {?>
			                    <img class="product-image-hover" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['new_idimg']->value,'home_default'), ENT_QUOTES, 'UTF-8', true);?>
" alt="<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['legend'])) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['legend'], ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" title="<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['legend'])) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['legend'], ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" <?php if (isset($_smarty_tpl->tpl_vars['homeSize']->value)) {?> width="<?php echo $_smarty_tpl->tpl_vars['homeSize']->value['width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['homeSize']->value['height'];?>
"<?php }?> itemprop="image" />
			                <?php } else { ?>
			                    <img class="product-image-hover" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['id_image'],'home_default'), ENT_QUOTES, 'UTF-8', true);?>
" alt="<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['legend'])) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['legend'], ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" title="<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['legend'])) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['legend'], ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" <?php if (isset($_smarty_tpl->tpl_vars['homeSize']->value)) {?> width="<?php echo $_smarty_tpl->tpl_vars['homeSize']->value['width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['homeSize']->value['height'];?>
"<?php }?> itemprop="image" />
			                <?php }?>				            		
			        	</a>                     		
                     </figure>
                     <div class="product-action-container">
                        <div class="product-action-wrapper action-responsive">                        	
                        	<?php if (($_smarty_tpl->tpl_vars['product']->value['id_product_attribute']==0||(isset($_smarty_tpl->tpl_vars['add_prod_display']->value)&&($_smarty_tpl->tpl_vars['add_prod_display']->value==1)))&&$_smarty_tpl->tpl_vars['product']->value['available_for_order']&&!isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)&&$_smarty_tpl->tpl_vars['product']->value['customizable']!=2&&!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
								<?php if ((!isset($_smarty_tpl->tpl_vars['product']->value['customization_required'])||!$_smarty_tpl->tpl_vars['product']->value['customization_required'])&&($_smarty_tpl->tpl_vars['product']->value['allow_oosp']||$_smarty_tpl->tpl_vars['product']->value['quantity']>0)) {?>
									<?php $_smarty_tpl->_capture_stack[0][] = array('default', null, null); ob_start(); ?>add=1&amp;id_product=<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
<?php if (isset($_smarty_tpl->tpl_vars['static_token']->value)) {?>&amp;token=<?php echo $_smarty_tpl->tpl_vars['static_token']->value;?>
<?php }?><?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
									<a class="ajax_add_to_cart_button product-add-btn" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('cart',true,null,Smarty::$_smarty_vars['capture']['default'],false), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Add to cart'),$_smarty_tpl);?>
" data-id-product="<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
" data-minimal_quantity="<?php if (isset($_smarty_tpl->tpl_vars['product']->value['product_attribute_minimal_quantity'])&&$_smarty_tpl->tpl_vars['product']->value['product_attribute_minimal_quantity']>1) {?><?php echo intval($_smarty_tpl->tpl_vars['product']->value['product_attribute_minimal_quantity']);?>
<?php } else { ?><?php echo intval($_smarty_tpl->tpl_vars['product']->value['minimal_quantity']);?>
<?php }?>">
										<span class="add-btn-text"><?php echo smartyTranslate(array('s'=>'Add to Cart','mod'=>'simplecategory'),$_smarty_tpl);?>
</span> <span class="product-btn product-cart"><?php echo smartyTranslate(array('s'=>'Cart','mod'=>'simplecategory'),$_smarty_tpl);?>
</span>
									</a>
								<?php } else { ?>
									<span class="ajax_add_to_cart_button product-add-btn disabled">
										<span class="add-btn-text"><?php echo smartyTranslate(array('s'=>'Add to Cart','mod'=>'simplecategory'),$_smarty_tpl);?>
</span> <span class="product-btn product-cart"><?php echo smartyTranslate(array('s'=>'Cart','mod'=>'simplecategory'),$_smarty_tpl);?>
</span>
									</span>
								<?php }?>
							<?php }?>
							
	                        <?php if (isset($_smarty_tpl->tpl_vars['quick_view']->value)&&$_smarty_tpl->tpl_vars['quick_view']->value) {?>
	                        	<a href="javascript:void(0)" title="<?php echo smartyTranslate(array('s'=>'Quick view'),$_smarty_tpl);?>
" data-rel="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" class="quick-view product-btn product-search"></a>
							<?php }?> 	                        
	                        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayProductListFunctionalButtons','product'=>$_smarty_tpl->tpl_vars['product']->value),$_smarty_tpl);?>
	                        
							<?php if (isset($_smarty_tpl->tpl_vars['comparator_max_item']->value)&&$_smarty_tpl->tpl_vars['comparator_max_item']->value) {?>
								<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Add to compare'),$_smarty_tpl);?>
" class="add_to_compare link-compare product-btn product-compare" data-id-product="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
"></a>
							  <!-- <a class="add_to_compare product-btn link-compare" title="<?php echo smartyTranslate(array('s'=>'Add to compare'),$_smarty_tpl);?>
" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" data-id-product="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
"><?php echo smartyTranslate(array('s'=>'Add to compare'),$_smarty_tpl);?>
</a> -->
							<?php }?>
                        </div>
                     </div>
                  </div>
                  
                  <h3 class="product-name" itemprop="name">
                  	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" itemprop="url" >
						<?php echo htmlspecialchars($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['product']->value['name'],32,''), ENT_QUOTES, 'UTF-8', true);?>

					</a>
                  </h3>
                  <div class="ratings-container">
                  	<?php if ($_smarty_tpl->tpl_vars['over']->value==1) {?>
	                  	<div class="ratings" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
		                	<div class="ratings-result" data-result="<?php echo $_smarty_tpl->tpl_vars['rate']->value['avg'];?>
"></div>
		                	<meta itemprop="worstRating" content="<?php echo $_smarty_tpl->tpl_vars['rate']->value['min'];?>
">
		                	<meta itemprop="ratingValue" content="<?php echo $_smarty_tpl->tpl_vars['rate']->value['avg'];?>
">
		                	<meta itemprop="bestRating" content="<?php echo $_smarty_tpl->tpl_vars['rate']->value['max'];?>
">
		                	<meta itemprop="reviewCount" content="<?php echo $_smarty_tpl->tpl_vars['rate']->value['review'];?>
">
		              	</div>
		              	<!-- <span class="ratings-amount"><?php echo $_smarty_tpl->tpl_vars['rate']->value['review'];?>
 review(s)</span> -->
                  	<?php } else { ?>
                  		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayProductListReviews','product'=>$_smarty_tpl->tpl_vars['product']->value),$_smarty_tpl);?>

                  	<?php }?>
					
					</div>
					<p class="product-desc" itemprop="description">
						<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate(strip_tags($_smarty_tpl->tpl_vars['product']->value['description_short']),360,'...');?>

					</p>
                  <div class="product-price-container">
						<?php if (isset($_smarty_tpl->tpl_vars['product']->value['show_price'])&&$_smarty_tpl->tpl_vars['product']->value['show_price']&&!isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)) {?>
							<meta itemprop="priceCurrency" content="<?php echo $_smarty_tpl->tpl_vars['currency']->value->iso_code;?>
" />
			                <?php if (isset($_smarty_tpl->tpl_vars['product']->value['specific_prices'])&&$_smarty_tpl->tpl_vars['product']->value['specific_prices']&&isset($_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction'])&&$_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction']>0) {?>
								<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"displayProductPriceBlock",'product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>"old_price"),$_smarty_tpl);?>

			                    <span class="product-old-price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPrice'][0][0]->displayWtPrice(array('p'=>$_smarty_tpl->tpl_vars['product']->value['price_without_reduction']),$_smarty_tpl);?>
</span>
			                    <span class="product-price" itemprop="price"><?php if (!$_smarty_tpl->tpl_vars['priceDisplay']->value) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price']),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price_tax_exc']),$_smarty_tpl);?>
<?php }?></span>                                            
			                <?php } else { ?>
			                    <span class="product-price" itemprop="price">
			                        <?php if (!$_smarty_tpl->tpl_vars['priceDisplay']->value) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price']),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price_tax_exc']),$_smarty_tpl);?>
<?php }?>                                    
			                    </span>
			                <?php }?>
						<?php }?>
                  </div>
				</div>
            </div>
            <?php if (($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['index']%$_smarty_tpl->tpl_vars['productPerRow']->value==($_smarty_tpl->tpl_vars['productPerRow']->value-1))&&!$_smarty_tpl->getVariable('smarty')->value['foreach']['products']['last']) {?> 
				</div>
				<div class="row"> 
			<?php }?>
    		<?php } ?>
    	</div>
    </div>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('addJsDefL', array('name'=>'min_item')); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'min_item'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<?php echo smartyTranslate(array('s'=>'Please select at least one product','js'=>1),$_smarty_tpl);?>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'min_item'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php $_smarty_tpl->smarty->_tag_stack[] = array('addJsDefL', array('name'=>'max_item')); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'max_item'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<?php echo smartyTranslate(array('s'=>'You cannot add more than %d product(s) to the product comparison','sprintf'=>$_smarty_tpl->tpl_vars['comparator_max_item']->value,'js'=>1),$_smarty_tpl);?>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'max_item'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('comparator_max_item'=>$_smarty_tpl->tpl_vars['comparator_max_item']->value),$_smarty_tpl);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('comparedProductsIds'=>$_smarty_tpl->tpl_vars['compared_products']->value),$_smarty_tpl);?>

<?php }?>
<?php }} ?>
