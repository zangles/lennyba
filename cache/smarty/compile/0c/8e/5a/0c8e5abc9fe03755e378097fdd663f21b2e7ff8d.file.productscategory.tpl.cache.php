<?php /* Smarty version Smarty-3.1.19, created on 2015-10-21 11:28:32
         compiled from "/home/u481889647/public_html/themes/granada/modules/productscategory/productscategory.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5551976935627a110ce8ac0-01542511%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0c8e5abc9fe03755e378097fdd663f21b2e7ff8d' => 
    array (
      0 => '/home/u481889647/public_html/themes/granada/modules/productscategory/productscategory.tpl',
      1 => 1445437516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5551976935627a110ce8ac0-01542511',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'categoryProducts' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5627a110cf5b86_79248087',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5627a110cf5b86_79248087')) {function content_5627a110cf5b86_79248087($_smarty_tpl) {?><?php if (count($_smarty_tpl->tpl_vars['categoryProducts']->value)>0&&$_smarty_tpl->tpl_vars['categoryProducts']->value!==false) {?>
<section class="blockproductscategory">
    <h2 class="title_block"><?php echo smartyTranslate(array('s'=>'UPSELL PRODUCTS','mod'=>'ovicproductscategory'),$_smarty_tpl);?>
</h2>        
	<div id="productscategory_list" class="clearfix">
	   <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-list-limit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array('products'=>$_smarty_tpl->tpl_vars['categoryProducts']->value,'limit_item'=>4), 0);?>

 	</div>
</section>
<?php }?><?php }} ?>
