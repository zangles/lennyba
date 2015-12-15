<?php /* Smarty version Smarty-3.1.19, created on 2015-10-21 12:05:27
         compiled from "/home/u481889647/public_html/admin/themes/default/template/controllers/shop/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:125928960156277f87ef2878-60364563%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2ee3ca07d622c750e7c0605d02f671036c6a4b79' => 
    array (
      0 => '/home/u481889647/public_html/admin/themes/default/template/controllers/shop/content.tpl',
      1 => 1445407908,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '125928960156277f87ef2878-60364563',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'shops_tree' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56277f87ef9f69_24672981',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56277f87ef9f69_24672981')) {function content_56277f87ef9f69_24672981($_smarty_tpl) {?>

<div class="row">
	<div class="col-lg-4">
		<?php echo $_smarty_tpl->tpl_vars['shops_tree']->value;?>

	</div>
	<div class="col-lg-8"><?php echo $_smarty_tpl->tpl_vars['content']->value;?>
</div>
</div><?php }} ?>
